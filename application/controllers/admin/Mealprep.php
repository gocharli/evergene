<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mealprep extends CI_Controller
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
		$this->data['page_title'] = 'Meal Prep';
		$this->load->view('admin/list_mealprep', $this->data);
	}



	public function add()
	{

		$this->check_login();
		$this->data['page_title'] = 'Add Meal prep - Admin';
		$this->load->view('admin/add_mealprep', $this->data);
	}



	public function edit($id = 0)
	{

		$this->check_login();
		$test = $this->db->query("SELECT * FROM tests WHERE testId='" . $id . "' and isDeleted='No' and productType='MealPrep'")->row();

		if ($test) {

			$this->data['page_title'] = 'Edit Meal Prep';
			$this->data['row'] = $test;
			$this->load->view('admin/edit_mealprep', $this->data);
		} else {

			redirect('admin/mealprep');
		}
	}



	public function view($id = 0)
	{

		$this->check_login();
		$test = $this->db->query("SELECT tests.* FROM tests 		
 		WHERE testId='" . $id . "' and isDeleted='No' and productType='MealPrep'")->row();

		if ($test) {

			$this->data['page_title'] = 'View Meal Prep';
			$this->data['row'] = $test;
			$this->load->view('admin/view_mealprep', $this->data);
		} else {

			redirect('admin/mealprep');
		}
	}



	public  function  add_process()
	{

		$this->check_ajax_login();
		$this->form_validation->set_rules('testName', 'Name', 'required');
		$this->form_validation->set_rules('originalPrice', 'original Price', 'required');
		$this->form_validation->set_rules('discountPrice', 'Discount Price', 'required');
		$this->form_validation->set_rules('testDescription', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = validation_errors();
			echo json_encode($response);
			exit();
		} else {

			$testName = $this->input->post('testName');
			$originalPrice = $this->input->post('originalPrice');
			$discountPrice = $this->input->post('discountPrice');
			$discountPercentage = $this->input->post('discountPercentage');
			$testDescription = $this->input->post('testDescription');
			$testDetails = $this->input->post('testDetails');
			$menu = $this->input->post('menu');
			$howItsWork = $this->input->post('howItsWork');

			$slug = slug($testName);
			$slug_chk = $this->general_model->role_exists('slug', $slug, 'tests');

			if ($slug_chk == false) {

				$response = array();
				$response['code'] = 0;
				$response['message'] = 'Meal prep with same name already exist';
				echo json_encode($response);
				exit();
			}

			if ($discountPrice < 1 || $originalPrice < 1) {

				$response = array();
				$response['code'] = 0;
				$response['message'] = 'Price must me greater than 0';
				echo json_encode($response);
				exit();
			}


			if ($discountPercentage == 'Yes') {

				if ($discountPrice >= 100) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Discount must be less than 100%';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = $originalPrice * ($discountPrice / 100);
			} else {

				if ($discountPrice >= $originalPrice) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Discount price must be less than Original price';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = ($discountPrice / $originalPrice) * 100;
				$discountPercentage = 'No';
			}

			$path = './uploads/tests/logo/';
			$this->load->library('upload');
			$this->upload->initialize(
				array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*',
					"encrypt_name"      =>  true
				)
			);

			if ($this->upload->do_upload("testLogo")) {

				$upload_data = $this->upload->data();
				$testLogo = $upload_data['file_name'];
			} else {

				$response = array();
				$response['code'] = 0;
				$response['message'] = $this->upload->error_msg[0];
				echo json_encode($response);
				exit();
			}

			$ins = array();
			$ins['testName'] = $testName;
			$ins['slug'] = $slug;
			$ins['originalPrice'] = $originalPrice;
			$ins['discountPercentage'] = $discountPercentage;
			$ins['discountPrice'] = $discountPrice;
			$ins['discountedPrice'] = $discountedPrice;
			$ins['testDescription'] = $testDescription;
			$ins['testDetails'] = $testDetails;
			$ins['menu'] = $menu;
			$ins['howItsWork'] = $howItsWork;
			$ins['testLogo'] = $testLogo;
			$ins['productType'] = 'MealPrep';
			$ins['testStatus'] = 'Active';
			$ins['isDeleted'] = 'No';
			$ins['createdAt'] = current_datetime();
			$ins['updatedAt'] = current_datetime();
			$this->db->insert('tests', $ins);
			$testId = $this->db->insert_id();

			// more images //
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['moreImages']['name']);

			for ($i = 0; $i < $cpt; $i++) {

				$_FILES['image']['name'] = $files['moreImages']['name'][$i];
				$_FILES['image']['type'] = $files['moreImages']['type'][$i];
				$_FILES['image']['tmp_name'] = $files['moreImages']['tmp_name'][$i];
				$_FILES['image']['error'] = $files['moreImages']['error'][$i];
				$_FILES['image']['size'] = $files['moreImages']['size'][$i];

				$path = './uploads/tests/products/';
				$this->upload->initialize(
					array(
						"upload_path"       =>  $path,
						"allowed_types"     =>  '*',
						"encrypt_name"      =>  true
					)
				);
				if ($this->upload->do_upload('image')) {

					$upload_data = $this->upload->data();
					$dataInfo[] = $upload_data['file_name'];
				}
			}
			foreach ($dataInfo as $img) {

				$ins = array();
				$ins['testId'] = $testId;
				$ins['imageName'] = $img;
				$this->db->insert('test_images', $ins);
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Added successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function edit_process($id = 0)
	{

		$this->check_ajax_login();
		$this->check_ajax_login();
		$test = $this->db->query("SELECT * FROM tests WHERE testId='" . $id . "' and isDeleted='No' and productType='MealPrep'")->row();

		if (!$test) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = "Meal Prep Not found";
			echo json_encode($response);
			exit();
		}

		$this->form_validation->set_rules('testName', 'Name', 'required');
		$this->form_validation->set_rules('originalPrice', 'original Price', 'required');
		$this->form_validation->set_rules('discountPrice', 'Discount Price', 'required');
		$this->form_validation->set_rules('testDescription', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = validation_errors();
			echo json_encode($response);
			exit();
		} else {

			$testName = $this->input->post('testName');
			$originalPrice = $this->input->post('originalPrice');
			$categoryId = $this->input->post('categoryId');
			$discountPrice = $this->input->post('discountPrice');
			$discountPercentage = $this->input->post('discountPercentage');
			$testDescription = $this->input->post('testDescription');
			$testDetails = $this->input->post('testDetails');
			$menu = $this->input->post('menu');
			$howItsWork = $this->input->post('howItsWork');

			$slug = slug($testName);

			if ($test->slug != $slug) {

				$slug_chk = $this->general_model->role_exists('slug', $slug, 'tests');

				if ($slug_chk == false) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Meal prep with same name already exist';
					echo json_encode($response);
					exit();
				}
			}

			if ($discountPrice < 1 || $originalPrice < 1) {

				$response = array();
				$response['code'] = 0;
				$response['message'] = 'Price must me greater than 0';
				echo json_encode($response);
				exit();
			}

			if ($discountPercentage == 'Yes') {

				if ($discountPrice >= 100) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Discount must be less than 100%';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = $originalPrice * ($discountPrice / 100);
			} else {

				if ($discountPrice >= $originalPrice) {

					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Discount price must be less than Original price';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = ($discountPrice / $originalPrice) * 100;
				$discountPercentage = 'No';
			}

			$path = './uploads/tests/logo/';
			$this->load->library('upload');
			$this->upload->initialize(
				array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*',
					"encrypt_name"      =>  true
				)
			);

			$upd = array();
			$upd['testName'] = $testName;
			$upd['slug'] = $slug;
			$upd['categoryId'] = $categoryId;
			$upd['originalPrice'] = $originalPrice;
			$upd['discountPercentage'] = $discountPercentage;
			$upd['discountPrice'] = $discountPrice;
			$upd['discountedPrice'] = $discountedPrice;
			$upd['testDescription'] = $testDescription;
			$upd['testDetails'] = $testDetails;
			$upd['menu'] = $menu;
			$upd['howItsWork'] = $howItsWork;

			if ($this->upload->do_upload("testLogo")) {

				$upload_data = $this->upload->data();
				$upd['testLogo'] = $upload_data['file_name'];
			}

			$upd['updatedAt'] = current_datetime();
			$this->db->update('tests', $upd, array('testId' => $id));
			$testId = $id;
			// more images //
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['moreImages']['name']);

			for ($i = 0; $i < $cpt; $i++) {

				$_FILES['image']['name'] = $files['moreImages']['name'][$i];
				$_FILES['image']['type'] = $files['moreImages']['type'][$i];
				$_FILES['image']['tmp_name'] = $files['moreImages']['tmp_name'][$i];
				$_FILES['image']['error'] = $files['moreImages']['error'][$i];
				$_FILES['image']['size'] = $files['moreImages']['size'][$i];

				$path = './uploads/tests/products/';
				$this->upload->initialize(
					array(
						"upload_path"       =>  $path,
						"allowed_types"     =>  '*',
						"encrypt_name"      =>  true
					)
				);

				if ($this->upload->do_upload('image')) {

					$upload_data = $this->upload->data();
					$dataInfo[] = $upload_data['file_name'];
				}
			}

			foreach ($dataInfo as $img) {
				$ins = array();
				$ins['testId'] = $testId;
				$ins['imageName'] = $img;
				$this->db->insert('test_images', $ins);
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Updated successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function list_data()
	{

		$this->check_ajax_datatable();

		$columns = array(
			0 => 'testId',
			1 => 'testName',
			4 => 'originalPrice',
			5 => 'discountPrice',
			6 => 'testStatus',
			7 => 'testId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr = 'where 1=1 ';
		$whr .= ' and isDeleted="No" and productType="MealPrep" ';

		$totalData = $this->db->query('select * from tests ' . $whr)->num_rows();
		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {

			$sq = $this->db->query('select tests.* from tests
 			' . $whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);

			if ($sq->num_rows() > 0) {
				$result = $sq->result();
			} else {
				$result = null;
			}
		} else {

			$search = $this->input->post('search')['value'];
			$whr .= ' and (testId like "%' . $search . '%" or  testName like "%' . $search . '%")';

			$sq = $this->db->query('select tests.* from tests
 			' . $whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);

			if ($sq->num_rows() > 0) {

				$result = $sq->result();
			} else {
				$result = null;
			}

			$totalFiltered = $this->db->query('select tests.* from tests
 			' . $whr)->num_rows();
		}

		$data = array();

		if (!empty($result)) {

			foreach ($result as $row) {

				$btn = 'btn btn-out btn-sm waves-effect waves-light btn-info';
				$txt = "Pending";

				if ($row->testStatus == 'Active') {

					$btn = 'btn btn-out btn-sm waves-effect waves-light btn-success';
					$txt = "Active";
				} else if ($row->testStatus == 'Block') {
					$txt = "Block";
					$btn = 'btn btn-out btn-sm waves-effect waves-light btn-danger';
				}

				$nestedData['id'] = $row->testId;
				$nestedData['name'] = $row->testName;
				$nestedData['price'] = '<i class="icofont icofont-cur-pound"></i> ' . $row->originalPrice;

				if ($row->discountPercentage == 'Yes') {
					$nestedData['discount'] = $row->discountPrice . ' %';
				} else {
					$nestedData['discount'] = '<i class="icofont icofont-cur-pound"></i> ' . $row->discountPrice;
				}

				$nestedData['status'] = '<a id="status_' . $row->testId . '" href="javascript:status(' . $row->testId . ');"><button class="' . $btn . '">' . $txt . '</button></a>';

				$nestedData['action'] = ' 
										<a href="' . $this->config->item('admin_url') . '/mealprep/faqs/' . $row->testId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-support-faq"></i>FAQs</a>
										<a href="' . $this->config->item('admin_url') . '/mealprep/edit/' . $row->testId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
										<a href="' . $this->config->item('admin_url') . '/mealprep/view/' . $row->testId . '" class="btn waves-effect waves-light btn-inverse btn-sm"><i class="icofont icofont-eye-alt"></i></a> ';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}



	public  function  delete_img()
	{

		$this->check_ajax_login();
		$id = $this->input->post('id');

		if ($id > 0) {

			$test_images = $this->db->query("SELECT * FROM test_images WHERE imageId='" . $id . "'")->row();

			if ($test_images) {
				unlink('./uploads/tests/products/' . $test_images->imageName);
				$this->db->delete('test_images', array('imageId' => $id));
				$response = array();
				$response['code'] = 1;
				$response['message'] = 'Deleted';
				echo json_encode($response);
				exit();
			} else {
				$response = array();
				$response['code'] = 0;
				$response['message'] = 'image not found';
				echo json_encode($response);
				exit();
			}
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'image not found';
			echo json_encode($response);
			exit();
		}
	}



	public function change_status()
	{

		$this->check_ajax_login();
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$tests = $this->db->query("SELECT * FROM tests WHERE testId='" . $id . "'")->row();

		if ($tests) {

			$btn = '<button class="btn btn-out btn-sm waves-effect waves-light btn-success">Active</button>';

			if ($type != 'Active') {

				$type = 'Block';
				$btn = '<button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Block</button>';
			}

			$this->db->set('testStatus ', $type);
			$this->db->where('testId', $id);
			$this->db->update('tests');

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Status updated successfully';
			$response['status_code'] = $btn;
			echo json_encode($response);
			exit();
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Meal prep not found';
			echo json_encode($response);
			exit();
		}
	}



	public function faqs($id = 0)
	{

		$this->check_login();
		$test = $this->db->query("SELECT * FROM tests WHERE testId='" . $id . "' and isDeleted='No' and productType='MealPrep'")->row();

		if ($test) {

			$this->data['page_title'] = 'Faqs';
			$this->data['row'] = $test;
			$this->load->view('admin/mealprep_faqs', $this->data);
		} else {

			redirect('admin/mealprep');
		}
	}



	public  function list_faqs_data($testId = 0)
	{

		$this->check_ajax_datatable();

		$columns = array(
			0 => 'faqTitle',
			1 => 'faqId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr = ' where 1=1 ';

		if ($testId > 0) {
			$whr = ' where faq_relations.testId=' . $testId . ' ';
		}
		$whr .= ' and faq_relations.relationTestType="MealPrep" ';

		$totalData = $this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId' .
			$whr)->num_rows();
		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {

			$sq = $this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId' .
				$whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);

			if ($sq->num_rows() > 0) {
				$result = $sq->result();
			} else {
				$result = null;
			}
		} else {

			$search = $this->input->post('search')['value'];
			$whr .= ' and (faq_relations.faqId like "%' . $search . '%" or  faqTitle like "%' . $search . '%" )';

			$sq = $this->db->query('select * from faq_relations
								LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId' .
				$whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);
			if ($sq->num_rows() > 0) {
				$result = $sq->result();
			} else {
				$result = null;
			}

			$totalFiltered = $this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId'
				. $whr)->num_rows();
		}

		$data = array();

		if (!empty($result)) {

			foreach ($result as $row) {

				$nestedData['id'] = $row->relationId;
				$nestedData['faq'] = $row->faqTitle;

				$nestedData['action'] = ' <a target="_blank" href="' . $this->config->item('admin_url') . '/faqs/edit/' . $row->faqId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
										<a href="javascript:;" onclick="del(this,' . $row->relationId . ')" class="btn waves-effect waves-light btn-danger btn-sm"><i class="icofont icofont-trash"></i></a> ';
				$data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw"            => intval($this->input->post('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}



	public function rel_faq_code()
	{

		$this->check_ajax_login();
		$testId = $this->input->post('testId');

		if (isset($_POST['rfaqId']) && $testId > 0) {
			$faqId = $this->input->post('rfaqId');

			foreach ($faqId as $faq) {
				$ins = array();
				$ins['faqId'] = $faq;
				$ins['testId'] = $testId;
				$ins['relationTestType'] = 'MealPrep';
				$this->db->insert('faq_relations', $ins);
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Faq added successfully';
			echo json_encode($response);
			exit();
		} else {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please select faq';
			echo json_encode($response);
			exit();
		}
	}



	public function edit_faq_code()
	{

		$this->check_ajax_login();
		$this->form_validation->set_rules('faqTitle', 'Title', 'required');
		$this->form_validation->set_rules('faqDescription', 'Detail', 'required');
		$this->form_validation->set_rules('testId', 'Test', 'required');

		if ($this->form_validation->run() == FALSE) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = validation_errors();
			echo json_encode($response);
			exit();
		} else {

			$faqTitle = $this->input->post('faqTitle');
			$faqDescription = $this->input->post('faqDescription');
			$testId = $this->input->post('testId');

			// check slug //
			$slug = slug($faqTitle);
			$slug_chk = $this->general_model->role_exists('faqSlug', $slug, 'faqs');

			if ($slug_chk == false) {
				$response = array();
				$response['code'] = 0;
				$response['message'] = 'Faq with same title already exist';
				echo json_encode($response);
				exit();
			}

			$ins = array();
			$ins['faqTitle'] = $faqTitle;
			$ins['faqDescription'] = $faqDescription;
			$ins['faqSlug'] = $slug;
			$ins['faqType'] = 'MealPrep';
			$ins['createdAt'] = current_datetime();
			$ins['updatedAt'] = current_datetime();
			$this->db->insert('faqs', $ins);
			$faqId = $this->db->insert_id();

			$ins = array();
			$ins['faqId'] = $faqId;
			$ins['testId'] = $testId;
			$ins['relationTestType'] = 'MealPrep';
			$this->db->insert('faq_relations', $ins);

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Faq added successfully';
			echo json_encode($response);
			exit();
		}
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



	public function check_ajax_datatable()
	{

		if (!isset($this->session_data->adminID)) {
			$json_data = array(
				"draw"            => intval($this->input->post('draw')),
				"recordsTotal"    => intval(0),
				"recordsFiltered" => intval(0),
				"data"            => array()
			);

			echo json_encode($json_data);
			exit();
		}
	}
}
