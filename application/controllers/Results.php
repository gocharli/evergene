<?php


class Results extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;
		//check membership detail
		$this->membership_data = new stdClass();
		$this->membership_data->expire = true;

		if (isset($this->session_data->userId)) {

			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId=' . $this->session_data->userId)->row();

			if ($mship) {

				if ($currnet < $mship->period_end) {
					$mship->expire = false;
				} else {
					$mship->expire = true;
				}
				$this->membership_data = $mship;
			}
		}
	}



	public function index()
	{

		$this->session->set_userdata('current_url', base_url() . 'results');
		$this->check_login();
		$this->response['page_title'] = "Test Results";
		$resultsPerPage = 12;
		$pagination_sql = " LIMIT 0 , $resultsPerPage";

		$this->response['newResults'] = $this->db->query('select count(*) as count FROM order_details
 		WHERE userId=' . $this->session_data->userId . ' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();

		$this->response['results'] = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" order by detailId DESC ' . $pagination_sql)->result();
		$this->response['resultsPerPage'] = $resultsPerPage;
		$this->load->view('list_results', $this->response);
	}



	public function loadmore()
	{

		$this->check_ajax_login();
		$resultsPerPage = 12;
		$paged = 0;

		if (isset($_POST['page'])) {
			$paged = $_POST['page'];
		}

		if ($paged > 0) {
			$page_limit = $resultsPerPage * ($paged - 1);
			$pagination_sql = " LIMIT  $page_limit, $resultsPerPage";
		} else {
			$pagination_sql = " LIMIT 0 , $resultsPerPage";
		}

		$results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" order by detailId DESC ' . $pagination_sql);

		$record = $results->num_rows();
		$results = $results->result();

		if ($record > 0) {

			$html = $this->load->view('components/list_results', array('results' => $results), true);

			if ($record >= $resultsPerPage) {
				$page = $paged + 1;
			} else {
				$page = 0;
			}
		} else {
			$html = '';
			$page = 0;
		}

		$response = array();
		$response['code'] = 1;
		$response['html'] = $html;
		$response['page'] = $page;
		echo json_encode($response);
		exit();
	}


	public function view($detailId = 0)
	{

		$this->check_login();

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType,tests.resultHistory , users.userFirstName,users.userLastName,users.userDob as dob, users.userGender as gender from order_details
		LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId
 		WHERE order_details.userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();


		// Added by david 13-4-2020
		$markers = $this->db->query("select * from test_markers_value where tm_test_id = '" . $order_details->testId . "'")->result();
		$response['markers'] = $markers;
		foreach ($markers as $mm) {
			$response['res_unit'][] = $mm->tm_unit;
		}

		$test_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.detailId=' . $detailId)->result();

		//echo '<pre>'; print_r($test_results); exit;

		// Added by david 

		$test_marker_res = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.marker_title = "'.$test_results[0]->marker_title.'" and results.testId="'. $test_results[0]->testId.'" and results.userId="'. $test_results[0]->userId.'" ')->result();
		$response['test_marker_res'] = $test_marker_res;
		
		//echo '<pre>'; print_r($test_marker_res); 
		$test_marker_results = [];

		for($i=0; $i<=count($test_marker_res); $i++){

			$test_marker_results[$i] = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.marker_title = "'.$test_results[$i]->marker_title.'" and results.testId="'. $test_results[$i]->testId.'" and results.userId="'. $test_results[$i]->userId.'" ')->result();
			//echo '<pre>'; print_r($test_marker_results); 
		}

		$response['test_marker_results'] = $test_marker_results;

		//exit;

		// End added by david

		$data = array(
			'orderViewStatus' => '1'
		);

		$this->db->where('detailId', $detailId);
		$this->db->update('order_details', $data);

		if (!$order_details) {
			redirect('results');
			exit();
		}

		$previous_results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();
		
		 //echo '<pre>'; print_r($test_results); exit;
		
		 $response['previous_results'] = $previous_results;

		$response['page_title'] = 'Evergene - ' . $order_details->testName . ' - Health Testing ';
		$response['meta_description'] = $test_results[0]->testDescription;
		$response['order_details'] = $order_details;
		$response['results'] = $test_results;

		if ($test_results[0]->testResultType == 'Result 1') {
			$this->load->view('result_details1', $response);
		} else if ($test_results[0]->testResultType == 'Result 2') {
			$this->load->view('result_details2', $response);
		} else if ($test_results[0]->testResultType == 'Result 3') {
			$this->load->view('result_details3', $response);
		} else if ($test_results[0]->testResultType == 'Result 4') {
			$this->load->view('result_details4', $response);
		} else {
			$this->load->view('result_details1', $response);
		}
	}

	public function filter_chart(){

		$testId = $this->input->post('testId');
		$marker_title = $this->input->post('marker_title');
		
		$test_marker_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.marker_title = "'.$marker_title.'" and results.testId="'. $testId.'" ')->result();
		
		$data = "[";
			$data .="['No Value', 'Abnormal Range','Normal Range','Abnormal Range','Your Result Value'],";

			$is_max = 0;
			$is_upper = 0;
			$is_lower = 0;
			$is_true = false;
			$no = 0;
			foreach ($test_marker_results as $res) {

				$no++;

				if($no == 1){
					
					$is_max = $res->max_value;
					$is_upper = $res->upper_value;
					$is_lower = $res->lower_value;
				}
				
				if($is_max == $res->max_value && $is_upper == $res->upper_value && $is_lower == $res->lower_value){

					$is_true = true;
				}

				if($is_max < $res->max_value){

					$is_true = false;

					$is_max = $res->max_value;
				}
				if($is_upper < $res->upper_value){

					$is_true = false;

					$is_upper = $res->upper_value;
				}
				if($is_lower < $res->lower_value){

					$is_true = false;
					
					$is_lower = $res->lower_value;
				}
			}

			if($is_true == true){
				foreach ($test_marker_results as $res) {

					$upper_value = $res->upper_value - $res->lower_value;
					$max_value = $res->max_value - $res->upper_value;

					//$data .="['',".$res->lower_value.",".$upper_value.",".$max_value.",".$res->resultValue."],";
					$data .="['".date('Y-m-d', strtotime($res->createdAt))."',".$res->lower_value.",".$upper_value.",".$max_value.",".$res->resultValue."],";
				}
			}
			else{

				foreach ($test_marker_results as $res) {

					$upper_value = $is_upper - $is_lower;
					$max_value = $is_max - $is_upper;

					$data .="['".date('Y-m-d', strtotime($res->createdAt))."',".$is_lower.",".$upper_value.",".$max_value.",".$res->resultValue."],";
				}
			}

		$data .= "]";

		echo $data;

	}

	public function filter_chart_bk()
	{

		$testId = $this->input->post('testId');
		$marker_title = $this->input->post('marker_title');

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

		$result_track_graph = $this->db->query('select * from results WHERE  DATE(createdAt)>="' . $last_year . '" and  userId=' . $this->session_data->userId . ' and testId=' . $testId . ' and resType="OBX" ')->result();

		if (trim($marker_title) != "") {
			$result_track_graph = $this->db->query('select * from results WHERE  DATE(createdAt)>="' . $last_year . '" and  userId=' . $this->session_data->userId . ' and testId=' . $testId . ' and marker_title = "' . $marker_title . '" and resType="OBX" GROUP BY YEAR(createdAt), MONTH(createdAt) ')->result();
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

	public function result_details()
	{
		redirect('results/result_details1');
	}

	public function result_details4()
	{
		$detailId = 331;

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType,tests.resultHistory , users.userFirstName,users.userLastName,user_details.dob,user_details.gender from order_details
		LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		$test_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.detailId=' . $detailId)->result();

		$data = array(
			'orderViewStatus' => '1'
		);

		$this->db->where('detailId', $detailId);
		$this->db->update('order_details', $data);

		if (!$order_details) {
			redirect('results');
			exit();
		}


		$previous_results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();

		$response['previous_results'] = $previous_results;

		$response['page_title'] = 'Result ' . $order_details->testName;
		$response['order_details'] = $order_details;
		$response['results'] = $test_results;
		$this->load->view('result_details4', $response);
	}

	public function result_details1($detailId = '')
	{

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType,tests.resultHistory , users.userFirstName,users.userLastName,user_details.dob,user_details.gender from order_details
		LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		$test_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.detailId=' . $detailId)->result();

		$data = array(
			'orderViewStatus' => '1'
		);

		$this->db->where('detailId', $detailId);
		$this->db->update('order_details', $data);

		if (!$order_details) {
			redirect('results');
			exit();
		}

		$previous_results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();

		$response['previous_results'] = $previous_results;

		$response['page_title'] = 'Result ' . $order_details->testName;
		$response['order_details'] = $order_details;
		$response['results'] = $test_results;
		$this->load->view('result_details1', $response);
	}

	public function result_details2()
	{

		$detailId = 331;

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType,tests.resultHistory , users.userFirstName,users.userLastName,user_details.dob,user_details.gender from order_details
		LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		$test_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.detailId=' . $detailId)->result();

		$data = array(
			'orderViewStatus' => '1'
		);

		$this->db->where('detailId', $detailId);
		$this->db->update('order_details', $data);

		if (!$order_details) {
			redirect('results');
			exit();
		}

		$previous_results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();

		$response['previous_results'] = $previous_results;

		$response['page_title'] = 'Result ' . $order_details->testName;
		$response['order_details'] = $order_details;
		$response['results'] = $test_results;
		$this->load->view('result_details2', $response);
	}

	public function result_details3()
	{

		$detailId = 331;

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType,tests.resultHistory , users.userFirstName,users.userLastName,user_details.dob,user_details.gender from order_details
		LEFT JOIN tests on order_details.testId=tests.testId LEFT JOIN users on order_details.userId=users.userId LEFT JOIN user_details on order_details.userId=user_details.userId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		$test_results = $this->db->query('select tests.* , results.* from tests LEFT JOIN results on results.testId=tests.testId WHERE results.detailId=' . $detailId)->result();

		$data = array(
			'orderViewStatus' => '1'
		);

		$this->db->where('detailId', $detailId);
		$this->db->update('order_details', $data);

		if (!$order_details) {
			redirect('results');
			exit();
		}

		$previous_results = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE order_details.productType="Test" and order_details.detailStatus="Completed" and testName="' . $order_details->testName . '" order by detailId DESC ')->result();

		$response['previous_results'] = $previous_results;

		$response['page_title'] = 'Result ' . $order_details->testName;
		$response['order_details'] = $order_details;
		$response['results'] = $test_results;
		$this->load->view('result_details3', $response);
	}



	public function call()
	{

		$this->check_ajax_login();
		$type = $this->input->post('type');
		$detailId = $this->input->post('orderId');

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		if ($order_details) {

			if ($type == 'doctor') {
				$request_call = $this->db->query('select * from request_call
 				WHERE detailId="' . $detailId . '" and requestType="doctor" and  requestStatus="Pending"')->row();

				if ($request_call) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Request already submitted please wait.';
					echo json_encode($response);
					exit();
				}

				$call_doctor_price = $this->general_model->select_where('settings', array('settingOption' => 'call_doctor_price'));

				if ($call_doctor_price) {

					if ($call_doctor_price->settingValue > 0) {
						$response = array();
						$response['code'] = 1;
						$response['type'] = 'doctor';
						$response['price'] = $call_doctor_price->settingValue;
						echo json_encode($response);
						exit();
					}
				}

				$response = array();
				$response['code'] = 1;
				$response['type'] = 'doctor';
				$response['price'] = 0;
				echo json_encode($response);
				exit();
			} else {

				$request_call = $this->db->query('select * from request_call
 				WHERE detailId="' . $detailId . '" and requestType="nurse" and  requestStatus="Pending"')->row();

				if ($request_call) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Request already submitted please wait.';
					echo json_encode($response);
					exit();
				}
				if ($order_details->callNurseType == 'Used') {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Request nurse already used';
					echo json_encode($response);
					exit();
				} else {

					$call_nurse_price = $this->general_model->select_where('settings', array('settingOption' => 'call_nurse_price'));

					if ($call_nurse_price) {

						if ($call_nurse_price->settingValue > 0) {

							$response = array();
							$response['code'] = 1;
							$response['type'] = 'nurse';
							$response['price'] = $call_nurse_price->settingValue;
							echo json_encode($response);
							exit();
						}
					}

					$response = array();
					$response['code'] = 1;
					$response['type'] = 'nurse';
					$response['price'] = 0;
					echo json_encode($response);
					exit();
				}
			}
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Result not Found';
			echo json_encode($response);
			exit();
		}
	}



	public function call_payment()
	{

		$this->check_ajax_login();
		$type = $this->input->post('type');
		$detailId = $this->input->post('orderId');

		$order_details = $this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testResultType from order_details
		LEFT JOIN tests on order_details.testId=tests.testId
 		WHERE userId=' . $this->session_data->userId . ' and order_details.productType="Test" and order_details.detailStatus="Completed" and order_details.detailId="' . $detailId . '"')->row();

		if ($order_details) {

			if ($type == 'doctor') {

				$call_doctor_price = $this->general_model->select_where('settings', array('settingOption' => 'call_doctor_price'));

				if ($call_doctor_price) {

					if ($call_doctor_price->settingValue > 0) {

						$token = $this->input->post('stripeToken');

						if ($token == '') {

							$response = array();
							$response['code'] = 0;
							$response['message'] = 'payment failed.';
							echo json_encode($response);
							exit();
						}

						require_once(APPPATH . 'libraries/stripe-php/init.php');
						$stripe_api_key = getenv('stripe_api_secret');
						\Stripe\Stripe::setApiKey($stripe_api_key);
						$customer_email = $this->session_data->userEmail;
						$customer = \Stripe\Customer::create(array(
							'email' => $customer_email, // customer email id
							'card'  => $token
						));
						$charge = \Stripe\Charge::create(array(
							'customer'  => $customer->id,
							'amount'    => ceil($call_doctor_price->settingValue * 100),
							'currency'  => 'GBP'
						));

						if ($charge->paid == true) {

							if (isset($charge->balance_transaction)) {
								$tk = $charge->balance_transaction;
							} else {
								$tk = '';
							}

							$customer = (array)$customer;
							$charge = (array)$charge;
							// payment
							$ins = array();
							$ins['userId'] = $this->session_data->userId;
							$ins['orderAmount'] = $call_doctor_price->settingValue;
							$ins['paymentDetail'] = "Customer Info: \n" . json_encode($customer, true) . "\n \n Charge Info: \n" . json_encode($charge, true);
							$ins['transactionId'] = $tk;
							$ins['createdAt'] = current_datetime();
							$this->db->insert('payments', $ins);
						} else {

							$response = array();
							$response['code'] = 0;
							$response['message'] = 'Payment Failed!';
							echo json_encode($response);
							exit();
						}
					}
				}

				$ins = array();
				$ins['userId'] = $order_details->userId;
				$ins['detailId'] = $order_details->detailId;
				$ins['orderId'] = $order_details->orderId;
				$ins['testId'] = $order_details->testId;
				$ins['requestType'] = 'doctor';
				$ins['requestStatus'] = 'Pending';
				$ins['createdAt'] = current_datetime();
				$this->db->insert('request_call', $ins);
				$requestId = $this->db->insert_id();
				// send notifcation to admin notify_admin //
				$notify = array();
				$notify['notificationMessage'] = 'A new doctor request is placed by ' . $this->session_data->userFirstName;
				$notify['notificationLink'] = $requestId;
				$notify['notificationStatus'] = 1;
				$notify['notificationTime'] = current_datetime();
				$notify['notificationTo'] = 1;
				$notify['notificationToType'] = 'Admin';
				$notify['notificationFrom'] = $this->session_data->userId;
				$notify['notificationFromType'] = 'Member';
				$notify['notificationType'] = 'Request';
				$this->db->insert('notifications', $notify);

				$response = array();
				$response['code'] = 1;
				$response['message'] = 'Request submitted successfully';
				echo json_encode($response);
				exit();
			} else {

				if ($order_details->callNurseType == 'Used') {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Request nurse already used';
					echo json_encode($response);
					exit();
				} else {

					$call_nurse_price = $this->general_model->select_where('settings', array('settingOption' => 'call_nurse_price'));

					if ($call_nurse_price) {

						if ($call_nurse_price->settingValue > 0) {

							$token = $this->input->post('stripeToken');

							if ($token == '') {

								$response = array();
								$response['code'] = 0;
								$response['message'] = 'payment failed.';
								echo json_encode($response);
								exit();
							}

							require_once(APPPATH . 'libraries/stripe-php/init.php');
							$stripe_api_key = getenv('stripe_api_secret');
							\Stripe\Stripe::setApiKey($stripe_api_key);
							$customer_email = $this->session_data->userEmail;
							$customer = \Stripe\Customer::create(array(
								'email' => $customer_email, // customer email id
								'card'  => $token
							));
							$charge = \Stripe\Charge::create(array(
								'customer'  => $customer->id,
								'amount'    => ceil($call_nurse_price->settingValue * 100),
								'currency'  => 'GBP'
							));

							if ($charge->paid == true) {

								if (isset($charge->balance_transaction)) {
									$tk = $charge->balance_transaction;
								} else {
									$tk = '';
								}

								$customer = (array)$customer;
								$charge = (array)$charge;
								// payment
								$ins = array();
								$ins['userId'] = $this->session_data->userId;
								$ins['orderAmount'] = $call_nurse_price->settingValue;
								$ins['paymentDetail'] = "Customer Info: \n" . json_encode($customer, true) . "\n \n Charge Info: \n" . json_encode($charge, true);
								$ins['transactionId'] = $tk;
								$ins['createdAt'] = current_datetime();
								$this->db->insert('payments', $ins);
							} else {

								$response = array();
								$response['code'] = 0;
								$response['message'] = 'Payment Failed!';
								echo json_encode($response);
								exit();
							}
						}
					}

					$ins = array();
					$ins['userId'] = $order_details->userId;
					$ins['detailId'] = $order_details->detailId;
					$ins['orderId'] = $order_details->orderId;
					$ins['testId'] = $order_details->testId;
					$ins['requestType'] = 'nurse';
					$ins['requestStatus'] = 'Pending';
					$ins['createdAt'] = current_datetime();
					$this->db->insert('request_call', $ins);
					$requestId = $this->db->insert_id();

					// send notifcation to admin notify_admin //
					$notify = array();
					$notify['notificationMessage'] = 'A new nurse request is placed by ' . $this->session_data->userFirstName;
					$notify['notificationLink'] = $requestId;
					$notify['notificationStatus'] = 1;
					$notify['notificationTime'] = current_datetime();
					$notify['notificationTo'] = 1;
					$notify['notificationToType'] = 'Admin';
					$notify['notificationFrom'] = $this->session_data->userId;
					$notify['notificationFromType'] = 'Member';
					$notify['notificationType'] = 'Request';
					$this->db->insert('notifications', $notify);

					$response = array();
					$response['code'] = 1;
					$response['message'] = 'Request submitted successfully';
					echo json_encode($response);
					exit();
				}
			}
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Result not Found';
			echo json_encode($response);
			exit();
		}
	}


	public function check_login()
	{

		if (!isset($this->session_data->userId)) {
			redirect('home');
		}
	}


	public function check_ajax_login()
	{

		if (!isset($this->session_data->userId)) {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
	}
}
