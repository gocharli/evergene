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
				
				// if ($currnet < $mship->period_end) {         // commented by david
				// 	$mship->expire = false;
				// }
				// else {
				// 	$mship->expire = true;
				// }
				// $this->membership_data = $mship;


				// Code added by david

				if ($currnet < $mship->period_end) {

					$month_number=date('m');
					$year=date('Y');
					$rrr=$this->db->query('select detailQty as total from order_details WHERE 
					userId='.$this->session_data->userId.' AND regularType="One Time"
					AND paymentType="Membership" AND YEAR(membershipDate)='.$year.'  AND MONTH(membershipDate)='.$month_number.' group by orderId')->result();
					
					$available_orders=0;
					foreach($rrr as $r){
						$available_orders+=$r->total;
					}

					//echo $available_orders; exit;
					if($available_orders >= $mship->orders){
						$mship->expire = true;
					}

					//$mship->expire = false;
				}
				else {
					$mship->expire = true;	
				}
				$this->membership_data = $mship;
				
				// End code added by david
			}
		}
	}



	public function index($slug='') {
		
		//echo $slug; exit;
		$this->session->set_userdata('current_url', base_url().'tests');
		
		if($slug=='mealprep' || $slug=='items') {
			$this->response['slug']=$slug;
		}else {
			
			$this->response['slug']=$slug;
			$slug_chk=$this->general_model->role_exists('catSlug',$slug,'categories');
			
			if($slug_chk==true) {
				$this->response['slug']='all';
			}
		}

		$this->response['page_title']="Tests";
		
		$tests=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
		 WHERE productType="Test" and testStatus = "Active" and (coming_soon = 0 or coming_soon_date <= CURDATE() ) order by sort desc')->result();

		// $tests=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		// LEFT JOIN categories ON tests.categoryId=categories.categoryId
		//  WHERE productType="Test" and testStatus = "Active" order by coming_soon asc, sort desc')->result();
		 
		
		$coming_soon_tests=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
		LEFT JOIN categories ON tests.categoryId=categories.categoryId
		WHERE productType="Test" and testStatus = "Active" and tests.coming_soon = 1 and tests.coming_soon_date > CURDATE() order by sort desc')->result();
		

		//echo '<pre>'; print_r($coming_soon_tests); exit;

		$this->response['results']=$tests;
		$this->response['coming_soon_tests']=$coming_soon_tests;
		$this->load->view('tests',$this->response);
	}
	


	public function view($slug='') {

		$test=$this->db->query('select tests.*,categories.categoryName,categories.catSlug from tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
 		WHERE productType="Test" AND slug="'.$slug.'" and testStatus = "Active"')->row();
		
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
