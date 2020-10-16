<?php
class Cart extends CI_Controller
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
				} elseif (empty($mship->StripeSubscriptionEnded)) {
					$mship->expire = false;
				} else {
					$mship->expire = true;
				}
				$this->membership_data = $mship;
				$this->membership_data = $mship;
			}
		}
	}



	public  function index()
	{

		$this->session->set_userdata('current_url', base_url() . 'cart');
		$this->data['page_title'] = 'Cart';
		$cart = $this->cart->contents();
		function sortByOrder1($a, $b)
		{
			return $b['price'] - $a['price'];
		}
		usort($cart, 'sortByOrder1');

		$this->data['cart_data'] = $cart;

		$totalAllowedOrders = $this->membership_data->orders;
		$month_number = date('m');
		$year = date('Y');

		if ($this->membership_data->expire == false) {

			$rrr = $this->db->query('select detailQty as total from order_details
        	WHERE userId=' . $this->session_data->userId . ' AND regularType="One Time"
        	AND paymentType="Membership" AND YEAR(membershipDate)=' . $year . '  AND MONTH(membershipDate)=' . $month_number . ' group by orderId')->result();

			$available_orders = 0;
			foreach ($rrr as $r) {
				$available_orders += $r->total;
			}

			$toBeChanged = $totalAllowedOrders - $available_orders;
		}

		$a = 1;
		$new_cart = array();

		foreach ($cart as $row) {

			if ($row['options']['pType'] == 'Regular' && $row['options']['paymentType'] != 'Discounted Price') {

				if ($a <= $toBeChanged) {

					$row['options']['membershipStatus'] = "Active";
					$row['options']['paymentType'] = "Membership";
					$row['options']['membershipDate'] = date('Y-m-d', strtotime($this->membership_data->createdAt));

					if (trim($row['options']['discountPercentage']) == 'Yes') {

						if ($row['options']['discount'] > 0) {

							$row['price'] = $row['options']['orginalPrice'] - ($row['options']['orginalPrice'] * ($row['options']['discount'] / 100));
						}
					} else {
						$row['price'] = $row['options']['orginalPrice'] - $row['options']['discount'];
					}
				} else {

					$row['options']['membershipStatus'] = "Pending";
					$row['options']['paymentType'] = "Full Price";
					$row['price'] = $row['options']['orginalPrice'];
				}
			}

			if (isset($new_cart[$row['options']['ref']])) {

				$new_cart[$row['options']['ref']]['qty'] = $row['qty'] + $new_cart[$row['options']['ref']]['qty'];
				$new_cart[$row['options']['ref']]['scheduleDate'][] = $row['options']['scheduleDate'];
				$sub_date[$row['options']['scheduleDate']] = $row['options'];
				$new_cart[$row['options']['ref']]['scheduleDateOptions'] = $sub_date;
			} else {

				$new = array();
				$new['id'] = $row['id'];
				$new['qty'] = $row['qty'];
				$new['price'] = $row['price'];
				$new['name'] = $row['name'];
				$new['options'] = $row['options'];
				$new['rowid'] = $row['rowid'];
				$new['payDebit'] = $row['options']['payDebit'];
				$new['pType'] = $row['options']['pType'];
				$new['scheduleDate'][] = $row['options']['scheduleDate'];
				$sub_date[$row['options']['scheduleDate']] = $row['options'];
				$new['scheduleDateOptions'] = $sub_date;
				$new_cart[$row['options']['ref']] = $new;
			}

			$a++;
		}

		$this->cart->destroy();
		$this->cart->insert($new_cart);
		$this->data['cart_data_new'] = $new_cart;
		$this->load->view('cart', $this->data);
	}

	public function add()
	{

		$insert_cart_ids = array();
		$testId = $this->input->post('testId');
		$test = $this->db->query('select tests.* from tests WHERE testId=' . $testId)->row();

		if (!$test) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Something Wrong';
			echo json_encode($response);
			exit();
		}
		if ($test->productType == 'MealPrep') {

			$diet = $this->input->post('diet');
			$alergies = $this->input->post('alergies');
			$alergies_detail = $this->input->post('alergies_detail');
			$meals = $this->input->post('meals');
			$delivery = $this->input->post('delivery');
			$wantMore = $this->input->post('wantMore');
			$notWant = $this->input->post('notWant');
			$additional = $this->input->post('additional');
			$extra = array();
			$extra['diet'] = $diet;
			$extra['alergies'] = $alergies;
			$extra['alergies_detail'] = $alergies_detail;
			$extra['meals'] = $meals;
			$extra['delivery'] = $delivery;
			$extra['wantMore'] = $wantMore;
			$extra['notWant'] = $notWant;
			$extra['additional'] = $additional;
		} else {

			$extra = array();
		}

		if ($this->membership_data->expire == false) {

			$this->check_ajax_login();
			$this->form_validation->set_rules('purchaseType', 'Purchase Type', 'required');
			$this->form_validation->set_rules('Qty', 'Quantity', 'required');
			if ($this->form_validation->run() == FALSE) {

				$error = validation_errors();
				$response = array();
				$response['code'] = 0;
				$response['message'] = $error;
				echo json_encode($response);
				exit();
			} else {

				$purchaseType = $this->input->post('purchaseType');
				$startMonth = $this->input->post('startMonth');
				$quantity = $this->input->post('Qty');

				if ($purchaseType != 'Regular') {

					if (!($startMonth > 0 && $startMonth < 13)) {

						$startMonth = date('m', strtotime('now'));
						$startDate = date('Y-m-d', strtotime('now'));
					} else {

						if ($startMonth >= date('m')) {

							$day = date('d', strtotime('now'));
							$year = date('Y', strtotime('now'));
						} else {

							$ydate = date('Y-m-d', strtotime(' +1 year'));
							$day = date('d', strtotime($ydate));
							$year = date('Y', strtotime($ydate));
						}

						$startDate = $year . '-' . sprintf("%02d", $startMonth) . '-' . $day;
					}

					$month_number = $startMonth;
					$date = $startDate;
					$year_number = date('Y', strtotime($date));
					$availble_orders = $this->available_orders($month_number, $year_number);
					$scheduleDate = $year_number . '-' . $month_number . '-' . date('d');
					$originalPrice = $test->originalPrice;

					$mprice = 0;
					if ($test->discountPercentage == 'Yes') {
						if ($test->discountPrice > 0) {
							$mprice = $originalPrice - ($originalPrice * ($test->discountPrice / 100));
						}
					} else {
						$mprice = $originalPrice - $test->discountPrice;
					}

					$uqty = $quantity;
					$cart_qty = 0;
					if ($uqty > $availble_orders) {
						$cart_qty = $availble_orders;
						$uqty = $uqty - $availble_orders;
					} else {
						$cart_qty = $uqty;
						$uqty = $uqty - $uqty;
					}

					if ($cart_qty > 0) {
						$membershipDate = date('Y-m-d', strtotime($scheduleDate));
						$price = $mprice;
						$paymentType = 'Membership';

						if ($this->membership_data->period_end >= strtotime($membershipDate)) {
							$membershipStatus = 'Active';
						} else {
							$membershipStatus = 'InActive';
						}

						$ref_id = randomString();
						$payDebit = 'No';
						$pType = 'One Time';

						$data =  array(
							'id'      => $testId,
							'qty'     => $cart_qty,
							'price'   => $price,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => $purchaseType, 'discountPercentage' => $test->discountPercentage, 'discountedPrice' => $test->discountedPrice, 'discount' => $test->discountPrice, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => $membershipDate, 'membershipStatus' => $membershipStatus, 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);
						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();

						if ($lid != '') {
							$insert_cart_ids[] = $lid;
						}
					}

					if ($uqty > 0) {

						$ref_id = randomString();
						$payDebit = 'No';
						$pType = 'One Time';


						$price = $originalPrice;
						$paymentType = 'Full Price';
						$data =  array(
							'id'      => $testId,
							'qty'     => $uqty,
							'price'   => $price,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => 'payFull', 'discountPercentage' => $test->discountPercentage, 'discountedPrice' => $test->discountedPrice, 'discount' => $test->discountPrice, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => '', 'membershipStatus' => 'Pending', 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);
						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();

						if ($lid != '') {
							$insert_cart_ids[] = $lid;
						}
					}
				} else {

					$regularType = $this->input->post('regularType');

					if (!($startMonth > 0 && $startMonth < 13)) {

						$startMonth = date('m', strtotime('now'));
						$startDate = date('Y-m-d', strtotime('now'));
					} else {

						if ($startMonth >= date('m')) {

							$day = date('d', strtotime('now'));
							$year = date('Y', strtotime('now'));
						} else {

							$ydate = date('Y-m-d', strtotime(' +1 year'));
							$day = date('d', strtotime($ydate));
							$year = date('Y', strtotime($ydate));
						}
						$startDate = $year . '-' . sprintf("%02d", $startMonth) . '-' . $day;
					}

					$month_number = $startMonth;
					$date = $startDate;
					if ($regularType == 'Month') {
						$inc = 1;
					} else if ($regularType == 'Quarterly') {
						$inc = 3;
					} else if ($regularType == 'Semi Annually') {
						$inc = 6;
					}

					$ref_id = randomString();
					$payDebit = 'No';
					$pType = 'Regular';

					$mm = '';

					for ($i = 1; $i <= $quantity; $i++) {

						if ($i != 1) {

							$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +' . $inc . ' month'));
							$month_number = date('m', strtotime($date));
						}

						$year_number = date('Y', strtotime($date));
						$availble_orders = $this->available_orders($month_number, $year_number);
						$scheduleDate = $year_number . '-' . $month_number . '-' . date('d');
						$originalPrice = 0;
						$originalPrice = $test->originalPrice;

						$mprice = 0;

						if ($test->discountPercentage == 'Yes') {
							if ($test->discountPrice > 0) {
								$mprice = $originalPrice - ($originalPrice * ($test->discountPrice / 100));
							}
						} else {
							$mprice = $originalPrice - $test->discountPrice;
						}

						$uqty = 1;
						$cart_qty = 0;
						if ($uqty > $availble_orders) {
							$cart_qty = $availble_orders;
							$uqty = $uqty - $availble_orders;
						} else {
							$cart_qty = $uqty;
							$uqty = $uqty - $uqty;
						}

						if ($i == 1) {
							if ($cart_qty > 0) {
								$mm = 'Membership';
							} else {
								$mm = 'Full Price';
							}
						}

						if ($mm == 'Membership') {

							$membershipDate = date('Y-m-d', strtotime($scheduleDate));
							$price = $mprice;
							$paymentType = 'Membership';

							if ($this->membership_data->period_end >= strtotime($membershipDate)) {
								$membershipStatus = 'Active';
							} else {
								$membershipStatus = 'InActive';
							}

							$data =  array(
								'id'      => $testId,
								'qty'     => 1,
								'price'   => $price,
								'name'    => clean_string($test->testName),
								'options' => array('regularType' => $regularType, 'discount' => $test->discountPrice, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => $membershipDate, 'membershipStatus' => $membershipStatus, 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
							);

							$this->cart->insert($data);
							$lid = $this->get_last_cart_id();

							if ($lid != '') {
								$insert_cart_ids[] = $lid;
							}
						} else {



							$price = $price + $originalPrice;

							$membershipDate = date('Y-m-d', strtotime($scheduleDate));
							$paymentType = 'Membership Price';

							if ($this->membership_data->period_end >= strtotime($membershipDate)) {
								$membershipStatus = 'Active';
							} else {
								$membershipStatus = 'InActive';
							}

							$data =  array(
								'id'      => $testId,
								'qty'     => 1,
								'price'   => $mprice,
								'name'    => clean_string($test->testName),
								'options' => array('regularType' => $regularType, 'discount' => $test->discountPrice, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => $membershipDate, 'membershipStatus' => $membershipStatus, 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
							);

							$this->cart->insert($data);
							$lid = $this->get_last_cart_id();

							if ($lid != '') {
								$insert_cart_ids[] = $lid;
							}
						}
					}
				}
				$response = array();
				$response['code'] = 1;
				$response['message'] = 'Add to cart Successfully';
				echo json_encode($response);
				exit();
			}
		} else {

			$this->form_validation->set_rules('purchaseType', 'Purchase Type', 'required');
			$this->form_validation->set_rules('Qty', 'Quantity', 'required');

			if ($this->form_validation->run() == FALSE) {

				$error = validation_errors();
				$response = array();
				$response['code'] = 0;
				$response['message'] = $error;
				echo json_encode($response);
				exit();
			} else {

				$purchaseType = $this->input->post('purchaseType');
				$qty = $this->input->post('Qty');
				$scheduleDate = date('Y-m-d', strtotime('now'));
				$regularType = $this->input->post('regularType');

				if ($purchaseType == 'Regular' && $this->session_data) {

					if ($qty < 4) {

						$response = array();
						$response['code'] = 0;
						$response['message'] = 'Minimum 4 items in ' . $regularType . ' are allowed for the non-members.';
						echo json_encode($response);
						exit();
					}
					if ($regularType == 'Month') {
						$inc = 1;
					} else if ($regularType == 'Quarterly') {
						$inc = 3;
					} else if ($regularType == 'Semi Annually') {
						$inc = 6;
					}

					$ref_id = randomString();
					$payDebit = 'No';
					$pType = 'Regular';
					$directDebit = 'No';

					for ($k = 1; $k <= $qty; $k++) {

						$price = $originalPrice = $test->originalPrice;
						$paymentType = 'Discounted Price';

						if ($k != 1) {

							$scheduleDate = $date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($scheduleDate)) . ' +' . $inc . ' month'));
						}

						$mprice = 0;

						if ($test->discountPercentage == 'Yes') {

							if ($test->discountPrice > 0) {
								$mprice = $originalPrice - ($originalPrice * ($test->discountPrice / 100));
							}
						} else {

							$mprice = $price - $test->discountPrice;
						}


						$data =  array(
							'id'      => $testId,
							'qty'     => 1,
							'price'   => $mprice,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => $regularType, 'directDebit' => $directDebit, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => '', 'membershipStatus' => 'Pending', 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);

						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();
						if ($lid != '') {

							$insert_cart_ids[] = $lid;
						}
					}
				}

				if ($purchaseType != 'Regular' && $this->session_data) {

					$regularType = $this->input->post('regularType');
					if ($qty < 1) {
						$response = array();
						$response['code'] = 0;
						$response['message'] = 'Minimum 1 items in ' . $regularType . ' are allowed for the non-members.';
						echo json_encode($response);
						exit();
					}

					$ref_id = randomString();
					$payDebit = 'No';
					$pType = 'Regular';
					$directDebit = 'No';

					for ($k = 1; $k <= $qty; $k++) {

						$price = $originalPrice = $test->originalPrice;
						$paymentType = 'Full Price';

						$data =  array(
							'id'      => $testId,
							'qty'     => 1,
							'price'   => $price,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => $regularType, 'ref' => $ref_id, 'directDebit' => $directDebit, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => '', 'membershipStatus' => 'Pending', 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);

						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();

						if ($lid != '') {
							$insert_cart_ids[] = $lid;
						}
					}
				}

				//Purchase type is regular and user has not registered
				else if ($purchaseType == 'Regular' && !$this->session_data) {

					if ($qty < 4) {
						$response = array();
						$response['code'] = 0;
						$response['message'] = 'Minimum 4 items in ' . $regularType . ' are allowed for the non-members.';
						echo json_encode($response);
						exit();
					}
					if ($regularType == 'Month') {
						$inc = 1;
					} else if ($regularType == 'Quarterly') {
						$inc = 3;
					} else if ($regularType == 'Semi Annually') {
						$inc = 6;
					}

					$ref_id = randomString();
					$payDebit = 'No';
					$pType = 'Regular';
					$directDebit = 'No';

					for ($k = 1; $k <= $qty; $k++) {
						$price = $originalPrice = $test->originalPrice;
						$paymentType = 'Discounted Price';
						if ($k != 1) {
							$scheduleDate = $date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($scheduleDate)) . ' +' . $inc . ' month'));
						}
						$mprice = 0;
						if ($test->discountPercentage == 'Yes') {

							if ($test->discountPrice > 0) {
								$mprice = $originalPrice - ($originalPrice * ($test->discountPrice / 100));
							}
						} else {
							$mprice = $price - $test->discountPrice;
						}


						$data =  array(
							'id'      => $testId,
							'qty'     => 1,
							'price'   => $mprice,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => $regularType, 'directDebit' => $directDebit, 'ref' => $ref_id, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => '', 'membershipStatus' => 'Pending', 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);
						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();
						if ($lid != '') {
							$insert_cart_ids[] = $lid;
						}
					}
				} else if ($purchaseType != 'Regular' && !$this->session_data) {

					$regularType = $this->input->post('regularType');
					if ($qty < 1) {
						$response = array();
						$response['code'] = 0;
						$response['message'] = 'Minimum 1 item in ' . $regularType . ' are allowed for the non-members.';
						echo json_encode($response);
						exit();
					}


					$ref_id = randomString();
					$payDebit = 'No';
					$pType = 'Regular';
					$directDebit = 'No';
					for ($k = 1; $k <= $qty; $k++) {
						$price = $originalPrice = $test->originalPrice;
						$paymentType = 'Full Price';


						$data =  array(
							'id'      => $testId,
							'qty'     => 1,
							'price'   => $price,
							'name'    => clean_string($test->testName),
							'options' => array('regularType' => $regularType, 'ref' => $ref_id, 'discountPercentage' => $test->discountPercentage, 'discountedPrice' => $test->discountedPrice, 'discount' => $test->discountPrice, 'directDebit' => $directDebit, 'payDebit' => $payDebit, 'pType' => $pType, 'paymentStatus' => 'Yes', 'membershipDate' => '', 'membershipStatus' => 'Pending', 'scheduleDate' => $scheduleDate, 'paymentType' => $paymentType, 'productType' => $test->productType, 'orginalPrice' => $originalPrice, 'image' => $test->testLogo, 'extra' => $extra)
						);
						$this->cart->insert($data);
						$lid = $this->get_last_cart_id();
						if ($lid != '') {
							$insert_cart_ids[] = $lid;
						}
					}
				} else {
				}
			}


			$response = array();
			$response['message'] = 'Add to cart Successfully';
			echo json_encode($response);
			exit();
		}
	}


	public function destroy_cart_ids($row)
	{

		foreach ($row as $v) {
			$this->cart->remove($v);
		}
	}



	public function get_last_cart_id()
	{

		$last_id = '';

		foreach ($this->cart->contents() as $row) {
			$last_id = $row['rowid'];
		}

		return $last_id;
	}



	public function available_orders($month_number, $year)
	{

		$rrr = $this->db->query('select detailQty as total from order_details WHERE 
        userId=' . $this->session_data->userId . ' AND regularType="One Time"
        AND paymentType="Membership" AND YEAR(membershipDate)=' . $year . '  AND MONTH(membershipDate)=' . $month_number . ' group by orderId')->result();

		$available_orders = 0;
		foreach ($rrr as $r) {
			$available_orders += $r->total;
		}

		if ($this->membership_data->orders > 0) {

			if ($available_orders) {

				$available_orders = $this->membership_data->orders - $available_orders;
			} else {

				$available_orders = $this->membership_data->orders;
			}

			if ($available_orders < 1) {

				$available_orders = 0;
			}
		} else {

			$available_orders = 0;
		}

		$cart = $this->cart->contents();

		foreach ($cart as $item) {

			if ($item['options']['membershipDate'] != '') {

				if (strtotime(date('Y-m', strtotime($item['options']['membershipDate']))) == strtotime($year . '-' . $month_number)) {
					$available_orders -= $item['qty'];
				}
			}
		}

		return $available_orders;
	}



	public function get_product_detail()
	{

		$testId = $this->input->post('testId');
		$test = $this->db->query('select tests.* from tests WHERE testId=' . $testId)->row();

		if (!$test) {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Something Wrong';
			echo json_encode($response);
			exit();
		}
		if ($test->productType == 'MealPrep') {

			$diet = $this->input->post('diet');
			$alergies = $this->input->post('alergies');
			$alergies_detail = $this->input->post('alergies_detail');
			$meals = $this->input->post('meals');
			$delivery = $this->input->post('delivery');
			$wantMore = $this->input->post('wantMore');
			$notWant = $this->input->post('notWant');
			$additional = $this->input->post('additional');

			if ($wantMore != '') {
				$wantMore = implode(',', $wantMore);
			}
			if ($notWant != '') {
				$notWant = implode(',', $notWant);
			}

			$html = '<input type="hidden" name="diet" value="' . $diet . '">
			<input type="hidden" name="alergies" value="' . $alergies . '">
			<input type="hidden" name="alergies_detail" value="' . $alergies_detail . '">
			<input type="hidden" name="meals" value="' . $meals . '">
			<input type="hidden" name="delivery" value="' . $delivery . '">
			<input type="hidden" name="wantMore" value="' . $wantMore . '">
			<input type="hidden" name="notWant" value="' . $notWant . '">
			<input type="hidden" name="additional" value="' . $additional . '">' .
				'';
		} else {
			$html = '';
		}

		if ($this->membership_data->expire == false) {

			$this->check_ajax_login();
			$this->form_validation->set_rules('purchaseType', 'Purchase Type', 'required');
			$this->form_validation->set_rules('Qty', 'Quantity', 'required');

			if ($this->form_validation->run() == FALSE) {

				$error = validation_errors();
				$response = array();
				$response['code'] = 0;
				$response['message'] = $error;
				echo json_encode($response);
				exit();
			} else {

				$purchaseType = $this->input->post('purchaseType');
				$Qty = $this->input->post('Qty');
				$startMonth = $this->input->post('startMonth');
				if ($purchaseType == 'Regular') {

					$regularType = $this->input->post('regularType');

					if (!($startMonth > 0 && $startMonth < 13)) {

						$startMonth = date('m', strtotime('now'));
						$startDate = date('Y-m-d', strtotime('now'));
					} else {

						if ($startMonth >= date('m')) {

							$day = date('d', strtotime('now'));
							$year = date('Y', strtotime('now'));
						} else {

							$ydate = date('Y-m-d', strtotime(' +1 year'));
							$day = date('d', strtotime($ydate));
							$year = date('Y', strtotime($ydate));
						}

						$startDate = $year . '-' . sprintf("%02d", $startMonth) . '-' . $day;
					}

					$month_number = $startMonth;
					$date = $startDate;
					$html .= '<input type="hidden" name="purchaseType" value="' . $purchaseType . '">
							<input type="hidden" name="regularType" value="' . $regularType . '">
							';

					for ($i = 0; $i < 12; $i++) {

						$sQty = 0;

						if ($i != 0) {

							$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
							$month_number = date('m', strtotime($date));
						}
						if ($regularType == 'Month') {

							if ($Qty > 0) {
								$sQty = 1;
								$Qty--;
							}
						} else {

							if ($i == 0) {

								$fdate = $date;
								$lastDate = date('Y-m-t', strtotime($date));
							} else {

								$fdate = date('Y-m-01', strtotime($date));
								$lastDate = date('Y-m-t', strtotime($date));
							}

							$dateDiff = dateDiff($lastDate, $fdate);

							if (isset($dateDiff['Weeks'])) {

								$week = $dateDiff['Weeks'];

								if ($Qty > 0) {

									if ($Qty > $week) {
										$sQty = $week;
										$Qty = $Qty - $week;
									} else {
										$sQty = $Qty;
										$Qty = 0;
									}
								}
							}
						}

						$year_number = date('Y', strtotime($date));
						$availble_orders = $this->available_orders($month_number, $year_number);

						$month_name = $this->get_month($date);
						$html .= '<tr>
								<td><input type="number" name="sqty[]" class="form-control" min="0" value="' . $sQty . '"></td>
								<td class="text-center">' . $month_name . '</td>
								<td><input type="number" name="uorders[]" class="form-control" min="0" value="0"></td>
								<td class="text-center">' . $availble_orders . '</td>
								<input type="hidden" name="smonth[]"  value="' . $date . '">
								<input type="hidden" name="sorders[]" value="' . $availble_orders . '">
							</tr>
						';
					}

					$response = array();
					$response['code'] = 1;
					$response['message'] = $html;
					echo json_encode($response);
					exit();
				} else {

					if (!($startMonth > 0 && $startMonth < 13)) {

						$startMonth = date('m', strtotime('now'));
						$startDate = date('Y-m-d', strtotime('now'));
					} else {

						if ($startMonth >= date('m')) {

							$day = date('d', strtotime('now'));
							$year = date('Y', strtotime('now'));
						} else {

							$ydate = date('Y-m-d', strtotime(' +1 year'));
							$day = date('d', strtotime($ydate));
							$year = date('Y', strtotime($ydate));
						}

						$startDate = $year . '-' . sprintf("%02d", $startMonth) . '-' . $day;
					}

					$month_number = $startMonth;
					$date = $startDate;
					$html .= '<input type="hidden" name="purchaseType" value="' . $purchaseType . '">';

					for ($i = 0; $i < 12; $i++) {

						if ($i != 0) {

							$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
							$month_number = date('m', strtotime($date));

							$Qty = 0;
						}

						$year_number = date('Y', strtotime($date));
						$availble_orders = $this->available_orders($month_number, $year_number);

						$month_name = $this->get_month($date);
						$html .= '<tr>
								<td><input type="number" name="sqty[]" class="form-control" min="0" value="' . $Qty . '"></td>
								<td class="text-center">' . $month_name . '</td>
								<td class="text-center">' . $availble_orders . '</td>
								<input type="hidden" name="smonth[]"  value="' . $date . '">
								<input type="hidden" name="sorders[]" value="' . $availble_orders . '">
							</tr>
						';
					}

					$response = array();
					$response['code'] = 1;
					$response['message'] = $html;
					echo json_encode($response);
					exit();
				}
			}
		}
	}



	public function delete_item()
	{

		$rowid = $this->input->post('id');

		if ($rowid != '') {

			foreach ($this->cart->contents() as $row) {

				if ($row['options']['ref'] == $rowid) {

					$data = array(
						'rowid' => $row['rowid'],
						'qty'   => 0
					);

					$this->cart->update($data);
				}
			}

			$this->refresh_cart();

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'Deleted Successfully!';
			echo json_encode($response);
			exit();
		} else {
			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Something Wrong!';
			echo json_encode($response);
			exit();
		}
	}



	public function refresh_cart()
	{

		/*
        if ($this->membership_data->expire == false) {
        $cart=$this->cart->contents();
        function sortByOrder($a, $b) {
            return $b['price'] - $a['price'];
        }        
        usort($cart, 'sortByOrder');
        $groupCart=array();
       
       
        foreach($cart as $crow)
        {
            if($crow['options']['membershipDate']!='')
            {
              $date=$crow['options']['membershipDate'];
              
            }
            else
            {
                $date=$crow['options']['scheduleDate'];               
            }
            
          $month_number = date('m', strtotime($date));
          $year_number = date('Y', strtotime($date));
          $groupCart[$year_number.'-'.$month_number][]=$crow;
        }  
        
        foreach($groupCart as $key=>$gc)
        {
            foreach($gc as $row)
            {
                $key_e=explode('-',$key);
                $month_number = isset($key_e[1])?$key_e[1]:01;
                $year_number = isset($key_e[0])?$key_e[0]:1992;
                $availble_orders=$this->available_orders($month_number,$year_number);
                if($availble_orders>0 && $row['options']['membershipDate']=='')
                {
                    //delete old item //
                    $data_del = array(
        				'rowid' => $row['rowid'],
        				'qty'   =>0
        			);
        			$this->cart->update($data_del);                   
                    
                    
                    $testId=$row['id'];
                    $scheduleDate=$year_number.'-'.$month_number.'-'.date('d');
                    $test=$this->db->query('select tests.* from tests WHERE testId='.$testId)->row();
                    $originalPrice=$test->originalPrice;
				    $mprice=0;
				    if($test->discountPercentage=='Yes')
				    {
					   if($test->discountPrice>0)
					   {
						   $mprice=$originalPrice-($originalPrice*($test->discountPrice/100));
					   }

				    }else
				    {
					   $mprice=$originalPrice-$test->discountPrice;
				    }
                    $uqty=$row['qty'];
                    $cart_qty=0;
				    if($uqty>$availble_orders)
				    {
					   $cart_qty=$availble_orders;
					   $uqty=$uqty-$availble_orders;
				    }
				    else
				    {
					   $cart_qty=$uqty;
					   $uqty=$uqty-$uqty;
				    }
                    
                    if($cart_qty>0)
				    {//membership orders//
					   $membershipDate=date('Y-m-d',strtotime($scheduleDate));
					   //$price=$mprice*$cart_qty;
					   $price=$mprice;
					   $paymentType='Membership';
					   if($this->membership_data->period_end>=strtotime($membershipDate))
					   {
						   $membershipStatus='Active';
					   }
					   else
					   {
						   $membershipStatus='InActive';
					   }
					   $data =  array(
						   'id'      => $testId,
						   'qty'     => $cart_qty,
						   'price'   => $price,
						   'name'    => clean_string($test->testName),
						   'options' => array('paymentStatus'=>$row['options']['paymentStatus'],'membershipDate'=>$membershipDate,'membershipStatus'=>$membershipStatus,'scheduleDate'=>$scheduleDate,'paymentType'=>$paymentType,'productType'=>$test->productType,'orginalPrice'=>$originalPrice,'image'=>$test->testLogo,'extra'=>$row['options']['extra'])
					   );
					   $this->cart->insert($data);					   
				   }
                    
                   if($uqty>0)
				   { //full price //
					   $price=$originalPrice;
					   $paymentType='Full Price';
					   $data =  array(
						   'id'      => $testId,
						   'qty'     => $uqty,
						   'price'   => $price,
						   'name'    => clean_string($test->testName),
						   'options' => array('paymentStatus'=>$row['options']['paymentStatus'],'membershipDate'=>'','membershipStatus'=>'Pending','scheduleDate'=>$scheduleDate,'paymentType'=>$paymentType,'productType'=>$test->productType,'orginalPrice'=>$originalPrice,'image'=>$test->testLogo,'extra'=>$row['options']['extra'])
					   );
					   $this->cart->insert($data);
					  
				   }
                    
                    
                }
            }
        }
        
        }
        */
	}



	public function change_status()
	{

		$id = $this->input->post('id');
		$type = $this->input->post('type');

		if ($id != '') {

			if ($type != 'No') {
				$type = 'Yes';
			}

			foreach ($this->cart->contents() as $row) {

				if ($row['options']['ref'] == $id) {

					$data =  array(
						'rowid' =>  $row['rowid'],
						'id'      => $row['id'],
						'qty'     => $row['qty'],
						'price'   => $row['price'],
						'name'    => $row['name'],
						'options' => array('regularType' => $row['options']['regularType'], 'ref' => $row['options']['ref'], 'payDebit' => $type, 'pType' => $row['options']['pType'], 'paymentStatus' => $row['options']['paymentStatus'], 'membershipDate' => $row['options']['membershipDate'], 'membershipStatus' => $row['options']['membershipStatus'], 'scheduleDate' => $row['options']['scheduleDate'], 'paymentType' => $row['options']['paymentType'], 'productType' => $row['options']['productType'], 'orginalPrice' => $row['options']['orginalPrice'], 'image' => $row['options']['image'], 'extra' => $row['options']['extra'])
					);

					$this->cart->update($data);
				}
			}

			$response = array();
			$response['code'] = 1;
			$response['message'] = 'updated successfully';
			echo json_encode($response);
			exit();
		} else {

			$response = array();
			$response['code'] = 0;
			$response['message'] = 'Item not exist!';
			echo json_encode($response);
			exit();
		}
	}



	public function get_month($date)
	{

		return date('F Y', strtotime($date));
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



	public function test()
	{

		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);
		$product = \Stripe\Product::create([
			'name' =>  'alex 123',
			'type' => 'service',
		]);

		$new_plan_id = drandomString(10);

		$new_plan = \Stripe\Plan::create(array(
			'currency' => 'GBP',
			'interval' => 'month',
			'interval_count' => 1,
			'product' => $product->id,
			'nickname' => 'Test Plan',
			'amount' => 30 * 100,
			'id' => $new_plan_id
		));

		print_r($new_plan);
		exit();
	}
}
