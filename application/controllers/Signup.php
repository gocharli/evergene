<?php


class Signup extends CI_Controller{
	


	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'home');
		redirect('home');
	}



	public function process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('userFirstName', 'First Name', 'required');
		$this->form_validation->set_rules('userLastName', 'Last Name', 'required');
		$this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('userPassword', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
		$this->form_validation->set_rules('cuserPassword', 'Confirm Password', 'required|matches[userPassword]');
        $this->form_validation->set_rules('userDob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('userGender', 'Gender', 'required');
		$this->form_validation->set_rules('terms1', 'Terms and Condition', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {

			$userFirstName=$this->input->post('userFirstName');
			$userLastName=$this->input->post('userLastName');
			$userEmail=$this->input->post('userEmail');
			$userPassword=$this->input->post('userPassword');
            $userDob=$this->input->post('userDob');
  	        $userGender=$this->input->post('userGender');

			if(!valid_name($userFirstName) || !valid_name($userLastName)) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Invalid character in name field';
				echo json_encode($response);
				exit();
			}
			
			$email_check = $this->general_model->role_exists('userEmail', $userEmail,'users');
			
			if($email_check == false) {

				$deleted_check = $this->general_model->deleted_role_exists('userEmail', $userEmail,'users');

				if($deleted_check==false){

					$response=array();
					$response['code']=0;
					$response['message']= $userEmail.' already exists ssss';
					echo json_encode($response);
					exit();
				}
				else{

					$user_data = array(

						'userFirstName' => $userFirstName,
						'userLastName' => $userLastName,
						'userEmail' => $userEmail,
						'userPassword' => md5($userPassword),
						'userGender' => $userGender,
						'userDob' => $userDob,
						'userStatus' => 'Active',
						'isDeleted' => 'No',
					);
					$this->db->where('userId', $deleted_check->userId);
					$this->db->update('users', $user_data);

					$user=$this->db->query('SELECT * from users where userId="'.$deleted_check->userId.'"')->row();

					if($user){
						$this->session->set_userdata(array('users'=>$user));
					}
					
					$name=$userFirstName.' '.$userLastName;
					$response=array();
					$response['code']=1;
					$response['message']=$name." Profile Created Successfully";

					echo json_encode($response);
					exit();
				}
				
				
			}

			$ins=array();
			$ins['userFirstName'] = $userFirstName;
			$ins['userLastName'] = $userLastName;
			$ins['userEmail'] = $userEmail;
			$ins['userPassword'] = md5($userPassword);
            $ins['userGender'] = $userGender;  
            $ins['userDob'] = $userDob;
			$ins['userStatus'] = 'Active';
			$ins['userEmailStatus'] = 'Unverified';
			$ins['createdAt'] = current_datetime();
			$ins['updatedAt'] = current_datetime();

			$key = $userEmail.date('mY');
			$key = md5($key);
			$ins['userEmailConfirmCode']=$key;
			$this->db->insert('users', $ins);
			$userId=$this->db->insert_id();
			// Referral  //
			$ref=$this->input->post('ref');
			
			if($ref!='') {
				
				$ref=str_replace('EG','',$ref);
				$ref_chk=$this->db->query('select * from users WHERE userId="'.$ref.'"')->row();
				
				if($ref_chk) {
					
					$upd=array();
					$upd['userReferal']=$ref;
					$this->db->update('users',$upd,array('userId'=>$userId));
					$recommended_bonus=$this->general_model->select_where('settings',array('settingOption'=>'recommended_bonus'));
					
					if($recommended_bonus) {
						
						if($recommended_bonus->settingValue==1) {
							
							$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_item_new_user'));
							
							if($setting_qry) {
								
								$bonus=$setting_qry->settingValue;
								
								if($bonus<1) {
									$bonus=0;
								}
								
								$ins=array();
								$ins['userId']=$userId;
								$ins['refId']=$ref;
								$ins['refType']='Referral';
								$ins['refStatus']='Active';
								$ins['refBonus']=$bonus;
								$ins['refBonusPercentage']='No';
								$ins['refBonusType']='First Order';
								$this->db->insert('user_referral_bonus', $ins);
							}

							$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_item_existing_user'));
							
							if($setting_qry) {
								
								$bonus=$setting_qry->settingValue;
								
								if($bonus<1) {
									$bonus=0;
								}
								
								$ins=array();
								$ins['userId']=$ref;
								$ins['refId']=$userId;
								$ins['refType']='User';
								$ins['refStatus']='Pending';
								$ins['refBonus']=$bonus;
								$ins['refBonusPercentage']='No';
								$ins['refBonusType']='First Order';
								$this->db->insert('user_referral_bonus', $ins);
							}
						}
					}
				}
			}

            $ins=array();
			$ins['userId']=$userId;
            $ins['gender']=$userGender;
            $ins['dob']=$userDob;
			$this->db->insert('user_details', $ins);
            
            $user=$this->db->query('SELECT * from users where userId="'.$userId.'"')->row();
            
            if($user) {
                unset($user->userPassword);
    			unset($user->passwordResetToken);
    			$this->session->set_userdata(array('users'=>$user));
            }

            $name=$userFirstName.' '.$userLastName;
			$to=$userEmail;
			$subject='CONFIRMATION EMAIL';
			$email_data['title'] ='CONFIRMATION EMAIL';
    		$email_data['body']='Welcome '.$name.'. Kindly click the given link for activation of your Account.';
    		$email_data['link']=base_url().'signup/confirm/'.$key.'/'.$to;
    		$email_data['link_name']='Activate';
    		$message=$this->load->view('emails/templete_1',$email_data,true);  
			$this->smtp_email->send('','',$to,$subject,$message);
            
			$response=array();
			$response['code']=1;
			$response['message']=$name." Profile Created Successfully";


			// Added 19 May

				$data_array=array();
				$data_array['userLastLogin'] = current_datetime();
				$data_array['loginIP'] = $this->input->ip_address();
				$this->db->update('users', $data_array,array('userId'=>$user->userId));
				unset($user->userPassword);
				unset($user->passwordResetToken);
				$this->session->set_userdata(array('users'=>$user));
				
				//echo json_encode($response);
				//exit();

			// End


			echo json_encode($response);
			exit();
		}
	}

	public function password_check($str)
	{
	if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
		return TRUE;
	}else{
		$this->form_validation->set_message('password_check', 'The {field} must contains atleast 1 letter and number');
		return false;
	}
	//return FALSE;
	}



	public function confirm($key,$email) {
		
		//$this->check_login();
		// Added by david
		$this->session->unset_userdata('users');
		$this->session->unset_userdata('current_url');
		$this->cart->destroy();
		// Added by david

		//$sql = "SELECT SQL_CALC_FOUND_ROWS * from `users` where `userEmailConfirmCode`='".$key."' and `userEmail`='".$email."'";
		$sql = "SELECT SQL_CALC_FOUND_ROWS * from `users` where `userEmailConfirmCode`='".$key."'";
		$res = $this->db->query($sql);
		
		if($res->num_rows()>0) {
			
			$user=$res->row();
			$data['userEmailStatus']='Verified';
			$data['userStatus']='Active';
			$data['userEmailConfirmCode']="";
			//$this->db->update('users',$data,array('userId'=>$user->userId));
			// Added by david
			if(!empty($user->tempEmail) && $user->userEmail != $user->tempEmail){
				$data['userEmail']=$user->tempEmail;
				$data['tempEmail']='';
				$this->db->update('users',$data,array('userId'=>$user->userId));
			}else{
				$this->db->update('users',$data,array('userId'=>$user->userId));
			}
			$this->session->set_flashdata('verification', 'Email is verified successfully please login!!');
			redirect('home');
		}
		else {
			redirect('home');
		}
	}



	public function check_login() {
		
		if (isset($this->session_data->userId)) {
			redirect('account');
		}
	}



	public function check_ajax_login() {
		
		if (isset($this->session_data->userId)) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Already login!';
			echo json_encode($response);
			exit();
		}
	}


}
