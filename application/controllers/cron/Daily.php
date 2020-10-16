<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Daily extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->premium_member_notification();
		$this->order_subscription_check();
		$this->check_pre_order_subscription();
	}
	// update profile feature every month
	public function premium_member_notification()
	{
		$users = $this->db->query('SELECT * FROM `memberships`
				LEFT JOIN users on memberships.userId=users.userId')->result();
		foreach ($users as $row) {
			$currnet = strtotime('now');
			if ($currnet < $row->period_end) {
				// check notification time //
				$cur_date = date('Y-m-d');
				$date = date('Y-m-d', $row->period_start);
				$date1 = date_create($cur_date);
				$date2 = date_create($date);
				$diff = date_diff($date1, $date2);
				if ($diff->d == 20 || $diff->d == 25 || $diff->d == 28) // || 1==1 )
				{
					$month_number = date('m', strtotime($row->$cur_date));
					$year = date('Y', strtotime($row->$cur_date));
					$available_orders = $this->db->query('select sum(detailQty) as total from order_details WHERE userId=' . $row->userId . ' AND paymentType="Membership" AND YEAR(membershipDate)=' . $year . '  AND MONTH(membershipDate)=' . $month_number)->row();

					if ($available_orders) {
						$available_orders = $available_orders->total;
					} else {
						$available_orders = 0;
					}
					// send email
					if ($row->noti_reminder > 0) {  // added by david
						$name = $row->userFirstName . ' ' . $row->userLastName;
						$to = 'davidmark0772@gmail.com';
						$subject = 'Premium Member Information';
						$content = '<h2>Premium Member Information</h2>';
						$content .= '<p>Hi ' . $name . ' you can order ' . $available_orders . ' items this month <Br><br></p>';
						$content .= '<div style="width:100px;margin:0 auto;"><a href="' . base_url() . '">Profile</a></div>';
						$message = $content;


						// Code added by david template

						$email_data['title'] = $name;
						$email_data['link'] = base_url() . 'tests';
						$email_data['available_orders'] = $available_orders;
						$message = $this->load->view('emails/reminder', $email_data, true);

						// End


						$this->smtp_email->send('', '', $to, $subject, $message);
					}
				}
			}
		}
	}
	public function order_subscription_check()
	{
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);

		$order_subscriptions = $this->db->query('SELECT * FROM `order_subscriptions` where planEnd=CURRENT_DATE()')->result();
		foreach ($order_subscriptions as $row) {
			$subscription = \Stripe\Subscription::retrieve($row->StripeSubscriptionID);
			$subscription->cancel(array('at_period_end' => true));

			if (isset($subscription->id)) {
				if ($subscription->id != "" && $subscription->status == "active") {
					$current_period_end = $subscription->current_period_end;
					$current_period_start = $subscription->current_period_start;
					$canceled_at = $subscription->canceled_at;
					$data = array();
					$data['period_start'] = $current_period_start;
					$data['period_end'] = $current_period_end;
					$data['StripeSubscriptionEnded'] = $canceled_at;
					$this->db->update('order_subscriptions', $data, array('subId' => $row->subId));
					$this->db->update('order_items_group', array('subscriptionCancel' => 'Yes'), array('orderGroupId' => $row->orderGroupId));
				}
			}
		}
	}
	public function check_pre_order_subscription()
	{
		require_once(APPPATH . 'libraries/stripe-php/init.php');
		$stripe_api_key = getenv('stripe_api_secret');
		\Stripe\Stripe::setApiKey($stripe_api_key);

		$order_details = $this->db->query('SELECT * FROM `order_details` where scheduleDate=CURRENT_DATE()')->result();
		foreach ($order_details as $row) {
			$expire = true;
			$currnet = strtotime('now');
			$mship = $this->db->query('SELECT * FROM memberships WHERE userId=' . $row->userId)->row();
			if ($mship) {
				if ($currnet < $mship->period_end) {
					$expire = false;
				} else {
					$expire = true;
				}
			}
			if ($expire == true) {
				// cancel subscription //                

				$order_subscriptions = $this->db->query('SELECT * FROM `order_subscriptions` where orderGroupId=' . $row->orderGroupId)->result();
				foreach ($order_subscriptions as $os) {
					$subscription = \Stripe\Subscription::retrieve($os->StripeSubscriptionID);
					$subscription->cancel(array('at_period_end' => true));

					if (isset($subscription->id)) {
						if ($subscription->id != "" && $subscription->status == "active") {
							$current_period_end = $subscription->current_period_end;
							$current_period_start = $subscription->current_period_start;
							$canceled_at = $subscription->canceled_at;
							$data = array();
							$data['period_start'] = $current_period_start;
							$data['period_end'] = $current_period_end;
							$data['StripeSubscriptionEnded'] = $canceled_at;
							$this->db->update('order_subscriptions', $data, array('subId' => $os->subId));
							$this->db->update('order_items_group', array('subscriptionCancel' => 'Yes'), array('orderGroupId' => $os->orderGroupId));
						}
					}
				}
			}
		}
	}
}
