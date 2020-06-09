<?php


class Orders extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
		//check membership detail
		$this->membership_data = new stdClass();
		$this->membership_data->expire = true;
		
		if (isset($this->session_data->userId)) {
			
			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId=' . $this->session_data->userId)->row();
			
			if ($mship) {
				if ($currnet < $mship->period_end) {
					$mship->expire = false;
				} else {
					$mship->expire = true;
				}
				$this->membership_data = $mship;
			}
		}
	}



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'orders');
		$this->check_login();

		$this->response['newResults']=$this->db->query('select count(*) as count FROM order_details
 		WHERE userId='.$this->session_data->userId.' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();

		$this->response['page_title']="Order History";
		$resultsPerPage=12;
		$pagination_sql=" LIMIT 0 , $resultsPerPage";
		$this->response['orders']=$this->db->query('select order_items_group.* , orders.* , order_details.detailStatus from order_items_group
         LEFT JOIN orders on order_items_group.orderId=orders.orderId LEFT JOIN order_details on orders.orderId=order_details.orderId
         WHERE order_items_group.userId='.$this->session_data->userId.' group by orders.orderId order by orderGroupId  DESC '.$pagination_sql)->result();

		$this->response['resultsPerPage']=$resultsPerPage;
		$this->load->view('order_history',$this->response);
	}



	public function loadmore() {
		
		$this->check_ajax_login();
		$resultsPerPage=12;
		$paged=0;
		
		if(isset($_POST['page'])) {
			$paged=$_POST['page'];
		}
		if($paged>0) {
			$page_limit=$resultsPerPage*($paged-1);
			$pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
		}
		else {
			$pagination_sql=" LIMIT 0 , $resultsPerPage";
		}

		$results=$this->db->query('select * from order_items_group
         LEFT JOIN orders on order_items_group.orderId=orders.orderId WHERE order_items_group.userId='.$this->session_data->userId.' order by orders.orderId desc '.$pagination_sql);
		//echo $this->db->last_query();
		$record=$results->num_rows();
		$results =$results->result();

		if($record>0) {
			
			$html=$this->load->view('components/order_history',array('orders'=>$results),true);
			
			if($record>=$resultsPerPage) {
				$page=$paged+1;
			}
			else {
				$page=0;
			}
		}
		else {
			
			$html='';
			$page=0;
		}
		
		$response=array();
		$response['code']=1;
		$response['html']=$html;
		$response['page']=$page;
		echo json_encode($response);
		exit();
	}



    public function cancel_subscription() {
        
        $this->check_ajax_login();
        $id=$this->input->post('id');
        
        if($id) {            
    		
    		require_once(APPPATH . 'libraries/stripe-php/init.php');
    		$stripe_api_key = getenv('stripe_api_secret');
    		\Stripe\Stripe::setApiKey($stripe_api_key);
            
    		$res=$this->db->query('select * from order_items_group                                           
            where order_items_group.userId='.$this->session_data->userId.' and orderGroupId='.$id)->row();
            
            if(!$res) {
                
                $response=array();
				$response['code']=0 ;
				$response['message']='Order not Found';
				echo json_encode($response);
				exit();
            }
            if($res->subscriptionCancel=='Yes') {
                
                $response=array();
				$response['code']=0 ;
				$response['message']='Already Subscription Canceled';
				echo json_encode($response);
				exit();
            }
            if($res->directDebit!='Yes') {
               
                $response=array();
				$response['code']=0 ;
				$response['message']='Subscription not found';
				echo json_encode($response);
				exit();
            }
            
            $order_subscriptions=$this->db->query('select * from order_subscriptions where orderGroupId='.$id)->row();
            
            if($order_subscriptions) {
                
                $currnet=strtotime('now');
    			
    			if($currnet<$order_subscriptions->period_end) {
    				
    				$subscription = \Stripe\Subscription::retrieve($order_subscriptions->StripeSubscriptionID);
    				$subscription->cancel(array('at_period_end' => true));
    				
    				if(isset($subscription->id)) {
    					
    					if($subscription->id!="" && $subscription->status=="active") {
    					    
    					    $current_period_end=$subscription->current_period_end;
    						$current_period_start=$subscription->current_period_start;
    						$canceled_at=$subscription->canceled_at;
                           
    					    $data=array();
        					$data['period_start']=$current_period_start;
        					$data['period_end']=$current_period_end;
        			    	$data['StripeSubscriptionEnded']=$canceled_at;					
        					$this->db->update('order_subscriptions',$data,array('subId'=>$order_subscriptions->subId));
        				    $this->db->update('order_items_group',array('subscriptionCancel'=>'Yes'),array('orderGroupId'=>$order_subscriptions->orderGroupId));
                
                            $response=array();
    						$response['code']=1 ;
    						$response['message']='Successfully Canceled';
    						echo json_encode($response);
    						exit();
    					}    
    				}
    			}
    			else {
    				
    				$response=array();
    				$response['code']=0 ;
    				$response['message']='Already Subscription Canceled';
    				echo json_encode($response);
    				exit();
    			}
            }
            else {
               
                $response=array();
				$response['code']=0 ;
				$response['message']='Subscription not found';
				echo json_encode($response);
				exit(); 
            }            
        }   	    
    }
	


	public function upcoming() {
		
		$this->check_login();

		$this->response['newResults']=$this->db->query('select count(*) FROM order_details
 		WHERE userId='.$this->session_data->userId.' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->result();
 		
		$this->response['page_title']="Upcoming Order History";
		$this->response['orders']=$this->db->query('select * from order_details
 		WHERE userId='.$this->session_data->userId.' and scheduleDate > CURDATE() GROUP BY YEAR(scheduleDate), MONTH(scheduleDate) ASC')->result();
		$this->load->view('upcoming_order_history',$this->response);
	}

	public function cancel() {
		
		$this->check_login();

		$this->response['page_title']="Cancel Order History";
		$this->response['orders']=$this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testDescription FROM order_details
		LEFT JOIN tests ON order_details.testId=tests.testId
		 WHERE order_details.userId='.$this->session_data->userId.' and order_details.order_cancel_status = 1')->result();
		 //echo '<pre>'; print_r($this->response['orders']); exit;
		$this->load->view('cancel_order_history',$this->response);
	}



	public function change_date() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('date', 'Date', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$id = $this->input->post('id');
			$date = $this->input->post('date');
			$curdate=date('Y-m-d');
			
			if(strtotime($curdate) > strtotime($date)) {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='Please select Future dates';
				echo json_encode($response);
				exit();
			}
			
			$order_date=$this->db->query('select * from order_details WHERE userId='.$this->session_data->userId.' and scheduleDate >= CURDATE() and detailId='.$id)->row();
			
			if($order_date) {
				
				if($order_date->paymentType=='Full Price') {
					$upd=array();
					$upd['scheduleDate']=$date;
					$this->db->update('order_details',$upd,array('detailId'=>$id));
				}
				else if($order_date->paymentType=='Membership') {
					
					$available_orders=$this->available_orders(date('m',strtotime($date)),date('Y',strtotime($date)));
					
					if($available_orders<1) {
						
						$response=array();
						$response['code']=0 ;
						$response['message']='No membership order available this month';
						echo json_encode($response);
						exit();
					}

					$upd=array();
					$upd['scheduleDate']=$date;
					$upd['membershipDate']=$date;
					$this->db->update('order_details',$upd,array('detailId'=>$id));
				}
				
				$response=array();
				$response['code']=1;
				$response['message']='Update successfully.';
				echo json_encode($response);
				exit();
			}
			else {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='You cannot change date of this order.';
				echo json_encode($response);
				exit();
			}
		}
	}



	public function pay() {
		
		$id = $this->input->post('id');
		$token = $this->input->post('token');
		
		if($token=='') {
			
			$response=array();
			$response['code']=0 ;
			$response['message']='Payment Failed.';
			echo json_encode($response);
			exit();
		}
		
		$order_date=$this->db->query('select * from order_details WHERE userId='.$this->session_data->userId.' and detailId='.$id)->row();
		
		if($order_date) {
			
			if($order_date->paymentStatus=='Yes') {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='You already pay this order.';
				echo json_encode($response);
				exit();
			}
			else {
				
				$paynow=$order_date->detailPrice;
				require_once(APPPATH . 'libraries/stripe-php/init.php');
				$stripe_api_key = getenv('stripe_api_secret');
				\Stripe\Stripe::setApiKey($stripe_api_key);

				$customer_email = $this->session_data->userEmail;
				$customer = \Stripe\Customer::create(array(
					'email' => $customer_email, // customer email id
					'card'  => $token
				));
				$charge = \Stripe\Charge::create(array(
					'customer'  => $customer->id,
					'amount'    => ceil($paynow*100),
					'currency'  => 'GBP'
				));

				if($charge->paid == true) {
					
					if(isset($charge->balance_transaction)) {
						$tk=$charge->balance_transaction;
					}
					else {
						$tk='';
					}
					
					$customer = (array)$customer;
					$charge = (array)$charge;

					$upd=array();
					$upd['paymentStatus']="Yes";
					$this->db->update('order_details',$upd,array('detailId'=>$id));

					// payment
					$ins=array();
					$ins['userId']=$this->session_data->userId;
					$ins['orderAmount']=$paynow;
					$ins['paymentDetail']="Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
					$ins['transactionId']=$tk;
					$ins['createdAt']=current_datetime();
					$this->db->insert('payments',$ins);

					// send notifcation to admin notify_admin //
					$notify=array();
					$notify['notificationMessage']=''.$this->session_data->userFirstName.' paid for order item#'.$id;
					$notify['notificationLink']=$id;
					$notify['notificationStatus']=1;
					$notify['notificationTime']=current_datetime();
					$notify['notificationTo']=1;
					$notify['notificationToType']='Admin';
					$notify['notificationFrom']=$this->session_data->userId;
					$notify['notificationFromType']='Member';
					$notify['notificationType']='Order Item';
					$this->db->insert('notifications', $notify);

					$response=array();
					$response['code']=1 ;
					$response['message']='paid successfully!';
					echo json_encode($response);
					exit();
				}
				else {
					
					$response=array();
					$response['code']=0 ;
					$response['message']='Payment Failed!';
					echo json_encode($response);
					exit();
				}
			}
		}
		else {
			
			$response=array();
			$response['code']=0 ;
			$response['message']='You cannot pay this order.';
			echo json_encode($response);
			exit();
		}
	}



	public function available_orders($month_number,$year){

		$available_orders=$this->db->query('select sum(detailQty) as total from order_details WHERE userId='.$this->session_data->userId.' AND paymentType="Membership" AND YEAR(membershipDate)='.$year.'  AND MONTH(membershipDate)='.$month_number)->row();
		
		if($this->membership_data->orders>0) {
			
			if($available_orders) {
				$available_orders=$this->membership_data->orders-$available_orders->total;
			}
			else {
				$available_orders=$this->membership_data->orders;
			}

			if($available_orders<1) {
				$available_orders=0;
			}
		}
		else {
			$available_orders=0;
		}
		
		$cart=$this->cart->contents();
		
		foreach ($cart as $item) {
			
			if ($item['options']['membershipDate'] != '') {
				
				if(strtotime(date('Y-m',strtotime($item['options']['membershipDate']))) == strtotime($year.'-'.$month_number)) {
					$available_orders-=$item['qty'];
				}
			}
		}

		return $available_orders;
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
