<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Month extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

	}
	public function index(){
		$this->account_updated_notification();
		$this->track();
	}
	// update profile feature every month
	public function account_updated_notification()
	{
		$users = $this->db->query('SELECT user_details.updatedAt,users.userEmail,users.userFirstName,users.userLastName FROM `user_details` 
		        LEFT JOIN users ON user_details.userId=users.userId')->result();
		foreach ($users as $row)
		{
			$email=$row->userEmail;
			if($row->updatedAt!='0000-00-00 00:00:00')
			{
				$cur_date=date('Y-m-d');
				$date=date('Y-m-d',strtotime($row->updatedAt));
				$date1=date_create($cur_date);
				$date2=date_create($date);
				$diff=date_diff($date1,$date2);
				if($diff->d>0)
				{
					if($diff->d==1)
					{
						$t='Not updated account in a month';
					}
					else
					{
						$t='Not updated account in '.$diff->d.' months';
					}
					// send email
					$name=$row->userFirstName.' '.$row->userLastName;
					$to=$email;
					$subject='Profile Updated';
					$content ='<h2>Profile Updated</h2>';
					$content .='<p>Hi '.$name.' '.$t.'<Br><br></p>';
					$content.='<div style="width:100px;margin:0 auto;"><a href="'.base_url().'">Profile</a></div>' ;
					//$email_data['content']= $content;
					//$message=$this->load->view('emails/general',$email_data,true);
					$message=$content;
					$this->smtp_email->send('','',$to,$subject,$message);
				}
			}
			else
			{
				// no updated profile Yet send email
				$name=$row->userFirstName.' '.$row->userLastName;
				$to=$email;
				$subject='Profile Updated';
				$content ='<h2>Profile Updated</h2>';
				$content .='<p>Hi '.$name.'. You cannot updated account yet.<Br><br></p>';
				$content.='<div style="width:100px;margin:0 auto;"><a href="'.base_url().'">Profile</a></div>' ;
				//$email_data['content']= $content;
				//$message=$this->load->view('emails/general',$email_data,true);
				$message=$content;
				$this->smtp_email->send('','',$to,$subject,$message);

			}

		}
	}
	public function track()
	{
		$users = $this->db->query('SELECT * FROM `users`
        WHERE userStatus="Active" AND userEmailStatus = "Verified"');
		foreach ($users->result() as $row)
		{
			$user_details = $this->db->query('SELECT * FROM `user_details` WHERE userId='.$row->userId)->row();
			if($user_details)
			{
				$bmi=$hip=$qrisk=$heart_attack=0;
				if($user_details->weight>0 && $user_details->height>0)
				{
					$bmi = (($user_details->weight / $user_details->height) / $user_details->height) * 10000;
					$bmi = number_point_format($bmi, 1);
				}
				if($user_details->waistMeasurment>0 && $user_details->hipMeasurment>0)
				{
					$hip = $user_details->waistMeasurment / $user_details->hipMeasurment;
					$hip = number_point_format($hip, 1);

				}


					$ins = array();
					$ins['userId'] = $row->userId;
					$ins['bmi'] = $bmi;
					$ins['hip']=$hip;
					$ins['qrisk']=$qrisk;
					$ins['heart_attack']=$heart_attack;
					$ins['date'] = date('Y-m-d');
					$this->db->insert('user_track_graph', $ins);

			}
		}
	}
}
