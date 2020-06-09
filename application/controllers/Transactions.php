<?php



class Transactions extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$session_data=$this->session->userdata('users');
		$this->session_data=$session_data;
		//check membership detail
		$this->membership_data = new stdClass();
		$this->membership_data->expire = true;
		
		if (isset($this->session_data->userId)) {
			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId=' . $this->session_data->userId)->row();
			
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



	public function index() {
		
		$this->session->set_userdata('current_url', base_url().'transactions');
		$this->check_login();
		$this->response['page_title']="Transactions";

		$this->response['newResults']=$this->db->query('select count(*) as count FROM order_details
 		WHERE userId='.$this->session_data->userId.' and productType="Test" and detailStatus="Completed" and orderViewStatus="0" ')->row();
 		
		$resultsPerPage=12;
		$pagination_sql=" LIMIT 0 , $resultsPerPage";
		$this->response['results']=$this->db->query('select * from transactions
         WHERE userId='.$this->session_data->userId.' order by transactionId  DESC '.$pagination_sql)->result();
		$this->response['resultsPerPage']=$resultsPerPage;
		$this->load->view('transactions',$this->response);
	}



	public function loadmore() {
		
		$this->check_ajax_login();
		$resultsPerPage=12;
		$paged=0;
		
		if(isset($_POST['page'])) {
			$paged=$_POST['page'];
		}
		if($paged>0) {
			
			$page_limit=$resultsPerPage*($paged-1);
			$pagination_sql=" LIMIT  $page_limit, $resultsPerPage";
		}
		else {
			$pagination_sql=" LIMIT 0 , $resultsPerPage";
		}

		$results=$this->db->query('select * from transactions
        WHERE userId='.$this->session_data->userId.' order by transactionId desc '.$pagination_sql);
		$record=$results->num_rows();
		$results =$results->result();
		
		if($record>0) {
			
			$html=$this->load->view('components/transactions',array('results'=>$results),true);
			
			if($record>=$resultsPerPage) {
				$page=$paged+1;
			}
			else {
				$page=0;
			}
		}
		else {
			$html='';
			$page=0;
		}
		
		$response=array();
		$response['code']=1;
		$response['html']=$html;
		$response['page']=$page;
		echo json_encode($response);
		exit();
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
