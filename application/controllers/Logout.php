<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->session->unset_userdata('users');
		$this->session->unset_userdata('current_url');
		$this->cart->destroy();
		redirect('home');

	}
}
