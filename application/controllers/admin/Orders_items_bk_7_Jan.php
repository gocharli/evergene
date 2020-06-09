<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'third_party/azure/vendor/autoload.php';
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;


class Orders_items extends CI_Controller {
	


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
		else if($type=='inprogress') {
			$this->data['page_title']='In Progress items';
			$this->data['type']='inprogress';
		}
		else if($type=='completed') {
			$this->data['page_title']='Completed items';
			$this->data['type']='completed';
		}
		else if($type=='upcoming') {
			$this->data['page_title']='Upcoming items';
			$this->data['type']='upcoming';
		}
		else if($type=='recieved') {
			$this->data['page_title']='Result Recieved';
			$this->data['type']='recieved';
		}
		else if($type=='draft') {
			$this->data['page_title']='Draft Items';
			$this->data['type']='draft';
		}
		else {
			$this->data['page_title']='All items';
			$this->data['type']='all';
		}

		$this->load->view('admin/list_orders_items', $this->data);
	}



	public function loadEditPassView($detailId=0) {

		$this->data['detailId']=$detailId;

		$this->load->view('admin/edit_test_result_pass',$this->data);
	}



	public function resultEditAuthCheck() {

		// array values
		$pin=$this->input->post('pin');

		$pin_code=$this->db->query("SELECT pin FROM auth_tbl")->row();

		$pin_code=$pin_code->pin;


		if($pin==$pin_code){

			$this->session->set_userdata('pin', $pin_code);
			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Authenticated Successfully.';
			echo json_encode($response);
			exit();
		}
		else{

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Invalid Pin! Click OK to go to listing page.';
			echo json_encode($response);
			exit();
		}		
	}



	public function list_data($type='all') {
		
		$this->check_ajax_datatable();
		
		if($type!='upcoming' && $type!='completed' && $type!='inprogress' && $type!='new' && $type!='recieved' && $type!='draft') {
			$type='all';
		}
		
		$columns = array(
			0 =>'detailId',
			1 =>'userFirstName',
			2 =>'testName',
			3=> 'detailPrice',
			4=> 'scheduleDate',
			5=> 'detailStatus',
			5=> 'paymentStatus',
			5=> 'detailId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		
		if($type=='new') {
			$whr=' where detailStatus="Pending" ';
		}
		else if($type=='inprogress') {
			$whr=' where detailStatus="Inprogress" ';
		}
		else if($type=='completed') {
			$whr=' where detailStatus="Completed" ';
		}
		else if($type=='upcoming') {
			$whr=' where scheduleDate >= CURDATE() and detailStatus="Pending" ';
		}
		else if($type=='recieved') {
			$whr=' where detailStatus="Recieved" ';
		}
		else if($type=='draft') {
			$whr=' where detailStatus="Draft" ';
		}
		else {
			$whr=' where 1=1 ';
		}


		$totalData = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId'.
			$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {
			
			$sq=$this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId'.
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
			$whr.=' and (detailId like "%'.$search.'%" or  userFirstName like "%'.$search.'%"  or testName like "%'.$search.'%" or  detailPrice like "%'.$search.'%" or  scheduleDate like "%'.$search.'%" or  detailStatus like "%'.$search.'%" or  paymentStatus like "%'.$search.'%")';

			$sq=$this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId'.
			$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {
				
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId'.
			$whr)->num_rows();
		}
		
		$data = array();
		
		if(!empty($result)) {
			
			foreach ($result as $row) {
				
				$nestedData['id'] = $row->detailId;
				$nestedData['name'] = $row->userFirstName.' '.$row->userLastName;
				$nestedData['item'] = short_text($row->testName,50);
				$nestedData['amount'] = '<i class="icofont icofont-cur-pound"></i>'.$row->detailPrice;
				$nestedData['date'] =  date('M d,Y',strtotime($row->scheduleDate));

				if($row->detailStatus=='Pending') {
					$nestedData['status']='<label class="label label-primary">Pending</label>';
				}
				else if($row->detailStatus=='Canceled') {
					$nestedData['status']='<label class="label label-danger">Canceled</label>';
				}
				else if($row->detailStatus=='Inprogress') {
					$nestedData['status']='<label class="label label-info">Inprogress</label>';
				}
				else if($row->detailStatus=='Completed') {
					$nestedData['status']='<label class="label label-success">Completed</label>';
				}
                else if($row->detailStatus=='Recieved') {
					$nestedData['status']='<label class="label label-primary">Recieved</label>';
				}
				else if($row->detailStatus=='Draft') {
					$nestedData['status']='<label class="label label-primary">Draft</label>';
				}


				if($row->paymentStatus=='Yes') {
					$nestedData['payment']='<label class="label label-success">Paid</label>';
				}
				else {
					$nestedData['payment']='<label class="label label-primary">Unpaid</label>';
				}
				
				if($row->detailStatus =='Inprogress') {
					
					$request_csv_name = $this->db->query("SELECT request_csv_name FROM orders WHERE orderId='$row->orderId'")->row('request_csv_name');
					
					$nestedData['action']='<a href="'.$this->config->item('admin_url').'/orders_items/view/'.$row->detailId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt icofont-2x"></i></a> / <a href="'.$this->config->item('admin_url').'/orders_items/addResult/'.$row->detailId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-plus-square icofont-2x"></i></a>';
				}
				else if($row->detailStatus =='Draft') {
					
					$nestedData['action']='<a href="'.$this->config->item('admin_url').'/orders_items/view/'.$row->detailId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a>';
				}
				else {
				
					$nestedData['action']='<a href="'.$this->config->item('admin_url').'/orders_items/view/'.$row->detailId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a>';
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



	public function addResult($detailId=0) {

		$this->check_login();
		
		$order_details=$this->db->query('select users.*,tests.*,test_markers_value.*,order_details.*,orders.* from orders LEFT JOIN users on orders.userId=users.userId LEFT JOIN order_details on orders.orderId=order_details.orderId LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN test_markers_value on tests.testId=test_markers_value.tm_test_id WHERE order_details.detailId='.$detailId)->result();

		$this->data['page_title']='Order Item detail';
		$this->data['order_details']=$order_details;

     	$this->load->view('admin/add_test_result', $this->data);

	}



	public function view($detailId=0) {
		
		$this->check_login();
		
		$order_details=$this->db->query('select users.userFirstName,users.userLastName,user_details.dob,user_details.gender,user_details.userAddress,tests.testMarkers,order_details.* from order_details
 		LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE detailId='.$detailId)->row();

 		$test_results=$this->db->query('select tests.* , results.*  from tests LEFT JOIN results on results.testId=tests.testId  WHERE results.detailId='.$detailId)->result();

		if(!$order_details) { 
			redirect('admin/orders_items'); exit(); 
		}

		$this->data['page_title']='Order Item detail';
		$this->data['order_details']=$order_details;
		$this->data['results']=$test_results;
		$this->data['test']=$this->db->query('select * from tests WHERE testId='.$order_details->testId)->row();
		$this->data['order']=$this->db->query('select * from orders WHERE orderId='.$order_details->orderId)->row();
		$this->data['same_test_results']=$this->db->query('select detailId , sample_taken_on , testId from results where testId='.$order_details->testId.' AND userId='.$order_details->userId.' group by detailId order by sample_taken_on DESC ')->result();
     	$this->load->view('admin/view_order_item_detail', $this->data);
	}



	public function change_result($detailId=0) {
		
		$order_details=$this->db->query('select order_details.* from order_details
 		WHERE detailId='.$detailId)->row();
		
		if(!$order_details) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Order not found';
			echo json_encode($response);
			exit();
		}

		foreach ($_POST as $key=>$val) {
			
			$test=explode('resultTest_',$key);
			
			if(isset($test[1])) {
				
				$id=$test[1];
				$upd=array();
				$upd['resultTest']=$val;
				$upd['resultTestName']=(isset($_POST['resultTestName_'.$id])?$_POST['resultTestName_'.$id]:'');
				$upd['resultLabDepartment']=(isset($_POST['resultLabDepartment_'.$id])?$_POST['resultLabDepartment_'.$id]:'');
				$upd['resultValue']=(isset($_POST['resultValue_'.$id])?$_POST['resultValue_'.$id]:'');
				$upd['resultUnit']=(isset($_POST['resultUnit_'.$id])?$_POST['resultUnit_'.$id]:'');
				$upd['resultRange']=(isset($_POST['resultRange_'.$id])?$_POST['resultRange_'.$id]:'');
				$upd['resultFlag']=(isset($_POST['resultFlag_'.$id])?$_POST['resultFlag_'.$id]:'');
				$upd['topText']=(isset($_POST['topText_'.$id])?$_POST['topText_'.$id]:'');
				$upd['bottomText']=(isset($_POST['BottomText_'.$id])?$_POST['bottomText'.$id]:'');
				$this->db->update('results',$upd,array('resultId'=>$id));
			}
		}

		$upd=array();
		$upd['detailStatus']='Completed';
		$upd['resultReceivedDate']=current_datetime();
		$this->db->update('order_details',$upd,array('detailId'=>$detailId));
		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Updated and send successfully.';
		echo json_encode($response);
		exit();
	}



	public function change_status() {
		
		$this->check_ajax_login();
		$upd=array();
        $detailId=$this->input->post('id');
		$type=$this->input->post('type');
		$order_details=$this->db->query('select order_details.* from order_details
 		WHERE detailId='.$detailId)->row();
		
		if(!$order_details) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Order not found';
			echo json_encode($response);
			exit();
		}

		if($order_details->detailStatus==$type) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Already in '.$type;
			echo json_encode($response);
			exit();
		}

		if($type=='Inprogress') {

			$tests=$this->db->query('select * from tests WHERE testId='.$order_details->testId)->row();
			$users=$this->db->query('select * from users WHERE userId='.$order_details->userId)->row();
            $orders=$this->db->query('select * from orders WHERE orderId='.$order_details->orderId)->row();
			$testId=$tests->testCode;
			
            $ref_1=drandomString(10);
            $ref_2=randomString();

            $upd['ref_1']=$ref_1;
            $upd['ref_2']=$ref_2;

			$upd['detailStatus']=$type;
			$upd['updatedAt']=current_datetime();
			$this->db->update('order_details',$upd,array('detailId'=>$detailId));
			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();			
		}
	}



	public function addTestResult() {

		$detailId=$this->input->post('detailId');
		$orderId=$this->input->post('orderId');
		$testId=$this->input->post('testId');
		$userId=$this->input->post('userId');

		$resultTest=$this->input->post('resultTest');
		$testName=$this->input->post('testName');
		$sampleTakeen=$this->input->post('sampleTakeen');
		$resultProcessed=$this->input->post('resultProcessed');
		$lab=$this->input->post('lab');
		$resultType=$this->input->post('resultType');

		// array values
		$markerTitle=$this->input->post('markerTitle');
		$markerUnit=$this->input->post('markerUnit');
		$resultValue=$this->input->post('resultValue');
		$minValue=$this->input->post('minValue');
		$lowerValue=$this->input->post('lowerValue');
		$upperValue=$this->input->post('upperValue');
		$maxValue=$this->input->post('maxValue');
		$topText=$this->input->post('standard');
		$normal=$this->input->post('normal');
		$abnormal=$this->input->post('abnormal');

		$upd=array();
		$upd['detailStatus']='Draft';
		$upd['updatedAt']=current_datetime();
		$upd['resultReceivedDate']= current_datetime();
		$value=$this->db->update('order_details',$upd,array('detailId'=>$detailId));

		if($value==true){

			for ($i=0; $i < sizeof($markerTitle); $i++) { 

				$bottomText="";

				if($resultValue[$i]>$upperValue[$i] || $resultValue[$i]<$lowerValue[$i]) {

					$bottomText=$abnormal[$i];
				}
				else {

					$bottomText=$normal[$i];
				}
				
				$result_data=array(
					'detailId' => $detailId,
					'orderId' => $orderId,
					'testId' => $testId,
					'userId' => $userId,
					'resultTest' => $resultTest,
					'resultTestName' => $testName,
					'resultLabDepartment' => $lab,
					'resultValue' => $resultValue[$i],
					'resultUnit' => $markerUnit[$i],
					'resultRange' => $minValue[$i].' - '.$maxValue[$i],
					'min_value' => $minValue[$i],
					'max_value' => $maxValue[$i],
					'lower_value' => $lowerValue[$i],
					'upper_value' => $upperValue[$i],
					'topText' => $topText[$i],
					'bottomText' => $bottomText,
					'resType' => $resultType,
					'marker_title' => $markerTitle[$i] ,
					'createdAt' => current_datetime(),
					'sample_taken_on' => $sampleTakeen,
					'result_processed_on' => $resultProcessed
				);

				$this->db->insert('results',$result_data);
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();
		}
		else {

			$upd=array();
			$upd['detailStatus']='Inprogress';
			$value=$this->db->update('order_details',$upd,array('detailId'=>$detail_id));

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Data not updated successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function onlySaveResult() {

		$resultId=$this->input->post('resultId');

		// array values
		$topText=$this->input->post('topText');
		$bottomText=$this->input->post('bottomText');
		$resultValue=$this->input->post('resultValue');

		$minValue=$this->input->post('minValue');
		$lowerValue=$this->input->post('lowerValue');
		$upperValue=$this->input->post('upperValue');
		$maxValue=$this->input->post('maxValue');

		for ($i=0; $i < sizeof($resultId); $i++) {

			$result_data=array(
				'topText' => $topText[$i],
				'bottomText' => $bottomText[$i],
				'resultValue' => $resultValue[$i],
				'min_value' => $minValue[$i],
				'lower_value' => $lowerValue[$i],
				'upper_value' => $upperValue[$i],
				'max_value' => $maxValue[$i]
			);			

			$value=$this->db->update('results',$result_data,array('resultId'=>$resultId[$i]));
		}		

		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Successfully updated';
		echo json_encode($response);
		exit();
	}



	public function saveAndPublishResult() {

		$resultId=$this->input->post('resultId');
		$detailId=$this->input->post('detailId');

		// array values
		$topText=$this->input->post('topText');
		$bottomText=$this->input->post('bottomText');
		$resultValue=$this->input->post('resultValue');

		$minValue=$this->input->post('minValue');
		$lowerValue=$this->input->post('lowerValue');
		$upperValue=$this->input->post('upperValue');
		$maxValue=$this->input->post('maxValue');

		for ($i=0; $i < sizeof($resultId); $i++) {

			$result_data=array(
				'topText' => $topText[$i],
				'bottomText' => $bottomText[$i],
				'resultValue' => $resultValue[$i],
				'min_value' => $minValue[$i],
				'lower_value' => $lowerValue[$i],
				'upper_value' => $upperValue[$i],
				'max_value' => $maxValue[$i]
			);			

			$value=$this->db->update('results',$result_data,array('resultId'=>$resultId[$i]));
		}

		$upd=array();
		$upd['detailStatus']='Completed';
		$upd['updatedAt']=current_datetime();
		$value=$this->db->update('order_details',$upd,array('detailId'=>$detailId));

		if(isset($_SESSION['pin'])){
			unset($_SESSION['pin']);
		}

		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Successfully updated';
		echo json_encode($response);
		exit();
	}
	


	public function upload_test_result(){

		$this->load->view('admin/upload_result');
	}



	public function upload_result_file(){

		if(isset($_POST['file_btn'])){

			$path = './uploads/results/';
			$this->load->library('upload');
			
			$this->upload->initialize(
				array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*'		
				)
			);

			if($this->upload->do_upload("upload_result")) {
			
				redirect('admin/orders_items/index');
			}
			else {

				$response=array();
				$response['code']=0;
				$response['img_error_message']=$this->upload->error_msg[0];

				print_r($response['img_error_message']);		

				exit();
			}

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
