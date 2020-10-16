<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Profile extends CI_Controller
{



	public function __construct()
	{

		parent::__construct();
		$sess_data = $this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function change_password()
	{

		$this->check_login();
		$this->data['page_title'] = 'Change Password - Admin';
		$this->load->view('admin/change_password', $this->data);
	}



	public function change_password_code()
	{

		$this->check_ajax_login();
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|matches[c-password]|min_length[8]');
		$this->form_validation->set_rules('c-password', 'Password Confirmation', 'required');

		if ($this->form_validation->run() == FALSE) {
			$error = validation_errors();
			$this->session->set_flashdata('perror', $error);

			$response = array();
			$response['code'] = 0;
			$response['message'] = $error;
			echo json_encode($response);
			exit();
		} else {

			$password = md5($this->input->post('password'));
			$new_password = md5($this->input->post('new_password'));

			$this->db->select('*');
			$this->db->from('admin');
			$this->db->where('adminID', $this->session_data->adminIDs);
			$this->db->where('password', $password);
			$this->db->limit(1);
			$query = $this->db->get();

			if ($query->num_rows() == 1) {
				$this->db->set('password', $new_password);
				$this->db->where('adminID', $this->session_data->adminID);
				$this->db->update('admin');
			} else {

				$response = array();
				$response['code'] = 0;
				$response['message'] = 'password is incorrect!';
				echo json_encode($response);
				exit();
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'password changed Successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function check_login()
	{

		$session = $this->session->userdata('admin');
		if (!isset($session->adminID)) {
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
