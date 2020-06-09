<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {
	


	public function __construct() {
		
		parent::__construct();
		$sess_data=$this->session->userdata('admin');
		$this->session_data = $sess_data;
	}



	public function index() {
		
		$this->check_login();
		$this->data['page_title']='Blogs';
		$this->load->view('admin/list_blogs', $this->data);
	}



	public function add() {
		
		$this->check_login();
		$this->data['page_title']='Add Blogs - Admin';
		$this->load->view('admin/add_blog', $this->data);
	}



	public function edit($id=0){
		
		$this->check_login();
		$blogs = $this->db->query("SELECT * FROM blogs WHERE blogId='".$id."'")->row();

		if($blogs) {
			
			$this->data['page_title']='Edit Blog';
			$this->data['row']=$blogs;
			$this->load->view('admin/edit_blog', $this->data);
		}
		else{
			
			redirect('admin/blogs');
		}
	}



	public  function  add_process() {
		
		$this->check_ajax_login();
		$this->form_validation->set_rules('blogTitle', 'Title', 'required');
		$this->form_validation->set_rules('blogSlug', 'Page Slug', 'required');
		$this->form_validation->set_rules('pageDescription', 'Page Description', 'required');
		$this->form_validation->set_rules('PicAltText', 'Picture Alt Text', 'required');
		$this->form_validation->set_rules('blogDescription', 'Description', 'required');

		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else{

			$blogTitle=$this->input->post('blogTitle');
			$blogDescription=$this->input->post('blogDescription');
			$slug= $this->input->post('blogSlug'); //slug($blogTitle);

			$pageDescription = $this->input->post('pageDescription');
			$PicAltText = $this->input->post('PicAltText');

			$slug_chk=$this->general_model->role_exists('blogSlug',$slug,'blogs');

			if($slug_chk==false) {
				
				$response=array();
				$response['code']=0;
				$response['message']='Blog with same name already exist';
				echo json_encode($response);
				exit();
			}

			$path = './uploads/blog/';
			$this->load->library('upload');

			$this->upload->initialize(array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*',
					"encrypt_name"      =>  true
				)
			);

			if($this->upload->do_upload("blogImage")) {

				$upload_data = $this->upload->data();
				$blogImage=$upload_data['file_name'];
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']=$this->upload->error_msg[0];
				echo json_encode($response);
				exit();
			}

			$ins=array();
			$ins['blogTitle']=$blogTitle;
			$ins['blogDescription']=$blogDescription;
			$ins['blogSlug']=$slug;
			$ins['blogImage']=$blogImage;

			$ins['pageDescription'] = $pageDescription;
			$ins['PicAltText'] = $PicAltText;

			$ins['createdAt']=current_datetime();
			$ins['updatedAt']=current_datetime();
			$this->db->insert('blogs',$ins);
			$response=array();
			$response['code']=1;
			$response['message']='Added successfully';
			echo json_encode($response);
			exit();
		}

	}

	public function get_slug(){
		$title = $this->input->post('title');
		echo slug($title);
	}

	public function edit_process($id=0) {
		
		$this->check_ajax_login();
		$blogs= $this->db->query("SELECT * FROM blogs WHERE blogId='".$id."'")->row();

		if(!$blogs) {
			
			$response=array();
			$response['code']=0;
			$response['message']="Blog Not found";
			echo json_encode($response);
			exit();
		}
		
		// $this->form_validation->set_rules('blogTitle', 'Title', 'required');
		// $this->form_validation->set_rules('blogDescription', 'Description', 'required');

		$this->form_validation->set_rules('blogTitle', 'Title', 'required');
		$this->form_validation->set_rules('blogSlug', 'Page Slug', 'required');
		$this->form_validation->set_rules('pageDescription', 'Page Description', 'required');
		$this->form_validation->set_rules('PicAltText', 'Picture Alt Text', 'required');
		$this->form_validation->set_rules('blogDescription', 'Description', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$response=array();
			$response['code']=0;
			$response['message']=validation_errors();
			echo json_encode($response);
			exit();
		}
		else {

			$blogTitle=$this->input->post('blogTitle');
			$blogDescription=$this->input->post('blogDescription');
			$slug= $this->input->post('blogSlug'); //slug($blogTitle);

			$pageDescription = $this->input->post('pageDescription');
			$PicAltText = $this->input->post('PicAltText');


			$slug_chk=$this->general_model->role_exists('blogSlug',$slug,'blogs');
			

			if($blogs->blogSlug!=$slug) {

				if ($slug_chk == false) {
					
					$response = array();
					$response['code'] = 0;
					$response['message'] = 'Blog with same name already exist';
					echo json_encode($response);
					exit();
				}
			}
			
			$path = './uploads/blog/';
			$this->load->library('upload');
			$this->upload->initialize(
				array(
					"upload_path"       =>  $path,
					"allowed_types"     =>  '*',
					"encrypt_name"      =>  true
				)
			);

			$upd=array();
			$upd['blogTitle']=$blogTitle;
			$upd['blogDescription']=$blogDescription;
			$upd['blogSlug']=$slug;

			$upd['pageDescription'] = $pageDescription;
			$upd['PicAltText'] = $PicAltText;

			if($this->upload->do_upload("blogImage")) {
				
				$upload_data = $this->upload->data();
				$upd['blogImage']=$upload_data['file_name'];
			}
			
			$upd['updatedAt']=current_datetime();
			$this->db->update('blogs',$upd,array('blogId'=>$id));

			$response=array();
			$response['code']=1;
			$response['message']='Updated successfully';
			echo json_encode($response);
			exit();
		}
	}



	public function list_data() {
		
		$this->check_ajax_datatable();
		
		$columns = array(
			0 =>'blogId',
			1 =>'blogTitle',
			2 =>'createdAt',
			3=> 'blogId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];

		$whr='where 1=1 ';

		$totalData = $this->db->query('select * from blogs '.$whr)->num_rows();
		$totalFiltered = $totalData;

		if(empty($this->input->post('search')['value'])) {

			$sq=$this->db->query('select blogs.* from blogs
 			'.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);
			
			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {
				
				$result=null;
			}
		}
		else {

			$search = $this->input->post('search')['value'];
			$whr.=' and (blogId like "%'.$search.'%" or  blogTitle like "%'.$search.'%")';

			$sq=$this->db->query('select blogs.* from blogs
 			'.$whr.' order by '.$order.' '.$dir.' limit '.$start.','.$limit);

			if($sq->num_rows()>0) {
				
				$result=$sq->result();
			}
			else {
				
				$result=null;
			}
			
			$totalFiltered = $this->db->query('select blogs.* from blogs
 			'.$whr)->num_rows();
		}
		
		$data = array();
		
		if(!empty($result)) {
			
			foreach ($result as $row) {
				
				$nestedData['id'] = $row->blogId;
				$nestedData['name'] = $row->blogTitle;
				$nestedData['createdDate'] = date('F d,Y',strtotime($row->createdAt));
				$nestedData['action']=' <a href="'.$this->config->item('admin_url').'/blogs/edit/'.$row->blogId.'" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
 				<a href="javascript:;" onclick="delete_blog(this,'.$row->blogId.')" class="btn waves-effect waves-light btn-danger btn-sm"><i class="icofont icofont-trash"></i></a>	';
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



	public  function  delete_blog() {
		
		$this->check_ajax_login();
		$id=$this->input->post('id');
		
		if($id>0) {
			
			$blogs = $this->db->query("SELECT * FROM blogs WHERE blogId='".$id."'")->row();
			
			if($blogs) {
				
				unlink('./uploads/blog/'.$blogs->blogImage);
				$this->db->delete('blogs',array('blogId'=>$id));
				$response=array();
				$response['code']=1;
				$response['message']='Deleted';
				echo json_encode($response);
				exit();
			}
			else {
				
				$response=array();
				$response['code']=0;
				$response['message']='Blog not found';
				echo json_encode($response);
				exit();
			}
		}
		else {
			
			$response=array();
			$response['code']=0;
			$response['message']='Blog not found';
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
}

