<?php



class Questionaire extends CI_Controller {
	


	public function __construct() {
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}


	public function index() {
		$this->session->set_userdata('current_url', base_url().'questionaire');
		$this->check_login();
		$this->response['page_title']="Questionaire";
		$this->response['row']=$this->db->query('select * from user_details WHERE userId='.$this->session_data->userId)->row();
		$this->response['user']=$this->db->query('select * from users WHERE userId='.$this->session_data->userId)->row();
		
		$this->load->view('questionaire',$this->response);
	}


	public function process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('f_name', 'First Name', 'required');
		$this->form_validation->set_rules('l_name', 'Last Name', 'required');
		//$this->form_validation->set_rules('gender', 'Gender', 'required');
		//$this->form_validation->set_rules('dob', 'Date of birth', 'required');
		//$this->form_validation->set_rules('userAddress', 'Address', 'required');
		//echo 'dddd'; exit;
		
		if ($this->form_validation->run() == FALSE) {
			
			$error=validation_errors();
			$response=array();
			$response['code']=0;
			$response['message']=$error;
			echo json_encode($response);
			exit();
		}
		else {
			
			$upd=array();
			$upd['f_name']=$this->input->post('f_name');
			$upd['l_name']=$this->input->post('l_name');
			//$upd['gender']=$this->input->post('gender');
			$upd['dob']=$this->input->post('dob');
			$upd['userAddress']=$this->input->post('userAddress');
			$upd['profession']=$this->input->post('profession');
			$upd['height']=$this->input->post('height');
			$upd['weight']=$this->input->post('weight');
			$upd['cholesterol']=$this->input->post('cholesterol');
			$upd['cholesterolLastCheck']=$this->input->post('cholesterolLastCheck');
			$upd['activelyTrack']=$this->input->post('trackCholesterol');
			$upd['activelyDetail']=$this->input->post('trackCholesterolDetail');
			$upd['sleepPerNight']=$this->input->post('sleepPerNight');
			$upd['sleepTrack']=$this->input->post('sleepTrack');
			$upd['sleepDetails']=$this->input->post('sleepDetails');

			$upd['excericseAvgWeek']=$this->input->post('excericseAvgWeek');
			$upd['stepAvgDay']=$this->input->post('stepAvgDay');
			$upd['stepTrack']=$this->input->post('stepTrack');
			$upd['stepDetails']=$this->input->post('stepDetails');
			//$upd['waterAvgDay']=$this->input->post('waterAvgDay');
			$upd['ethnicity']=$this->input->post('ethnicity');
			$upd['medication']=$this->input->post('medication');
			$upd['medicationDetails']=$this->input->post('medicationDetails');
			$upd['intolerances']=$this->input->post('intolerances');
			$upd['intolerancesDetails']=$this->input->post('intolerancesDetails');
			$upd['intolerances_other_detail']=$this->input->post('intolerances_other_detail');

			$upd['alergies']=$this->input->post('alergies');

			$alergies_items = $this->input->post('alerg');

			if($alergies_items != '') {

				$upd['alergiesDetails']= implode(',', $alergies_items);
			}
			
			$upd['trackMedical']=$this->input->post('medical');

			// if(isset($this->input->post('medical_conditions'))){
			// 	echo 'yes';
			// }else{
			// 	echo 'no';
			// }

			$medical_conditions = $this->input->post('medical_conditions');

			$str="";
			if(NULL != $medical_conditions ) {

				$str= implode(',', $medical_conditions);
				$upd['medical_conditions'] = $str;
			}else{
				$upd['medical_conditions'] = $str;
			}

			// Added 12 June for Qrisk // new field medical_conditions_json

				$medi_cond['diabetes type 1'] = 0;
				$medi_cond['diabetes type 2'] = 0;
				$medi_cond['overactive thyroid'] = 0;
				$medi_cond['high blood pressure'] = 0;
				$medi_cond['heart disease'] = 0;
				$medi_cond['Atrial fibrillation'] = 0;
				$medi_cond['Rheumatoid arthritis'] = 0;
				$medi_cond['Severe mental illness'] = 0;
				$medi_cond['On blood pressure treatment'] = 0;
				$medi_cond['On atypical antipsychotic medication'] = 0;
				$medi_cond['A diagnosis of or treatment for erectile disfunction'] = 0;
				$medi_cond['Are you on regular steroid tablets?'] = 0;
				$medi_cond['Do you have migraines'] = 0;

				foreach($medi_cond as $key=>$val){

					if(strpos($str, $key) !== false) {   // this option is yes
						$medi_cond[$key] = 1;
					}
				}

				$upd['medical_conditions_json'] = json_encode($medi_cond);

			// End Added 12 June for Qrisk // new field medical_conditions_json

			$upd['track_family_med']=$this->input->post('track_family_med');

			$family_medical = $this->input->post('family_medical');

			if($family_medical != '') {

				$upd['family_medical']= implode(',', $family_medical);
			}

			$upd['restHeartRate']=$this->input->post('restHeartRate');
			$upd['heartLastCheck']=$this->input->post('heartLastCheck');
			$upd['trackHeart']=$this->input->post('trackHeart');
			$upd['trackHeartDetail']=$this->input->post('trackHeartDetail');
			$upd['bloodPressure']=$this->input->post('bloodPressure');
			$upd['bloodPressureLastCheck']=$this->input->post('bloodPressureLastCheck');
			$upd['trackBlookPressure']=$this->input->post('trackBlookPressure');
			$upd['trackBlookPressureDetails']=$this->input->post('trackBlookPressureDetails');
			$upd['hipMeasurment']=$this->input->post('hipMeasurment');
			$upd['waistMeasurment']=$this->input->post('waistMeasurment');
			$upd['bodyType']=$this->input->post('bodyType');
			$upd['smoker']=$this->input->post('smoker');
			$upd['diabetesStatus']=$this->input->post('diabetesStatus');
			$upd['heartAttactdegreeRelativelessSixty']=$this->input->post('heartAttactdegreeRelativelessSixty');
			$upd['chronicKidneyDisease']=$this->input->post('chronicKidneyDisease');
			$upd['atrialFibrillation']=$this->input->post('atrialFibrillation');
			$upd['bloodPressureTreatment']=$this->input->post('bloodPressureTreatment');
			$upd['rheumatoidArthritis']=$this->input->post('rheumatoidArthritis');
			$upd['prostateCancer']=$this->input->post('prostateCancer');
			$upd['prostateCancerLastCheck']=$this->input->post('prostateCancerLastCheck');			

			$upd['waterAvgDay']=$this->input->post('avg_water');
			$upd['trackWater']=$this->input->post('waterTrack');
			$upd['waterDetails']=$this->input->post('waterDetails');

			$upd['alcoholUnits']=$this->input->post('avg_alcohol');
			$upd['trackAlcohol']=$this->input->post('alcoholTrack');
			$upd['alcoholDetails']=$this->input->post('alcoholDetails');

			$upd['smoker']=$this->input->post('per_day_smoking');
			$upd['trackSmoking']=$this->input->post('smokeTrack');
			$upd['smookingDetails']=$this->input->post('smokeDetail');
			
			$upd['nutritional_goals']=$this->input->post('nutritional_goals');
			
			$upd['trackDiet']=$this->input->post('diet');
			$upd['dietDetails']=$this->input->post('dietDetails');

			$upd['systolic_bp']=$this->input->post('systolic_bp');

			$upd['testicular_cancer']=$this->input->post('testicular_cancer');
			$upd['testicular_lastcheck']=$this->input->post('testicular_lastcheck');
			$upd['ovarian_cancer']=$this->input->post('ovarian_cancer');
			$upd['ovarian_lastcheck']=$this->input->post('ovarian_lastcheck');	

			if($this->input->post('dietDetails') == 'other'){

				$upd['diet_other_details']=$this->input->post('diet_other_details');
			}

			$upd['updatedAt']=current_datetime();

			//echo '<pre>'; print_r($upd); exit;

			$this->db->update('user_details',$upd,array('userId'=>$this->session_data->userId));            
			
			//commented by david
            // $upd=array();
           	// $upd['userGender']=$this->input->post('gender');
			// $upd['userDob']=$this->input->post('dob');
			// $this->db->update('users',$upd,array('userId'=>$this->session_data->userId));
			

			if($this->input->post('weight')>0 && $this->input->post('height')>0) {

				
				$weight = $this->input->post('weight');
				$height = $this->input->post('height');
				$height_in_m = $height/100;
				$bmi=$weight/($height_in_m*$height_in_m);
				
				$track['userId'] = $this->session_data->userId;
				$track['bmi'] = $bmi;
				$track['date'] = date('Y-m-d');
				$track['hip'] = $this->input->post('hipMeasurment');
				$track['waist'] = $this->input->post('waistMeasurment');

				$this_month = $this->db->query("SELECT count(*) as cnt, trackId FROM `user_track_graph` WHERE MONTH(date) = MONTH(CURRENT_DATE())
				AND YEAR(date) = YEAR(CURRENT_DATE()) and userId=".$this->session_data->userId)->row();
				//echo $this->db->last_query();
				if($this_month->cnt > 0){
					$this->db->where('trackId', $this_month->trackId)->update("user_track_graph", $track);
				}else{
					$this->db->insert("user_track_graph", $track);
				}
				

			}

            
			$response=array();
			$response['code']=1;
			$response['message']='Questionaire updated successfully';
			echo json_encode($response);
			exit();
		}
	}


	public function check_login() {
		if (!isset($this->session_data->userId)) {
			redirect('home');
		}
	}


	public function check_ajax_login() {
		
		if (!isset($this->session_data->userId)) {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
	}
}
