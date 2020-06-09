<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index() {
		
		$this->check_login();
		$this->data['page_title']='Coupons';
		$this->data['pakages'] = $this->db->query("select * from membership_plan")->result(); //
		$this->load->view('admin/list_coupons', $this->data);
	}


	public function used(){
		$this->check_login();
		$this->data['page_title']='Used coupon - Admin';
		$res = $this->db->query("select * from coupon_used")->result();
		foreach($res as $r){
			$plan = $this->db->query("select * from membership_plan where mpId = '".$r->plan_id."'")->row();
			if($plan){
				$r->planTitle = $plan->planTitle;
				$r->planAmount = $plan->planAmount;
				$r->paid_amount = $r->planAmount - ($r->planAmount * $r->percentage/100);
			}
		}
		$this->data['coupon_used'] = $res;
		$this->load->view('admin/coupon_used', $this->data);
	}


	public function add() {
		
		$this->check_login();
		$this->data['page_title']='Add coupon - Admin';
		$this->data['coupons'] = $this->db->query("select * from membership_plan")->result();
		$this->load->view('admin/add_coupon', $this->data);
	}

	public function import_coupons(){

		$this->check_login();
		$this->load->library('form_validation');
		$this->load->library('excellib'); 
		
		$config['upload_path']          = './uploads/excel/';
		$config['allowed_types']        = 'xlsx|xls';                
		$this->load->library('upload', $config);
					
		if (!$this->upload->do_upload('file')){                   
				$error =  $this->upload->display_errors();
				$this->session->set_flashdata('error', $error);  
				redirect('admin/coupons');
		}else{
			
				$imageDetailArray = $this->upload->data();
				$file1 =  $imageDetailArray['file_name'];   
		}
	
		$file = './uploads/excel/'.$file1;  
				
		//read file from path
		PHPExcel_Settings::getZipClass();
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$objPHPExcel = PHPExcel_IOFactory::load($file);
			
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			//$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getCalculatedValue();
			
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}

		$rr=$ii=0;
		foreach($arr_data as $key=>$row)
		{
			//echo '<pre>'; print_r($row); //['D'];
			$start_date  = gmdate("Y-m-d",($row['D'] - 25569) * 86400);
			$expiry_date = gmdate("Y-m-d",($row['E'] - 25569) * 86400);
			//gmdate("Y-m-d", $UNIX_DATE);
			//echo gmdate("Y-m-d\TH:i:s\Z", $row['D']);
			//echo date('Y-m-d', strtotime(trim($row['D']))); 
			//exit;
			
					$data['code']= isset($row['A'])? $row['A']:'';
					$data['pkg_id']= isset($row['B'])? $row['B']:'';
					$data['percentage']= isset($row['C'])? $row['C']:'';
					$data['start_date']= isset($start_date)? $start_date:'';
					$data['expiry_date']= isset($expiry_date)? $expiry_date:'';
					$data['frequency']= isset($row['F'])? $row['F']:'';
					$data['display_code']= 0;
					
					
				$check=$this->db->query('select * from coupons where code="'.$row['A'].'"');
				if($check->num_rows()==0)
				{
					if(isset($row['A']))
					{
						if($row['A']!="")
						{
							$ii++;
							$data['createdAt']= date('Y-m-d H:i:s');
							$this->db->insert('coupons',$data);
						}
					}    
					
				}
				else
				{
					if(isset($row['A']))
					{
						if($row['B']!="")
						{
							$rr++;
							$this->db->update('coupons',$data,array('code'=>$row['A']));
						}
					}         	
				}
		}
		
		$this->session->set_flashdata('success', $rr.'  Record Updated <br>'.$ii.' Record Inserted. ');   
		redirect('admin/coupons');
	}


	public function edit($id=0){
		
		$this->check_login();
		$coupon = $this->db->query("SELECT * FROM coupons WHERE ID='".$id."'")->row();

		if($coupon) {
			
			$this->data['page_title']='Edit coupon';
			$this->data['coupons'] = $this->db->query("select * from membership_plan")->result();
			$this->data['row']=$coupon;
			$this->load->view('admin/edit_coupon', $this->data);
		}
		else{
			
			redirect('admin/coupons');
		}
	}



	public  function  add_process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('pkg_id', 'Package', 'required');
		$this->form_validation->set_rules('percentage', 'Percentage', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('frequency', 'Frequency', 'required');
		

		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else{

			$code=$this->input->post('code');
			$cnt=$this->db->query("select count(*) as cnt from coupons where code = '".$code."'")->row()->cnt;
			if($cnt>0) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Coupon with same code already exist';
				echo json_encode($response);
				exit();
			}

			
			$ins=array();
			$ins['pkg_id']=$this->input->post('pkg_id');
			$ins['percentage']=$this->input->post('percentage');
			$ins['start_date']=$this->input->post('start_date');
			$ins['expiry_date']=$this->input->post('expiry_date');
			$ins['code']=$code;
			$ins['frequency']=$this->input->post('frequency');
			$ins['createdAt']=current_datetime();
			
			$this->db->insert('coupons',$ins);
			$response=array();
			$response['code']=1;
			$response['message']='Added successfully';
			echo json_encode($response);
			exit();
		}

	}

	public function edit_process($id=0) {
		
		$this->check_ajax_login();
		$coupon= $this->db->query("SELECT * FROM coupons WHERE ID='".$id."'")->row();

		if(!$coupon) {
			
			$response=array();
			$response['code']=0;
			$response['message']="Coupon Not found";
			echo json_encode($response);
			exit();
		}
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('pkg_id', 'Package', 'required');
		$this->form_validation->set_rules('percentage', 'Percentage', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('frequency', 'Frequency', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {

			$code=$this->input->post('code');
			$cnt=$this->db->query("select count(*) as cnt from coupons where code = '".$code."' and ID != '".$id."'")->row()->cnt;
			if($cnt>0) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Coupon with same code already exist';
				echo json_encode($response);
				exit();
			}

			$upd=array();
			$upd['pkg_id']=$this->input->post('pkg_id');
			$upd['percentage']=$this->input->post('percentage');
			$upd['start_date']=$this->input->post('start_date');
			$upd['expiry_date']=$this->input->post('expiry_date');
			$upd['code']=$code;
			$upd['frequency']=$this->input->post('frequency');
			$upd['createdAt']=current_datetime();

			$this->db->update('coupons',$upd,array('ID'=>$id));

			$response=array();
			$response['code']=1;
			$response['message']='Updated successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function list_data() {
		
		$this->check_ajax_datatable();
		
		$columns = array(
			0 =>'ID',
			1 =>'code',
			2 =>'percentage',
			3=> 'start_date',
			4=> 'expiry_date',
			5=> 'frequency',
			6=> 'package',
			7=> 'createdAt',
			8=> 'action'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr='where 1=1 ';

		$totalData = $this->db->query('select * from coupons '.$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {

			$sq=$this->db->query('select coupons.* from coupons
 			'.$whr.' order by display_code desc, '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {
				
				$result=null;
			}
		}
		else {

			$search = $this->input->post('search')['value'];
			$whr.=' and (ID like "%'.$search.'%" or  code like "%'.$search.'%")';

			$sq=$this->db->query('select coupons.* from coupons
 			'.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);

			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {
				
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select coupons.* from coupons
 			'.$whr)->num_rows();
		}
		
		$data = array();
		
		if(!empty($result)) {
			
			foreach ($result as $row) {
				
				$nestedData['ID'] = $row->ID;
				$nestedData['code'] = $row->code;
				$nestedData['percentage'] = $row->percentage;
				$nestedData['start_date'] = date('d F,Y',strtotime($row->start_date));
				$nestedData['expiry_date'] = date('d F,Y',strtotime($row->expiry_date));
				$nestedData['frequency'] = $row->frequency;
				$nestedData['display_code'] = $row->display_code;
				$nestedData['package'] = $this->db->query("select planTitle from membership_plan where mpId = '$row->pkg_id'")->row()->planTitle; //$row->pkg_id;
				$nestedData['createdAt'] = date('d F,Y',strtotime($row->createdAt));

				if($row->display_code == 1){
					$nestedData['action']=' 
					<a href="'.$this->config->item('admin_url').'/coupons/mark_display/'.$row->ID.'/0" class="btn waves-effect waves-light btn-success btn-sm" title="hide code at front">Hide Code</a></a>
					<a href="'.$this->config->item('admin_url').'/coupons/edit/'.$row->ID.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
					<a href="javascript:;" onclick="delete_coupon(this,'.$row->ID.')" class="btn waves-effect waves-light btn-danger btn-sm"><i class="icofont icofont-trash"></i></a>	';
					
				}else{
					$nestedData['action']=' 
					<a href="'.$this->config->item('admin_url').'/coupons/mark_display/'.$row->ID.'/1" class="btn waves-effect waves-light btn-info btn-sm" title="display code at front">Show Code</a></a>
					<a href="'.$this->config->item('admin_url').'/coupons/edit/'.$row->ID.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
					<a href="javascript:;" onclick="delete_coupon(this,'.$row->ID.')" class="btn waves-effect waves-light btn-danger btn-sm"><i class="icofont icofont-trash"></i></a>	';
				}
				
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


	public function mark_display($id=0, $code=0){

			if($id > 0){
				$this->db->update("coupons", array("display_code"=>0)); // hide all
				$this->db->where("ID", $id)->update("coupons", array("display_code"=>$code)); // update given code
			}

			redirect('admin/coupons');
	}

	public  function  delete_coupon() {
		
		$this->check_ajax_login();
		$id=$this->input->post('id');
		
		if($id>0) {
			
			$coupon = $this->db->query("SELECT * FROM coupons WHERE ID='".$id."'")->row();
			
			if($coupon) {
				
				$this->db->delete('coupons',array('ID'=>$id));
				$response=array();
				$response['code']=1;
				$response['message']='Deleted';
				echo json_encode($response);
				exit();
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']='coupon not found';
				echo json_encode($response);
				exit();
			}
		}
		else {
			
			$response=array();
			$response['code']=0;
			$response['message']='coupon not found';
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

