<?php


class Memberships extends CI_Controller {

	

	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}

	public function update_current_url(){  
		$plan_id = $this->input->post('plan_id');
		$this->session->set_userdata('current_url', base_url().'memberships?plan_id='.$plan_id);
	}

	public function index() {
		//echo $_SESSION["current_url"]; exit;
		if($_GET['redirect'] == 'cart'){
			$this->session->set_userdata('current_url', base_url().'cart');
		}else{
			$this->session->set_userdata('current_url', base_url().'memberships');
		}
		
		$this->response['page_title']="Memberships";
		$this->response['bonus']=0;
		$results=$this->db->query('select * from membership_plan ORDER BY mpId ASC')->result();

		// Added by david
		$discount_price = 0;
		if($_SESSION["coupon_code"]){
			$code = $_SESSION["coupon_code"];
			$coupon = $this->db->query("select pkg_id, percentage from coupons where code = '".$code."'")->row(); 
			foreach($results as $r){
				if($r->mpId == $coupon->pkg_id){
					$r->planAmount = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
					//$discount_price = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
				}
			}
		}

		//echo '<pre>'; print_r($results); exit;
//
		$this->response['code'] = '';
		$res = $this->db->query("select pkg_id, code, percentage from coupons where display_code = 1")->row();
		if($res){
			$res1 = $this->db->query("select planAmount, PlanDuration from membership_plan where mpId = '".$res->pkg_id."'")->row();
			if($res1){
				$this->response['code'] = $res->code;
				//$this->response['percentage'] = $r->planAmount = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
				$this->response['discounted_price'] = $res1->planAmount - ($res1->planAmount * $res->percentage/100);
				$this->response['PlanDuration'] = $res1->PlanDuration;
			}
		}
		//echo $this->response['discounted_price']; exit;
		//End

		$this->response['results'] = $results;
        
        if(isset($this->session_data->userId)){
            
            $this->response['membership_type'] = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId.' order by membershipId desc')->row();
            $this->response['orders']=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
        }        
		
        if (isset($this->session_data->userId)) {
			
			if($this->session_data->userReferal>0) {
				
				$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
				
				if (!$mship) {
					
					$orders=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
					
					if($orders==0) {
						
						$recommended_bonus=$this->general_model->select_where('settings',array('settingOption'=>'recommended_bonus'));
						
						if($recommended_bonus) {
							
							if ($recommended_bonus->settingValue == 1) {
								
								$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_membership_new_user'));
								
								if($setting_qry) {
									$bonus=$setting_qry->settingValue;
									if($bonus<1){ $bonus=0;	}
									$this->response['bonus']=$bonus;
								}
							}
						}
					}
				}
			}
		}

		$this->load->view('memberships',$this->response);
	}

	public function buy_memb($id=0){

		if (!isset($this->session_data->userId)) {
			redirect('memberships');
		}

		$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
		if($mship){ // previous subscription exists

			if($mship->mpId == $id){  // same package already subscribed
				$now = date('Y-m-d');
				$exp = date('Y-m-d', $mship->period_end);
				
				if($exp > $now){ // pakges is active
					redirect('memberships');
				}
			}

			

			

		}
		
		$this->response['page_title']="Buy Membership";

		// Importing same code as membership
		
		$this->response['bonus']=0;
		$results=$this->db->query('select * from membership_plan where mpId = "'.$id.'"')->result();

		// Added by david
		$discount_price = 0;
		if($_SESSION["coupon_code"]){
			$code = $_SESSION["coupon_code"];
			$coupon = $this->db->query("select pkg_id, percentage from coupons where code = '".$code."'")->row(); 
			foreach($results as $r){
				if($r->mpId == $coupon->pkg_id){
					$r->planAmount = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
					//$discount_price = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
				}
			}
		}

		//echo '<pre>'; print_r($results); exit;
//
		$this->response['code'] = '';
		$res = $this->db->query("select pkg_id, code, percentage from coupons where display_code = 1")->row();
		if($res){
			$res1 = $this->db->query("select planAmount, PlanDuration from membership_plan where mpId = '".$res->pkg_id."'")->row();
			if($res1){
				$this->response['code'] = $res->code;
				//$this->response['percentage'] = $r->planAmount = $r->planAmount - ($r->planAmount * $coupon->percentage/100);
				$this->response['discounted_price'] = $res1->planAmount - ($res1->planAmount * $res->percentage/100);
				$this->response['PlanDuration'] = $res1->PlanDuration;
			}
		}
		//echo $this->response['discounted_price']; exit;
		//End

		$this->response['results'] = $results;
        
        if(isset($this->session_data->userId)){
            
            $this->response['membership_type'] = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
            $this->response['orders']=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
        }        
		
        if (isset($this->session_data->userId)) {
			
			if($this->session_data->userReferal>0) {
				
				$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
				
				if (!$mship) {
					
					$orders=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
					
					if($orders==0) {
						
						$recommended_bonus=$this->general_model->select_where('settings',array('settingOption'=>'recommended_bonus'));
						
						if($recommended_bonus) {
							
							if ($recommended_bonus->settingValue == 1) {
								
								$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_membership_new_user'));
								
								if($setting_qry) {
									$bonus=$setting_qry->settingValue;
									if($bonus<1){ $bonus=0;	}
									$this->response['bonus']=$bonus;
								}
							}
						}
					}
				}
			}
		}


		// End


		$this->load->view('buy_memb',$this->response);
	}

	public function add_coupon(){

		$curr_date = date('Y-m-d');
		$code = $this->input->post('code');


		$cnt = $this->db->query("select count(*) as cnt from coupons where code = '".$code."'")->row()->cnt;
		if($this->input->post('plan_id') && $this->input->post('plan_id') > 0){
			$plan_id = $this->input->post('plan_id');
			$cnt = $this->db->query("select count(*) as cnt from coupons where code = '".$code."' and pkg_id = '".$plan_id."'")->row()->cnt;
		}

		
		if($cnt <= 0){
			$response['code']=0;
			$response['message']='Invalid Code!';
			echo json_encode($response);
			exit();
		}
		
		$coupon = $this->db->query("select * from coupons where code = '".$code."' and ('".$curr_date."' between start_date and expiry_date) and frequency > 0 ")->row();
		$response=array();

		if($coupon->expiry_date < $curr_date){
			$response['code']=0;
			$response['message']='Code has been expired!';
			echo json_encode($response);
			exit();
		}


		if($curr_date < $coupon->start_date){
			$response['code']=0;
			$response['message']='You cannot use this code before '.$coupon->start_date;
			echo json_encode($response);
			exit();
		}

		if($coupon){
			
			session_start();
			$_SESSION["coupon_code"] = $code;

			$original_price = $this->db->query("select planAmount from membership_plan where mpId = '".$coupon->pkg_id."'")->row()->planAmount;
			$new_price = $original_price - ($original_price * $coupon->percentage/100);
			
			$response['code']=1;
			$response['plan_id'] = $coupon->pkg_id;
			$response['new_price'] = $new_price; 
			$response['message']='Code is applied successfully';
			echo json_encode($response);
			exit();
			
		}else{
			$response['code']=0;
			$response['message']='Invalid Code!';
			echo json_encode($response);
			exit();
		}
	}

	public function remove_coupon(){

		unset($_SESSION['coupon_code']);
		redirect($_SERVER['HTTP_REFERER']);
		//redirect('memberships');

	}



	public function process() {
		
		$this->check_ajax_login();
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);

		$this->form_validation->set_rules('planId', 'Plan', 'required');
		$this->form_validation->set_rules('stripeToken', 'Token', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$mpId=$this->input->post('planId');
			$token=$this->input->post('stripeToken');
			$plan=$this->db->query('select * from membership_plan where mpId='.$mpId)->row();
			
			if(!$plan) {
				
				$response=array();
				$response['code']=0 ;
				$response['message']='Plan not found';
				echo json_encode($response);
				exit();
			}

			$bonus=0;
			
			if($this->session_data->userReferal>0) {
				
				$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
				
				if (!$mship) {
					
					$orders=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
					
					if($orders==0) {
						
						$recommended_bonus=$this->general_model->select_where('settings',array('settingOption'=>'recommended_bonus'));

						if($recommended_bonus) {
							
							if ($recommended_bonus->settingValue == 1) {
								
								$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_membership_new_user'));
								
								if($setting_qry) {
									
									$bonus=$setting_qry->settingValue;
									if($bonus<1){ $bonus=0;	}
								}
							}
						}
					}
				}
			}

			// Added by David
			$coupon_discount = 0;
			if($_SESSION["coupon_code"]){
				$code = $_SESSION["coupon_code"];
				$coupon = $this->db->query("select * from coupons where code = '".$code."' ")->row();
				if($mpId == $coupon->pkg_id){
					$coupon_discount = $plan->planAmount * $coupon->percentage/100;
					//echo $coupon_discount; exit;
				}	
			}
			// End

			$customer_email = $this->session_data->userEmail;
			$customer = \Stripe\Customer::create(array(
				'email' => $customer_email, // customer email id
				'card'  => $token
			));

			if($bonus>0) {
				
				$nbonus=$bonus*100;
				if($coupon_discount > 0){
					$nbonus = $nbonus + ($coupon_discount*100);
				}
				$coupon= \Stripe\Coupon::retrieve("discount-once");
				
				if(isset($coupon->id)) {
					$coupon->delete();
				}
				
				\Stripe\Coupon::create(array(
					'duration' => 'once',
					'id' => 'discount-once',
					'currency' => 'GBP',
					'amount_off' => $nbonus,
				));

				$subscription = \Stripe\Subscription::create(array(
					"customer" => $customer->id,
					"plan" => $plan->planId,
					'coupon' => 'discount-once',
				));
			}
			else {
				// Added by david
				if($coupon_discount > 0){
					$nbonus = $coupon_discount*100;
					$coupon= \Stripe\Coupon::retrieve("discount-once");
				
					if(isset($coupon->id)) {
						$coupon->delete();
					}
					
					\Stripe\Coupon::create(array(
						'duration' => 'once',
						'id' => 'discount-once',
						'currency' => 'GBP',
						'amount_off' => $nbonus,
					));

					$subscription = \Stripe\Subscription::create(array(
						"customer" => $customer->id,
						"plan" => $plan->planId,
						'coupon' => 'discount-once'
					));

					// End

				}else{
					$subscription = \Stripe\Subscription::create(array(
						"customer" => $customer->id,
						"plan" => $plan->planId
					));
				}

				
			}
			
			if(isset($subscription->id)) {
				
				if($subscription->id!="" && $subscription->status=="active") {
					
					$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
					
					if($mship) {
						
						// cancel //
						$oldsub = \Stripe\Subscription::retrieve($mship->StripeSubscriptionID);
						$currnet=strtotime('now');
						
						if($oldsub->ended_at>=$currnet) {
							$oldsub->cancel();
						}

						$sub_id = $subscription->id;
						$coustomer = $subscription->customer;
						//$created   =$subscription_new->created;
						$current_period_end=$subscription->current_period_end;
						$current_period_start=$subscription->current_period_start;

						$data=array();
						$data['mpId']=$plan->mpId;
						$data['period_start']=$current_period_start;
						$data['period_end']=$current_period_end;
						$data['createdAt']=current_datetime();
						$data['StripeCustomerID']=$coustomer;
						$data['StripeSubscriptionID']=$sub_id;
						$data['StripeSubscriptionEnded']='';
						$data['orders']=$plan->planOrders;
						$data['ordersPeriod']=$plan->planOrderPeriod;
						$this->db->update('memberships',$data,array('userId'=>$this->session_data->userId));


						// Code added by david & Unset coupon and keep log
						if($_SESSION["coupon_code"]){

							$code = $_SESSION["coupon_code"];
							$coupon = $this->db->query("select * from coupons where code = '".$code."' ")->row();

							if($mpId == $coupon->pkg_id){
								if($coupon->frequency > 0){
									$new_freq = $coupon->frequency - 1;
									$this->db->where("ID", $coupon->ID)->update("coupons", array("frequency"=>$new_freq));
								}

								$c_used['code'] = $code;
								$c_used['plan_id'] = $plan->mpId;
								$c_used['user_id'] = $this->session_data->userId;
								$c_used['user_name'] = $this->session_data->userFirstName.' '.$this->session_data->userLastName;
								$c_used['percentage'] = $coupon->percentage;
								$c_used['createdAt'] = date('Y-m-d');
								$c_used['code'] = $code;
								$this->db->insert("coupon_used", $c_used);
								unset($_SESSION["coupon_code"]);
							}
						}
						// End

						$response=array();
						$response['code']=1;
						$response['message']='Successfully subscribe';
						echo json_encode($response);
						exit();
					}
					else {
						
						$sub_id = $subscription->id;
						$coustomer = $subscription->customer;
						//$created   =$subscription->created;
						$current_period_end=$subscription->current_period_end;
						$current_period_start=$subscription->current_period_start;

						$data=array();
						$data['mpId']=$plan->mpId;
						$data['userId']=$this->session_data->userId;
						$data['period_start']=$current_period_start;
						$data['period_end']=$current_period_end;
						$data['createdAt']=current_datetime();
						$data['StripeCustomerID']=$coustomer;
						$data['StripeSubscriptionID']=$sub_id;
						$data['StripeSubscriptionEnded']='';
						$data['orders']=$plan->planOrders;
						$data['ordersPeriod']=$plan->planOrderPeriod;
						$this->db->insert('memberships',$data);

						// add referal entry //
						if($bonus>0) {
							
							$ins=array();
							$ins['userId']=$this->session_data->userId;
							$ins['refId']=$this->session_data->userReferal;
							$ins['refType']='Referral';
							$ins['refStatus']='Used';
							$ins['refBonus']=$bonus;
							$ins['refBonusPercentage']='No';
							$ins['refBonusType']='Subscribe membership';
							$this->db->insert('user_referral_bonus', $ins);

							$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_membership_existing_user'));
							
							if($setting_qry) {
								
								$ebonus=$setting_qry->settingValue;
								
								if($ebonus<1) { 
									$ebonus=0;
								}

								$ins=array();
								$ins['userId']=$this->session_data->userReferal;
								$ins['refId']=$this->session_data->userId;
								$ins['refType']='User';
								$ins['refStatus']='Active';
								$ins['refBonus']=$ebonus;
								$ins['refBonusPercentage']='No';
								$ins['refBonusType']='Subscribe membership';
								$this->db->insert('user_referral_bonus', $ins);
							}
						}


						// Code added by david & Unset coupon and keep log
						if($_SESSION["coupon_code"]){

							$code = $_SESSION["coupon_code"];
							$coupon = $this->db->query("select * from coupons where code = '".$code."' ")->row();
							
							if($mpId == $coupon->pkg_id){
								if($coupon->frequency > 0){
									$new_freq = $coupon->frequency - 1;
									$this->db->where("ID", $coupon->ID)->update("coupons", array("frequency"=>$new_freq));
								}

								$c_used['code'] = $code;
								$c_used['plan_id'] = $plan->mpId;
								$c_used['user_id'] = $this->session_data->userId;
								$c_used['user_name'] = $this->session_data->userFirstName.' '.$this->session_data->userLastName;
								$c_used['percentage'] = $coupon->percentage;
								$c_used['createdAt'] = date('Y-m-d');
								$c_used['code'] = $code;
								$this->db->insert("coupon_used", $c_used);
								unset($_SESSION["coupon_code"]);
							}
						}
						// End


						$response=array();
						$response['code']=1;
						$response['message']='Successfully subscribe';
						echo json_encode($response);
						exit();
					}
				}
				else {
					
					$response=array();
					$response['code']=0;
					$response['message']='Failed to subscribe';
					echo json_encode($response);
					exit();
				}
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']='Failed to subscribe';
				echo json_encode($response);
				exit();
			}
		}
	}

	public function get_subs(){
		
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);



		//\Stripe\Stripe::setApiKey('sk_test_QhoBncRkypT7psMtGpnsEnaG');
		//$res = \Stripe\Coupon::retrieve("discount-once");
			$res = \Stripe\Subscription::retrieve(
			'sub_GiMBuIi2ezN5fx'
			);
			echo '<pre>'; print_r($res);
	}


	public function hide_top_bar(){

		$this->session->set_userdata('hide_top_bar', 'yes');
		echo 'success';

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
