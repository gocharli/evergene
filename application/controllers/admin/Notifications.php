<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Notifications extends CI_Controller {
	
	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index() {
		
		$this->check_login();
		$this->data['page_title']='Notifications';
		$resultsPerPage=10;
		$pagination_sql=" LIMIT 0 , $resultsPerPage";
		$orders=$this->db->query('select * from notifications 
        where notificationToType="Admin" order by notificationID desc '.$pagination_sql)->result();
		$this->data['results']=$orders;
		$this->load->view('admin/notifications', $this->data);
	}



	public function load_more() {
		
		$this->check_ajax_login();
		$resultsPerPage=10;
		
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

		$orders=$this->db->query('select * from notifications 
         where notificationToType="Admin" order by notificationID desc '.$pagination_sql);

		$job_interval =$orders->result();
		
		if($orders->num_rows()>0) {
			$html=$this->load->view('admin/components/notifications',array('results'=>$job_interval),true);
			$page=$paged+1;
		}
		else {
			
			$html='';
			$page=0;
		}
		
		$response=array();
		$response['html']=$html;
		$response['page']=$page;
		echo json_encode($response);
		exit();
	}



	public function top() {
		
		$rr=$this->db->query('select * from notifications where notificationStatus=1 and notificationToType="Admin"');
		$new=$rr->num_rows();

		$res=$this->db->query('select * FROM notifications WHERE  notificationToType="Admin"  order by notificationID DESC LIMIT 10 ');
		$html='<li>
                <h6>Notifications</h6>
                <label class="label label-danger">New</label>
            </li>';
		$result=$res->result();
		
		if($result) {
			
			foreach($result as $row) {
				
				$name='Admin';
				
				if($row->notificationFromType=='Member') {
					
					$client = $this->db->query("SELECT * FROM users WHERE userId='".$row->notificationFrom."'")->row();
					$name=$client->userFirstName;
				}
				
				$sc='';
				
				if($row->notificationStatus==1) {
					$sc='bg-warning';
				}
				
				$html.='<li class="'.$sc.'" id="notification_'.$row->notificationID.'" onclick="notifications('.$row->notificationID.')">
                        <div class="media">
                            <img class="img-radius" src="'.base_url().'assets/admin/assets/images/user-profile/contact-user.jpg" alt="Generic placeholder image">
                            <div class="media-body">
                                <h5 class="notification-user">'.$name.'</h5>
                                <p class="notification-msg">'.$row->notificationMessage.'</p>
                                <span class="notification-time">'.date("d F Y g:i a",strtotime($row->notificationTime)).'</span>
                            </div>
                        </div>
                    </li>
                ';

			}

			$html.='<li class="text-center">
							<a href="'.base_url().'admin/notifications" class="btn btn-out btn-sm waves-effect waves-light btn-primary" style="color: #fff;padding: 10px;">
							View All</a>
						</li>
			';
		}
		else {
			
			$html.='<li  class="text-center">No Notification</li>';
			$html.='<li class="text-center">
							<a href="'.base_url().'admin/notifications" class="btn btn-out btn-sm waves-effect waves-light btn-primary" style="color: #fff;padding: 10px;">
							View All</a>
						</li>
			';
		}

		echo json_encode(array("total"=>$new,"result"=>$html));
		exit();
	}



	public function read(){
		
		$this->check_ajax_login();
		$notificationID=$this->input->post("notificationId");

		$row=$this->db->query("SELECT * FROM notifications WHERE  notificationToType='Admin' and notificationID=".$notificationID)->row();
		
		if($row){
			
			$data["notificationStatus"]=0;
			$this->db->where("notificationID",$notificationID);
			$this->db->update("notifications",$data);

			$link='home';
			
			if($row->notificationType=='Order') {
				$link='orders/view/'.$row->notificationLink;
			}
			if($row->notificationType=='Order Item') {
				$link='orders_items/view/'.$row->notificationLink;
			}
			if($row->notificationType=='Request') {
				$link='requests/index/new';
			}

			echo json_encode(array("code"=>1,"link"=>$link));
			exit();
		}
		else {

			echo json_encode(array("code"=>0,"link"=>'nill'));
			exit();
		}
	}



	public function check_login() {

		if (!isset($this->session_data->adminID)) {
			
			redirect('admin/login');
		}
	}

	public function activity_log(){

		$this->data['activities'] = $this->db->query("select * from activity_log order by ID desc")->result();
		$this->load->view('admin/activity_log', $this->data);

	}
	
	public function check_ajax_login() {
		
		if (!isset($this->session_data->adminID)) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Login required!';
			echo json_encode($response);
			exit();
		}
	}
}
