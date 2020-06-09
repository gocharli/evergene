<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index() {
		
		$this->check_login();
		$this->data['page_title']='Banner';
		$this->data['banner'] = $this->db->query("select * from banner")->row(); 
		$this->load->view('admin/list_banner', $this->data);
	}

	public function edit($id=0){
		
		$this->check_login();
		$banner = $this->db->query("SELECT * FROM banner WHERE ID='".$id."'")->row();

		if($banner) {
			
			$this->data['page_title']='Edit banner';
			$this->data['row'] = $banner;
			$this->load->view('admin/edit_banner', $this->data);
		}
		else{
			
			redirect('admin/banner');
		}
	}

	public function edit_process($id=0) {
		
		$this->check_ajax_login();
		$banner= $this->db->query("SELECT * FROM banner WHERE ID='".$id."'")->row();

		if(!$banner) {
			
			$response=array();
			$response['code']=0;
			$response['message']="Banner Not found";
			echo json_encode($response);
			exit();
		}
		
		$this->check_ajax_login();
			
		$upd=array();
		$upd['title']=$this->input->post('title');
		$upd['link']=$this->input->post('link');
		$this->db->update('banner',$upd,array('ID'=>$id));

		$response=array();
		$response['code']=1;
		$response['message']='Updated successfully';
		echo json_encode($response);
		exit();
		
	}

	public function mark_display($id=0, $code=0){

			if($id > 0){
				$this->db->where("ID", $id)->update("banner", array("display_code"=>$code)); // update given code
			}

			redirect('admin/coupons');
	}

	public function check_login() {
		
		if (!isset($this->session_data->adminID)) {
			
			redirect('admin/login');
		}
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



	public function check_ajax_datatable() {

		if (!isset($this->session_data->adminID)) {
			
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

