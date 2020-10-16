<?php



class Questionaire extends CI_Controller
{



	public function __construct()
	{
		parent::__construct();
		$session_data = $this->session->userdata('users');
		$this->session_data = $session_data;
		$this->load->model('qrisk_model');
	}


	public function index()
	{
		$this->session->set_userdata('current_url', base_url() . 'questionaire');
		$this->check_login();
		$this->response['page_title'] = "Questionaire";
		$this->response['row'] = $this->db->query('select * from user_details WHERE userId=' . $this->session_data->userId)->row();
		$this->response['user'] = $this->db->query('select * from users WHERE userId=' . $this->session_data->userId)->row();

		$this->load->view('questionaire', $this->response);
	}


	public function process()
	{

		$this->check_ajax_login();
		$this->form_validation->set_rules('f_name', 'First Name', 'required');
		$this->form_validation->set_rules('l_name', 'Last Name', 'required');

		if ($this->form_validation->run() == FALSE) {

			$error = validation_errors();
			$response = array();
			$response['code'] = 0;
			$response['message'] = $error;
			echo json_encode($response);
			exit();
		} else {

			$upd = array();
			$upd['f_name'] = $this->input->post('f_name');
			$upd['l_name'] = $this->input->post('l_name');
			$upd['dob'] = $this->input->post('dob');
			$upd['userAddress'] = $this->input->post('userAddress');
			$upd['profession'] = $this->input->post('profession');
			$upd['height'] = $this->input->post('height');
			$upd['weight'] = $this->input->post('weight');
			$upd['cholesterol'] = $this->input->post('cholesterol');
			$upd['cholesterolLastCheck'] = $this->input->post('cholesterolLastCheck');
			$upd['activelyTrack'] = $this->input->post('trackCholesterol');
			$upd['activelyDetail'] = $this->input->post('trackCholesterolDetail');
			$upd['sleepPerNight'] = $this->input->post('sleepPerNight');
			$upd['sleepTrack'] = $this->input->post('sleepTrack');
			$upd['sleepDetails'] = $this->input->post('sleepDetails');

			$upd['excericseAvgWeek'] = $this->input->post('excericseAvgWeek');
			$upd['stepAvgDay'] = $this->input->post('stepAvgDay');
			$upd['stepTrack'] = $this->input->post('stepTrack');
			$upd['stepDetails'] = $this->input->post('stepDetails');
			$upd['ethnicity'] = $this->input->post('ethnicity');
			$upd['medication'] = $this->input->post('medication');
			$upd['medicationDetails'] = $this->input->post('medicationDetails');
			$upd['intolerances'] = $this->input->post('intolerances');
			$upd['intolerancesDetails'] = $this->input->post('intolerancesDetails');
			$upd['intolerances_other_detail'] = $this->input->post('intolerances_other_detail');

			$upd['alergies'] = $this->input->post('alergies');

			$alergies_items = $this->input->post('alerg');

			if ($alergies_items != '') {

				$upd['alergiesDetails'] = implode(',', $alergies_items);
			}

			$upd['trackMedical'] = $this->input->post('medical');

			$medical_conditions = $this->input->post('medical_conditions');

			$str = "";
			if (NULL != $medical_conditions) {

				$str = implode(',', $medical_conditions);
				$upd['medical_conditions'] = $str;
			} else {
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

			foreach ($medi_cond as $key => $val) {

				if (strpos($str, $key) !== false) {   // this option is yes
					$medi_cond[$key] = 1;
				}
			}

			$upd['medical_conditions_json'] = json_encode($medi_cond);

			// End Added 12 June for Qrisk // new field medical_conditions_json

			$upd['track_family_med'] = $this->input->post('track_family_med');

			$family_medical = $this->input->post('family_medical');

			if ($family_medical != '') {

				$upd['family_medical'] = implode(',', $family_medical);
			}

			$upd['restHeartRate'] = $this->input->post('restHeartRate');
			$upd['heartLastCheck'] = $this->input->post('heartLastCheck');
			$upd['trackHeart'] = $this->input->post('trackHeart');
			$upd['trackHeartDetail'] = $this->input->post('trackHeartDetail');
			$upd['bloodPressure'] = $this->input->post('bloodPressure');
			$upd['bloodPressureLastCheck'] = $this->input->post('bloodPressureLastCheck');
			$upd['trackBlookPressure'] = $this->input->post('trackBlookPressure');
			$upd['trackBlookPressureDetails'] = $this->input->post('trackBlookPressureDetails');
			$upd['hipMeasurment'] = $this->input->post('hipMeasurment');
			$upd['waistMeasurment'] = $this->input->post('waistMeasurment');
			$upd['bodyType'] = $this->input->post('bodyType');
			$upd['smoker'] = $this->input->post('smoker');
			$upd['diabetesStatus'] = $this->input->post('diabetesStatus');
			$upd['heartAttactdegreeRelativelessSixty'] = $this->input->post('heartAttactdegreeRelativelessSixty');
			$upd['chronicKidneyDisease'] = $this->input->post('chronicKidneyDisease');
			$upd['atrialFibrillation'] = $this->input->post('atrialFibrillation');
			$upd['bloodPressureTreatment'] = $this->input->post('bloodPressureTreatment');
			$upd['rheumatoidArthritis'] = $this->input->post('rheumatoidArthritis');
			$upd['prostateCancer'] = $this->input->post('prostateCancer');
			$upd['prostateCancerLastCheck'] = $this->input->post('prostateCancerLastCheck');

			$upd['waterAvgDay'] = $this->input->post('avg_water');
			$upd['trackWater'] = $this->input->post('waterTrack');
			$upd['waterDetails'] = $this->input->post('waterDetails');

			$upd['alcoholUnits'] = $this->input->post('avg_alcohol');
			$upd['trackAlcohol'] = $this->input->post('alcoholTrack');
			$upd['alcoholDetails'] = $this->input->post('alcoholDetails');

			$upd['smoker'] = $this->input->post('per_day_smoking');
			$upd['trackSmoking'] = $this->input->post('smokeTrack');
			$upd['smookingDetails'] = $this->input->post('smokeDetail');

			$upd['nutritional_goals'] = $this->input->post('nutritional_goals');

			$upd['trackDiet'] = $this->input->post('diet');
			$upd['dietDetails'] = $this->input->post('dietDetails');

			$upd['systolic_bp'] = $this->input->post('systolic_bp');
			$upd['deviation_systolic_bp'] = $this->input->post('deviation_systolic_bp');

			$upd['testicular_cancer'] = $this->input->post('testicular_cancer');
			$upd['testicular_lastcheck'] = $this->input->post('testicular_lastcheck');
			$upd['ovarian_cancer'] = $this->input->post('ovarian_cancer');
			$upd['ovarian_lastcheck'] = $this->input->post('ovarian_lastcheck');

			if ($this->input->post('dietDetails') == 'other') {

				$upd['diet_other_details'] = $this->input->post('diet_other_details');
			}

			$upd['updatedAt'] = current_datetime();

			$this->db->update('user_details', $upd, array('userId' => $this->session_data->userId));

			//commented by david


			if ($this->input->post('weight') > 0 && $this->input->post('height') > 0) {


				$weight = $this->input->post('weight');
				$height = $this->input->post('height');
				$height_in_m = $height / 100;
				$bmi = $weight / ($height_in_m * $height_in_m);

				$track['userId'] = $this->session_data->userId;
				$track['bmi'] = $bmi;
				$track['date'] = date('Y-m-d');
				$track['hip'] = $this->input->post('hipMeasurment');
				$track['waist'] = $this->input->post('waistMeasurment');

				$this_month = $this->db->query("SELECT count(*) as cnt, trackId FROM `user_track_graph` WHERE MONTH(date) = MONTH(CURRENT_DATE())
				AND YEAR(date) = YEAR(CURRENT_DATE()) and userId=" . $this->session_data->userId)->row();

				$gender = $this->db->query('select userGender from users WHERE userId=' . $this->session_data->userId)->row()->userGender;
				$track['qrisk'] = $this->qrisk_model->get_qrisk($this->session_data->userId, $gender);

				if ($gender == 'Male') {

					if ($track['qrisk'] < 0.3) $track['heart_age'] = '< 30';

					if ($track['qrisk'] >= 0.3 && $track['qrisk'] < 0.4428) $track['heart_age'] = '31';

					if ($track['qrisk'] >= 0.4428 && $track['qrisk'] < 0.5262) $track['heart_age'] = '32';

					if ($track['qrisk'] >= 0.5262 && $track['qrisk'] < 0.6196) $track['heart_age'] = '33';

					if ($track['qrisk'] >= 0.6196 && $track['qrisk'] < 0.7234) $track['heart_age'] = '34';

					if ($track['qrisk'] >= 0.7234 && $track['qrisk'] < 0.8382) $track['heart_age'] = '35';

					if ($track['qrisk'] >= 0.8382 && $track['qrisk'] < 0.9643) $track['heart_age'] = '36';

					if ($track['qrisk'] >= 0.9643 && $track['qrisk'] < 1.1023) $track['heart_age'] = '37';

					if ($track['qrisk'] >= 1.1023 && $track['qrisk'] < 1.2527) $track['heart_age'] = '38';

					if ($track['qrisk'] >= 1.2527 && $track['qrisk'] < 1.4159) $track['heart_age'] = '39';

					if ($track['qrisk'] >= 1.4159 && $track['qrisk'] < 1.5986) $track['heart_age'] = '40';

					if ($track['qrisk'] >= 1.5986 && $track['qrisk'] < 1.7893) $track['heart_age'] = '41';

					if ($track['qrisk'] >= 1.7893 && $track['qrisk'] < 1.9944) $track['heart_age'] = '42';

					if ($track['qrisk'] >= 1.9944 && $track['qrisk'] < 2.2145) $track['heart_age'] = '43';

					if ($track['qrisk'] >= 2.2145 && $track['qrisk'] < 2.4502) $track['heart_age'] = '44';

					if ($track['qrisk'] >= 2.4502 && $track['qrisk'] < 2.7022) $track['heart_age'] = '45';

					if ($track['qrisk'] >= 2.7022 && $track['qrisk'] < 2.9711) $track['heart_age'] = '46';

					if ($track['qrisk'] >= 2.9711 && $track['qrisk'] < 3.2577) $track['heart_age'] = '47';

					if ($track['qrisk'] >= 3.2577 && $track['qrisk'] < 3.5629) $track['heart_age'] = '48';

					if ($track['qrisk'] >= 3.5629 && $track['qrisk'] < 3.8875) $track['heart_age'] = '49';

					if ($track['qrisk'] >= 3.8875 && $track['qrisk'] < 4.2255) $track['heart_age'] = '50';

					if ($track['qrisk'] >= 4.2255 && $track['qrisk'] < 4.5919) $track['heart_age'] = '51';

					if ($track['qrisk'] >= 4.5919 && $track['qrisk'] < 4.981) $track['heart_age'] = '52';

					if ($track['qrisk'] >= 4.981 && $track['qrisk'] < 5.3937) $track['heart_age'] = '53';

					if ($track['qrisk'] >= 5.3937 && $track['qrisk'] < 5.8314) $track['heart_age'] = '54';

					if ($track['qrisk'] >= 5.8314 && $track['qrisk'] < 6.2955) $track['heart_age'] = '55';

					if ($track['qrisk'] >= 6.2955 && $track['qrisk'] < 6.7874) $track['heart_age'] = '56';

					if ($track['qrisk'] >= 6.7874 && $track['qrisk'] < 7.3088) $track['heart_age'] = '57';

					if ($track['qrisk'] >= 7.3088 && $track['qrisk'] < 7.8613) $track['heart_age'] = '58';

					if ($track['qrisk'] >= 7.8613 && $track['qrisk'] < 8.4468) $track['heart_age'] = '59';

					if ($track['qrisk'] >= 8.4468 && $track['qrisk'] < 9.0596) $track['heart_age'] = '60';

					if ($track['qrisk'] >= 9.0596 && $track['qrisk'] < 9.7188) $track['heart_age'] = '61';

					if ($track['qrisk'] >= 9.7188 && $track['qrisk'] < 10.4174) $track['heart_age'] = '62';

					if ($track['qrisk'] >= 10.4174 && $track['qrisk'] < 11.1577) $track['heart_age'] = '63';

					if ($track['qrisk'] >= 11.1577 && $track['qrisk'] < 11.9424) $track['heart_age'] = '64';

					if ($track['qrisk'] >= 11.9424 && $track['qrisk'] < 12.7741) $track['heart_age'] = '65';

					if ($track['qrisk'] >= 12.7741 && $track['qrisk'] < 13.6557) $track['heart_age'] = '66';

					if ($track['qrisk'] >= 13.6557 && $track['qrisk'] < 14.5901) $track['heart_age'] = '67';

					if ($track['qrisk'] >= 14.5901 && $track['qrisk'] < 15.5805) $track['heart_age'] = '68';

					if ($track['qrisk'] >= 15.5805 && $track['qrisk'] < 16.6303) $track['heart_age'] = '69';

					if ($track['qrisk'] >= 16.6303 && $track['qrisk'] < 17.784) $track['heart_age'] = '70';

					if ($track['qrisk'] >= 17.784 && $track['qrisk'] < 18.9698) $track['heart_age'] = '71';

					if ($track['qrisk'] >= 18.9698 && $track['qrisk'] < 20.2259) $track['heart_age'] = '72';

					if ($track['qrisk'] >= 20.2259 && $track['qrisk'] < 21.5561) $track['heart_age'] = '73';

					if ($track['qrisk'] >= 21.5561 && $track['qrisk'] < 22.9643) $track['heart_age'] = '74';

					if ($track['qrisk'] >= 22.9643 && $track['qrisk'] < 24.4542) $track['heart_age'] = '75';

					if ($track['qrisk'] >= 24.4542 && $track['qrisk'] < 26.0298) $track['heart_age'] = '76';

					if ($track['qrisk'] >= 26.0298 && $track['qrisk'] < 27.6947) $track['heart_age'] = '77';

					if ($track['qrisk'] >= 27.6947 && $track['qrisk'] < 29.4526) $track['heart_age'] = '78';

					if ($track['qrisk'] >= 29.4526 && $track['qrisk'] < 31.3069) $track['heart_age'] = '79';

					if ($track['qrisk'] >= 31.3069 && $track['qrisk'] < 33.367) $track['heart_age'] = '80';

					if ($track['qrisk'] >= 33.367 && $track['qrisk'] < 35.4301) $track['heart_age'] = '81';

					if ($track['qrisk'] >= 35.4301 && $track['qrisk'] < 37.5969) $track['heart_age'] = '82';

					if ($track['qrisk'] >= 37.5969 && $track['qrisk'] < 39.8685) $track['heart_age'] = '83';

					if ($track['qrisk'] >= 39.8685) $track['heart_age'] = '> 84';
				} else {

					if ($track['qrisk'] < 0.25) $track['heart_age'] = '< 30';

					if ($track['qrisk'] >= 0.25 && $track['qrisk'] < 0.3159) $track['heart_age'] = '31';

					if ($track['qrisk'] >= 0.3159 && $track['qrisk'] < 0.3582) $track['heart_age'] = '32';

					if ($track['qrisk'] >= 0.3582 && $track['qrisk'] < 0.4046) $track['heart_age'] = '33';

					if ($track['qrisk'] >= 0.4046 && $track['qrisk'] < 0.4554) $track['heart_age'] = '34';

					if ($track['qrisk'] >= 0.4554 && $track['qrisk'] < 0.511) $track['heart_age'] = '35';

					if ($track['qrisk'] >= 0.511 && $track['qrisk'] < 0.5717) $track['heart_age'] = '36';

					if ($track['qrisk'] >= 0.5717 && $track['qrisk'] < 0.6381) $track['heart_age'] = '37';

					if ($track['qrisk'] >= 0.6381 && $track['qrisk'] < 0.7106) $track['heart_age'] = '38';

					if ($track['qrisk'] >= 0.7106 && $track['qrisk'] < 0.7898) $track['heart_age'] = '39';

					if ($track['qrisk'] >= 0.7898 && $track['qrisk'] < 0.8761) $track['heart_age'] = '40';

					if ($track['qrisk'] >= 0.8761 && $track['qrisk'] < 0.9702) $track['heart_age'] = '41';

					if ($track['qrisk'] >= 0.9702 && $track['qrisk'] < 1.0728) $track['heart_age'] = '42';

					if ($track['qrisk'] >= 1.0728 && $track['qrisk'] < 1.1846) $track['heart_age'] = '43';

					if ($track['qrisk'] >= 1.1846 && $track['qrisk'] < 1.3063) $track['heart_age'] = '44';

					if ($track['qrisk'] >= 1.3063 && $track['qrisk'] < 1.4389) $track['heart_age'] = '45';

					if ($track['qrisk'] >= 1.4389 && $track['qrisk'] < 1.5832) $track['heart_age'] = '46';

					if ($track['qrisk'] >= 1.5832 && $track['qrisk'] < 1.7402) $track['heart_age'] = '47';

					if ($track['qrisk'] >= 1.7402 && $track['qrisk'] < 1.911) $track['heart_age'] = '48';

					if ($track['qrisk'] >= 1.911 && $track['qrisk'] < 2.0966) $track['heart_age'] = '49';

					if ($track['qrisk'] >= 2.0966 && $track['qrisk'] < 2.2984) $track['heart_age'] = '50';

					if ($track['qrisk'] >= 2.2984 && $track['qrisk'] < 2.5177) $track['heart_age'] = '51';

					if ($track['qrisk'] >= 2.5177 && $track['qrisk'] < 2.7559) $track['heart_age'] = '52';

					if ($track['qrisk'] >= 2.7559 && $track['qrisk'] < 3.0146) $track['heart_age'] = '53';

					if ($track['qrisk'] >= 3.0146 && $track['qrisk'] < 3.2953) $track['heart_age'] = '54';

					if ($track['qrisk'] >= 3.2953 && $track['qrisk'] < 3.5999) $track['heart_age'] = '55';

					if ($track['qrisk'] >= 3.5999 && $track['qrisk'] < 3.9303) $track['heart_age'] = '56';

					if ($track['qrisk'] >= 3.9303 && $track['qrisk'] < 4.2885) $track['heart_age'] = '57';

					if ($track['qrisk'] >= 4.2885 && $track['qrisk'] < 4.6766) $track['heart_age'] = '58';

					if ($track['qrisk'] >= 4.6766 && $track['qrisk'] < 5.0971) $track['heart_age'] = '59';

					if ($track['qrisk'] >= 5.0971 && $track['qrisk'] < 5.5523) $track['heart_age'] = '60';

					if ($track['qrisk'] >= 5.5523 && $track['qrisk'] < 6.0448) $track['heart_age'] = '61';

					if ($track['qrisk'] >= 6.0448 && $track['qrisk'] < 6.5776) $track['heart_age'] = '62';

					if ($track['qrisk'] >= 6.5776 && $track['qrisk'] < 7.1535) $track['heart_age'] = '63';

					if ($track['qrisk'] >= 7.1535 && $track['qrisk'] < 7.7756) $track['heart_age'] = '64';

					if ($track['qrisk'] >= 7.7756 && $track['qrisk'] < 8.4472) $track['heart_age'] = '65';

					if ($track['qrisk'] >= 8.4472 && $track['qrisk'] < 9.1717) $track['heart_age'] = '66';

					if ($track['qrisk'] >= 9.1717 && $track['qrisk'] < 9.9528) $track['heart_age'] = '67';

					if ($track['qrisk'] >= 9.9528 && $track['qrisk'] < 10.7942) $track['heart_age'] = '68';

					if ($track['qrisk'] >= 10.7942 && $track['qrisk'] < 11.6997) $track['heart_age'] = '69';

					if ($track['qrisk'] >= 11.6997 && $track['qrisk'] < 12.6733) $track['heart_age'] = '70';

					if ($track['qrisk'] >= 12.6733 && $track['qrisk'] < 13.7192) $track['heart_age'] = '71';

					if ($track['qrisk'] >= 13.7192 && $track['qrisk'] < 14.8415) $track['heart_age'] = '72';

					if ($track['qrisk'] >= 14.8415 && $track['qrisk'] < 16.0444) $track['heart_age'] = '73';

					if ($track['qrisk'] >= 16.0444 && $track['qrisk'] < 17.332) $track['heart_age'] = '74';

					if ($track['qrisk'] >= 17.332 && $track['qrisk'] < 18.7086) $track['heart_age'] = '75';

					if ($track['qrisk'] >= 18.7086 && $track['qrisk'] < 20.1781) $track['heart_age'] = '76';

					if ($track['qrisk'] >= 20.1781 && $track['qrisk'] < 21.7443) $track['heart_age'] = '77';

					if ($track['qrisk'] >= 21.7443 && $track['qrisk'] < 23.4108) $track['heart_age'] = '78';

					if ($track['qrisk'] >= 23.4108 && $track['qrisk'] < 25.1808) $track['heart_age'] = '79';

					if ($track['qrisk'] >= 25.1808 && $track['qrisk'] < 27.0569) $track['heart_age'] = '80';

					if ($track['qrisk'] >= 27.0569 && $track['qrisk'] < 29.0413) $track['heart_age'] = '81';

					if ($track['qrisk'] >= 29.0413 && $track['qrisk'] < 31.1353) $track['heart_age'] = '82';

					if ($track['qrisk'] >= 31.1353 && $track['qrisk'] < 33.3395) $track['heart_age'] = '83';

					if ($track['qrisk'] >= 33.3395) $track['heart_age'] = '> 84';
				}
				if ($this_month->cnt > 0) {
					$this->db->where('trackId', $this_month->trackId)->update("user_track_graph", $track);
				} else {
					$this->db->insert("user_track_graph", $track);
				}
			}


			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Questionaire updated successfully';
			echo json_encode($response);
			exit();
		}
	}


	public function check_login()
	{
		if (!isset($this->session_data->userId)) {
			redirect('home');
		}
	}


	public function check_ajax_login()
	{

		if (!isset($this->session_data->userId)) {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Please Login!!';
			echo json_encode($response);
			exit();
		}
	}
}
