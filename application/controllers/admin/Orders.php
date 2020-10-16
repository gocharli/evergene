<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Orders extends CI_Controller
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
		$this->data['page_title'] = 'Orders - Admin';
		$this->load->view('admin/list_orders', $this->data);
	}



	public function list_data()
	{

		$this->check_ajax_datatable();
		$columns = array(
			0 => 'orderId',
			1 => 'userFirstName',
			2 => 'orderAmount',
			3 => 'trx_id',
			4 => 'orderShipAddress',
			5 => 'createdAt',
			6 => 'orderId'
		);

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$whr = ' where 1=1 ';
		$totalData = $this->db->query('select orders.*,users.userFirstName,users.userLastName from orders
			LEFT JOIN users ON orders.userId=users.userId' .
			$whr)->num_rows();
		$totalFiltered = $totalData;

		if (empty($this->input->post('search')['value'])) {

			$sq = $this->db->query('select orders.*,users.userFirstName,users.userLastName, transactions.trx_id from orders 
			LEFT JOIN users ON orders.userId=users.userId
			LEFT JOIN transactions ON orders.orderId=transactions.orderId' .
				$whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);
			if ($sq->num_rows() > 0) {
				$result = $sq->result();
			} else {
				$result = null;
			}
		} else {

			$search = $this->input->post('search')['value'];
			$whr .= ' and (orders.orderId like "%' . $search . '%" or  users.userFirstName like "%' . $search . '%"  or orderAmount like "%' . $search . '%" or  orderShipAddress like "%' . $search . '%")';

			$sq = $this->db->query('select orders.*,users.userFirstName,users.userLastName, transactions.trx_id from orders 
			LEFT JOIN users ON orders.userId=users.userId
			LEFT JOIN transactions ON orders.orderId=transactions.orderId' .
				$whr . ' order by ' . $order . ' ' . $dir . ' limit ' . $start . ',' . $limit);
			if ($sq->num_rows() > 0) {

				$result = $sq->result();
			} else {

				$result = null;
			}

			$totalFiltered = $this->db->query('select orders.*,users.userFirstName,users.userLastName from orders 
			LEFT JOIN users ON orders.userId=users.userId' .
				$whr)->num_rows();
		}

		$data = array();

		if (!empty($result)) {

			foreach ($result as $row) {

				$nestedData['id'] = $row->orderId;
				$nestedData['name'] = $row->userFirstName . ' ' . $row->userLastName;
				$nestedData['amount'] = '<i class="icofont icofont-cur-pound"></i>' . $row->orderAmount;
				$nestedData['trx_id'] = $row->trx_id;
				$nestedData['address'] = $row->orderShipAddress . ' ' . $row->orderCity . ' ' . $row->orderState;
				$nestedData['date'] =  date('M d,Y', strtotime($row->createdAt));
				$nestedData['action'] = '<a href="' . $this->config->item('admin_url') . '/orders/view/' . $row->orderId . '" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-eye-alt"></i></a> ';
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



	public function view($orderId = 0)
	{

		$this->check_login();
		$orders = $this->db->query('select * from orders where orderId=' . $orderId)->row();

		if ($orders) {

			$order_services = $this->db->query('select order_details.*,users.userFirstName,users.userLastName,tests.testName from order_details
			LEFT JOIN users ON order_details.userId=users.userId
			LEFT JOIN tests ON order_details.testId=tests.testId
         	where orderId=' . $orderId)->result();

			foreach ($order_services as $key => $row) {

				if ($row->detailStatus == 'Pending') {
					$row->detailStatus = '<label class="label label-primary">Pending</label>';

					if ($row->scheduleDate > date('Y-m-d')) {
						$row->detailStatus = '<label class="label label-primary">Schedule</label>';
					}
				} else if ($row->detailStatus == 'Canceled') {
					$row->detailStatus = '<label class="label label-danger">Canceled</label>';
				} else if ($row->detailStatus == 'Inprogress') {
					$row->detailStatus = '<label class="label label-info">Inprogress</label>';
				} else if ($row->detailStatus == 'Completed') {
					$row->detailStatus = '<label class="label label-success">Completed</label>';
				}

				if ($row->paymentStatus == 'Yes') {
					$row->paymentStatus = '<label class="label label-success">Paid</label>';
				} else {
					$row->paymentStatus = '<label class="label label-primary">Unpaid</label>';
				}

				$row->scheduleDate =  date('M d,Y', strtotime($row->scheduleDate));
			}

			$this->data['page_title'] = 'Orders Services';
			$this->data['results'] = $order_services;
			$this->load->view('admin/order_services', $this->data);
		} else {

			redirect('admin/orders');
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
