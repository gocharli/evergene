<?php



class Tests extends CI_Controller{

	

	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
		//check membership detail
		$this->membership_data=new stdClass();
		$this->membership_data->expire=true;
		
		if(isset($this->session_data->userId)) {
			
			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId='.$this->session_data->userId)->row();
			
			if ($mship) {
				
				if ($currnet < $mship->period_end) {
					$mship->expire = false;
				}
				else {
					$mship->expire = true;
				}
				$this->membership_data = $mship;
			}
		}
	}



	public function index($slug='') {
		
		$this->session->set_userdata('current_url', base_url().'tests');
		
		if($slug=='mealprep' || $slug=='items') {
			$this->response['slug']=$slug;
		}
		else {
			
			$this->response['slug']=$slug;
			$slug_chk=$this->general_model->role_exists('catSlug',$slug,'categories');
			
			if($slug_chk==true) {
				$this->response['slug']='all';
			}
		}

		$this->response['page_title']="Tests";
		$tests=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
 		WHERE productType="Test"')->result();
		$this->response['results']=$tests;
		$this->load->view('tests',$this->response);
	}
	


	public function view($slug='') {

		$test=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
 		WHERE productType="Test" AND slug="'.$slug.'"')->row();
		
		if($test) {
			
			$related=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
			LEFT JOIN categories ON tests.categoryId=categories.categoryId
			WHERE productType="Test" AND slug!="'.$slug.'" and tests.categoryId='.$test->categoryId.' ORDER BY RAND() LIMIT 8')->result();

			$this->response['page_title']=$test->testName;
			$this->response['row']=$test;
			$this->response['related']=$related;
			$this->load->view('test_detail',$this->response);
		}
		else {
			redirect('tests');
		}

	}


}
