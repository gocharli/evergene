<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
    
    

    public function __construct() {
        
        parent::__construct();
        $sess_data=$this->session->userdata('admin');
        $this->session_data = $sess_data;
    }



    public function index() {
        
        $this->check_login();
        $this->data['page_title']='Members - Admin';
        $this->load->view('admin/list_members', $this->data);
    } 



    public function add() {
        
        $this->check_login();
        $this->data['page_title']='Add Member - Admin';
        $this->load->view('admin/add_member', $this->data);
    } 



    public function edit($id=0) {
        
        $this->check_login();
        $user = $this->db->query("SELECT * FROM users WHERE userId='".$id."'")->row();
        
        if($user) {
            $this->data['page_title']='Edit Member';
            $this->data['row']=$user;
            $this->load->view('admin/edit_users', $this->data);
        }
        else {

           redirect('admin/members');
        }        
    }



    public function edit_process($id=0) {
        
        $this->check_ajax_login();
        $user = $this->db->query("SELECT * FROM users WHERE userId='".$id."'")->row();
        
        if($user) {
			
            $this->form_validation->set_rules('userFirstName', 'First Name', 'required');
			$this->form_validation->set_rules('userLastName', 'Last Name', 'required');
            $this->form_validation->set_rules('userDob', 'Date of Birth', 'required');
            $this->form_validation->set_rules('userGender', 'Gender', 'required');
    		
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
                $upd['userFirstName']=$userFirstName;
                $upd['userLastName']=$userLastName;
                $upd['userGender'] = $userGender;  
                $upd['userDob'] = $userDob;
                $upd['updatedAt'] = current_datetime();
                $this->db->update('users',$upd,array('userId'=>$user->userId));
                
                $upd=array();
                $upd['gender']=$userGender;
                $upd['dob']=$userDob;
                $this->db->update('user_details',$upd,array('userId'=>$user->userId));    			
                
                $response=array();
    			$response['code']=1;
    			$response['message']='updated successfully';
    			echo json_encode($response);
    			exit();            
            }  
        }
        else {
           
           $response=array();
		   $response['code']=0;
		   $response['message']='Member not found';
		   echo json_encode($response);
		   exit();   
        }        
    }



    public function add_process() {
        
        $this->check_ajax_login();
       	$this->form_validation->set_rules('userFirstName', 'First Name', 'required');
		$this->form_validation->set_rules('userLastName', 'Last Name', 'required');
		$this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('userPassword', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('userDob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('userGender', 'Gender', 'required');
       
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
        	   $response=array();
    		   $response['code']=0;
    		   $response['message']= $userEmail.' already exists ';
    		   echo json_encode($response);
    		   exit();  
            }

            
            $ins=array();
            $ins['userFirstName'] = $userFirstName;
            $ins['userLastName'] = $userLastName;
            $ins['userEmail'] = $userEmail;
    	    $ins['userPassword'] = md5($userPassword);
            $ins['userGender'] = $userGender;  
            $ins['userDob'] = $userDob;
            $ins['userStatus'] = 'Active';
            $ins['userEmailStatus'] = 'Verified';
            $ins['createdAt'] = current_datetime();
            $ins['updatedAt'] = current_datetime();
     	    $this->db->insert('users', $ins);

    		$userId=$this->db->insert_id();
                
            $ins=array();
    		$ins['userId']=$userId;
            $ins['gender']=$userGender;
            $ins['dob']=$userDob;
    		$this->db->insert('user_details', $ins);
                 
                 
            $name=$userFirstName.' '.$userLastName;
            $to=$userEmail;
            $subject=getenv('APP_NAME').' Login Information';
            $content ='<h2>Login Information</h2>';
            $content .='Email: '.$to.' <br/>Password: '.$userPassword.' <br/> Please click on the following link (or copy and paste it into your browser) to sign in.<br/><br/> <a href="'.base_url().'login">'.base_url().'login</a>';
            $content.='<div style="width:100px;margin:0 auto;"><a href="'.base_url().'login" style="color: #ffffff; background: #14191c; padding:8px; text-decoration: none;">Login</a></div>' ;
            //$email_data['content']= $content;                 
            //$message=$this->load->view('emails/general',$email_data,true); 
            $message=$content;
            $this->smtp_email->send('','',$to,$subject,$message);

    		$response=array();
    		$response['code']=1;
    		$response['message']=$name." Profile Created Successfully!";
    		echo json_encode($response);
    		exit();
    	}
    }



    public function list_data() {
   	    
        $this->check_ajax_datatable();
        $columns = array( 
            0 =>'userId',
            1 =>'userFirstName',
            2 =>'userEmail',
            3=> 'userEmailStatus',
            4=> 'userStatus',
            5=> 'userId'
        );
        
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        
        $whr='where 1=1 ';
        
        $totalData = $this->db->query('select * from users '.$whr)->num_rows();
        $totalFiltered = $totalData; 
        
        if(empty($this->input->post('search')['value'])) {   
            
            $sq=$this->db->query('select * from users '.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
            
            if($sq->num_rows()>0) {
                
                $result=$sq->result();   
            }
            else {
                
                $result=null;   
            } 
        }
        else {
            
            $search = $this->input->post('search')['value'];
            $whr.=' and (userId like "%'.$search.'%" or  userFirstName like "%'.$search.'%" or userEmail like "%'.$search.'%")';
            
            $sq=$this->db->query('select * from users '.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
            
            if($sq->num_rows()>0) {
                
                $result=$sq->result();   
            }
            else {
                
                $result=null;   
            }
            $totalFiltered = $this->db->query('select * from users '.$whr)->num_rows();
        }
        
        $data = array();
        
        if(!empty($result)) {
            
            foreach ($result as $row) { 
                
                $btn='btn btn-out btn-sm waves-effect waves-light btn-info';
                $txt="Pending";
                
                if($row->userStatus=='Active') {
                    
                    $btn='btn btn-out btn-sm waves-effect waves-light btn-success';    
                    $txt="Active";
                }

                else if($row->userStatus=='Inactive') {
                    $txt="Block";
                    $btn='btn btn-out btn-sm waves-effect waves-light btn-danger';
                }
                
                $nestedData['id'] = $row->userId;
                $nestedData['name'] = $row->userFirstName.' '.$row->userLastName;
                $nestedData['email'] = $row->userEmail;
                $nestedData['status'] = '<a id="status_'.$row->userId.'" href="javascript:status('.$row->userId.');"><button class="'.$btn.'">'.$txt.'</button></a>';
                $nestedData['emailStatus'] = $row->userEmailStatus;
                $nestedData['action']='<a href="'.$this->config->item('admin_url').'/members/edit/'.$row->userId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a> ';
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);       
    }  



    public function change_status() {
        
        $this->check_ajax_login();
        $id=$this->input->post('id');
        $type=$this->input->post('type');
        $client = $this->db->query("SELECT * FROM users WHERE userId='".$id."'")->row();
        
        if($client) {
            
            $btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-success">Active</button>'; 
            
            if($type!='Active') {
                
                $type='Inactive';
                $btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Block</button>'; 
            }
            
            $this->db->set('userStatus', $type);
	   	    $this ->db->where('userId',$id);
		    $this->db->update('users');
           
            $response=array();
            $response['code']=1;
            $response['message']='Status updated successfully';
            $response['status_code']=$btn;
            echo json_encode($response);
            exit();            
        }
        else {

            $response = array();
			$response['code'] = 0;
			$response['message'] = 'Client not found';
			echo json_encode($response);
			exit();
        }        
    }



    public function check_login() {

		if (!isset($this->session_data->adminID)) {
		  
            redirect('admin/login');
		}
	}



	public function check_ajax_login() {
		
        if(!isset($this->session_data->adminID)) {
			
            $response = array();
			$response['code'] = 0;
			$response['message'] = 'Login required!';
			echo json_encode($response);
			exit();
		}
	}



    public function check_ajax_datatable() {
        
        if(!isset($this->session_data->adminID)) {
            
            $json_data = array(
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval(0),  
                "recordsFiltered" => intval(0), 
                "data"            => array()  
            );
                
            echo json_encode($json_data);
            exit();
        }
    }
}
