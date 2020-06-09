<?php
class Checkout extends CI_Controller {

	


	public function __construct() {
		
		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;
		$this->membership_data = new stdClass();
		$this->membership_data->expire = true;

		if (isset($this->session_data->userId)) {
			
			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
			
			if ($mship) {
				
				if ($currnet < $mship->period_end) {
					$mship->expire = false;
				}
				else {
					$mship->expire = true;
				}
				$this->membership_data = $mship;
			}
		}
	}



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'checkout');
		$this->data['page_title'] = 'Checkout';
		$this->data['cart_data'] = $this->cart->contents();

		$c=0;
		foreach ($this->cart->contents() as $item) {
			
			if ($item['options']['paymentStatus'] == 'Yes') {
				$c++;
			}
		}
		if($c==0) {
			
			redirect('tests');
			exit();
		}

		$discount=0;

		if (isset($this->session_data->userId)) {
			
			$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus!="Used" AND refType="Referral" AND userId=' . $this->session_data->userId)->row();
			
			if ($urbb) {
				$discount = $discount + $urbb->discount;
			}
			
			$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus="Active" AND refType="User" AND userId=' . $this->session_data->userId)->row();
			
			if ($urbb) {
				$discount = $discount + $urbb->discount;
			}
		}
        
        $cart=$this->cart->contents();
        
        function sortByOrder($a, $b) {
          	
          	if ($a['price']== $b['price']){
	            return 0; 
	        }
        	if ($a['price'] < $b['price']){
	            return -1; 
	        }
        	else{
	            return 1;
	        }
        }

        usort($cart, 'sortByOrder');        
        
        $new_cart=array();
        foreach($cart as $row) {
           
           if(isset($new_cart[$row['options']['ref']])) {                
               
               $new_cart[$row['options']['ref']]['qty']= $row['qty']+ $new_cart[$row['options']['ref']]['qty'];
               $new_cart[$row['options']['ref']]['scheduleDate'][]=$row['options']['scheduleDate'];              
            }
           	else {
                
                $new=array();
                $new['id']=$row['id'];
                $new['qty']= $row['qty'];
                $new['price']=$row['price'];
                $new['name']=$row['name'];
                $new['options']=$row['options'];
                $new['rowid']=$row['rowid'];
                $new['payDebit']=$row['options']['payDebit'];
                $new['pType']=$row['options']['pType'];
                $new['scheduleDate'][]=$row['options']['scheduleDate'];
                $new_cart[$row['options']['ref']]=$new;
            }           
        }

        $this->data['cart_data_new'] = $new_cart;
        
		$this->data['discount'] = $discount;
		$this->load->view('checkout', $this->data);
	}



	public function process() {   // did't found yet when this function is called
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('orderEmail', 'Email', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('orderShipAddress', 'Address', 'required');
		$this->form_validation->set_rules('orderCity', 'City', 'required');
		$this->form_validation->set_rules('orderState', 'County', 'required');
		$this->form_validation->set_rules('orderPostalCode', 'Postal Code', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {

			$response=array();
			$response['code']=0 ;
			$response['message']='Something Wrong';
			echo json_encode($response);
			exit();

			$cart_data=$this->cart->contents();
			$grand = 0;
			$paynow=0;
			
			foreach ($cart_data as $item) {
				$grand = $grand + $item['subtotal'];
				if($item['options']['paymentStatus']=='Yes') {
					$paynow = $paynow + $item['subtotal'];
				}
			}

			if($grand==0) {
				$response=array();
				$response['code']=0 ;
				$response['message']='Cart is empty!';
				echo json_encode($response);
				exit();
			}

			$orderShipName=$this->input->post('first_name').' '.$this->input->post('last_name');
			$orderShipAddress=$this->input->post('orderShipAddress');
			$orderEmail=$this->input->post('orderEmail');
			$orderCity=$this->input->post('orderCity');
			$orderState=$this->input->post('orderState');
			$orderPostalCode=$this->input->post('orderPostalCode');
			$orderPhone=$this->input->post('orderPhone');
				// make orders //
			$ins=array();
			$ins['userId']=$this->session_data->userId;
			$ins['orderAmount']=$grand;
			$ins['orderStatus']='Pending';
			$ins['orderShipName']=$orderShipName;
			$ins['orderEmail']=$orderEmail;
			$ins['orderShipAddress']=$orderShipAddress;
			$ins['orderCity']=$orderCity;
			$ins['orderState']=$orderState;
			$ins['orderPostalCode']=$orderPostalCode;
			$ins['orderCountry']='United Kingdom';
			$ins['orderPhone']=$orderPhone;
			$ins['createdAt']=current_datetime();
			$ins['updatedAt']=current_datetime();
			$this->db->insert('orders',$ins);
			$orderId=$this->db->insert_id();
			
			foreach ($cart_data as $item) {
				
				$pp=$item['subtotal'];
				
				if($item['options']['paymentStatus']=='Yes') {
					// check discount //
					$urbb = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus!="Used" AND refType="Referral" AND userId=' . $this->session_data->userId)->result();
					
					foreach ($urbb as $urbb_row) {
						
						if ($pp > 0) {
							
							if ($pp >= $urbb_row->discount) {
								//used
								$upd = array();
								$upd['refBonus'] = 0;
								$upd['refStatus'] = 'Used';
								$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
								// active referal user //
								$chk = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus="Pending" AND refType="User" AND refId=' . $this->session_data->userId)->row();
								if ($chk) {
									$upd = array();
									$upd['refStatus'] = 'Active';
									$this->db->update('user_referral_bonus', $upd, array('userRefId' => $chk->userRefId));
								}
								$pp = $pp - $urbb_row->discount;
							}
							else {
								$upd = array();
								$upd['refBonus'] = $urbb_row->refBonus - $pp;
								$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
								$pp = 0;
							}
						}
					}
					
					$urbb = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus="Active" AND refType="User" AND userId=' . $this->session_data->userId)->result();
					
					foreach ($urbb as $urbb_row) {
						if ($pp > 0) {
							if ($pp >= $urbb_row->discount) {
								//used
								$upd = array();
								$upd['refBonus'] = 0;
								$upd['refStatus'] = 'Used';
								$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
								$pp = $pp - $urbb_row->discount;
							}
							else {
								$upd = array();
								$upd['refBonus'] = $urbb_row->refBonus - $pp;
								$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
								$pp = 0;
							}
						}
					}
				}

				$ins=array();
				$ins['orderId']=$orderId;
				$ins['userId']=$this->session_data->userId;
				$ins['testId']=$item['id'];
				$ins['productType']=$item['options']['productType'];
				$ins['orginalPrice']=$item['options']['orginalPrice'];
				$ins['detailPrice']=$item['subtotal'];
				$ins['detailQty']=$item['qty'];
				$ins['scheduleDate']=$item['options']['scheduleDate'];
				
				if($pp==0) {
					$ins['paymentStatus']="Yes";
				}
				else {
					$ins['paymentStatus']="No";
				}
				
				$ins['detailStatus']='Pending';
				$ins['paymentType']=$item['options']['paymentType'];
				$ins['membershipDate']=$item['options']['membershipDate'];
				$ins['membershipStatus']=$item['options']['membershipStatus'];
				$ins['extra']=json_encode($item['options']['extra'],true);
				$ins['createdAt']=current_datetime();
				$ins['updatedAt']=current_datetime();
				$this->db->insert('order_details',$ins);
			}

			$notify=array();
			$notify['notificationMessage']='A new order #'.$orderId.' is placed by '.$this->session_data->userFirstName;
			$notify['notificationLink']=$orderId;
			$notify['notificationStatus']=1;
			$notify['notificationTime']=current_datetime();
			$notify['notificationTo']=1;
			$notify['notificationToType']='Admin';
			$notify['notificationFrom']=$this->session_data->userId;
			$notify['notificationFromType']='Member';
			$notify['notificationType']='Order';
			$this->db->insert('notifications', $notify);

			$this->cart->destroy();
			$response=array();
			$response['code']=1 ;
			$response['message']='Order submitted successfully!';
			echo json_encode($response);
			exit();
		}
	}
	public function process_payment_test() {
		
		//echo '<pre>'; print_r($this->session_data); exit;
		$cart_data=$this->cart->contents();

		$cdata['cdata'] = $cart_data;
		$cdata['title'] = 'david mark';
		$subject='Payment Rreceipt';
		$to='davidmark0772@gmail.com';

		$message=$this->load->view('emails/payment_receipt',$cdata,true); 
		$this->smtp_email->send('','',$to,$subject,$message);


		$this->load->view('emails/payment_receipt', $cdata);
		
	}


	public function process_payment() {

		$cart_data=$this->cart->contents();

		$cdata['cdata'] = $cart_data;
		//echo '<pre>'; print_r($cart_data); exit;
		// Added by david
		$k=1;
		$s_dates_arr=[];
		// End added by david
				
		$this->check_ajax_login();
		$this->form_validation->set_rules('stripeToken', 'Token', 'required');
		$this->form_validation->set_rules('orderEmail', 'Email', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('orderShipAddress', 'Address', 'required');
		$this->form_validation->set_rules('orderCity', 'City', 'required');
		$this->form_validation->set_rules('orderState', 'County', 'required');
		$this->form_validation->set_rules('orderPostalCode', 'Postal Code', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$cart_data=$this->cart->contents();
			$grand = 0;
			$paynow=0;	
            $new_cart=array();
            
            foreach($cart_data as $row) {
               
                if(isset($new_cart[$row['options']['ref']])) {
                   $new_cart[$row['options']['ref']]['qty']= $row['qty']+ $new_cart[$row['options']['ref']]['qty'];
                   $new_cart[$row['options']['ref']]['scheduleDate'][]=$row['options']['scheduleDate'];    
                   $sub_date[$row['options']['scheduleDate']]=$row['options'];
                   $new_cart[$row['options']['ref']]['scheduleDateOptions']=$sub_date;     
                }
                else {
                    
                    $new=array();
                    $new['id']=$row['id'];
                    $new['qty']= $row['qty'];
                    $new['price']=$row['price'];
                    $new['name']=$row['name'];
                    $new['options']=$row['options'];
                    $new['rowid']=$row['rowid'];
                    $new['payDebit']=$row['options']['payDebit'];
                    $new['pType']=$row['options']['pType'];
                    $new['scheduleDate'][]=$row['options']['scheduleDate'];
                    $new['regularType'][]=$row['options']['pType'];
                    $sub_date[$row['options']['scheduleDate']]=$row['options'];
                    $new['scheduleDateOptions']=$sub_date;
                    $new_cart[$row['options']['ref']]=$new;
				} 
				

				// Added by david
				$s_dates_arr[$k] = $row['scheduleDate'];
				// foreach($row['scheduleDate'] as $r){
				// 	echo $r;
				// }
				$k++;
				// End added by david
				                 
			}  
			
			//echo '<pre>'; print_r($new_cart); exit;
            
            foreach($new_cart as $key=>$item){
                
                if($item['payDebit']=='No') {
                    $grand = $grand + ($item['qty']*$item['price']);
                }
                else {
                    $grand = $grand + $item['price'];
                }
            }
            
			if($grand==0) {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='Cart is empty!';
				echo json_encode($response);
				exit();
			}
            
            require_once(APPPATH . 'libraries/stripe-php/init.php');
			$stripe_api_key = getenv('stripe_api_secret');
			\Stripe\Stripe::setApiKey($stripe_api_key);

			$token=$this->input->post('stripeToken');

			$customer_email = $this->session_data->userEmail;
			$customer = \Stripe\Customer::create(array(
				'email' => $customer_email, // customer email id
				'card'  => $token
			));

			$discount=0;
			// check discount //
			$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus!="Used" AND refType="Referral" AND userId=' . $this->session_data->userId)->row();
			if ($urbb) {
				$discount = $discount + $urbb->discount;
			}

			$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus="Active" AND refType="User" AND userId=' . $this->session_data->userId)->row();
			
			if ($urbb) {
				$discount = $discount + $urbb->discount;
			}
            
           
            // palce order    
        	$orderShipName=$this->input->post('first_name').' '.$this->input->post('last_name');
			$orderShipAddress=$this->input->post('orderShipAddress');
            $orderShipAddress2=$this->input->post('orderShipAddress2');
			$orderEmail=$this->input->post('orderEmail');
			$orderCity=$this->input->post('orderCity');
			$orderState=$this->input->post('orderState');
			$orderPostalCode=$this->input->post('orderPostalCode');
			$orderPhone=$this->input->post('orderPhone');
			// make orders //
			$ins=array();
			$ins['userId']=$this->session_data->userId;
			$ins['orderAmount']=$grand;
			$ins['orderStatus']='Pending';
			$ins['orderShipName']=$orderShipName;
			$ins['orderEmail']=$orderEmail;
			$ins['orderShipAddress']=$orderShipAddress;
            $ins['orderShipAddress2']=$orderShipAddress2;
			$ins['orderCity']=$orderCity;
			$ins['orderState']=$orderState;
			$ins['orderPostalCode']=$orderPostalCode;
			$ins['orderCountry']='United States';
			$ins['orderPhone']=$orderPhone;
			$ins['createdAt']=current_datetime();
			$ins['updatedAt']=current_datetime();
			$this->db->insert('orders',$ins);                
			$orderId=$this->db->insert_id();           
            
            // end order //
            $no_error=0;
            
            $total_paid=0;
			$j=1;
			
            foreach($new_cart as $key=>$item) {	
				
                if($item['pType']!='Regular') {  // did't found this case david // when subscription is active
					//echo 'No Regular  '.$item['pType']; exit;
                    $paidAmount = $item['price']*$item['qty'];
                    $orgPrice=$paidAmount;
                    $total_charge=$paidAmount-$discount;
                    $paidAmount=$paidAmount-$discount;                    
                    
                    if($paidAmount<1) {
                        $paidAmount=1;
                    }                         
                    
                    $total_paid+=$paidAmount;
                    
                    $charge = \Stripe\Charge::create(array(
        				'customer'  => $customer->id,
        				'amount'    => ceil($paidAmount*100),
        				'currency'  => 'GBP'
        			));
                    
                    if($charge->paid == true) {
                        
                        if(isset($charge->balance_transaction)) {
        					$tk=$charge->balance_transaction;
        				}
        				else {
        					$tk='';
        				}

                        $customer_data = (array)$customer;
						$charge_data = (array)$charge;
						
                        // payment
        				$ins=array();
        				$ins['userId']=$this->session_data->userId;
        				$ins['orderAmount']=$total_charge;
        				$ins['paymentDetail']="Customer Info: \n".json_encode($customer_data,true)."\n \n Charge Info: \n".json_encode($charge_data,true);
        		        $ins['transactionId']=$tk;
        				$ins['createdAt']=current_datetime();
						$this->db->insert('payments',$ins);
						
						// transaction  Added by david
						$ins=array();
						$ins['trx_id']=$tk; 
						$ins['userId']=$this->session_data->userId;
						$ins['paidAmount']=$paidAmount; //$total_paid;
						$ins['orderId']=$orderId;
						$ins['createdAt']=current_datetime();
						$this->db->insert('transactions',$ins);  
						//  End
                        
                        $ins=array();
    					$ins['orderId']=$orderId;
    					$ins['userId']=$this->session_data->userId;
    					$ins['testId']=$item['id'];
    					$ins['orderGroupPrice']=$item['price'];
    					$ins['orderGroupQty']=$item['qty'];
    					$ins['directDebit']='No';
    					$ins['orderGroupRef']=$key;
    					$ins['orderGroupType']=$item['pType'];    				
    					$ins['createdAt']=current_datetime();
    					$this->db->insert('order_items_group',$ins);
                        $orderGroupId=$this->db->insert_id();                  
						
						// Code (if else) Added By David
						if(isset($s_dates_arr[$j]) && count($s_dates_arr[$j]) > 1){
	
							// Loop Added By David
							foreach($s_dates_arr[$j] as $sd_date_new){
								
								$ins=array();
								$ins['orderId']=$orderId;
								$ins['orderGroupId']=$orderGroupId;
								$ins['userId']=$this->session_data->userId;
								$ins['testId']=$item['id'];
								$ins['productType']=$item['options']['productType'];
								$ins['orginalPrice']=$item['options']['orginalPrice'];
								$ins['detailPrice']=$item['price'];
								$ins['detailQty']=$item['qty'];
								$ins['scheduleDate']=$sd_date_new; //$sd_date;
								$ins['paymentStatus']='Yes';
								$ins['detailStatus']='Pending';
								$ins['paymentType']=$item['options']['paymentType'];
								$ins['regularType']=$item['options']['pType'];
								$ins['membershipDate']=$item['options']['membershipDate'];
								$ins['membershipStatus']=$item['options']['membershipStatus'];
								$ins['extra']=json_encode($item['options']['extra'],true);
								$ins['createdAt']=current_datetime();
								$ins['updatedAt']=current_datetime();
								$this->db->insert('order_details',$ins); 
								

							}

						}else{

							// Loop Added By David
							$sc_date = date('Y-m-d');
							for($q=1; $q<=$item['qty']; $q++){

								
								// if($q > 1){
								// 	$sc_date = date("Y-m-d", strtotime("+1 month ".$sc_date));
								// }

								$ins=array();
								$ins['orderId']=$orderId;
								$ins['orderGroupId']=$orderGroupId;
								$ins['userId']=$this->session_data->userId;
								$ins['testId']=$item['id'];
								$ins['productType']=$item['options']['productType'];
								$ins['orginalPrice']=$item['options']['orginalPrice'];
								$ins['detailPrice']=$item['price']; //$item['price']*$item['qty']; //commented by david
								$ins['detailQty']=$item['qty'];
								$ins['scheduleDate']=$sc_date; //$item['options']['scheduleDate']; //commented by david
								$ins['paymentStatus']='Yes';
								$ins['detailStatus']='Pending';
								$ins['paymentType']=$item['options']['paymentType'];
								$ins['regularType']=$item['options']['pType'];
								
								$ins['membershipDate']=$item['options']['membershipDate'];
								$ins['membershipStatus']=$item['options']['membershipStatus'];
								$ins['extra']=json_encode($item['options']['extra'],true);
								$ins['createdAt']=current_datetime();
								$ins['updatedAt']=current_datetime();
								$this->db->insert('order_details',$ins);
							}
						}
						
                        
                        // check discount //
                        $pp=$orgPrice;
						$urbb = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus!="Used" AND refType="Referral" AND userId=' . $this->session_data->userId)->result();
						
						foreach ($urbb as $urbb_row) {
							
							if ($pp > 0) {
								
								if ($pp >= $urbb_row->discount) {
									//used
									$upd = array();
									$upd['refBonus'] = 0;
									$upd['refStatus'] = 'Used';
									$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
									// active referal user //
									$chk = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus="Pending" AND refType="User" AND refId=' . $this->session_data->userId)->row();
									if ($chk) {
										$upd = array();
										$upd['refStatus'] = 'Active';
										$this->db->update('user_referral_bonus', $upd, array('userRefId' => $chk->userRefId));

									}
									$pp = $pp - $urbb_row->discount;
								}
								else {
									$upd = array();
									$upd['refBonus'] = $urbb_row->refBonus - $pp;
									$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
									$pp = 0;
								}
							}
						}
						
						$urbb = $this->db->query('SELECT * FROM user_referral_bonus WHERE refStatus="Active" AND refType="User" AND userId=' . $this->session_data->userId)->result();
						
						foreach ($urbb as $urbb_row) {
							
							if ($pp > 0) {

								if ($pp >= $urbb_row->discount) {
									//used
									$upd = array();
									$upd['refBonus'] = 0;
									$upd['refStatus'] = 'Used';
									$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
									$pp = $pp - $urbb_row->discount;
								}
								else {
									$upd = array();
									$upd['refBonus'] = $urbb_row->refBonus - $pp;
									$this->db->update('user_referral_bonus', $upd, array('userRefId' => $urbb_row->userRefId));
									$pp = 0;
								}
							}
						}

                        $no_error=1;                    
                    }
                    else { }                  
                }
                else {

					//echo 'yes Regular  '; echo '<pre>'; print_r($s_dates_arr[$j]); echo count($s_dates_arr[$j]); exit;
                    if($item['payDebit']=='No') {
						
                        $paidAmount = $item['price']*$item['qty'];
                        $total_paid+=$paidAmount;
                                
                        $charge = \Stripe\Charge::create(array(
            				'customer'  => $customer->id,
            				'amount'    => ceil($paidAmount*100),
            				'currency'  => 'GBP'
            			));

                        if($charge->paid == true) {
                            
                            if(isset($charge->balance_transaction)) {
            					$tk=$charge->balance_transaction;
            				}
            				else {
            					$tk='';
            				}

                            $customer_data = (array)$customer;
    				        $charge_data = (array)$charge;
                            // payment
            				$ins=array();
            				$ins['userId']=$this->session_data->userId;
            				$ins['orderAmount']=$total_charge;
            				$ins['paymentDetail']="Customer Info: \n".json_encode($customer_data,true)."\n \n Charge Info: \n".json_encode($charge_data,true);
            		        $ins['transactionId']=$tk;
            				$ins['createdAt']=current_datetime();
							$this->db->insert('payments',$ins);
							
							// transaction  Added by david
							$ins=array();
							$ins['trx_id']=$tk; 
							$ins['userId']=$this->session_data->userId;
							$ins['paidAmount']=$paidAmount; //$total_paid;
							$ins['orderId']=$orderId;
							$ins['createdAt']=current_datetime();
							$this->db->insert('transactions',$ins);  
							//  End
                
                            $ins=array();
        					$ins['orderId']=$orderId;
        					$ins['userId']=$this->session_data->userId;
        					$ins['testId']=$item['id'];
        					$ins['orderGroupPrice']=$item['price'];
        					$ins['orderGroupQty']=$item['qty'];
        					$ins['directDebit']='No';
        					$ins['orderGroupRef']=$key;
        					$ins['orderGroupType']=$item['pType'];    				
        					$ins['createdAt']=current_datetime();
        					$this->db->insert('order_items_group',$ins);
                            $orderGroupId=$this->db->insert_id();                    
							
							// echo '<pre>'; print_r($s_dates_arr[$j]);
							// foreach($s_dates_arr[$j] as $sd_date){
							// 	echo $sd_date.'<br>';
							// }

							// Code Added by David
							if(trim($item['options']['regularType']) == ""){
								//echo 'One Time';
								$sc_date = date('Y-m-d');
								for($q=1; $q<=$item['qty']; $q++){
									
									// if($q > 1){
									// 	$sc_date = date("Y-m-d", strtotime("+1 month ".$sc_date));
									// }
									
									$ins=array();
									$ins['orderId']=$orderId;
									$ins['orderGroupId']=$orderGroupId;
									$ins['userId']=$this->session_data->userId;
									$ins['testId']=$item['id'];
									$ins['productType']=$item['options']['productType'];
									$ins['orginalPrice']=$item['options']['orginalPrice'];
									$ins['detailPrice']=$item['price'];
									$ins['detailQty']=$item['qty'];
									$ins['scheduleDate']= $sc_date; //$sd_date_new; //$sd_date;
									$ins['paymentStatus']='Yes';
									$ins['detailStatus']='Pending';
									$ins['paymentType']=$item['options']['paymentType'];
									$ins['regularType']=$item['options']['pType'];
									$ins['membershipDate']=$item['options']['membershipDate'];
									$ins['membershipStatus']=$item['options']['membershipStatus'];
									$ins['extra']=json_encode($item['options']['extra'],true);
									$ins['createdAt']=current_datetime();
									$ins['updatedAt']=current_datetime();
									$this->db->insert('order_details',$ins); 
									
								}
							}else{
								//echo 'Regular';
								foreach($item['scheduleDateOptions'] as $sd_date=>$scheduleDateOptions){
							
									//if(isset($s_dates_arr[$j]) && count($s_dates_arr[$j]) > 1){
		
										// Loop Added By David
										//foreach($s_dates_arr[$j] as $sd_date_new){
											
											$ins=array();
											$ins['orderId']=$orderId;
											$ins['orderGroupId']=$orderGroupId;
											$ins['userId']=$this->session_data->userId;
											$ins['testId']=$item['id'];
											$ins['productType']=$scheduleDateOptions['productType'];
											$ins['orginalPrice']=$scheduleDateOptions['orginalPrice'];
											$ins['detailPrice']=$item['price'];
											$ins['detailQty']=$item['qty'];
											$ins['scheduleDate']=$sd_date; //$sd_date_new
											$ins['paymentStatus']='Yes';
											$ins['detailStatus']='Pending';
											$ins['paymentType']=$scheduleDateOptions['paymentType'];
											$ins['regularType']=$item['options']['pType'];
											$ins['membershipDate']=$scheduleDateOptions['membershipDate'];
											$ins['membershipStatus']=$scheduleDateOptions['membershipStatus'];
											$ins['extra']=json_encode($scheduleDateOptions['extra'],true);
											$ins['createdAt']=current_datetime();
											$ins['updatedAt']=current_datetime();
											$this->db->insert('order_details',$ins); 
											
										//}
	
									//}
																	
								}
							}
                                                               
                            
                          	$no_error=1;  
                        }                                
                    }
                    else {
                            
                        $regularType=$item['options']['regularType'];   
                        
                        $product = \Stripe\Product::create([
                                'name' =>  $item['name'],
                                'type' => 'service',
                        ]);
                            
                        $new_plan_id = drandomString(10);    
                                                      
                        if($regularType=='Month') { 
        				    $plan = \Stripe\Plan::create(
        				    	array(
                                'currency' => 'GBP',
                                'interval' => 'month',
                                'interval_count' =>1,
                                'product' => $product->id,
                                'nickname' => 'Test Plan',
                                'amount' => $item['price'] * 100,
                                'id' => $new_plan_id)
                            );                                       
                        }
        			    else if($regularType=='Quarterly') {
        				    
        				    $plan = \Stripe\Plan::create(
        				    	array(
                               'currency' => 'GBP',
                                'interval' => 'month',
                                'interval_count' =>3,
                                'product' => $product->id,
                                'nickname' => 'Test Plan',
                                'amount' => $item['price'] * 100,
                                'id' => $new_plan_id)
                            );
        			    }
        			    else if($regularType=='Semi Annually') {
        				   $plan = \Stripe\Plan::create(
            				   	array(
                               'currency' => 'GBP',
                                'interval' => 'month',
                                'interval_count' =>6,
                                'product' => $product->id,
                                'nickname' => 'Test Plan',
                                'amount' => $item['price'] * 100,
                                'id' => $new_plan_id)
            				);
        			    }
                        
                        if(isset($plan->id)) {
                            
                            $subscription = \Stripe\Subscription::create(array(
            					"customer" => $customer->id,
            					"plan" => $plan->id
            				)); 
                            
                            if(isset($subscription->id)) {
                          	    
                          	    if($subscription->id!="" && $subscription->status=="active") {
                             	   
                                    $ins=array();
                					$ins['orderId']=$orderId;
                					$ins['userId']=$this->session_data->userId;
                					$ins['testId']=$item['id'];
                					$ins['orderGroupPrice']=$item['price'];
                					$ins['orderGroupQty']=$item['qty'];
                					$ins['directDebit']='Yes';
                					$ins['orderGroupRef']=$key;
                					$ins['orderGroupType']=$item['pType'];    				
                					$ins['createdAt']=current_datetime();
                					$this->db->insert('order_items_group',$ins);
                                    $orderGroupId=$this->db->insert_id();                                               
                                    
                                    $ins=array();
                					$ins['orderGroupId']=$orderGroupId;
                					$ins['userId']=$this->session_data->userId;
                					$ins['period_start']=$subscription->current_period_start;
                					$ins['period_end']=$subscription->current_period_end;
                					$ins['StripeCustomerID']=$subscription->customer;
                					$ins['StripeSubscriptionID']=$subscription->id;
                					$ins['StripeSubscriptionEnded']='';
                                    $ins['subPlanId']=$plan->id;
                                    $ins['subPlanAmount']=$item['price'];
                                    $ins['subPlanInc']=count($item['scheduleDateOptions']);
                                    $ins['subPlanPeriod']=$regularType; 
                					$ins['createdAt']=current_datetime();
                					$this->db->insert('order_subscriptions',$ins);
                                    $db_subId=$this->db->insert_id();   
                                    
                                    $kkk_check=1;
                                    $end_date_expire='';

                                    foreach($item['scheduleDateOptions'] as $sd_date=>$scheduleDateOptions) {
										
										// Loop Added By David
										foreach($s_dates_arr[$j] as $sd_date_new){  

											$ins=array();
											$ins['paymentStatus']='No';
											
											if($kkk_check==1) {
												$ins['paymentStatus']='Yes';
											}
											
											$kkk_check++;                                                        
											
											$ins['orderId']=$orderId;
											$ins['orderGroupId']=$orderGroupId;
											$ins['userId']=$this->session_data->userId;
											$ins['testId']=$item['id'];
											$ins['productType']=$scheduleDateOptions['productType'];
											$ins['orginalPrice']=$scheduleDateOptions['orginalPrice'];
											$ins['detailPrice']=$item['price'];
											$ins['detailQty']=$item['qty'];
											$ins['scheduleDate']=$sd_date_new; //$sd_date;
											
											$ins['detailStatus']='Pending';
											$ins['regularType']=$item['options']['pType'];
											$ins['paymentType']=$scheduleDateOptions['paymentType'];
											$ins['membershipDate']=$scheduleDateOptions['membershipDate'];
											$ins['membershipStatus']=$scheduleDateOptions['membershipStatus'];
											$ins['extra']=json_encode($scheduleDateOptions['extra'],true);
											$ins['createdAt']=current_datetime();
											$ins['updatedAt']=current_datetime();
											$this->db->insert('order_details',$ins);
											$end_date_expire=$sd_date_new; //$sd_date;  
										}                                                  
                                    } 
                                    
                                    if($end_date_expire!='') {
                                        
                                        $end_date_expire=date('Y-m-d', strtotime($end_date_expire. ' + 2 days'));;
                                        $this->db->update('order_subscriptions',array('planEnd'=>$end_date_expire),array('subId'=>$db_subId));                                                   
                                    }                                               
                                }                                       
                            }
                            $no_error=1;                                         
                        }    
                    }
				} 
				
				$j++;
            }

			if($no_error==0) {
			 
                $this->db->delete('orders',array('orderId'=>$orderId));
				$response=array();
				$response['code']=0 ;
				$response['message']='payment Failed!';
				echo json_encode($response);
				exit();
			} 
            
            $this->cart->destroy();
            
            // payment  Commented by david
			// $ins=array();
			// $ins['userId']=$this->session_data->userId;
			// $ins['paidAmount']=$total_paid;
			// $ins['orderId']=$orderId;
			// $ins['createdAt']=current_datetime();
			// $this->db->insert('transactions',$ins);            
            
           	// send notifcation to admin notify_admin //
			$notify=array();
			$notify['notificationMessage']='A new order #'.$orderId.' is placed by '.$this->session_data->userFirstName;
			$notify['notificationLink']=$orderId;
			$notify['notificationStatus']=1;
			$notify['notificationTime']=current_datetime();
			$notify['notificationTo']=1;
			$notify['notificationToType']='Admin';
			$notify['notificationFrom']=$this->session_data->userId;
			$notify['notificationFromType']='Member';
			$notify['notificationType']='Order';
			$this->db->insert('notifications', $notify);

			// Added by david
			$noti = $this->db->query("select noti_order, noti_status, noti_reminder from users where userId = ".$this->session_data->userId)->row();
			if($noti->noti_order > 0){
			
				// send notifcation to user notify_user //
				$notify['notificationMessage']='Dear '.$this->session_data->userFirstName.', Your order #'.$orderId.' has been placed successfully';
				$notify['notificationToType']='Member';
				$notify['notificationTo']=$this->session_data->userId;
				$notify['notificationFromType']='Admin';
				$this->db->insert('notifications', $notify);
				
				// send email
				$to=$this->session_data->userEmail;
				$subject='Order Successful';

				$email_data['title']=$this->session_data->userFirstName;
				$email_data['link']= base_url().'orders';                 
				$message=$this->load->view('emails/order_test',$email_data,true); 
				//$message='Dear '.$this->session_data->userFirstName.', Your order #'.$orderId.' has been placed successfully. Flollow <a href="'.base_url().'orders" Link </a> to view detail';			
				$this->smtp_email->send('','',$to,$subject,$message);

				// payment_receipt email
				$subject='Payment Receipt';
				$cdata['title'] = $this->session_data->userFirstName;
				$message=$this->load->view('emails/payment_receipt',$cdata,true); 
				$this->smtp_email->send('','',$to,$subject,$message);
			}
			// End

			$response=array();
			$response['code']=1 ;
			$response['message']='Order submitted successfully!';
			echo json_encode($response);
			exit();
		}
	}



	public function chk() {
		
		if (!isset($this->session_data->userId)) {
			$response = array();
			$response['code'] = 2;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
		
		$this->form_validation->set_rules('orderEmail', 'Email', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('orderShipAddress', 'Address', 'required');
		$this->form_validation->set_rules('orderCity', 'City', 'required');
		$this->form_validation->set_rules('orderState', 'County', 'required');
		$this->form_validation->set_rules('orderPostalCode', 'Postal Code', 'required');

		//$this->form_validation->set_rules('terms1', 'Terms and Condition', 'required');
		//$this->form_validation->set_rules('terms2', 'Agree to Evergene', 'required');
		
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {

			// if(!$this->input->post('terms1')){
			// 	$response=array();
			// 	$response['code']=0 ;
			// 	$response['message']='Please read and accept our terms and conditions';
			// 	echo json_encode($response);
			// 	exit();
			// }

			// if(!$this->input->post('terms2')){
			// 	$response=array();
			// 	$response['code']=0 ;
			// 	$response['message']='Please agree to evergene to use the email';
			// 	echo json_encode($response);
			// 	exit();
			// }
			
			$orderPostalCode=$this->input->post('orderPostalCode');
			
			if (!preg_match('/^[a-zA-Z]{1,2}([0-9]{1,2}|[0-9][a-zA-Z])\s*[0-9][a-zA-Z]{2}$/i',
				$orderPostalCode)) {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='Postcode is not valid';
				echo json_encode($response);
				exit();
			}
            
            $new_cart=array();
            
            foreach($this->cart->contents() as $row) {
                
                if(isset($new_cart[$row['options']['ref']])) {
                   
                   $new_cart[$row['options']['ref']]['qty']= $row['qty']+ $new_cart[$row['options']['ref']]['qty'];
                   $new_cart[$row['options']['ref']]['scheduleDate'][]=$row['options']['scheduleDate'];                
                }
                else {
                    
                    $new=array();
                    $new['id']=$row['id'];
                    $new['qty']= $row['qty'];
                    $new['price']=$row['price'];
                    $new['name']=$row['name'];
                    $new['options']=$row['options'];
                    $new['rowid']=$row['rowid'];
                    $new['payDebit']=$row['options']['payDebit'];
                    $new['pType']=$row['options']['pType'];
                    $new['scheduleDate'][]=$row['options']['scheduleDate'];
                    $new_cart[$row['options']['ref']]=$new;
                }                 
            } 

            $grand = $paynow = 0; 
            $total =0;

           	foreach($new_cart as $key=>$item) {	
			    
			    if($item['payDebit']=='No') {
                    
                    $grand = $grand + ($item['qty']*$item['price']);
                }
                else {
                    $grand = $grand + $item['price'];
                }
                 
                $Cday=date('m',strtotime($item['scheduleDate'][0]));
                $Cyear=date('Y',strtotime($item['scheduleDate'][0]));  
                $date1= $Cday."-".$Cyear;
                $startMonth=date('m',strtotime('now'));
                $startYear=date('Y',strtotime('now'));   
                $date2= $startMonth."-".$startYear;
                $total = $total + $sub_total;
            }

			if($grand==0) {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='Cart is empty!';
				echo json_encode($response);
				exit();
			}
			else {

				$discount=0;
				// check discount //
				if (isset($this->session_data->userId)) {
					
					$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus!="Used" AND refType="Referral" AND userId=' . $this->session_data->userId)->row();
					
					if ($urbb) {
						$discount = $discount + $urbb->discount;
					}
					
					$urbb = $this->db->query('SELECT sum(refBonus) AS discount FROM user_referral_bonus WHERE refStatus="Active" AND refType="User" AND userId=' . $this->session_data->userId)->row();
					
					if ($urbb) {
						$discount = $discount + $urbb->discount;
					}
				}

				$charge=$grand-$discount;
                //$charge=$total-$discount;
				if($charge<1) {
					$charge=0;
				}
          
				$response=array();
				$response['code']=1 ;
				$response['message']=$charge;
				echo json_encode($response);
				exit();
			}
		}
	}



	public function check_login() {
		
		if (!isset($this->session_data->userId)) {
			redirect('home');
		}
	}



	public function check_ajax_login() {
		
		if (!isset($this->session_data->userId)) {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
	}

}
