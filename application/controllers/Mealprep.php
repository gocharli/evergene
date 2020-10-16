<?php


class Mealprep extends CI_Controller
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

		$this->session->set_userdata('current_url', base_url() . 'mealprep');
		$this->response['page_title'] = "Meal Prep";
		$tests = $this->db->query('select tests.*,(SELECT test_images.imageName FROM test_images WHERE tests.testId=test_images.testId ORDER BY rand() LIMIT 1) as otherImg from tests
 		WHERE productType="MealPrep"')->result();
		$this->response['results'] = $tests;
		$this->load->view('mealprep', $this->response);
	}



	public function view($slug = '')
	{

		$test = $this->db->query('select tests.* from tests
 		WHERE productType="MealPrep" AND slug="' . $slug . '"')->row();

		if ($test) {

			$related = $this->db->query('select tests.* from tests
			WHERE productType="MealPrep" AND slug!="' . $slug . '"  ORDER BY RAND() LIMIT 8')->result();

			$this->response['page_title'] = $test->testName;
			$this->response['row'] = $test;
			$this->response['related'] = $related;
			$this->load->view('mealprep_detail', $this->response);
		} else {

			redirect('mealprep');
		}
	}
}
