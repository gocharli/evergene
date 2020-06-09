<?php


class Premium_membership extends CI_Controller {
	

	public function __construct() {
		

		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
	}

	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'memberships');
		$this->response['page_title']="Memberships";
		$this->response['bonus']=0;
		$this->response['results']=$this->db->query('select * from membership_plan ORDER BY mpId ASC')->result();
        
        if(isset($this->session_data->userId)){
            
            $this->response['membership_type'] = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
            $this->response['orders']=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
        }        
		
        if (isset($this->session_data->userId)) {
			
			if($this->session_data->userReferal>0) {
				
				$mship = $this->db->query('SELECT * FROM memberships WHERE userId='. $this->session_data->userId)->row();
				
				if (!$mship) {
					
					$orders=$this->db->query('select * from orders WHERE userId='.$this->session_data->userId)->num_rows();
					
					if($orders==0) {
						
						$recommended_bonus=$this->general_model->select_where('settings',array('settingOption'=>'recommended_bonus'));
						
						if($recommended_bonus) {
							
							if ($recommended_bonus->settingValue == 1) {
								
								$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'recommended_new_user_purchase_membership_new_user'));
								
								if($setting_qry) {
									$bonus=$setting_qry->settingValue;
									if($bonus<1){ $bonus=0;	}
									$this->response['bonus']=$bonus;
								}
							}
						}
					}
				}
			}
		}

		$this->load->view('premium-membership',$this->response);
	}

}
