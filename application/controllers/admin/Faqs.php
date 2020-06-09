<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {



	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function edit($id=0) {
		
		$this->check_login();
		$test = $this->db->query("SELECT * FROM faqs WHERE faqId='".$id."'")->row();

		if($test) {
			
			$this->data['page_title']='Edit Faq';
			$this->data['row']=$test;
			$this->load->view('admin/edit_faq', $this->data);
		}
		else {
			
			redirect('admin/tests');
		}
	}



	public function edit_code() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('faqTitle', 'Title', 'required');
		$this->form_validation->set_rules('faqDescription', 'Detail', 'required');
		$this->form_validation->set_rules('faqId', 'Faq', 'required');

		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else{

			$faqId=$this->input->post('faqId');
			$faq= $this->db->query("SELECT * FROM faqs WHERE faqId='".$faqId."'")->row();
			
			if(!$faq) {
				
				$response=array();
				$response['code']=0;
				$response['message']="Faq Not found";
				echo json_encode($response);
				exit();
			}
			
			$faqTitle=$this->input->post('faqTitle');
			$faqDescription=$this->input->post('faqDescription');
			$slug=slug($faqTitle);

			if($faq->faqSlug!=$slug) {
				
				$slug_chk=$this->general_model->role_exists('faqSlug',$slug,'faqs');
				
				if($slug_chk==false) {

					$response=array();
					$response['code']=0;
					$response['message']='Faq with same title already exist';
					echo json_encode($response);
					exit();
				}
			}

			$upd=array();
			$upd['faqTitle']=$faqTitle;
			$upd['faqDescription']=$faqDescription;
			$upd['faqSlug']=$slug;
			$upd['updatedAt']=current_datetime();
			$this->db->update('faqs',$upd,array('faqId'=>$faqId));

			$response=array();
			$response['code']=1;
			$response['message']='Faq Updated successfully';
			echo json_encode($response);
			exit();
		}
	}



	public  function  delete_faq() {
		
		$this->check_ajax_login();
		$id=$this->input->post('id');
		
		if($id>0) {
			
			$faq_relations = $this->db->query("SELECT * FROM faq_relations WHERE relationId='".$id."'")->row();
			
			if($faq_relations) {

				$this->db->delete('faq_relations',array('relationId'=>$id));
				$total=$this->db->query("SELECT * FROM faq_relations WHERE faqId='".$faq_relations->faqId."'")->num_rows();
				
				if($total==0) {
					
					$this->db->delete('faqs',array('faqId'=>$faq_relations->faqId));
				}

				$response=array();
				$response['code']=1;
				$response['message']='Deleted';
				echo json_encode($response);
				exit();
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']='Faq not found';
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

}

