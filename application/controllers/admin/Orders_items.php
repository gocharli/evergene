<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Orders_items extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();
		$sess_data = $this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index($type = 'all')
	{

		$this->check_login();

		if ($type == 'new') {
			$this->data['page_title'] = 'New items';
			$this->data['type'] = 'new';
		} else if ($type == 'inprogress') {
			$this->data['page_title'] = 'In Progress items';
			$this->data['type'] = 'inprogress';
		} else if ($type == 'completed') {
			$this->data['page_title'] = 'Completed items';
			$this->data['type'] = 'completed';
		} else if ($type == 'upcoming') {
			$this->data['page_title'] = 'Scheduled items';
			$this->data['type'] = 'upcoming';
		} else if ($type == 'recieved') {
			$this->data['page_title'] = 'Result Recieved';
			$this->data['type'] = 'recieved';
		} else if ($type == 'draft') {
			$this->data['page_title'] = 'Draft Items';
			$this->data['type'] = 'draft';
		} else if ($type == 'cancel') {
			$this->data['page_title'] = 'Draft Items';
			$this->data['type'] = 'cancel';
		} else {
			$this->data['page_title'] = 'All items';
			$this->data['type'] = 'all';
		}

		$this->load->view('admin/list_orders_items', $this->data);
	}



	public function loadEditPassView($detailId = 0)
	{

		$this->data['detailId'] = $detailId;

		$this->load->view('admin/edit_test_result_pass', $this->data);
	}

	public function loadRefundView()
	{

		$this->load->view('admin/cancel_refund_test_result_pass', $this->data);
	}



	public function resultEditAuthCheck()
	{

		// array values
		$pin = $this->input->post('pin');

		$pin_code = $this->db->query("SELECT pin FROM auth_tbl")->row();

		$pin_code = $pin_code->pin;


		if ($pin == $pin_code) {

			$this->session->set_userdata('pin', $pin_code);
			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Authenticated Successfully.';
			echo json_encode($response);
			exit();
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Invalid Pin! Click OK to go to listing page.';
			echo json_encode($response);
			exit();
		}
	}



	public function list_data($type = 'all')
	{

		$this->check_ajax_datatable();

		if ($type != 'upcoming' && $type != 'completed' && $type != 'inprogress' && $type != 'new' && $type != 'recieved' && $type != 'draft' && $type != 'cancel') {
			$type = 'all';
		}

		$columns = array(
			0 => 'detailId',
			1 => 'orderId',
			2 => 'userFirstName',
			3 => 'testName',
			4 => 'detailPrice',
			5 => 'scheduleDate',
			6 => 'detailStatus',
			7 => 'paymentStatus',
			8 => 'detailId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$col_id = $this->input->post('order')[0]['column']; // Added by david set to 7 (action column) from frontend
		if ($type == 'new') {
			$whr = ' where detailStatus="Pending" ';
		} else if ($type == 'inprogress') {
			$whr = ' where detailStatus="Inprogress" ';
		} else if ($type == 'completed') {
			$whr = ' where detailStatus="Completed" ';
		} else if ($type == 'upcoming') {
			$whr = ' where scheduleDate > CURDATE() and detailStatus="Pending" ';
		} else if ($type == 'recieved') {
			$whr = ' where detailStatus="Recieved" ';
		} else if ($type == 'draft') {
			$whr = ' where detailStatus="Draft" ';
		} else if ($type == 'cancel') {
			$whr = ' where order_cancel_status=1 ';
		} else {
			$whr = ' where 1=1 ';
		}


		$totalData = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId' .
			$whr . ' group by order_details.detailId')->num_rows();

		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {


			$sq = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName, transactions.trx_id from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId
			LEFT JOIN transactions ON order_details.orderId=transactions.orderId' .
				$whr . ' group by order_details.detailId order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);


			if ($col_id == 7) {   // loaded first time on page load

				$sq = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName, transactions.trx_id from order_details
					LEFT JOIN users ON order_details.userId=users.userId
					LEFT JOIN tests ON order_details.testId=tests.testId
					LEFT JOIN transactions ON order_details.orderId=transactions.orderId' .
					$whr . ' group by order_details.detailId ORDER BY (CASE WHEN date(order_details.scheduleDate) >= CURRENT_DATE() THEN 1 ELSE 0 END) DESC, order_details.scheduleDate ASC limit ' . $start . ',' . $limit);
			}

			if ($sq->num_rows() > 0) {

				$result = $sq->result();
			} else {

				$result = null;
			}
		} else {

			$search = $this->input->post('search')['value'];
			$whr .= ' and (order_details.detailId like "%' . $search . '%" or order_details.orderId like "%' . $search . '%" or  userFirstName like "%' . $search . '%"  or testName like "%' . $search . '%" or  detailPrice like "%' . $search . '%" or  scheduleDate like "%' . $search . '%" or  detailStatus like "%' . $search . '%" or  paymentStatus like "%' . $search . '%")';

			$sq = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName, transactions.trx_id from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId 
			LEFT JOIN transactions ON order_details.orderId=transactions.orderId' .
				$whr . ' group by order_details.detailId order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);

			if ($sq->num_rows() > 0) {

				$result = $sq->result();
			} else {

				$result = null;
			}

			$totalFiltered = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId' .
				$whr)->num_rows();
		}

		$data = array();
		if (!empty($result)) {

			foreach ($result as $row) {

				// Added by david
				$detailId = $row->detailId;
				$all_orders = $this->db->query('select @acount:=@acount+1 sub_id, order_details.detailId from (SELECT @acount:= 0) AS acount, order_details WHERE orderId=' . $row->orderId)->result(); // all order items of the order
				$sub_id = 1;
				foreach ($all_orders as $o) {
					if ($o->detailId == $detailId) {
						$sub_id = $o->sub_id;
					}
				}
				// End

				$nestedData['id'] = $row->detailId;
				$nestedData['orderId'] = $row->orderId . '-' . $sub_id;
				$nestedData['name'] = $row->userFirstName . ' ' . $row->userLastName;
				$nestedData['item'] = short_text($row->testName, 50);
				$nestedData['amount'] = '<i class="icofont icofont-cur-pound"></i>' . $row->detailPrice;
				$nestedData['date'] =  date('d F Y', strtotime($row->scheduleDate));

				if ($row->order_cancel_status == '1') {
					$nestedData['status'] = '<label class="label label-danger">Canceled</label>';
				} else if ($row->detailStatus == 'Pending') {
					$nestedData['status'] = '<label class="label label-primary">Pending</label>';
					if ($row->scheduleDate >= date('Y-m-d')) {
						$nestedData['status'] = '<label class="label label-primary">Scheduled</label>';
					}
				} else if ($row->detailStatus == 'Canceled') {
					$nestedData['status'] = '<label class="label label-danger">Canceled</label>';
				} else if ($row->detailStatus == 'Inprogress') {
					$nestedData['status'] = '<label class="label label-info">Inprogress</label>';
				} else if ($row->detailStatus == 'Completed') {
					$nestedData['status'] = '<label class="label label-success">Completed</label>';
				} else if ($row->detailStatus == 'Recieved') {
					$nestedData['status'] = '<label class="label label-primary">Recieved</label>';
				} else if ($row->detailStatus == 'Draft') {
					$nestedData['status'] = '<label class="label label-primary">Results Received</label>';
				}


				if ($row->paymentStatus == 'Yes') {
					$nestedData['payment'] = '<label class="label label-success">Paid</label> ' . $row->trx_id;
				} else {
					$nestedData['payment'] = '<label class="label label-primary">Unpaid</label>';
				}





				// Added by David

				if ($row->order_cancel_status == '1') {
					$nestedData['action'] = 'Cancelled';
				}

				// End ''else' added below 

				else if ($row->detailStatus == 'Inprogress') {

					$request_csv_name = $this->db->query("SELECT request_csv_name FROM orders WHERE orderId='$row->orderId'")->row('request_csv_name');

					$nestedData['action'] = '<a href="' . $this->config->item('admin_url') . '/orders_items/view/' . $row->detailId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt icofont-2x"></i></a> / <a href="' . $this->config->item('admin_url') . '/orders_items/addResult/' . $row->detailId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-plus-square icofont-2x"></i></a>';
				} else if ($row->detailStatus == 'Draft') {

					$nestedData['action'] = '<a href="' . $this->config->item('admin_url') . '/orders_items/view/' . $row->detailId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a>';
				} else {

					$txt = "";
					if ($type == 'new' || $type == 'inprogress') {


						if (isset($_SESSION['pin'])) {
							$txt = '|  <a id="status_' . $row->order_cancel_status . '" href="javascript:cancel_order_status(' . $row->detailId . ',' . $row->order_cancel_status . ')"><button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Cancel</button></a>';
						} else {
							$txt = '|  <a href="' . $this->config->item('admin_url') . '/orders_items/loadRefundView"><button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Cancel</button></a>';
						}

						if ($row->order_cancel_status == '1') {
							$txt = '|  Cancelled';
						}
					}


					$nestedData['action'] = '<a href="' . $this->config->item('admin_url') . '/orders_items/view/' . $row->detailId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a>  ' . $txt;
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



	public function addResult($detailId = 0)
	{

		$this->check_login();

		$order_details = $this->db->query('select users.*,tests.*,test_markers_value.*,order_details.*,orders.* from orders LEFT JOIN users on orders.userId=users.userId LEFT JOIN order_details on orders.orderId=order_details.orderId LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN test_markers_value on tests.testId=test_markers_value.tm_test_id WHERE order_details.detailId=' . $detailId)->result();

		$this->data['page_title'] = 'Order Item detail';
		$this->data['order_details'] = $order_details;

		if ($order_details[0]->testResultType == 'Result 3') {
			$this->load->view('admin/add_test_result3', $this->data);
		} else if ($order_details[0]->testResultType == 'Result 4') {
			$this->load->view('admin/add_test_result4', $this->data);
		} else {
			$this->load->view('admin/add_test_result', $this->data);
		}
	}

	public function cancel_order_status()
	{

		$this->check_ajax_login();

		$detailId = $this->input->post('detailId');
		$order_cancel_status = $this->input->post('st');
		$order_detail = $this->db->query("SELECT * FROM order_details WHERE detailId='" . $detailId . "'")->row();

		if ($order_detail) {

			$this->db->set('order_cancel_status', $order_cancel_status);
			$this->db->where('detailId', $detailId);
			$this->db->update('order_details');

			$response = array();
			$response['code'] = 1;
			$message = "Order has been cancelled";
			if ($order_cancel_status == 1) {
				$message = "Order has been cancelled";
			} else {
				$message = "Order has been marked as active";
			}
			$response['message'] = $message;
			$response['status_code'] = 1;

			if (isset($_SESSION['pin'])) {
				unset($_SESSION['pin']);
			}

			echo json_encode($response);
			exit();
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Order not found';
			echo json_encode($response);
			exit();
		}
	}

	public function addResult3($detailId = 0)
	{

		$this->check_login();

		$order_details = $this->db->query('select users.*,tests.*,test_markers_value.*,order_details.*,orders.* from orders LEFT JOIN users on orders.userId=users.userId LEFT JOIN order_details on orders.orderId=order_details.orderId LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN test_markers_value on tests.testId=test_markers_value.tm_test_id WHERE order_details.detailId=' . $detailId)->result();

		$this->data['page_title'] = 'Order Item detail';
		$this->data['order_details'] = $order_details;

		$this->load->view('admin/add_test_result3', $this->data);
	}

	public function addResult4($detailId = 0)
	{

		$this->check_login();

		$order_details = $this->db->query('select users.*,tests.*,test_markers_value.*,order_details.*,orders.* from orders LEFT JOIN users on orders.userId=users.userId LEFT JOIN order_details on orders.orderId=order_details.orderId LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN test_markers_value on tests.testId=test_markers_value.tm_test_id WHERE order_details.detailId=' . $detailId)->result();

		$this->data['page_title'] = 'Order Item detail';
		$this->data['order_details'] = $order_details;

		$this->load->view('admin/add_test_result4', $this->data);
	}

	public function filter_chart()
	{

		$testId = $this->input->post('testId');
		$marker_title = $this->input->post('marker_title');
		$user_id = $this->input->post('user_id');

		$no_of_markers = $this->db->query("select no_of_markers from tests where testId = '" . $testId . "'")->row()->no_of_markers;

		$result_analytics = array();
		$last_year = date("Y-m-d", strtotime("-1 year"));
		$date = $last_year;
		for ($i = 1; $i < 13; $i++) {
			if ($i != 0) {
				$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
			}
			$new = array();
			$new['y'] = date('Y-m-d', strtotime($date));
			$new['x'] = 0;

			for ($g = 1; $g <= $no_of_markers; $g++) {
				$new['x' . $g] = 0;
			}
			$result_analytics[] = $new;
		}


		$result_track_graph = $this->db->query('select * from results WHERE  DATE(createdAt)>="' . $last_year . '" and  userId=' . $user_id . ' and testId=' . $testId . ' and resType="OBX" ')->result();

		if (trim($marker_title) != "") {
			$result_track_graph = $this->db->query('select * from results WHERE  DATE(createdAt)>="' . $last_year . '" and  userId=' . $user_id . ' and testId=' . $testId . ' and marker_title = "' . $marker_title . '" and resType="OBX" GROUP BY YEAR(createdAt), MONTH(createdAt) ')->result();
		}

		foreach ($result_track_graph as $r) {
			foreach ($result_analytics as $key => $row) {
				if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->createdAt))) {
					$result_analytics[$key]['y'] = date('Y-m-d', strtotime($r->sample_taken_on)); // added on 20 may
					$result_analytics[$key]['x'] = $r->resultValue;
					if (trim($marker_title) == "") {
						$mrkrs = $this->db->query("select * from results where detailId = '" . $r->detailId . "'  ")->result();
						$p = 1;
						foreach ($mrkrs as $mm) {
							$result_analytics[$key]['x' . $p] = $mm->resultValue;
							$p++;
						}
					}
				}
			}
		}


		$result_analytics1 = [];
		foreach ($result_analytics as $idx => $row) {
			if ($row['x'] != 0) {
				$result_analytics1[] = $row;
			}
		}


		echo json_encode($result_analytics1);
	}

	public function view($detailId = 0)
	{

		$this->check_login();

		$order_details = $this->db->query('select users.userId, users.userFirstName,users.userLastName,users.userDob as dob,user_details.gender,user_details.userAddress,tests.testMarkers,order_details.* from order_details
 		LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE detailId=' . $detailId)->row();

		$test_results = $this->db->query('select tests.* , results.*  from tests LEFT JOIN results on results.testId=tests.testId  WHERE results.detailId=' . $detailId)->result();

		foreach ($test_results as $r) {
			$res = $this->db->query("select firstName, lastName from admin where adminID = '" . $r->added_by . "'")->row();

			if ($res) {
				$r->res_added_by = $res->firstName . ' ' . $res->lastName;
			} else {
				$r->res_added_by = "ddd";
			}
		}

		if (!$order_details) {
			redirect('admin/orders_items');
			exit();
		}




		// Added by david  10 December

		$test_marker_res = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.marker_title = "'.$test_results[0]->marker_title.'" and results.testId="'. $test_results[0]->testId.'" and results.userId="'. $test_results[0]->userId.'" ')->result();
		$this->data['test_marker_res'] = $test_marker_res;
		
		//echo '<pre>'; print_r($test_marker_res); 
		$test_marker_results = [];

		for($i=0; $i<=count($test_marker_res); $i++){

			$test_marker_results[$i] = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.marker_title = "'.$test_results[$i]->marker_title.'" and results.testId="'. $test_results[$i]->testId.'" and results.userId="'. $test_results[$i]->userId.'" ')->result();
			//echo '<pre>'; print_r($test_marker_results); 
		}

		$this->data['test_marker_results'] = $test_marker_results;
		//echo '<pre>'; print_r($test_marker_results); exit;

		// End added by david






		// Added by david 
		$this->data['marker'] = $this->db->query("select * from test_markers_value where tm_test_id = '" . $order_details->testId . "'")->row();

		$markers = $this->db->query("select * from test_markers_value where tm_test_id = '" . $order_details->testId . "'")->result();
		$this->data['markers'] = $markers;
		foreach ($markers as $mm) {
			$this->data['res_unit'][] = $mm->tm_unit;
		}

		$all_orders = $this->db->query('select @acount:=@acount+1 sub_id, order_details.detailId from (SELECT @acount:= 0) AS acount, order_details WHERE orderId=' . $order_details->orderId)->result(); // all order items of the order
		$sub_id = 1;
		foreach ($all_orders as $o) {
			if ($o->detailId == $detailId) {
				$sub_id = $o->sub_id;
			}
		}
		$this->data['sub_id'] = $sub_id;

		$this->data['page_title'] = 'Order Item detail';
		$this->data['order_details'] = $order_details;
		$this->data['results'] = $test_results;
		$this->data['test'] = $this->db->query('select * from tests WHERE testId=' . $order_details->testId)->row();
		$this->data['order'] = $this->db->query('select * from orders WHERE orderId=' . $order_details->orderId)->row();
		$this->data['same_test_results'] = $this->db->query('select detailId , sample_taken_on , testId from results where testId=' . $order_details->testId . ' AND userId=' . $order_details->userId . ' group by detailId order by sample_taken_on DESC ')->result();
		$this->data['previous_results'] = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $order_details->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();
		$this->load->view('admin/view_order_item_detail', $this->data);
	}

	public function update_result3()
	{

		$resultId = $this->input->post('resultId');
		$data['result3'] = $this->input->post('result3');
		$data['topText'] = $this->input->post('topText');
		$data['bottomText'] = $this->input->post('bottomText');
		$this->db->where("resultId", $resultId)->update("results", $data);
		echo '1';
	}

	public function change_result($detailId = 0)
	{

		$order_details = $this->db->query('select order_details.* from order_details
 		WHERE detailId=' . $detailId)->row();

		if (!$order_details) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Order not found';
			echo json_encode($response);
			exit();
		}

		foreach ($_POST as $key => $val) {

			$test = explode('resultTest_', $key);

			if (isset($test[1])) {

				$id = $test[1];
				$upd = array();
				$upd['resultTest'] = $val;
				$upd['resultTestName'] = (isset($_POST['resultTestName_' . $id]) ? $_POST['resultTestName_' . $id] : '');
				$upd['resultLabDepartment'] = (isset($_POST['resultLabDepartment_' . $id]) ? $_POST['resultLabDepartment_' . $id] : '');
				$upd['resultValue'] = (isset($_POST['resultValue_' . $id]) ? $_POST['resultValue_' . $id] : '');
				$upd['resultUnit'] = (isset($_POST['resultUnit_' . $id]) ? $_POST['resultUnit_' . $id] : '');
				$upd['resultRange'] = (isset($_POST['resultRange_' . $id]) ? $_POST['resultRange_' . $id] : '');
				$upd['resultFlag'] = (isset($_POST['resultFlag_' . $id]) ? $_POST['resultFlag_' . $id] : '');
				$upd['topText'] = (isset($_POST['topText_' . $id]) ? $_POST['topText_' . $id] : '');
				$upd['bottomText'] = (isset($_POST['BottomText_' . $id]) ? $_POST['bottomText' . $id] : '');
				$this->db->update('results', $upd, array('resultId' => $id));
			}
		}

		$upd = array();
		$upd['detailStatus'] = 'Completed';
		$upd['resultReceivedDate'] = current_datetime();
		$this->db->update('order_details', $upd, array('detailId' => $detailId));
		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Updated and send successfully.';
		echo json_encode($response);
		exit();
	}



	public function change_status()
	{

		$this->check_ajax_login();
		$upd = array();
		$detailId = $this->input->post('id');
		$type = $this->input->post('type');
		$order_details = $this->db->query('select order_details.* from order_details
 		WHERE detailId=' . $detailId)->row();

		if (!$order_details) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Order not found';
			echo json_encode($response);
			exit();
		}

		if ($order_details->detailStatus == $type) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Already in ' . $type;
			echo json_encode($response);
			exit();
		}

		if ($type == 'Inprogress') {

			$tests = $this->db->query('select * from tests WHERE testId=' . $order_details->testId)->row();
			$users = $this->db->query('select * from users WHERE userId=' . $order_details->userId)->row();
			$orders = $this->db->query('select * from orders WHERE orderId=' . $order_details->orderId)->row();
			$testId = $tests->testCode;

			$ref_1 = drandomString(10);
			$ref_2 = randomString();

			$upd['ref_1'] = $ref_1;
			$upd['ref_2'] = $ref_2;

			$upd['detailStatus'] = $type;
			$upd['updatedAt'] = current_datetime();
			$this->db->update('order_details', $upd, array('detailId' => $detailId));

			// Code added by david
			if ($users->noti_status > 0) {
				// send notifcation to user notify_user //
				$notify['notificationMessage'] = 'Your order #' . $order_details->orderId . ' is in progress. We will let you know when results arrive.';
				$notify['notificationLink'] = $order_details->orderId;
				$notify['notificationStatus'] = 1;
				$notify['notificationTime'] = current_datetime();
				$notify['notificationTo'] = $order_details->userId;
				$notify['notificationToType'] = 'Member';
				$notify['notificationFrom'] = $this->session_data->adminID;
				$notify['notificationFromType'] = 'Admin';
				$notify['notificationType'] = 'Other';
				$this->db->insert('notifications', $notify);

				$to = $users->userEmail;
				$subject = 'Order Inprogress';

				$email_data['title'] = $users->userFirstName . ' ' . $users->userLastName;
				$email_data['link'] = base_url() . 'orders';
				$message = $this->load->view('emails/test_status', $email_data, true);
				$this->smtp_email->send('', '', $to, $subject, $message);
			}
			// End


			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();
		}
	}



	public function addTestResult()
	{

		$detailId = $this->input->post('detailId');
		$orderId = $this->input->post('orderId');
		$testId = $this->input->post('testId');
		$userId = $this->input->post('userId');

		$resultTest = $this->input->post('resultTest');
		$testName = $this->input->post('testName');
		$sampleTakeen = $this->input->post('sampleTakeen');
		$resultProcessed = $this->input->post('resultProcessed');
		$lab = $this->input->post('lab');
		$resultType = $this->input->post('resultType');

		// array values
		$markerTitle = $this->input->post('markerTitle');
		$markerUnit = $this->input->post('markerUnit');
		$resultValue = $this->input->post('resultValue');
		$minValue = $this->input->post('minValue');
		$lowerValue = $this->input->post('lowerValue');
		$upperValue = $this->input->post('upperValue');
		$maxValue = $this->input->post('maxValue');
		$topText = $this->input->post('standard');
		$normal = $this->input->post('normal');
		$abnormal = $this->input->post('abnormal');

		$result3 = $this->input->post('result3');

		$upd = array();
		$upd['detailStatus'] = 'Draft';
		$upd['updatedAt'] = current_datetime();
		$upd['resultReceivedDate'] = current_datetime();
		$value = $this->db->update('order_details', $upd, array('detailId' => $detailId));

		if ($value == true) {

			for ($i = 0; $i < sizeof($markerTitle); $i++) {

				$bottomText = "";

				if ($resultValue[$i] > $upperValue[$i] || $resultValue[$i] < $lowerValue[$i]) {

					$bottomText = $abnormal[$i];
				} else {

					$bottomText = $normal[$i];
				}

				$result_data = array(
					'detailId' => $detailId,
					'orderId' => $orderId,
					'testId' => $testId,
					'userId' => $userId,
					'resultTest' => $resultTest,
					'resultTestName' => $testName,
					'resultLabDepartment' => $lab,
					'resultValue' => $resultValue[$i],
					'resultUnit' => $markerUnit[$i],
					'resultRange' => $minValue[$i] . ' - ' . $maxValue[$i],
					'min_value' => $minValue[$i],
					'max_value' => $maxValue[$i],
					'lower_value' => $lowerValue[$i],
					'upper_value' => $upperValue[$i],
					'topText' => $topText[$i],
					'bottomText' => $bottomText,
					'resType' => $resultType,
					'marker_title' => $markerTitle[$i],
					'createdAt' => current_datetime(),
					'sample_taken_on' => $sampleTakeen,
					'result_processed_on' => $resultProcessed,
					'added_by' => $this->session_data->adminID
				);



				// Added by david

				$config =  array(
					'upload_path'     => './uploads/results/',
					'allowed_types'   => "*",
					'max_size'        => "0",
					'max_height'      => "1768",
					'max_width'       => "2048"
				);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('resultFile')) {
					$filed = $this->upload->data();
					$result_data['resultFile'] = $filed["file_name"];
				}



				$result_data['result3'] = $result3[$i];

				// End

				$this->db->insert('results', $result_data);

				// activity log by david
				$this->db->insert("activity_log", array("description" => 'Test result for ' . $testName . ' has been added by ' . $this->session_data->firstName, "tid" => 0, "oid" => $detailId, "createdAt" => date('Y-m-d H:i:s')));
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();
		} else {

			$upd = array();
			$upd['detailStatus'] = 'Inprogress';
			$value = $this->db->update('order_details', $upd, array('detailId' => $detail_id));

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Data not updated successfully';
			echo json_encode($response);
			exit();
		}
	}

	public function addTestResult3()
	{

		$detailId = $this->input->post('detailId');
		$orderId = $this->input->post('orderId');
		$testId = $this->input->post('testId');
		$userId = $this->input->post('userId');

		$resultTest = $this->input->post('resultTest');
		$testName = $this->input->post('testName');
		$sampleTakeen = $this->input->post('sampleTakeen');
		$resultProcessed = $this->input->post('resultProcessed');
		$lab = $this->input->post('lab');
		$resultType = $this->input->post('resultType');
		$topText = $this->input->post('standard');
		$normal = $this->input->post('normal');
		$abnormal = $this->input->post('abnormal');

		$result3 = $this->input->post('result3');



		$upd = array();
		$upd['detailStatus'] = 'Draft';
		$upd['updatedAt'] = current_datetime();
		$upd['resultReceivedDate'] = current_datetime();
		$value = $this->db->update('order_details', $upd, array('detailId' => $detailId));

		if ($value == true) {

			for ($i = 0; $i < sizeof($result3); $i++) {


				// Added by David
				$bottomText = "";
				$bottomText = $normal[$i]; // Considering the result is negative

				if ($result3[$i] == 'Positive') {
					$bottomText = $abnormal[$i];
				}

				// End


				$result_data = array(
					'detailId' => $detailId,
					'orderId' => $orderId,
					'testId' => $testId,
					'userId' => $userId,
					'resultTest' => $resultTest,
					'resultTestName' => $testName,
					'resultLabDepartment' => $lab,
					'topText' => $topText[$i], // topText will be the standrd text will remain same while adding result type 3
					'bottomText' => $bottomText,  // will be positive or negative description
					'resType' => $resultType,
					'createdAt' => current_datetime(),
					'sample_taken_on' => $sampleTakeen,
					'result_processed_on' => $resultProcessed,
					'added_by' => $this->session_data->adminID
				);

				$config =  array(
					'upload_path'     => './uploads/results/',
					'allowed_types'   => "*",
					'max_size'        => "0",
					'max_height'      => "1768",
					'max_width'       => "2048"
				);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload('resultFile')) {
					$filed = $this->upload->data();
					$result_data['resultFile'] = $filed["file_name"];
				}



				$result_data['result3'] = $result3[$i];

				$this->db->insert('results', $result_data);

				// activity log by david
				$this->db->insert("activity_log", array("description" => 'Test result for ' . $testName . ' has been added by ' . $this->session_data->firstName, "tid" => 0, "oid" => $detailId, "createdAt" => date('Y-m-d H:i:s')));

				// End

			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();
		} else {

			$upd = array();
			$upd['detailStatus'] = 'Inprogress';
			$value = $this->db->update('order_details', $upd, array('detailId' => $detail_id));

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Data not updated successfully';
			echo json_encode($response);
			exit();
		}
	}

	public function addTestResult4()
	{

		$this->load->library('upload');
		$detailId = $this->input->post('detailId');
		$orderId = $this->input->post('orderId');
		$testId = $this->input->post('testId');
		$userId = $this->input->post('userId');

		$resultTest = $this->input->post('resultTest');
		$testName = $this->input->post('testName');
		$sampleTakeen = $this->input->post('sampleTakeen');
		$resultProcessed = $this->input->post('resultProcessed');
		$lab = $this->input->post('lab');
		$resultType = $this->input->post('resultType');

		$topText = $this->input->post('standard');
		$normal = $this->input->post('normal');
		$abnormal = $this->input->post('abnormal');


		$files = $_FILES;
		$cpt = count($_FILES['result4File']['name']);
		$result4File = "";
		for ($i = 0; $i < $cpt; $i++) {
			$_FILES['result4File']['name'] = $files['result4File']['name'][$i];
			$_FILES['result4File']['type'] = $files['result4File']['type'][$i];
			$_FILES['result4File']['tmp_name'] = $files['result4File']['tmp_name'][$i];
			$_FILES['result4File']['error'] = $files['result4File']['error'][$i];
			$_FILES['result4File']['size'] = $files['result4File']['size'][$i];

			$this->upload->initialize($this->set_upload_options());
			if ($this->upload->do_upload('result4File')) {
				// Uploaded file data
				$imageData = $this->upload->data();
				$result4File .= $imageData['file_name'] . ',';
			}
		}

		$result4File = substr($result4File, 0, -1);

		$upd = array();
		$upd['detailStatus'] = 'Draft';
		$upd['updatedAt'] = current_datetime();
		$upd['resultReceivedDate'] = current_datetime();
		$value = $this->db->update('order_details', $upd, array('detailId' => $detailId));

		if ($value == true) {

			$result_data = array(
				'detailId' => $detailId,
				'orderId' => $orderId,
				'testId' => $testId,
				'userId' => $userId,
				'resultTest' => $resultTest,
				'resultTestName' => $testName,
				'resultLabDepartment' => $lab,
				'topText' => $topText[$i],
				'resType' => $resultType,
				'createdAt' => current_datetime(),
				'sample_taken_on' => $sampleTakeen,
				'result_processed_on' => $resultProcessed,
				'added_by' => $this->session_data->adminID
			);



			// Added by david

			$config =  array(
				'upload_path'     => './uploads/results/',
				'allowed_types'   => "*",
				'max_size'        => "0",
				'max_height'      => "1768",
				'max_width'       => "2048"
			);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);


			if ($this->upload->do_upload('resultFile')) {
				$filed = $this->upload->data();
				$result_data['resultFile'] = $filed["file_name"];
			}

			$result_data['result4File'] = $result4File;
			// End

			$this->db->insert('results', $result_data);

			// activity log by david
			$this->db->insert("activity_log", array("description" => 'Test result for ' . $testName . ' has been added by ' . $this->session_data->firstName, "tid" => 0, "oid" => $detailId, "createdAt" => date('Y-m-d H:i:s')));

			// End

			//}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Successfully updated';
			echo json_encode($response);
			exit();
		} else {

			$upd = array();
			$upd['detailStatus'] = 'Inprogress';
			$value = $this->db->update('order_details', $upd, array('detailId' => $detail_id));

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Data not updated successfully';
			echo json_encode($response);
			exit();
		}
	}

	public function remove_file()
	{

		$detailId = $this->input->post('detailId');
		$file = $this->input->post('file');

		$res = $this->db->query("select result4File from results where detailId = '" . $detailId . "'")->row();
		if ($res) {
			$result4File = $res->result4File;
			$result4FileNew = $this->removeFromString($result4File, $file);
			$path = FCPATH . 'uploads/results/' . $file;
			unlink($path);
			$this->db->update('results', array("result4File" => $result4FileNew), array('detailId' => $detailId));
			echo '1';
		} else {
			echo '0';
		}
	}

	function removeFromString($str, $item)
	{
		$parts = explode(',', $str);

		while (($i = array_search($item, $parts)) !== false) {
			unset($parts[$i]);
		}

		return implode(',', $parts);
	}

	public function upload_result4()
	{

		$detailId = $this->input->post('detailId_up');

		$result4File = $this->db->query("select result4File from results where detailId = '" . $detailId . "'")->row()->result4File;


		$txt = '';
		$this->load->library('upload');
		$dataInfo = array();
		$files = $_FILES;
		$cpt = count($_FILES['upload_result4_up']['name']);
		for ($i = 0; $i < $cpt; $i++) {
			$_FILES['upload_result4_up']['name'] = $files['upload_result4_up']['name'][$i];
			$_FILES['upload_result4_up']['type'] = $files['upload_result4_up']['type'][$i];
			$_FILES['upload_result4_up']['tmp_name'] = $files['upload_result4_up']['tmp_name'][$i];
			$_FILES['upload_result4_up']['error'] = $files['upload_result4_up']['error'][$i];
			$_FILES['upload_result4_up']['size'] = $files['upload_result4_up']['size'][$i];

			$this->upload->initialize($this->set_upload_options());

			if ($this->upload->do_upload('upload_result4_up')) {
				// Uploaded file data
				$imageData = $this->upload->data();
				$txt .= $imageData['file_name'] . ',';
			}
		}

		$result4FileNew = $txt . $result4File;
		if (empty($result4File)) {   // previous files are empty
			$result4FileNew = substr($txt, 0, -1);
		}

		$this->db->update('results', array("result4File" => $result4FileNew), array('detailId' => $detailId));
		redirect('admin/orders_items/view/' . $detailId);
	}

	public function set_upload_options()
	{

		//upload an image options
		$config =  array(
			'upload_path'     => './uploads/results/',
			'allowed_types'   => "*",
			'max_size'        => "0"
		);
		return $config;
	}



	public function onlySaveResult()
	{

		$resultId = $this->input->post('resultId');
		// array values
		$topText = $this->input->post('topText');
		$bottomText = $this->input->post('bottomText');
		$resultValue = $this->input->post('resultValue');

		$minValue = $this->input->post('minValue');
		$lowerValue = $this->input->post('lowerValue');
		$upperValue = $this->input->post('upperValue');
		$maxValue = $this->input->post('maxValue');

		for ($i = 0; $i < sizeof($resultId); $i++) {

			$result_data = array(
				'topText' => $topText[$i],
				'bottomText' => $bottomText[$i],
				'resultValue' => $resultValue[$i],
				'min_value' => $minValue[$i],
				'lower_value' => $lowerValue[$i],
				'upper_value' => $upperValue[$i],
				'max_value' => $maxValue[$i],
				'added_by' => $this->session_data->adminID
			);

			$value = $this->db->update('results', $result_data, array('resultId' => $resultId[$i]));

			// activity log by david
			$detailId = $this->input->post('detailId');
			$testName = $this->input->post('testName');
			$this->db->insert("activity_log", array("description" => 'The result for ' . $testName . ' has been updated by ' . $this->session_data->firstName, "tid" => 0, "oid" => $detailId, "createdAt" => date('Y-m-d H:i:s')));

			// End

		}



		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Successfully updated';
		echo json_encode($response);
		exit();
	}



	public function saveAndPublishResult()
	{
		$resultId = $this->input->post('resultId');
		$detailId = $this->input->post('detailId');

		// array values
		$topText = $this->input->post('topText');
		$bottomText = $this->input->post('bottomText');
		$resultValue = $this->input->post('resultValue');

		$minValue = $this->input->post('minValue');
		$lowerValue = $this->input->post('lowerValue');
		$upperValue = $this->input->post('upperValue');
		$maxValue = $this->input->post('maxValue');

		$result3 = $this->input->post('result3');

		for ($i = 0; $i < sizeof($resultId); $i++) {

			if (!empty($result3)) {

				$topText = $this->input->post('standard');
				$normal = $this->input->post('normal');
				$abnormal = $this->input->post('abnormal');

				if ($result3[$i] == 'Positive') {

					$bottomText = $abnormal[$i];
				} else {
					$bottomText = $normal[$i];
				}

				$result_data = array(
					'topText' => $topText[$i],
					'bottomText' => $bottomText,
					'result3' => $result3[$i],
					'added_by' => $this->session_data->adminID
				);
			} else {

				$result_data = array(
					'topText' => $topText[$i],
					'bottomText' => $bottomText[$i],
					'resultValue' => $resultValue[$i],
					'min_value' => $minValue[$i],
					'lower_value' => $lowerValue[$i],
					'upper_value' => $upperValue[$i],
					'max_value' => $maxValue[$i],
					'added_by' => $this->session_data->adminID
				);
			}

			$value = $this->db->update('results', $result_data, array('resultId' => $resultId[$i]));

			// activity log by david
			$detailId = $this->input->post('detailId');
			$testName = $this->db->query("select resultTestName from results where resultId = '" . $resultId[$i] . "'")->row()->resultTestName;  //$this->input->post('testName');
			$this->db->insert("activity_log", array("description" => 'The result for ' . $testName . ' has been updated by ' . $this->session_data->firstName, "tid" => 0, "oid" => $detailId, "createdAt" => date('Y-m-d H:i:s')));

			// End
		}

		$upd = array();
		$upd['detailStatus'] = 'Completed';
		$upd['updatedAt'] = current_datetime();
		$value = $this->db->update('order_details', $upd, array('detailId' => $detailId));

		if (isset($_SESSION['pin'])) {
			unset($_SESSION['pin']);
		}

		// Code added by david
		$order_details = $this->db->query('select users.userId, users.userFirstName,users.userLastName,users.userEmail,tests.testMarkers,order_details.* from order_details
 		LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId LEFT JOIN tests on order_details.testId=tests.testId
		 WHERE detailId=' . $detailId)->row();

		// send notifcation to user notify_user //
		$notify['notificationMessage'] = 'Your test results has been added.';
		$notify['notificationLink'] = $detailId;
		$notify['notificationStatus'] = 1;
		$notify['notificationTime'] = current_datetime();
		$notify['notificationTo'] = $order_details->userId;
		$notify['notificationToType'] = 'Member';
		$notify['notificationFrom'] = $this->session_data->adminID;
		$notify['notificationFromType'] = 'Admin';
		$notify['notificationType'] = 'Other';
		$this->db->insert('notifications', $notify);

		$to = $order_details->userEmail;
		$subject = 'Test Results Added';

		$email_data['title'] = $order_details->userFirstName . ' ' . $order_details->userLastName;
		$email_data['link'] = base_url() . 'results';
		$message = $this->load->view('emails/test_result', $email_data, true);

		$this->smtp_email->send('', '', $to, $subject, $message);

		// End

		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Successfully updated';
		echo json_encode($response);
		exit();
	}



	public function upload_test_result()
	{

		$this->load->view('admin/upload_result');
	}



	public function upload_result_file()
	{

		if (isset($_POST['file_btn'])) {

			$path = './uploads/results/';
			$this->load->library('upload');

			$this->upload->initialize(
				array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*'
				)
			);

			if ($this->upload->do_upload("upload_result")) {

				redirect('admin/orders_items/index');
			} else {

				$response = array();
				$response['code'] = 0;
				$response['img_error_message'] = $this->upload->error_msg[0];

				print_r($response['img_error_message']);

				exit();
			}
		}
	}



	public function check_login()
	{

		if (!isset($this->session_data->adminID)) {
			redirect('admin/login');
		}
	}



	public function check_ajax_login()
	{

		if (!isset($this->session_data->adminID)) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Login required!';
			echo json_encode($response);
			exit();
		}
	}



	public function check_ajax_datatable()
	{

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
