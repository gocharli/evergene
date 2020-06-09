<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Requests extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index($type='all') {
		
		$this->check_login();
		
		if($type=='new') {
			$this->data['page_title']='New items';
			$this->data['type']='new';
		}
		else if($type=='nurse') {
			$this->data['page_title']='Nurse Requests';
			$this->data['type']='nurse';
		}
		else if($type=='doctor') {
			$this->data['page_title']='Doctor requests';
			$this->data['type']='doctor';
		}
		else {
			$this->data['page_title']='All requests';
			$this->data['type']='all';
		}
		$this->load->view('admin/list_requests', $this->data);
	}



	public function list_data($type='all') {
		
		$this->check_ajax_datatable();
		
		if($type!='nurse' && $type!='doctor' && $type!='new') {
			$type='all';
		}
		
		$columns = array(
			0 =>'requestId',
			1 =>'userFirstName',
			2 =>'testName',
			3=> 'requestType',
			4=> 'requestStatus',
			5=> 'createdAt',
			6=> 'requestId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		if($type=='new') {
			$whr=' where requestStatus="Pending" ';
		}
		else if($type=='nurse') {
			$whr=' where requestType="nurse" ';
		}
		else if($type=='doctor') {
			$whr=' where requestType="doctor" ';
		}
		else {
			$whr=' where 1=1 ';
		}


		$totalData = $this->db->query('select request_call.*,users.userFirstName,users.userLastName,tests.testName from request_call
			LEFT JOIN users ON request_call.userId=users.userId
			LEFT JOIN tests ON request_call.testId=tests.testId'.
			$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {
			
			$sq=$this->db->query('select request_call.*,users.userFirstName,users.userLastName,tests.testName from request_call
			LEFT JOIN users ON request_call.userId=users.userId
			LEFT JOIN tests ON request_call.testId=tests.testId'.
				$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				$result=$sq->result();
			}
			else {
				$result=null;
			}
		}
		else {
			
			$search = $this->input->post('search')['value'];
			$whr.=' and (requestId like "%'.$search.'%" or  userFirstName like "%'.$search.'%"  or testName like "%'.$search.'%" or  requestType like "%'.$search.'%" or  requestStatus like "%'.$search.'%")';

			$sq=$this->db->query('select request_call.*,users.userFirstName,users.userLastName,tests.testName from request_call
			LEFT JOIN users ON request_call.userId=users.userId
			LEFT JOIN tests ON request_call.testId=tests.testId'.
				$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				$result=$sq->result();
			}
			else {
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select request_call.*,users.userFirstName,users.userLastName,tests.testName from request_call
			LEFT JOIN users ON request_call.userId=users.userId
			LEFT JOIN tests ON request_call.testId=tests.testId'.
				$whr)->num_rows();
		}
		
		$data = array();
		
		if(!empty($result)) {
			
			foreach ($result as $row) {

				$btn='btn btn-out btn-sm waves-effect waves-light btn-info';
				$txt="Pending";
				
				if($row->requestStatus=='Accept') {
					$btn='btn btn-out btn-sm waves-effect waves-light btn-success';
					$txt="Accept";
				}
				else if($row->requestStatus=='Reject') {
					$txt="Reject";
					$btn='btn btn-out btn-sm waves-effect waves-light btn-danger';
				}

				$nestedData['id'] = $row->requestId;
				$nestedData['name'] = '<a href="'.base_url("admin/members/edit/'.$row->userId.'").'"  target="_blank">'.$row->userFirstName.' '.$row->userLastName.'</a>';
				$nestedData['test'] = short_text($row->testName,50);
				$nestedData['type'] = $row->requestType;
				$nestedData['status'] = '<a id="status_'.$row->requestId.'" href="javascript:status('.$row->requestId.');"><button class="'.$btn.'">'.$txt.'</button></a>';
				$nestedData['date'] =  date('M d,Y',strtotime($row->createdAt));
				$nestedData['action']='<a target="_blank" href="'.$this->config->item('admin_url').'/orders_items/view/'.$row->detailId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a> ';

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
		$request_call = $this->db->query("SELECT * FROM request_call WHERE requestId='".$id."'")->row();
		
		if($request_call) {
			
			$btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-success">Accept</button>';
			
			if($type!='Accept') {
				
				$type='Reject';
				$btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Reject</button>';
				
				if($request_call->requestType=='nurse') {
					$upd=array();
					$upd['callNurseType']='Book In';
					$this->db->update('order_details',$upd,array('detailId'=>$request_call->detailId));
				}
			}
			else {
				
				if($request_call->requestType=='nurse') {
					$upd=array();
					$upd['callNurseType']='Used';
					$this->db->update('order_details',$upd,array('detailId'=>$request_call->detailId));
				}
			}

			$this->db->set('requestStatus', $type);
			$this ->db->where('requestId',$id);
			$this->db->update('request_call');

			$response=array();
			$response['code']=1;
			$response['message']='updated successfully';
			$response['status_code']=$btn;
			echo json_encode($response);
			exit();
		}
		else {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Request not found';
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
