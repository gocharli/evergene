<?php


class Memberships extends CI_Controller {

	

	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'memberships');
		$this->response['page_title']="Memberships";
		$this->response['bonus']=0;
		$this->response['results']=$this->db->query('select * from membership_plan ORDER BY mpId ASC')->result();
        
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

		$this->load->view('memberships',$this->response);
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

			$customer_email = $this->session_data->userEmail;
			$customer = \Stripe\Customer::create(array(
				'email' => $customer_email, // customer email id
				'card'  => $token
			));

			if($bonus>0) {
				
				$nbonus=$bonus*100;
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
				
				$subscription = \Stripe\Subscription::create(array(
					"customer" => $customer->id,
					"plan" => $plan->planId
				));
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
