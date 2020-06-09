<!DOCTYPE html>
<html lang="en">
<head>
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
	
	if(isset($this->session->userdata('users')->loginIP)) {
		$otherip = $this->db->query("select loginIP from users where userId = ".$this->session->userdata('users')->userId)->row()->loginIP;
		if($this->input->ip_address() != $otherip){ // user is login from other device/ip
			redirect('logout');
		}
	}
	
	$testing_version = $this->db->query("select settingValue from settings where settingOption = 'testing_version' ")->row()->settingValue;

	if($testing_version == 1){
		
		// session_start();
		// if($_GET['test'] == 'yes') { 
		// 	$_SESSION["test"] = 'yes'; 
		// } 

		// if($_GET['test'] == 'no') { 
		// 	unset($_SESSION["test"]); 
		// }

		// if(isset($_SESSION["test"]) && $_SESSION["test"] =='yes'){
			
		// }else{
		// 	echo 'Site is in testing mode';
		// 	exit;
		// 	//redirect('coming_soon');
		// }

		if (!isset($this->session->userdata('admin')->adminID)){
			echo 'Site is in testing mode';
		 	exit;
		}
	}

	?>
