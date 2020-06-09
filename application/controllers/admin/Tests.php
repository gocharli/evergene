<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Tests extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}
	


	public function index($categoryId=0) {
		
		$this->check_login();
		$categoryName='All Test';
		
		if($categoryId>0) {
			
			$category=$this->db->query('select * from categories WHERE categoryId='.$categoryId)->row();
			$categoryName=$category->categoryName;
		}

		$this->data['page_title']=$categoryName.' Tests';
		$this->data['categoryId']=$categoryId;
		$this->data['categoryName']=$categoryName;
		$this->load->view('admin/list_tests', $this->data);
	}

	public function sort() {
		
		$this->check_login();
		$this->data['page_title']='Sort Tests';
		$this->data['tests']=$this->db->query('select tests.*,categories.categoryName from tests
 			LEFT JOIN categories ON tests.categoryId=categories.categoryId where tests.testStatus = "Active" and (tests.coming_soon = 0 or tests.coming_soon_date <= CURDATE() ) order by sort desc')->result();
		//echo '<pre>'; print_r($this->data['tests']); exit;
		$this->load->view('admin/list_tests_sort', $this->data);
	}

	public function update_order(){
		$first_id=$this->input->post("first_id");
		$second_id=$this->input->post("second_id");
		
		$fsid=$this->input->post("fsid");
		$ssid=$this->input->post("ssid");
		
		//echo 'first id = '.$first_id.' first sorting id = '.$fsid.'</br>';
		//echo 'second id = '.$second_id.' second sorting id = '.$ssid;
		//exit;
		
		//$list_id = $this->db->query("select list_id from list where id = ".$first_id)->row()->list_id;
		//$deal_stage = $this->db->query("select testId from tests where testId = ".$first_id)->row()->DealStage;
		
		//echo $deal_stage; exit;
		
		$dec_id = array();
		if($fsid < $ssid){
			//echo "up"; exit;
			for($i=$ssid; $i > $fsid; $i--){
				$sid = $i-1;
				//echo "sid = ".$sid; //4,3,2
				$id = $this->db->query("select testId from tests where sort = '$i' ")->row()->testId;
				if($id > 0){
					
					$this->db->query("update tests set sort = '$sid' where testId = '$id'");
					$dec_id[$id] = $sid;
					
				}
				
				$this->db->query("update tests set sort = ".$ssid." where testId = ".$first_id);
			}
		}else{
			//echo "down"; exit;
			for($i=$ssid; $i < $fsid; $i++){
				$sid = $i+1;
				$id = $this->db->query("select testId from tests where sort = '$i' ")->row()->testId;
				if($id > 0){
					$dec_id[$id]=$sid;
				}
			}
			
			foreach($dec_id as $key => $value) {
				//echo 'id = '. $key . ' sid = ' . $value . '</a>';
				$this->db->query("update tests set testId = '$value' where testId = '$key'");
			}
			
			$this->db->query("update tests set sort = ".$ssid." where testId = ".$first_id);
		}
		
		echo json_encode($dec_id);
		
	}



	public function add() {
		
		$this->check_login();
		$this->data['page_title']='Add Test - Admin';
		$this->data['labs'] = $this->db->query("SELECT * FROM labs")->result();
		$this->load->view('admin/add_test', $this->data);
	}



	public function faqs($id=0) {
		
		$this->check_login();
		$test = $this->db->query("SELECT * FROM tests WHERE testId='".$id."' and isDeleted='No' and productType='Test'")->row();
		
		if($test) {
			$this->data['page_title']='Faqs';
			$this->data['row']=$test;
			$this->load->view('admin/test_faqs', $this->data);
		}
		else {
			redirect('admin/tests');
		}
	}



	public function edit($id=0) {
		
		$this->check_login();
		$test = $this->db->query("SELECT * FROM tests WHERE testId='".$id."' and isDeleted='No' and productType='Test'")->row();
		$test_markers = $this->db->query("SELECT * FROM test_markers_value WHERE tm_test_id='".$id."' ")->result();
		
		if($test) {
			
			$this->data['page_title']='Edit Tests';
			$this->data['row']=$test;
			$this->data['labs'] = $this->db->query("SELECT * FROM labs")->result();
			$this->data['test_markers']=$test_markers;
			$this->load->view('admin/edit_test', $this->data);
		}
		else {
			redirect('admin/tests');
		}
	}



	public function view($id=0) {
		
		$this->check_login();
		$test = $this->db->query("SELECT tests.*,categories.categoryName FROM tests
 		LEFT JOIN categories ON tests.categoryId=categories.categoryId
 		WHERE testId='".$id."' and isDeleted='No' and productType='Test'")->row();
		
		if($test) {
			
			$this->data['page_title']='View Tests';
			$this->data['row']=$test;
			$this->load->view('admin/view_test', $this->data);
		}
		else {
			redirect('admin/tests');
		}
	}



	public function rel_faq_code() {
		
		$this->check_ajax_login();
		$testId=$this->input->post('testId');
		
		if(isset($_POST['rfaqId']) && $testId>0) {
			
			$faqId=$this->input->post('rfaqId');
			
			foreach ($faqId as $faq) {
				
				$ins=array();
				$ins['faqId']=$faq;
				$ins['testId']=$testId;
				$ins['relationTestType']='Test';
				$this->db->insert('faq_relations',$ins);
			}

			$response=array();
			$response['code']=1;
			$response['message']='Faq added successfully';
			echo json_encode($response);
			exit();
		}
		else {
			$response=array();
			$response['code']=0;
			$response['message']='Please select faq';
			echo json_encode($response);
			exit();
		}
	}



	public function edit_faq_code() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('faqTitle', 'Title', 'required');
		$this->form_validation->set_rules('faqDescription', 'Detail', 'required');
		$this->form_validation->set_rules('testId', 'Test', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {
			
			$faqTitle=$this->input->post('faqTitle');
			$faqDescription=$this->input->post('faqDescription');
			$testId=$this->input->post('testId');

			// check slug //
			$slug=slug($faqTitle);
			$slug_chk=$this->general_model->role_exists('faqSlug',$slug,'faqs');
			
			if($slug_chk==false) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Faq with same title already exist';
				echo json_encode($response);
				exit();
			}

			$ins=array();
			$ins['faqTitle']=$faqTitle;
			$ins['faqDescription']=$faqDescription;
			$ins['faqSlug']=$slug;
			$ins['faqType']='Test';
			$ins['createdAt']=current_datetime();
			$ins['updatedAt']=current_datetime();
			$this->db->insert('faqs',$ins);
			$faqId=$this->db->insert_id();

			$ins=array();
			$ins['faqId']=$faqId;
			$ins['testId']=$testId;
			$ins['relationTestType']='Test';
			$this->db->insert('faq_relations',$ins);

			$response=array();
			$response['code']=1;
			$response['message']='Faq added successfully';
			echo json_encode($response);
			exit();
		}
	}



	public  function  add_process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('testName', 'Test Name', 'required');
        $this->form_validation->set_rules('testCode', 'Test Code', 'required');
		$this->form_validation->set_rules('originalPrice', 'Original Price', 'required');
		$this->form_validation->set_rules('categoryId', 'Category', 'required');
		$this->form_validation->set_rules('discountPrice', 'Discount Price', 'required');

		$this->form_validation->set_rules('coming_soon', 'Coming Soon', 'required');
		$this->form_validation->set_rules('testResultType', 'Result Type', 'required');
		$this->form_validation->set_rules('testLab', 'Test Lab', 'required');
		$this->form_validation->set_rules('price_to_supplier', 'Price To Supplier', 'required');

		
		
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {

			$coming_soon = $this->input->post('coming_soon');
			$coming_soon_date = $this->input->post('coming_soon_date');
			if($coming_soon > 0){
				if(empty($coming_soon_date)){
					$response=array();
					$response['code']=0;
					$response['message']="Please enter date field!";
					echo json_encode($response);
					exit();
				}
			}

			$testResultType = $this->input->post("testResultType");
			$testLab = $this->input->post("testLab");
			$price_to_supplier = $this->input->post("price_to_supplier");
			
			$testName=$this->input->post('testName');
            $testCode=$this->input->post('testCode');
			$originalPrice=$this->input->post('originalPrice');
			$categoryId=$this->input->post('categoryId');
			$discountPrice=$this->input->post('discountPrice');
			$discountPercentage=$this->input->post('discountPercentage');
			$resultHistory = 'No';
			if($this->input->post('resultHistory') == 'Yes'){
				$resultHistory=$this->input->post('resultHistory');
			}
            //$resultHistory=$this->input->post('resultHistory');   
			$testDescription=$this->input->post('testDescription');
			$testDetails=$this->input->post('testDetails');
			$testSymtoms=$this->input->post('testSymtoms');
			$testMarkers=$this->input->post('testMarkers');
			$noOfMarkers=$this->input->post('noOfMarkers');
			$markerTitle=$this->input->post('markerTitle');
			$markerUnit=$this->input->post('markerUnit');
			$minValue=$this->input->post('minValue');
			$lowerValue=$this->input->post('lowerValue');
			$upperValue=$this->input->post('upperValue');
			$maxValue=$this->input->post('maxValue');
			$standard=$this->input->post('standard');
			$normal=$this->input->post('normal');
			$abnormal=$this->input->post('abnormal');

			// check slug //
			$slug=slug($testName);
			$slug_chk=$this->general_model->role_exists('slug',$slug,'tests');
			
			if($slug_chk==false) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Test with same name already exist';
				echo json_encode($response);
				exit();
			}
			if($discountPrice<1 || $originalPrice<1) {
				$response=array();
				$response['code']=0;
				$response['message']='Price must me greater than 0';
				echo json_encode($response);
				exit();
			}
			if($testMarkers!='') {
				$testMarkers=implode(',',$testMarkers);
			}
			else{
				$testMarkers='';
			}


			if($discountPercentage=='Yes') {
				
				if($discountPrice>=100) {
					$response=array();
					$response['code']=0;
					$response['message']='Discount must be less than 100%';
					echo json_encode($response);
					exit();
				}

				$discountedPrice=$originalPrice*($discountPrice/100);
			}
			else {
				
				if($discountPrice>=$originalPrice) {
					$response=array();
					$response['code']=0;
					$response['message']='Discount price must be less than Original price';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = ($discountPrice / $originalPrice) * 100;
				$discountPercentage='No';
			}

			$path = './uploads/tests/logo/';
			$this->load->library('upload');
			$this->upload->initialize(array(
				"upload_path"       =>  $path,
				"allowed_types"     =>  '*',
				"encrypt_name"      =>  true
			));

			if($this->upload->do_upload("testLogo")) {


				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData['file_name'];
				//Resize after upload start
				$config['image_library'] = 'gd2'; 
				$config['source_image'] = $path.$uploadData["file_name"]; 
				$config['create_thumb'] = FALSE; 
				$config['maintain_ratio'] = TRUE; 
				$config['quality'] = '60%'; 
				$config['width'] = 300; 
				$config['height'] = 300; 
				$config['new_image'] = $path.$uploadData["file_name"]; 
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				//Resize after upload end
				//$this->model_name->save_function($uploadedFile);
				$testLogo = $uploadedFile;
				//echo $testLogo; exit;

				//$upload_data = $this->upload->data();
				//$testLogo=$upload_data['file_name'];
			}
			else {
				$response=array();
				$response['code']=0;
				$response['message']=$this->upload->error_msg[0];
				echo json_encode($response);
				exit();
			}

			$ins=array();
			$ins['testName']=$testName;
            $ins['testCode']=$testCode;
			$ins['slug']=$slug;
			$ins['categoryId']=$categoryId;
			$ins['originalPrice']=$originalPrice;
			$ins['discountPercentage']=$discountPercentage;
			$ins['discountPrice']=$discountPrice;
			$ins['discountedPrice']=$discountedPrice;
			$ins['testDescription']=$testDescription;
			$ins['testDetails']=$testDetails;
			$ins['testMarkers']=$testMarkers;
			$ins['testSymtoms']=$testSymtoms;
            $ins['resultHistory']=$resultHistory;            
			$ins['testLogo']=$testLogo;
			$ins['productType']='Test';
			$ins['testStatus']='Active';
			$ins['isDeleted']='No';
			
			$ins['coming_soon'] = $coming_soon;
			$ins['coming_soon_date'] = $coming_soon_date;
			$ins['testResultType'] = $testResultType;
			$ins['testLab'] = $testLab;
			$ins['price_to_supplier'] = $price_to_supplier;

			$ins['createdAt']=current_datetime();
			$ins['updatedAt']=current_datetime();

			$this->db->insert('tests',$ins);
			$testId=$this->db->insert_id();

			// activity log by david
			$this->db->insert("activity_log", array("description"=>'New test has been added by '.$this->session_data->firstName, "tid"=>$testId, "oid"=>0, "createdAt"=>date('Y-m-d H:i:s')));
			//echo $this->db->last_query(); exit;
			// End
			// more images //
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['moreImages']['name']);
			
			for($i=0; $i<$cpt; $i++) {
				
				$_FILES['image']['name']= $files['moreImages']['name'][$i];
				$_FILES['image']['type']= $files['moreImages']['type'][$i];
				$_FILES['image']['tmp_name']= $files['moreImages']['tmp_name'][$i];
				$_FILES['image']['error']= $files['moreImages']['error'][$i];
				$_FILES['image']['size']= $files['moreImages']['size'][$i];

				$path = './uploads/tests/products/';
				$this->upload->initialize(array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*',
					"encrypt_name"      =>  true
				));
				
				if($this->upload->do_upload('image')) {
					$upload_data = $this->upload->data();
					$dataInfo[] =$upload_data['file_name'];
				}
			}

			foreach ($dataInfo as $img) {
				$ins=array();
				$ins['testId']=$testId;
				$ins['imageName']=$img;
				$this->db->insert('test_images',$ins);
			}

			for ($i=0; $i < $noOfMarkers ; $i++) { 
				
				$markers_data=array(
					'tm_test_id' => $testId,
					'tm_title' => $markerTitle[$i],
					'tm_unit' => $markerUnit[$i],
					'tm_range' => $minValue[$i].' - '.$maxValue[$i],
					'tm_min_value' => $minValue[$i],
					'tm_max_vaue' => $maxValue[$i],
					'tm_lower_value' => $lowerValue[$i],
					'tm_upper_value' => $upperValue[$i],
					'tm_standard_description' => $standard[$i],
					'tm_normal_description' => $normal[$i],
					'tm_abnormal_description' => $abnormal[$i]
				);

				$this->db->insert('test_markers_value',$markers_data);

				$upd=array();
				$upd['no_of_markers']=$noOfMarkers;

				$this->db->update('tests',$upd,array('testId'=>$testId));
			}

			$response=array();
			$response['code']=1;
			$response['message']='Test added successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function edit_process($id=0) {
		
		$this->check_ajax_login();
		$test= $this->db->query("SELECT * FROM tests WHERE testId='".$id."' and isDeleted='No' and productType='Test'")->row();
		
		if(!$test) {
			
			$response=array();
			$response['code']=0;
			$response['message']="Test Not found";
			echo json_encode($response);
			exit();
		}
		
		$this->form_validation->set_rules('testName', 'Test Name', 'required');
        $this->form_validation->set_rules('testCode', 'Test Code', 'required');
		$this->form_validation->set_rules('originalPrice', 'Original Price', 'required');
		$this->form_validation->set_rules('categoryId', 'Category', 'required');
		$this->form_validation->set_rules('discountPrice', 'Discount Price', 'required');
		$this->form_validation->set_rules('testDescription', 'Test Description', 'required');
		$this->form_validation->set_rules('price_to_supplier', 'Price to Supplier', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {

			// Added by david
			$coming_soon = $this->input->post('coming_soon');
			$coming_soon_date = $this->input->post('coming_soon_date');
			if($coming_soon > 0){
				if(empty($coming_soon_date)){
					$response=array();
					$response['code']=0;
					$response['message']="Please enter date field!";
					echo json_encode($response);
					exit();
				}
			}

			$testResultType = $this->input->post("testResultType");
			$testLab = $this->input->post("testLab");
			$price_to_supplier = $this->input->post("price_to_supplier");

			// End

			
			$testName=$this->input->post('testName');
            $testCode=$this->input->post('testCode');
			$originalPrice=$this->input->post('originalPrice');
			$categoryId=$this->input->post('categoryId');
			$discountPrice=$this->input->post('discountPrice');
			$discountPercentage=$this->input->post('discountPercentage');
			$testDescription=$this->input->post('testDescription');
			$testDetails=$this->input->post('testDetails');
			$testSymtoms=$this->input->post('testSymtoms');
            $resultHistory=$this->input->post('resultHistory');
            $testMarkers=$this->input->post('testMarkers');
			// $noOfMarkers=$this->input->post('noOfMarkers');
			$markerTitle=$this->input->post('markerTitle');
			$markerUnit=$this->input->post('markerUnit');
			$minValue=$this->input->post('minValue');
			$lowerValue=$this->input->post('lowerValue');
			$upperValue=$this->input->post('upperValue');
			$maxValue=$this->input->post('maxValue');
			$standard=$this->input->post('standard');
			$normal=$this->input->post('normal');
			$abnormal=$this->input->post('abnormal');

			$slug=slug($testName);
			if($test->slug!=$slug) {

				$slug_chk=$this->general_model->role_exists('slug',$slug,'tests');
				
				if($slug_chk==false) {
					
					$response=array();
					$response['code']=0;
					$response['message']='Test with same name already exist';
					echo json_encode($response);
					exit();
				}
			}

			if($discountPrice<1 || $originalPrice<1) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Price must me greater than 0';
				echo json_encode($response);
				exit();
			}
			if($testMarkers!='') {
				
				$testMarkers=implode(',',$testMarkers);
			}
			else{
				
				$testMarkers='';
			}


			if($discountPercentage=='Yes') {
				
				if($discountPrice>=100) {
					
					$response=array();
					$response['code']=0;
					$response['message']='Discount must be less than 100%';
					echo json_encode($response);
					exit();
				}

				$discountedPrice=$originalPrice*($discountPrice/100);
			}
			else {
				
				if($discountPrice>=$originalPrice) {
					
					$response=array();
					$response['code']=0;
					$response['message']='Discount price must be less than Original price';
					echo json_encode($response);
					exit();
				}

				$discountedPrice = ($discountPrice / $originalPrice) * 100;
				$discountPercentage='No';
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

			$upd=array();
			$upd['testName']=$testName;
            $upd['testCode']=$testCode;
			$upd['slug']=$slug;
			$upd['categoryId']=$categoryId;
			$upd['originalPrice']=$originalPrice;
			$upd['discountPercentage']=$discountPercentage;
			$upd['discountPrice']=$discountPrice;
			$upd['discountedPrice']=$discountedPrice;
			$upd['testDescription']=$testDescription;
			$upd['testDetails']=$testDetails;
			$upd['testMarkers']=$testMarkers;
			$upd['testSymtoms']=$testSymtoms;
            $upd['resultHistory']=$resultHistory;
            
			if($this->upload->do_upload("testLogo")) {

				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData['file_name'];
				//Resize after upload start
				$config['image_library'] = 'gd2'; 
				$config['source_image'] = $path.$uploadData["file_name"]; 
				$config['create_thumb'] = FALSE; 
				$config['maintain_ratio'] = TRUE; 
				$config['quality'] = '60%'; 
				$config['width'] = 300; 
				$config['height'] = 300; 
				$config['new_image'] = $path.$uploadData["file_name"]; 
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$this->image_lib->clear();
				//Resize after upload end
				//$this->model_name->save_function($uploadedFile);
				$testLogo = $uploadedFile;
				$upd['testLogo']=$uploadedFile;
				//echo $testLogo; exit;
				
				//$upload_data = $this->upload->data();
				//$upd['testLogo']=$upload_data['file_name'];
			}

			$upd['coming_soon'] = $coming_soon;
			$upd['coming_soon_date'] = $coming_soon_date;
			$upd['testResultType'] = $testResultType;
			$upd['testLab'] = $testLab;
			$upd['price_to_supplier'] = $price_to_supplier;

			$upd['updatedAt']=current_datetime();
			$this->db->update('tests',$upd,array('testId'=>$id));


			// activity log by david
			$this->db->insert("activity_log", array("description"=>'Test '.$testName.' has been updated by '.$this->session_data->firstName, "tid"=>$id, "oid"=>0, "createdAt"=>date('Y-m-d H:i:s')));
			//echo $this->db->last_query(); exit;
			// End

			$testId=$id;
			// more images //
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['moreImages']['name']);
			
			for($i=0; $i<$cpt; $i++) {
				
				$_FILES['image']['name']= $files['moreImages']['name'][$i];
				$_FILES['image']['type']= $files['moreImages']['type'][$i];
				$_FILES['image']['tmp_name']= $files['moreImages']['tmp_name'][$i];
				$_FILES['image']['error']= $files['moreImages']['error'][$i];
				$_FILES['image']['size']= $files['moreImages']['size'][$i];

				$path = './uploads/tests/products/';
				$this->upload->initialize(
					array(
						"upload_path"       =>  $path,
						"allowed_types"     =>  '*',
						"encrypt_name"      =>  true
					)
				);

				if($this->upload->do_upload('image')) {
					
					$upload_data = $this->upload->data();
					$dataInfo[] =$upload_data['file_name'];
				}
			}

			foreach ($dataInfo as $img) {
				
				$ins=array();
				$ins['testId']=$testId;
				$ins['imageName']=$img;
				$this->db->insert('test_images',$ins);
			}


			$this->db->where('tm_test_id', $testId);
			$this->db->delete('test_markers_value');


			if($testResultType != 'Result 4'){   // if is added by david there is no markers for type 4

				$noOfMarkers=sizeof($markerTitle);

				for ($i=0; $i < $noOfMarkers ; $i++) { 
					
					$markers_data=array(
						'tm_test_id' => $testId,
						'tm_title' => $markerTitle[$i],
						'tm_unit' => $markerUnit[$i],
						'tm_range' => $minValue[$i].' - '.$maxValue[$i],
						'tm_min_value' => $minValue[$i],
						'tm_max_vaue' => $maxValue[$i],
						'tm_lower_value' => $lowerValue[$i],
						'tm_upper_value' => $upperValue[$i],
						'tm_standard_description' => $standard[$i],
						'tm_normal_description' => $normal[$i],
						'tm_abnormal_description' => $abnormal[$i]
					);

					//echo '<pre>'; print_r($markers_data); exit;
					$this->db->insert('test_markers_value',$markers_data);

					$upd=array();
					$upd['no_of_markers']=$noOfMarkers;

					$this->db->update('tests',$upd,array('testId'=>$testId));
				}

			}
			

			$response=array();
			$response['code']=1;
			$response['message']='Test Updated successfully';
			echo json_encode($response);
			exit();
		}
	}


	public  function  delete_marker() {
		
		$this->check_ajax_login();
		$id=$this->input->post('id');

		$value=$this->db->delete('test_markers_value',array('tm_id'=>$id));

		if($value==true){

			$response=array();
			$response['code']=1;
			$response['message']='Deleted';
			echo json_encode($response);
			exit();
		}
		else{

			$response=array();
			$response['code']=0;
			$response['message']='image not found';
			echo json_encode($response);
			exit();
		}
	}



	public  function list_faqs_data($testId=0) {
		
		$this->check_ajax_datatable();
		
		$columns = array(
			0 =>'faqTitle',
			1=> 'faqId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr=' where 1=1 ';

		if($testId>0) {
			$whr=' where faq_relations.testId='.$testId.' ';
		}
		
		$whr.=' and faq_relations.relationTestType="Test" ';

		$totalData = $this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId'.
									$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {
			
			$sq=$this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId'.
 									$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {

				$result=null;
			}
		}
		else {
			
			$search = $this->input->post('search')['value'];
			$whr.=' and (faq_relations.faqId like "%'.$search.'%" or  faqTitle like "%'.$search.'%" )';

			$sq=$this->db->query('select * from faq_relations
								LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId'.
								$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				$result=$sq->result();
			}
			else {
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select * from faq_relations
									LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId'
									.$whr)->num_rows();
		}

		$data = array();
		
		if(!empty($result)) {
			
			foreach ($result as $row) {

				$nestedData['id'] = $row->relationId;
				$nestedData['faq'] = $row->faqTitle;

				$nestedData['action']=' <a target="_blank" href="'.$this->config->item('admin_url').'/faqs/edit/'.$row->faqId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
										<a href="javascript:;" onclick="del(this,'.$row->relationId.')" class="btn waves-effect waves-light btn-danger btn-sm"><i class="icofont icofont-trash"></i></a> ';
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



	public function list_data($categoryId=0) {
		
		$this->check_ajax_datatable();
		$columns = array(
			0 =>'testId',
			1 =>'testName',
            2=> 'testCode',
			3 =>'categoryName',
			4 =>'originalPrice',			
			5=> 'testStatus',
			6=> 'testId'
		);
		
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr='where 1=1 ';

		if($categoryId>0) {
			
			$whr='where tests.categoryId='.$categoryId.' ';
		}

		$whr.=' and isDeleted="No" and productType="Test" ';

		$totalData = $this->db->query('select * from tests '.$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {

			$sq=$this->db->query('select tests.*,categories.categoryName from tests
 			LEFT JOIN categories ON tests.categoryId=categories.categoryId
 			'.$whr.' order by testStatus, '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				$result=$sq->result();
			}
			else {
				$result=null;
			}
		}
		else {
			
			$search = $this->input->post('search')['value'];
			$whr.=' and (testId like "%'.$search.'%" or  testName like "%'.$search.'%" or testCode like "%'.$search.'%"  or categoryName like "%'.$search.'%")';

			$sq=$this->db->query('select tests.*,categories.categoryName from tests
 			LEFT JOIN categories ON tests.categoryId=categories.categoryId
 			'.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				$result=$sq->result();
			}
			else {
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select tests.*,categories.categoryName from tests
 			LEFT JOIN categories ON tests.categoryId=categories.categoryId
 			'.$whr)->num_rows();
		}

		$data = array();
		
		if(!empty($result)) {
			foreach ($result as $row) {

				// Added by david
				$coming_soon = '';
				if($row->coming_soon > 0){
					if($row->coming_soon_date > date('Y-m-d')){
						$coming_soon = '<span style="margin-left: 10px; cursor: auto;" class="btn waves-effect waves-light btn-info btn-sm">Coming Soon</span>';
					}
				}
				// End

				$pop_class="btn-inverse";
				if($row->isPopular == 1){
					$pop_class="btn-success";
				}

				$btn='btn btn-out btn-sm waves-effect waves-light btn-info';
				$txt="Pending";
				
				if($row->testStatus=='Active') {
					
					$btn='btn btn-out btn-sm waves-effect waves-light btn-success';
					$txt="Active";
				}
				else if($row->testStatus=='Block') {
					
					$txt="Block";
					$btn='btn btn-out btn-sm waves-effect waves-light btn-danger';
				}

				$nestedData['id'] = $row->testId;
				$nestedData['name'] = $row->testName;
                $nestedData['code'] = $row->testCode;
                
				$nestedData['category'] = $row->categoryName;
				$nestedData['price'] = '<i class="icofont icofont-cur-pound"></i> '.$row->originalPrice;
				
				if($row->discountPercentage=='Yes') {
					$nestedData['discount'] =$row->discountPrice.' %';
				}
				else {
					$nestedData['discount'] ='<i class="icofont icofont-cur-pound"></i> '.$row->discountPrice;
				}

				$nestedData['status'] = '<a id="status_'.$row->testId.'" href="javascript:status('.$row->testId.');"><button class="'.$btn.'">'.$txt.'</button></a>'.$coming_soon;

				$nestedData['action']=' 
										<a href="'.$this->config->item('admin_url').'/tests/faqs/'.$row->testId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-support-faq"></i>FAQs</a>
										<a href="'.$this->config->item('admin_url').'/tests/edit/'.$row->testId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
										<a href="'.$this->config->item('admin_url').'/tests/view/'.$row->testId.'" class="btn waves-effect waves-light btn-inverse btn-sm"><i class="icofont icofont-eye-alt"></i></a>
										<a href="javascript:;" id="popular_'.$row->testId.'" onclick="popular('.$row->testId.');" class="btn waves-effect waves-light '.$pop_class.' btn-sm" title="Popluar Test" style="cursor: pointer"><i class="feather icofont icofont-badge"></i></a> <input type="hidden" id="pop_'.$row->testId.'" value="'.$row->isPopular.'" > ';
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



	public  function  delete_img() {
		
		$this->check_ajax_login();
		$id=$this->input->post('id');
		
		if($id>0) {

			$test_images = $this->db->query("SELECT * FROM test_images WHERE imageId='".$id."'")->row();
			
			if($test_images) {

				unlink('./uploads/tests/products/'.$test_images->imageName);
				$this->db->delete('test_images',array('imageId'=>$id));
				$response=array();
				$response['code']=1;
				$response['message']='Deleted';
				echo json_encode($response);
				exit();
			}
			else {
				$response=array();
				$response['code']=0;
				$response['message']='image not found';
				echo json_encode($response);
				exit();
			}
		}
		else {
			
			$response=array();
			$response['code']=0;
			$response['message']='image not found';
			echo json_encode($response);
			exit();
		}
	}



	public function change_status() {
		
		$this->check_ajax_login();

		$id=$this->input->post('id');
		$type=$this->input->post('type');
		$tests = $this->db->query("SELECT * FROM tests WHERE testId='".$id."'")->row();

		if($tests) {
			
			$btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-success">Active</button>';
			
			if($type!='Active') {

				$type='Block';
				$btn='<button class="btn btn-out btn-sm waves-effect waves-light btn-danger">Block</button>';
			}

			$this->db->set('testStatus ', $type);
			$this ->db->where('testId',$id);
			$this->db->update('tests');


			// Add notifcation to admin Added by admin
			$notify['notificationMessage']='Status of the test '.$tests->testName.' has been updated to '.$type;
			$notify['notificationLink']=$id;
			$notify['notificationStatus']=1;
			$notify['notificationTime']=current_datetime();
			$notify['notificationTo']=1;
			$notify['notificationToType']='Admin';
			$notify['notificationFrom']=$this->session_data->adminID;
			$notify['notificationFromType']='Admin';
			$notify['notificationType']='Other';
			$this->db->insert('notifications', $notify);


			$response=array();
			$response['code']=1;
			$response['message']='Status updated successfully';
			$response['status_code']=$btn;
			echo json_encode($response);
			exit();
		}
		else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Test not found';
			echo json_encode($response);
			exit();
		}
	}


	public function change_popular() {
		
		$this->check_ajax_login();

		$id=$this->input->post('id');
		$popular=$this->input->post('popular');
		$tests = $this->db->query("SELECT * FROM tests WHERE testId='".$id."'")->row();

		if($popular == 1){
			$cnt = $this->db->query("select count(*) as cnt from tests where isPopular = 1")->row()->cnt;
			if($cnt >= 6){
				$response['message']="You cannot mark more than 6 tests as popular";
				$response['code']=2;
				echo json_encode($response);
				exit;
			}
		}

		if($tests) {

			$this->db->set('isPopular ', $popular);
			$this ->db->where('testId',$id);
			$this->db->update('tests');

			$response=array();
			$response['code']=1;
			$message = "Test is marked as popular";
			if($popular == 1){
				$message = "Test is marked as popular";
			}else{
				$message = "Test is removed from popular";
			}
			$response['message']=$message;
			$response['status_code']=1;
			echo json_encode($response);
			exit();
		}
		else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Test not found';
			echo json_encode($response);
			exit();
		}
	}



	public function check_login() {
		
		if (!isset($this->session_data->adminID)) {
			redirect('admin/login');
		}
	}



	public function check_ajax_login() {
		
		if (!isset($this->session_data->adminID)) {
			
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Login required!';
			echo json_encode($response);
			exit();
		}
	}


	
	public function check_ajax_datatable() {
		
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

	public function imageResize50X50($imgName){

		$imgName = '00a5e876b0bf03ae4fc8506e9a54b0f4.jpg';
		$img_path =  realpath("uploads")."\\tests\\products\\".$imgName.".jpeg";
		// Configuration
		$config['image_library'] = 'gd2';
		$config['source_image'] = './uploads/tests/products/'.$imgName.".jpeg";
		$config['new_image'] = './uploads/tests/products/'.$imgName."_new.jpeg";
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 200; //$width;
		$config['height'] = 200; //$height;
		// Load the Library
		$this->load->library('image_lib', $config);
		// resize image
		$this->image_lib->resize();
		// handle if there is any problem
		if ( ! $this->image_lib->resize()){ 
		 echo $this->image_lib->display_errors();
		}
	   }
}

