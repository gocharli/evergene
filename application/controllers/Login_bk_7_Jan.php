<?php

class Login extends CI_Controller{
	
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
		$this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('userPassword', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']='Incorrect Email Or Password';
			echo json_encode($response);
			exit();
		}
		else {
			
			$userEmail=$this->input->post('userEmail');
			$userPassword=$this->input->post('userPassword');
			$res=$this->db->query('SELECT * from users
         	where userEmail="'.$userEmail.'" and userPassword="'.md5($userPassword).'"');
			$user=$res->row();
			
			if($user) {
				
				if($user->userStatus != 'Active') {
					$response=array();
					$response['code']=0;
					$response['message']='Oops, Your account is blocked please contact support';
					echo json_encode($response);
					exit();
				}

				$data_array=array();
				$data_array['userLastLogin'] = current_datetime();
				$this->db->update('users', $data_array,array('userId'=>$user->userId));
				unset($user->userPassword);
				unset($user->passwordResetToken);
				$this->session->set_userdata(array('users'=>$user));
				$response=array();
				$response['code']=1;
				$response['message']='Successful Login';
				echo json_encode($response);
				exit();
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']='Incorrect Email Or Password';
				echo json_encode($response);
				exit();
			}
		}
	}


	public function forget_access() {
		
		$this->check_ajax_login();
		$email = $this->input->post('userEmail');
		$query = $this->db->query("SELECT * FROM users WHERE userEmail='".$email."'");
		
		if($query->num_rows()<1) {
			
			$response=array('code'=>0,'message'=> 'Email does not exist');
			echo json_encode($response);
			exit();
		}
		else {
			
			$pass_code = (uniqid());
			$this->db->set('passwordResetToken', $pass_code);
			$this->db->where('userEmail',$email);
			$this->db->update('users');
			// email //
			$to=$email;
			$subject='Reset Password';			
            $email_data['title'] ='Reset Password';
    		$email_data['body']='Your New Password Renewal Link is '.base_url().'login/update_password/'.$pass_code;
    		$email_data['link']=base_url().'login/update_password/'.$pass_code;
    		$email_data['link_name']='Reset Password';
    		$message=$this->load->view('emails/templete_1',$email_data,true);           
            
			$this->smtp_email->send('','',$to,$subject,$message);
            
			$response=array('code'=>1,'message'=> 'Password change link has been sent to your email.');
			echo json_encode($response);
			exit();
		}
	}


    public function test() {
        
        $email_data['title'] ='Reset Password';
		$email_data['body']='Your New Password Renewal Link is '.base_url().'signin/update_password/';
		$email_data['link']=base_url().'signin/update_password/';
		$email_data['link_name']='Reset Password';
		$message=$this->load->view('emails/templete_1',$email_data,true);
        echo $message;        
    }


	public function update_password() {
		
		$this->check_login();
		$this->data['page_title']='Update password';
		
		if($this->uri->segment(3)) {

			$this -> db -> select('userId');
			$this -> db -> from('users');
			$this -> db -> where('passwordResetToken', $this->uri->segment(3));
			$this -> db -> limit(1);
			$query = $this->db->get();
			
			if($query -> num_rows() == 0) {
				redirect('home');
				exit();
			}
			
			$this->data['pass_code']=$this->uri->segment(3);
			$this->load->view('update_password_view', $this->data);
		}
		else {
			redirect('home');
			exit();
		}
	}


	public function update_password_code() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('password', 'Password', 'required|matches[c-password]|min_length[8]');
		$this->form_validation->set_rules('c-password', 'Password Confirmation', 'required');
		$pass_code=$this->input->post('pass_code');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('passwordResetToken',$pass_code);
			$this->db->limit(1);
			$query = $this->db->get();
			
			if($query -> num_rows() == 0) {

				$response=array();
				$response['code']=0;
				$response['message']='Something went wrong';
				echo json_encode($response);
				exit();
			}

			$password=md5($this->input->post('password'));
			$this->db->set('userPassword', $password);
			$this->db->where('passwordResetToken', $pass_code);
			$this->db->update('users');
			$this->db->set('passwordResetToken', '');
			$this->db->where('passwordResetToken', $pass_code);
			$this->db->update('users');

			$response=array();
			$response['code']=1;
			$response['message']='password changed successfully';
			echo json_encode($response);
			exit();
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
