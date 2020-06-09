<?php


class Account extends CI_Controller {
	

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
				}
				else {
					$mship->expire = true;
				}

				$this->membership_data = $mship;
			}
		}
	}



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'account');
		$this->check_login();

		$this->response['newResults']=$this->db->query('select count(*) as count FROM order_details
 		WHERE userId='.$this->session_data->userId.' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();
 		
		$this->response['page_title']="General Settings";
		$this->response['row']=$this->db->query('select * from users WHERE userId='.$this->session_data->userId)->row();
		$this->response['membership']=$this->db->query('select * from memberships
                                            left join membership_plan on memberships.mpId=membership_plan.mpId
                                            where memberships.userId='.$this->session_data->userId)->row();
		$this->load->view('account',$this->response);
	}

	public function export_csv(){
     
			header('Content-Type: text/csv; charset=utf-8');  
			header('Content-Disposition: attachment; filename=user.csv');  
			$output = fopen("php://output", "w");  
			fputcsv($output, array('First Name', 'Last Name', 'Email', 'Gender', 'DOB', 'Address', 'City', 'Country', 'Post Code', 'Created Date'));
			
			$user = $this->db->query("SELECT userFirstName, userLastName, userEmail, userGender, userDob, user_address1, user_city, user_country, user_post_code, date(createdAt) from users where userId = ".$this->session_data->userId)->row_array(); 
			fputcsv($output, $user);  
			
			fclose($output);  
	    

	}



	public function change_password() {

		exit();
		$this->check_login();
		$this->response['page_title']="Change Password";
		$this->load->view('change_password',$this->response);
	}



	public function process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('userFirstName', 'First Name', 'required');
		$this->form_validation->set_rules('userLastName', 'Last Name', 'required');
        $this->form_validation->set_rules('userDob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('userGender', 'Gender', 'required');
		$this->form_validation->set_rules('userEmail', 'Email Address', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$userFirstName=$this->input->post('userFirstName');
			$userLastName=$this->input->post('userLastName');
			$userEmail=$this->input->post('userEmail');
			$address1=$this->input->post('address1');
			$address2=$this->input->post('address2');
			$userCity=$this->input->post('userCity');
			$userCountry=$this->input->post('userCountry');
			$userPostCode=$this->input->post('userPostCode');
			$userPhone=$this->input->post('userPhone');
            $userDob=$this->input->post('userDob');
  	        $userGender=$this->input->post('userGender');
			
			if(!valid_name($userFirstName) || !valid_name($userLastName)) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Invalid character in name field';
				echo json_encode($response);
				exit();
			}

			$upd=array();
			// Added by david
			$key="";
			$new_msg="";
			if($this->session_data->userEmail != $userEmail){
				
				$upd['tempEmail'] = $userEmail;
				$upd['userEmailStatus'] = 'Unverified';
				$key = $userEmail.date('mY');
				$key = md5($key);
				$upd['userEmailConfirmCode']=$key;

			}
			// End 
			
			$upd['userFirstName']=$userFirstName;
			$upd['userLastName']=$userLastName;
			$upd['user_address1']=$address1;
			$upd['user_address2']=$address2;
			$upd['user_city']=$userCity;
			$upd['user_country']=$userCountry;
			$upd['user_post_code']=$userPostCode;
			$upd['userPhone']=$userPhone;
            $upd['userGender'] = $userGender;  
            $upd['userDob'] = $userDob;
			$upd['updatedAt'] = current_datetime();
			$this->db->update('users',$upd,array('userId'=>$this->session_data->userId));

			// Added by david send confirmation to new email
			if($this->session_data->userEmail != $userEmail){
						
				$name=$userFirstName.' '.$userLastName;
				$to=$userEmail;
				$subject='CONFIRMATION EMAIL';
				
				$email_data['title'] ='CONFIRMATION EMAIL';
				$email_data['body']='Welcomes '.$name.'. Kindly click the given link for activation of your Account.';
				$email_data['link']=base_url().'signup/confirm/'.$key.'/'.$to;
				$email_data['link_name']='Activate';
				$message=$this->load->view('emails/templete_1',$email_data,true);             
				$this->smtp_email->send('','',$to,$subject,$message);
				$new_msg=". Please check your email to verify your new email address";
			}
			// End
            
            $upd=array();
            $upd['gender']=$userGender;
            $upd['dob']=$userDob;
			$this->db->update('user_details',$upd,array('userId'=>$this->session_data->userId));            
            
			$user=$this->db->query('SELECT * from users where userId="'.$this->session_data->userId.'"')->row();
			unset($user->userPassword);
			unset($user->passwordResetToken);
			$this->session->set_userdata(array('users'=>$user));
			$response=array();
			$response['code']=1;
			$response['message']='Profile updated successfully'.$new_msg;
			echo json_encode($response);
			exit();
		}
	}



	public function password_code() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|matches[c-password]|min_length[8]');
		$this->form_validation->set_rules('c-password', 'Password Confirmation', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0 ;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$password = md5($this->input->post('password'));
			$new_password = md5($this->input->post('new_password'));
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('userId', $this->session_data->userId);
			$this->db->where('userPassword', $password);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				
				$this->db->set('userPassword', $new_password);
				$this->db->where('userId', $this->session_data->userId);
				$this->db->update('users');
			}
			else {
				
				$response = array();
				$response['code'] = 0;
				$response['message'] = 'password is incorrect!';
				echo json_encode($response);
				exit();
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'password changed Successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function membership() {
		
		exit();
		$this->check_login();
		$this->response['page_title']="Membership";
		$this->response['row']=$this->db->query('select * from memberships
                                            left join membership_plan on memberships.mpId=membership_plan.mpId
                                            where memberships.userId='.$this->session_data->userId)->row();
		$this->load->view('own_membership',$this->response);
	}



	public function cancel_membership() {
		
		$this->check_ajax_login();
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);
		$res=$this->db->query('select * from memberships                                           
        where memberships.userId='.$this->session_data->userId);
		
		if($res->num_rows()==1) {

			$result=$res->row_array();
			$currnet=strtotime('now');
            $dateAfterForteen= strtotime(date('m/d/Y',strtotime('+14 days',$result['period_start'])));
			
			if($currnet<$result['period_end']) {
				
				$subscription = \Stripe\Subscription::retrieve($result['StripeSubscriptionID']);
                
                if($currnet>$dateAfterForteen) {
                    $subscription->refunds->create(array('amount' => $subscription->plan->amount));
                }

				$subscription->cancel(array('at_period_end' => true));

				if(isset($subscription->id)) {

					if($subscription->id!="" && $subscription->status=="active") {
						
						//$sub_id = $subscription->id;
						//$coustomer = $subscription->customer;
						$current_period_end=$subscription->current_period_end;
						$current_period_start=$subscription->current_period_start;
						$canceled_at=$subscription->canceled_at;
						$data=array();
						$data['period_start']=$current_period_start;
						$data['period_end']=$current_period_end;
						//  $data['createdAt']=$created;
						$data['StripeSubscriptionEnded']=$canceled_at;
						$this->db->update('memberships',$data,array('userId'=>$this->session_data->userId));
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
			$response['message']='Something Wrong';
			echo json_encode($response);
			exit();
		}
	}

	public function delete_account() {
		
		$this->check_ajax_login();
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);
		$res=$this->db->query('select * from memberships                                           
        where memberships.userId='.$this->session_data->userId);
		
		if($res->num_rows()==1) {

			$result=$res->row_array();
			$currnet=strtotime('now');
            $dateAfterForteen= strtotime(date('m/d/Y',strtotime('+14 days',$result['period_start'])));
			
			if($currnet<$result['period_end']) {
				
				$subscription = \Stripe\Subscription::retrieve($result['StripeSubscriptionID']);
                
                if($currnet>$dateAfterForteen) {
                    $subscription->refunds->create(array('amount' => $subscription->plan->amount));
                }

				$subscription->cancel(array('at_period_end' => true));

				if(isset($subscription->id)) {

					if($subscription->id!="" && $subscription->status=="active") {
						
						//$sub_id = $subscription->id;
						//$coustomer = $subscription->customer;
						$current_period_end=$subscription->current_period_end;
						$current_period_start=$subscription->current_period_start;
						$canceled_at=$subscription->canceled_at;
						$data=array();
						$data['period_start']=$current_period_start;
						$data['period_end']=$current_period_end;
						//  $data['createdAt']=$created;
						$data['StripeSubscriptionEnded']=$canceled_at;
						$this->db->update('memberships',$data,array('userId'=>$this->session_data->userId));
						
					}
				}
			}
		}


		$this->db->update('users',array("isDeleted"=>'Yes'),array('userId'=>$this->session_data->userId));
		
		// Remove session
		$this->session->unset_userdata('users');
		$this->session->unset_userdata('current_url');
		$this->cart->destroy();
		// Remove session
		
		$response=array();
		$response['code']=1 ;
		$response['message']='Your account has been deleted successfully';
		echo json_encode($response);
		exit();

	}



	public function check_login() {
		
		if (!isset($this->session_data->userId)) {
			
			redirect('home');
		}
	}


	
	public function check_ajax_login() {
		
		if(!isset($this->session_data->userId)) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
	}

	public function update_notifications(){

			$type=$this->input->post('type');
			$noti=$this->input->post('noti');
			
			$this->db->where("userId", $this->session_data->userId)->update("users", array($type=>$noti));
			echo '1';

	}
}
