<?php


class How_it_works extends CI_Controller
{


	public function __construct()
	{


		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;
	}

	public function index()
	{

		$this->load->view('how-it-works');
	}
}
