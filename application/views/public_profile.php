<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- For IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- For Resposive Device -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="56x56" href="<?=base_url('assets/front/')?>images/fav-icon/icon.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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



<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
<div class="main-page-wrapper">


	<?php //$this->load->view('includes/menu'); ?>

	<div class="shop-page hub-page full-width">
		<div class="row">
			
			
			<div class="col-lg-12 col-md-8 col-sm-8 col-xs-12 float-right p-0">
				<div class="shop-product-wrapper service-version-one">

					<div class="row">
                        <?php $uu=$this->db->query('select * from users WHERE userId='.$row->userId)->row(); ?>
                        
						<div class="col-lg-12 col-xs-12">


							<div class="single-product">

								<div class="product-header">
									
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="product-list">

									<div class="row">
										<div class="col-lg-3 text-center">

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Exercise</label>
												<div class="b_ans"><?php if($row->excericseAvgWeek>0){ echo number_format($row->excericseAvgWeek).'/Week';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Sleep</label>
												<div class="b_ans"><?php if($row->sleepPerNight>0){ echo number_format($row->sleepPerNight).' Hours';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Steps</label>
												<div class="b_ans"><?php if($row->stepAvgDay>0){ echo number_format($row->stepAvgDay).'/Day';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Water</label>
												<div class="b_ans"><?php if($row->waterAvgDay>0){ echo number_format($row->waterAvgDay).'/Day';}else{ echo '---';} ?></div>

											</div><!--body info-->

										</div><!-- /.col- -->

										<div class="col-lg-6 text-center">

											<div class="human-body <?php if($row->gender == 'Male') echo 'human-body-male'; else echo 'human-body-female'; ?> ">

												<div class="age">
													<div>
														<span style="cursor: pointer" title="The age of a person"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														Years Old
														<span>
														<?php
														$age=age($row->dob);
														  if($age>0){ ?>
															<?=$age?> yrs
														  <?php } ?>
														</span>
													</div>
												</div><!--age-->

												<div class="height">
													<div>
													<span style="cursor: pointer" title="The height of the average North American male is 175.5 centimeters, a little over 5 foot 9 inches. The average US female is 162.5 cm, or 5 feet 4 inches."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														Height
														<span>
															<?php if($row->height>0) {
																echo number_point_format($row->height,1) . ' cm';
															} ?>
														</span>
													</div>
												</div><!--height-->

												<div class="hip-waist">
													<div>
													<span style="cursor: pointer" title="The waist-hip ratio or waist-to-hip ratio (WHR) is the dimensionless ratio of the circumference of the waist to that of the hips. According to the World Health Organization, a waist-to-hip ratio greater than 1.0 is indicative of a higher than normal risk of developing heart disease. A healthy WHR for women is under . 85 and a healthy WHR for men is . 90 or less."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														Hip/Waist Ratio
														<span>
															<?php if($row->waistMeasurment>0 && $row->hipMeasurment>0) {
																$wh=$row->waistMeasurment/$row->hipMeasurment;
																echo number_point_format($wh,1) . '';
															} ?>
														</span>
													</div>
												</div><!--Hip/Waist Ratio-->

												<div class="QRISK">
													<div>
													<span style="cursor: pointer" title="QRISK is an algorithm for predicting cardiovascular risk. It estimates the risk of a person developing cardiovascular disease (CVD) over the next 10 years and can be applied to those aged between 35 and 74 years. Those with a score of 20 per cent or more are considered to be at high risk of developing CVD."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														QRISK
														<span>2.5 .</span>
													</div>
												</div><!--QRISK-->

												<div class="Weight">
													<div>
													<span style="cursor: pointer" title="The average weight of an adult human is 137 pounds (62 kg) according to a league table of the world's 'fattest' nations from the London School of Hygiene & Tropical Medicine."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														Weight
														<span>
															<?php if($row->weight>0) {
																echo number_point_format($row->weight,1) . ' kg';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<div class="BMI">
													<div>
													<span style="cursor: pointer" title="If your BMI (Body mass index) is 18.5 to <25, it falls within the normal. If your BMI is 25.0 to <30, it falls within the overweight range. If your BMI is 30.0 or higher, it falls within the obese range."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														BMI
														<span>
															<?php if($row->weight>0 && $row->height>0) {
																$bmi=(($row->weight/$row->height)/$row->height)*10000;
																echo number_point_format($bmi,1) . '';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<div class="Heart-Age">
													<div>
													<span style="cursor: pointer" title="Heart age is a way to understand your risk of a heart attack or stroke. Your heart age is calculated based on your risk factors for heart disease, such as age and family history, as well as diet, physical activity and smoking. A younger heart age means a lower risk of heart disease.">i</a></span>
														Heart Age
														<span>###</span>
													</div>
												</div><!--Heart Age-->

											</div><!-- /human body- -->

										</div><!-- /.col- -->

										<div class="col-lg-3 text-center">

									
											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Heart Rate</label>

												<div class="b_ans"><?php if($row->restHeartRate>0){ echo number_format($row->restHeartRate).' bpm';}else{ echo '---';} ?></div>

											</div><!--body info-->


											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Blood Pressure</label>

												<div class="b_ans"><?php if($row->bloodPressure>0){ echo number_format($row->bloodPressure).' mmHg';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Cholesterol</label>
												<div class="b_ans"><?php if($row->cholesterol>0){ echo number_format($row->cholesterol).' ratio';}else{ echo '---';} ?></div>

											</div><!--body info-->


										</div><!-- /.col- -->

									</div>
								</div><!--product list-->

							</div> <!-- /.single-product -->

						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>


		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	
	
	<?php //$this->load->view('includes/footer'); ?>

	
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
