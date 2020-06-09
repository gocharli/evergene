<?php

class Home extends CI_Controller{

	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}
	
	public function index() {

		$this->response['page_title']="Home";
		$tests=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
 		WHERE productType="Test" and testStatus = "Active" and tests.isPopular > 0')->result();
		$this->response['results']=$tests;

		$this->response['tests_performed'] = $this->db->query("select count(*) as cnt from order_details")->row()->cnt;
		$this->response['infections_detected'] = $this->db->query("select count(*) as cnt from results where result3 = 'Positive' ")->row()->cnt;   // type 3 positive
		$this->response['abnormal_results_detected'] = $this->db->query("select count(*) as cnt from results where (resultValue <=  lower_value) or (resultValue >=  upper_value) ")->row()->cnt;   // type 1 and 2

		$pagination_sql=" LIMIT 0 , 3";
		$blogs=$this->db->query('select blogs.* from blogs
		 ORDER BY blogId DESC limit 3')->result();
		 $this->response['blogs']=$blogs;
		$this->load->view('home',$this->response);
	}


}
