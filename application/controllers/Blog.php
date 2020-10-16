<?php


class Blog extends CI_Controller
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

		$this->session->set_userdata('current_url', base_url() . 'blog');
		$this->response['page_title'] = "BLogs";
		$resultsPerPage = 12;
		$pagination_sql = " LIMIT 0 , $resultsPerPage";
		$tests = $this->db->query('select blogs.* from blogs
 		ORDER BY blogId DESC ' . $pagination_sql)->result();
		$this->response['results'] = $tests;
		$this->response['resultsPerPage'] = $resultsPerPage;
		$this->load->view('blogs', $this->response);
	}



	public function loadmore()
	{

		$this->check_ajax_login();
		$resultsPerPage = 12;
		$paged = 0;

		if (isset($_POST['page'])) {

			$paged = $_POST['page'];
		}
		if ($paged > 0) {

			$page_limit = $resultsPerPage * ($paged - 1);
			$pagination_sql = " LIMIT  $page_limit, $resultsPerPage";
		} else {

			$pagination_sql = " LIMIT 0 , $resultsPerPage";
		}

		$results = $this->db->query('select * from blogs WHERE  order by blogId desc ' . $pagination_sql);
		$record = $results->num_rows();
		$results = $results->result();

		if ($record > 0) {

			$html = $this->load->view('components/blogs', array('blogs' => $results), true);

			if ($record >= $resultsPerPage) {
				$page = $paged + 1;
			} else {
				$page = 0;
			}
		} else {

			$html = '';
			$page = 0;
		}

		$response = array();
		$response['code'] = 1;
		$response['html'] = $html;
		$response['page'] = $page;
		echo json_encode($response);
		exit();
	}



	public function view($slug = '')
	{

		$blogs = $this->db->query('select blogs.* from blogs
 		WHERE blogSlug="' . $slug . '"')->row();

		if ($blogs) {

			$this->response['page_title'] = $blogs->blogTitle;
			$this->response['row'] = $blogs;
			$this->load->view('blog_detail', $this->response);
		} else {
			redirect('blogs');
		}
	}
}
