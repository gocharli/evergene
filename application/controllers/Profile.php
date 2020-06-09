<?php

class Profile extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function view($enc) {

		
		$cdate = substr($enc, strpos($enc, "_") + 1);
		$createdAt = date('Y-m-d H:i:s', $cdate); 
		$id = 0;
		$id = $this->db->query("select userId from users where createdAt = '$createdAt'")->row()->userId;
		if($id <= 0){
			redirect('home');
		}
		$this->response['newResults']=$this->db->query('select count(*) as count FROM order_details
 		WHERE userId='.$id.' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();
 		
		//$this->check_login();
		$this->response['page_title']="Hub";
		$this->response['row']=$this->db->query('select * from user_details WHERE userId='.$id)->row();
		// recomended //
		//echo '<pre>'; print_r($this->response['row']); exit;
		//track//
		$daily_analytics=array();
		$last_year=date("Y-m-d",strtotime("-1 year"));
		$date=$last_year;
		
		for($i=1;$i<13;$i++) {
			
			if($i!=0) {
				$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
			}

			$new=array();
			$new['y']=date('Y-m-d',strtotime($date));
			$new['x']=0;
			$new['x1']=0;
			$new['x2']=0;
			$new['x3']=0;
			$daily_analytics[]=$new;
		}

		$user_track_graph=$this->db->query('select * from user_track_graph WHERE  DATE(date)>="'.$last_year.'" and  userId='.$id.' GROUP BY YEAR(date), MONTH(date)')->result();
		
		foreach ($user_track_graph as $r) {
			foreach ($daily_analytics as $key=>$row) {
				if(date('Y-m',strtotime($row['y']))==date('Y-m',strtotime($r->date))) {
					$daily_analytics[$key]['x']=$r->bmi;
					$daily_analytics[$key]['x1']=$r->hip;
					$daily_analytics[$key]['x2']=$r->qrisk;
					$daily_analytics[$key]['x3']=$r->heart_attack;
				}
			}
		}

		$pagination_sql=" LIMIT 0 , 4";
		
		$this->response['res_bmi']=$daily_analytics;
		
		$this->load->view('public_profile',$this->response);
	}
    
}
