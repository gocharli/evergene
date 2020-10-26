<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stripe_call extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);
		// Retrieve the request's body and parse it as JSON
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);
		if (isset($event_json->id)) {
			$res_test = $event_json->data->object;
			$test_sub_id = $res_test->id;
			$tt = array();
			$tt['SubscriptionID'] = $test_sub_id;
			$tt['text'] = $event_json->type;
			$this->db->insert('stripe_events', $tt);
			if ($event_json->type == 'customer.subscription.updated') {
				$res = $event_json->data->object;
				$sub_id = $res->id;
				$coustomer = $res->customer;
				$current_period_end = $res->current_period_end;
				$current_period_start = $res->current_period_start;

				$membership = $this->db->query('select * from memberships where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"')->row();
				if ($membership) {
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['createdAt'] = current_datetime();
					$data['StripeCustomerID'] = $coustomer;
					$data['StripeSubscriptionID'] = $sub_id;
					$data['StripeSubscriptionEnded'] = '';
					$plan = $this->db->query('select * from membership_plan where mpId=' . $membership->mpId)->row();
					if ($plan) {
						$data['orders'] = 1000;
						$data['ordersPeriod'] = $plan->planOrderPeriod;
					} else {
						$data['orders'] = 1000;
						$data['ordersPeriod'] = $membership->ordersPeriod;
					}
					$this->db->update('memberships', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));
				}

				// check order subscription //

				$order_subscriptions = $this->db->query('select * from order_subscriptions where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"')->row();
				if ($order_subscriptions) {
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['StripeCustomerID'] = $coustomer;
					$data['StripeSubscriptionID'] = $sub_id;
					$data['StripeSubscriptionEnded'] = '';
					$this->db->update('order_subscriptions', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));

					$order_details = $this->db->query('select * from order_details where orderGroupId="' . $order_subscriptions->orderGroupId . '" and MONTH(scheduleDate) = MONTH(CURRENT_DATE())
                    AND YEAR(scheduleDate) = YEAR(CURRENT_DATE())')->row();
					if ($order_details) {
						$data = array();
						$data['paymentStatus'] = 'Yes';
						$this->db->update('order_details', $data, array('detailId' => $order_details->detailId));
					}
				}
			} else if ($event_json->type == 'customer.subscription.deleted') {

				$res = $event_json->data->object;
				$sub_id = $res->id;
				$coustomer = $res->customer;
				//$created   =$res->created;
				$current_period_end = $res->current_period_end;
				$current_period_start = $res->current_period_start;
				$ended_at = $res->ended_at;
				$chk = $this->db->query('select * from memberships where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"');
				if ($chk->num_rows() == 1) {
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['StripeSubscriptionID'] = $sub_id;
					$data['StripeSubscriptionEnded'] = $ended_at;
					$this->db->update('memberships', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));
				}


				// check order subscription //

				$order_subscriptions = $this->db->query('select * from order_subscriptions where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"')->row();
				if ($order_subscriptions) {
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['StripeSubscriptionEnded'] = $ended_at;
					$data['StripeSubscriptionID'] = $sub_id;
					$this->db->update('order_subscriptions', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));
					$this->db->update('order_items_group', array('subscriptionCancel' => 'Yes'), array('orderGroupId' => $order_subscriptions->orderGroupId));
				}
			} else if ($event_json->type == 'customer.subscription.trial_will_end') {
				$res = $event_json->data->object;
				$sub_id = $res->id;
				$coustomer = $res->customer;
				$current_period_end = $res->current_period_end;
				$current_period_start = $res->current_period_start;

				$chk = $this->db->query('select * from memberships where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"');
				if ($chk->num_rows() == 1) {

					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['createdAt'] = current_datetime();
					$data['StripeCustomerID'] = $coustomer;
					$data['StripeSubscriptionID'] = $sub_id;
					$data['StripeSubscriptionEnded'] = '';
					$this->db->update('memberships', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));
				}

				$order_subscriptions = $this->db->query('select * from order_subscriptions where StripeCustomerID="' . $coustomer . '" and StripeSubscriptionID="' . $sub_id . '"')->row();
				if ($order_subscriptions) {
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['StripeSubscriptionEnded'] = '';
					$data['StripeSubscriptionID'] = $sub_id;
					$this->db->update('order_subscriptions', $data, array('StripeCustomerID' => $coustomer, 'StripeSubscriptionID' => $sub_id));

					$this->db->update('order_items_group', array('subscriptionCancel' => 'Yes'), array('orderGroupId' => $order_subscriptions->orderGroupId));
				}
			}
		}

		http_response_code(200);
	}
}
