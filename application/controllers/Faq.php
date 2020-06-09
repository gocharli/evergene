<?php

class Faq extends CI_Controller{

	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}
	
	public function index() {

		$this->response['page_title']="Terms of use";
		$this->load->view('FAQ',$this->response);
	}


}
