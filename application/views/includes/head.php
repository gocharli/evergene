<!DOCTYPE html>
<html lang="en">
<head>

	<?php 

		$testing_version = $this->db->query("select settingValue from settings where settingOption = 'testing_version' ")->row()->settingValue;

		if($testing_version == 1){
			if (!isset($this->session->userdata('admin')->adminID)){
	?>
				<meta charset="utf-8">
				<meta http-equiv="x-ua-compatible" content="ie=edge">
				<title>Coming Soon</title>
				<meta name="description" content="">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<!-- Favicon -->

				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
				<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

				<link rel="stylesheet" href="<?=base_url()?>assets/coming-soon/style.css">
				<link rel="stylesheet" href="<?=base_url()?>assets/coming-soon/responsive.css">
				<link rel="stylesheet" href="<?=base_url()?>assets/coming-soon/coming-soon.css">
	<?php
			}
		}
		else{
	?>
			<meta charset="UTF-8">
			<!-- For IE -->
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<!-- For Resposive Device -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?=$page_title?></title>
			<!-- Favicon -->
			<link rel="icon" type="image/png" sizes="56x56" href="<?=base_url('assets/front/')?>images/fav-icon/icon.png">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

			<!-- Main style sheet -->
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/front/')?>css/style.css">
			<!-- responsive style sheet -->
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/front/')?>css/responsive.css">
			<link href="<?=base_url()?>assets/plugins/jquery-confirm/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
			<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/front/ex_css/bootstrap-datetimepicker.min.css"/>

			<style type="text/css">
				.upgrade_to_premium{
					margin-right: 15px;
					float: right;
					margin-top: 0px;
				}
			</style>
	<?php
		}
	?>
</head>

	<?php 
	
	if(isset($this->session->userdata('users')->loginIP)) {
		$otherip = $this->db->query("select loginIP from users where userId = ".$this->session->userdata('users')->userId)->row()->loginIP;
		if($this->input->ip_address() != $otherip){ // user is login from other device/ip
			redirect('logout');
		}
	}
	
	$testing_version = $this->db->query("select settingValue from settings where settingOption = 'testing_version' ")->row()->settingValue;

	if($testing_version == 1){

		if (!isset($this->session->userdata('admin')->adminID)){
	?>
			<body>

				<div class="wrapper">
					<div id="overlay"></div>
					<main class="content">
						<h1>COMING SOON!</h1>
						<div class="countdown">
							<div class="countdown__days">
								<div class="number"></div>
								<span class>Days</span>
							</div>
							<div class="countdown__hours">
								<div class="number"></div>
								<span class>Hours</span>
							</div>
							<div class="countdown__minutes">
								<div class="number"></div>
								<span class>Minutes</span>
							</div>
							<div class="countdown__seconds">
								<div class="number"></div>
								<span class>Seconds</span>
							</div>
						</div>

						<p>Our website is under construction. </p> <p>We`ll be here soon with our new awesome site.</p>

					</main>
				</div>
			
				<script>
					(() => {
					// Specify the deadline date
					const deadlineDate = new Date('August 31, 2020 23:59:59').getTime();

					// Cache all countdown boxes into consts
					const countdownDays = document.querySelector('.countdown__days .number');
					const countdownHours= document.querySelector('.countdown__hours .number');
					const countdownMinutes= document.querySelector('.countdown__minutes .number');
					const countdownSeconds= document.querySelector('.countdown__seconds .number');

					// Update the count down every 1 second (1000 milliseconds)
					setInterval(() => {    
					// Get current date and time
					const currentDate = new Date().getTime();

					// Calculate the distance between current date and time and the deadline date and time
					const distance = deadlineDate - currentDate;

					// Calculations the data for remaining days, hours, minutes and seconds
					const days = Math.floor(distance / (1000 * 60 * 60 * 24));
					const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					const seconds = Math.floor((distance % (1000 * 60)) / 1000);

					// Insert the result data into individual countdown boxes
					countdownDays.innerHTML = days;
					countdownHours.innerHTML = hours;
					countdownMinutes.innerHTML = minutes;
					countdownSeconds.innerHTML = seconds;
					}, 1000);
					})();
				</script>
			</body>
	<?php
		 	exit;
		}
	}

	?>
