<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Settings extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$sess_data = $this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index()
	{

		$this->check_login();
		$this->data['page_title'] = 'Settings - Admin';
		$this->data['results'] = $this->db->query('select * from settings')->result();
		$this->load->view('admin/edit_settings', $this->data);
	}



	public function proccess()
	{

		$this->check_ajax_login();
		$results = $this->db->query('select * from settings')->result();

		foreach ($results as $row) {
			if (isset($_POST['setting_' . $row->settingID])) {
				if (($_POST['setting_' . $row->settingID]) > -1) {
					$upd = array();
					$upd['settingValue'] = $_POST['setting_' . $row->settingID];
					$this->db->update('settings', $upd, array('settingID' => $row->settingID));
				}
			}
		}

		$response = array();
		$response['code'] = 1;
		$response['message'] = 'Updated Successfully';
		echo json_encode($response);
		exit();
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
}
