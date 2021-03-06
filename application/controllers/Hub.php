<?php

class Hub extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;

		$this->load->model('qrisk_model');

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
		$this->check_login();
		$this->response['newResults'] = $this->db->query('select count(*) as count FROM order_details
 		WHERE userId=' . $this->session_data->userId . ' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();

		$this->session->set_userdata('current_url', base_url() . 'hub');
		$this->response['page_title'] = "Hub";

		$row = $this->db->query('select * from user_details WHERE userId=' . $this->session_data->userId)->row();
		$gender = $this->db->query('select userGender from users WHERE userId=' . $this->session_data->userId)->row()->userGender;
		$row->qriskk = $this->qrisk_model->get_qrisk($this->session_data->userId, $gender);
		$row->heart_age = '';
		$rr = $this->db->query('select * from user_track_graph WHERE userId="' . $this->session_data->userId . '" order by trackId desc')->row();
		if ($rr) {
			$row->heart_age = $rr->heart_age;
		}
		$this->response['row'] = $row;
		// recomended //
		$this->response['recommended_products'] = $this->db->query('SELECT tests.* ,(SELECT sum(detailQty) FROM order_details LIMIT 1) as cqty  FROM `order_details`
						LEFT JOIN tests ON order_details.testId=tests.testId where tests.productType="Test" and tests.testStatus = "Active" 
						GROUP by testId
						order by cqty desc
						LIMIT 4')->result();

		//track//
		$daily_analytics = array();
		$last_year = date("Y-m-d", strtotime("-1 year"));
		$date = $last_year;

		for ($i = 1; $i < 13; $i++) {

			if ($i != 0) {
				$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
			}

			$new = array();
			$new['y'] = date('Y-m-d', strtotime($date));
			$new['x'] = 0;
			$new['x1'] = 0;
			$new['x2'] = 0;
			$new['x3'] = 0;
			$daily_analytics[] = $new;
		}

		$user_track_graph = $this->db->query('select * from user_track_graph WHERE DATE(date)>="' . $last_year . '" and  userId=' . $this->session_data->userId . '  GROUP BY YEAR(date), MONTH(date) order by trackId desc')->result();

		foreach ($user_track_graph as $r) {
			foreach ($daily_analytics as $key => $row) {
				if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {
					$hip_waist_ratio = 0;
					if ($r->hip > 0 && $r->waist > 0) {
						$wh = $r->hip / $r->waist;
						$hip_waist_ratio = number_point_format($wh, 1);
					}
					$daily_analytics[$key]['x'] = $r->bmi;
					$daily_analytics[$key]['x1'] = $hip_waist_ratio;
					$daily_analytics[$key]['x2'] = $r->qrisk;
					$daily_analytics[$key]['x3'] = $r->heart_attack;
				}
			}
		}

		$pagination_sql = " LIMIT 0 , 4";
		$blogs = $this->db->query('select blogs.* from blogs
 		ORDER BY blogId DESC ' . $pagination_sql)->result();
		$this->response['res_bmi'] = $daily_analytics;
		$this->response['blogs'] = $blogs;
		$this->load->view('hub', $this->response);
	}


	public function filter_chart()
	{
		$daily_analytics = array();
		$last_year = date("Y-m-d", strtotime("-1 year"));
		$date = $last_year;

		for ($i = 1; $i < 13; $i++) {

			if ($i != 0) {
				$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
			}

			$new = array();
			$new['y'] = date('Y-m-d', strtotime($date));
			$new['x'] = 0;
			$daily_analytics[] = $new;
		}
		$user_track_graph = $this->db->query('select * from user_track_graph WHERE DATE(date)>="' . $last_year . '" and  userId=' . $this->session_data->userId . '  GROUP BY YEAR(date), MONTH(date) order by trackId desc')->result();


		if ($_POST['type'] == 'BMI') {
			foreach ($user_track_graph as $r) {
				foreach ($daily_analytics as $key => $row) {
					if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {

						$daily_analytics[$key]['x'] = $r->bmi;
					}
				}
			}
		} else if ($_POST['type'] == 'Hip/Waist Ratio') {
			foreach ($user_track_graph as $r) {
				foreach ($daily_analytics as $key => $row) {
					if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {
						$hip_waist_ratio = 0;
						if ($r->hip > 0 && $r->waist > 0) {
							$wh = $r->hip / $r->waist;
							$hip_waist_ratio = number_point_format($wh, 1);
						}
						$daily_analytics[$key]['x'] = $hip_waist_ratio; //$r->hip;

					}
				}
			}
		} else if ($_POST['type'] == 'QRISK') {
			foreach ($user_track_graph as $r) {
				foreach ($daily_analytics as $key => $row) {
					if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {

						$daily_analytics[$key]['x'] = $r->qrisk;
					}
				}
			}
		} else if ($_POST['type'] == 'Heart Age') {
			foreach ($user_track_graph as $r) {
				foreach ($daily_analytics as $key => $row) {
					if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {

						$daily_analytics[$key]['x'] = $r->heart_attack;
					}
				}
			}
		} else {
			foreach ($user_track_graph as $r) {
				foreach ($daily_analytics as $key => $row) {
					if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->date))) {

						$daily_analytics[$key]['x'] = $r->bmi;
						$daily_analytics[$key]['x1'] = $r->hip;
						$daily_analytics[$key]['x2'] = $r->qrisk;
						$daily_analytics[$key]['x3'] = $r->heart_attack;
					}
				}
			}
		}


		echo json_encode($daily_analytics);
	}


	public function resend_email()
	{

		$this->check_ajax_login();
		$uu = $this->db->query('select * from users WHERE userId=' . $this->session_data->userId)->row();

		if ($uu->userEmailStatus == 'Verified') {

			$error = validation_errors();
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Email is already verified.';
			echo json_encode($response);
			exit();
		} else {

			$key = $uu->userEmail . date('mY');
			$key = md5($key);
			$upd['userEmailConfirmCode'] = $key;
			$upd['updatedAt'] = current_datetime();
			$this->db->update('users', $upd, array('userId' => $this->session_data->userId));

			$name = $uu->userFirstName . ' ' . $uu->userLastName;

			// Added by David
			if ($this->session_data->userEmail != $uu->userEmail) {
				$to = $uu->tempEmail;
			} else {
				$to = $uu->userEmail;
			}
			// End


			$subject = 'CONFIRMATION EMAIL';

			$email_data['title'] = 'CONFIRMATION EMAIL';
			$email_data['body'] = 'Welcomes ' . $name . '. Kindly click the given link for activation of your Account.';
			$email_data['link'] = base_url() . 'signup/confirm/' . $key . '/' . $to;
			$email_data['link_name'] = 'Activate';
			$message = $this->load->view('emails/templete_1', $email_data, true);


			$this->smtp_email->send('', '', $to, $subject, $message);

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'confirmation email sent successfully.';
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
