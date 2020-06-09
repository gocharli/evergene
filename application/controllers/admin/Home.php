<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller {
    


    public function __construct() {
        
        parent::__construct();
        $sess_data=$this->session->userdata('admin');
        
        if(!isset($sess_data->adminID)) {
            redirect('admin/login');
        }

        $this->session_data = $sess_data;       
    }



    public function index() {

        $this->data['page_title']='Home - Admin';
		$this->data['total_new']=$this->orders('new');
		$this->data['total_inprogress']=$this->orders('inprogress');
		$this->data['total_completed']=$this->orders('completed');
		$this->data['total_upcoming']=$this->orders('upcoming');
		$this->data['total_result_recieved']=$this->orders('recieved');
		$this->data['total_nurse']=$this->request('nurse');
		$this->data['total_doctor']=$this->request('doctor');
		$this->data['total_test']=$this->tests('Test');
		$this->data['total_mealprep']=$this->tests('MealPrep');
		$this->data['total_items']=$this->tests('General items');

        $this->load->view('admin/home', $this->data);
    }
	


	public function tests($type) {
		
		$whr='where productType="'.$type.'"';
		$totalData = $this->db->query('select * from tests '.$whr)->num_rows();
		return $totalData;
	}



	public function request($type) {
		
		$whr='where requestType="'.$type.'"';
		$totalData = $this->db->query('select * from request_call '.$whr)->num_rows();
		return $totalData;
	}
	


	public function orders($type) {

		if($type=='new') {
			$whr=' where detailStatus="Pending" ';
		}
		else if($type=='inprogress') {
			$whr=' where detailStatus="Inprogress" ';
		}
		else if($type=='completed') {
			$whr=' where detailStatus="Completed" ';
		}
		else if($type=='recieved') {
			$whr=' where detailStatus="Recieved" ';
		}
		else if($type=='upcoming') {
			$whr=' where scheduleDate >= CURDATE() and detailStatus="Pending" ';
		}
		else {
			$whr=' where 1=1 ';
		}

		$totalData = $this->db->query('select * from order_details '.$whr)->num_rows();
		return $totalData;
	}

}    
