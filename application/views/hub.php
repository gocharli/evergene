<?php $this->load->view('includes/head');   ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<style>

.amber-color{
/* color: #d9f210 !important; */
border: 2px solid #d9f210 !important;
}

.red-color{
/* color: #fa5442 !important; */
border: 2px solid #fa5442 !important;
}

.gray-color{
/* color: #a19c9b !important; */
border: 2px solid #a19c9b !important;
}

.green-color{
/* color: #a19c9b !important; */
border: 2px solid #86c44c !important;
}

</style>


</head>

<body>
<div class="main-page-wrapper">


	<?php $this->load->view('includes/menu'); ?>

	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="shop-page hub-page full-width">
		<div class="row">
			<div class="col-lg-12 p-0 m-p-15 display-hub-dsk">
				<div class="title">
					<h5 class="pull-left" style="padding: 15px 0;">Welcome <?=$this->session_data->userFirstName?></h5>
					<?php $this->load->view('includes/recommend_friend');   ?>
					<?php $this->load->view('includes/upgarde_premium');   ?>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="clearfix"></div> 

			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15  display-hub-dsk">
				<?php $this->load->view('includes/sidebar'); ?>
			</div>

			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 float-right p-0">
				<div class="shop-product-wrapper service-version-one">

					<div class="row">
						<?php $uu=$this->db->query('select * from users WHERE userId='.$this->session_data->userId)->row(); 
						//echo '<pre>'; print_r($uu); 
						?>
                        <?php if($uu->userEmailStatus=='Unverified'){ ?>
                        <div class="col-lg-12">
							    <div class="col-lg-12 col-md-12 alert alert-warning" role="alert">
							        <div class="col-lg-10 col-md-10 p-0">
							            <p class="hub-error">	Confirmation email has been sent to your register email address please verify you email.</p>
							        </div>
							        <div class="col-lg-2 col-md-2 p-0">
							             <button onclick="resend_email()" style=" margin-top: 0px;padding: 0 10px;" class="tran3s cart-button btn-pay hvr-trim-two">Resend email</button>
							        </div>
							    </div>
						</div><!-- /.col- -->
                        <?php } ?>
                    
						<div class="col-lg-12">
							<div class="alert alert-success" role="alert">
								Welcome to the Evergene Hub where you can track your health and manage your test results…….
							</div>
						</div><!-- /.col- -->
						<div class="col-lg-12 col-xs-12">


							<div class="single-product">

								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>images/product/Cholesterol.png" alt=""/> You</h6>

									
									
									<?php if($row){ 
										
										if($row->updatedAt!='0000-00-00 00:00:00') { ?>

											<a href="<?=base_url('questionaire')?>" class="tran3s custom-btn">Update</a>

											<p class="update-date">

											<span>The date when the questionnaire was last updated: <?=date('d/m/y',strtotime($row->updatedAt))?> </span> <?php //=date('d,F Y',strtotime($row->updatedAt))?>
											</p>

										<?php } else{  ?>

											<a href="<?=base_url('questionaire')?>" class="tran3s custom-btn">Questionnaire</a>

												<p class="update-date">
												<span>Take the quiz to update your member hub</span>
											</p>

										<?php } 
									
									}else{ ?>

											<a href="<?=base_url('questionaire')?>" class="tran3s custom-btn">Questionnaire</a>

											<p class="update-date">
												<span>Take the quiz to update your member hub</span>
											</p>

										<?php } ?>
									
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="product-list product-list-mb">

									<div class="row">
										<div class="col-lg-3 row m-0 text-center">


										<?php 
										
											$eaw = explode('–', $row->excericseAvgWeek); 
											$min_excericseAvgWeek = floatval($eaw[0]); 
											$max_excericseAvgWeek = floatval($eaw[1]);
											if(!$max_excericseAvgWeek){
												$max_excericseAvgWeek = $min_excericseAvgWeek;
											}
											
											// $ex_img = base_url().'assets/front/images/icons/Exercise-icon-amber.png';
											$ex_img = base_url().'assets/front/images/icons/Exercise-icon-Grey.png';
											
											if($max_excericseAvgWeek > 0 && $max_excericseAvgWeek <= 2){
												$ex_img = base_url().'assets/front/images/icons/Exercise-icon-Red.png';
											}

											if($max_excericseAvgWeek >= 3){  // 3 is included
												$ex_img = base_url().'assets/front/images/icons/Exercise-icon-Green.png';
											}
										?>


											<div class="col-lg-12 col-md-12 col-xs-6  body-info body-info-mr">
												<img class="m-auto" src="<?php echo $ex_img; ?>">
												<label>Exercise</label>
												<!-- <div class="b_ans"><?php if($row->excericseAvgWeek>0){ echo number_format($row->excericseAvgWeek).'/Week';}else{ echo '---';} ?></div> -->
																			
												<?php $e_unit = 'hour'; if(trim($row->excericseAvgWeek) != '0-1') $e_unit .='s'; ?>
												<div class="b_ans"><?php  if($row->excericseAvgWeek != "" ){ echo $row->excericseAvgWeek.' '.$e_unit.'/Week';}else{ echo '---';} ?></div>

											</div><!--body info-->


										<?php 
										
											// $spn_img = base_url().'assets/front/images/icons/Sleep-icon-amber.png';
											$spn_img = base_url().'assets/front/images/icons/Sleep-icon-Grey.png';
											
											if($row->sleepPerNight >0 && $row->sleepPerNight <= 5){ // 5 is included
												$spn_img = base_url().'assets/front/images/icons/Sleep-icon-red.png';
											}

											if($row->sleepPerNight >= 8){  // 8 is included
												$spn_img = base_url().'assets/front/images/icons/Sleep-icon-green.png';
											}
										?>


											<div class="col-lg-12 col-md-12 col-xs-6 body-info">
													<img class="m-auto" src="<?php echo $spn_img; ?>">
												<label>Sleep</label>
												<div class="b_ans"><?php if($row->sleepPerNight>0){ if($row->sleepPerNight == 2) echo 'Less than 3 Hours'; else if($row->sleepPerNight == 12) echo '12+ Hours'; else echo intval($row->sleepPerNight).' Hours'; }else{ echo '---';} ?></div>

											</div><!--body info-->


										<?php 
										
											$sad = explode('-', $row->stepAvgDay); 
											$min_stepAvgDay = intval($sad[0]); 
											$max_stepAvgDay = intval($sad[1]);
											
											// $step_img = base_url().'assets/front/images/icons/Step-icon-Amber.png';
											$step_img = base_url().'assets/front/images/icons/Steps-icon-Grey.png';
											
											if($min_stepAvgDay > 0 && $min_stepAvgDay < 8000){  // Less than 8000
												$step_img = base_url().'assets/front/images/icons/Steps-icon-Red.png';
											}

											if($min_stepAvgDay >= 8000){  // 9999 is not included
												$step_img = base_url().'assets/front/images/icons/Steps-icon-Green.png';
											}
										?>

											<div class="col-lg-12 col-md-12 col-xs-6 body-info  body-info-mr">
												<img class="m-auto" src="<?php echo $step_img; ?>">
												<label>Steps</label>
												<div class="b_ans"><?php if($row->stepAvgDay != "" ){ if(trim($row->stepAvgDay) == '15000-20000') echo '15000+'; else echo $row->stepAvgDay.'/Day';}else{ echo '---';} ?></div>

											</div><!--body info-->



										<?php 
										
											$wad = explode('–', $row->waterAvgDay); 
											$min_waterAvgDay = floatval($wad[0]); 
											$max_waterAvgDay = floatval($wad[1]);
											if(!$max_waterAvgDay){
												$max_waterAvgDay = $min_waterAvgDay;
											}

											//echo '<pre>'; print_r($wad);
											
											// $wad_img = base_url().'assets/front/images/icons/water-icon-amber.png';
											$wad_img = base_url().'assets/front/images/icons/water-icon-Grey.png';
											
											if($max_waterAvgDay>0 && $max_waterAvgDay <= 1.2){
												$wad_img = base_url().'assets/front/images/icons/water-icon-Red.png';
											}

											if($max_waterAvgDay >= 2){  // 2 is included
												$wad_img = base_url().'assets/front/images/icons/water-icon-Green.png';
											}
										?>

											<div class="col-lg-12 col-md-12 col-xs-6 body-info">
													<img class="m-auto" src="<?php echo $wad_img; ?>"> 
												<label>Water</label>
												<!-- <div class="b_ans"><?php if($row->waterAvgDay>0){ echo number_format($row->waterAvgDay).'/Day';}else{ echo '---';} ?></div> -->
												<div class="b_ans"><?php if($row->waterAvgDay != "" && $row->waterAvgDay != 0){ echo $row->waterAvgDay.' liters/Day';}else{ echo '---';} ?></div>

												
											</div><!--body info-->

										</div><!-- /.col- -->

										<div class="col-lg-6 text-center">

											<div class="human-body <?php if($row->gender == 'Male') echo 'human-body-male'; else echo 'human-body-female'; ?> ">


												<div class="age"
												
													<?php
														if(age($row->dob) == 0 || age($row->dob) == ''){
													?>
															style="border-color: Grey;"
													<?php
														}
													?>

												>
													<div>
													
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

												<div class="height" 
													<?php
														if($row->height == 0 || $row->height == ''){
													?>
															style="border-color: Grey;"
													<?php
														}
													?>
												>
													<div>
													
														Height
														<span>
															<?php if($row->height>0) {
																echo number_point_format($row->height,1) . ' cm';
															} ?>
														</span>
													</div>
												</div><!--height-->

												<?php $ratiom = 0; 
												if($row->hipMeasurment > 0) { $ratiom = floatval($row->waistMeasurment/$row->hipMeasurment); $ratiom = number_format($ratiom, 2); };  // by default is green < 0.90 or 0.85 ?>

												<?php if($row->gender == 'Female'){ ?>   

													<div class="hip-waist <?php if($ratiom >= 0.85 && $ratiom <= 1 ) echo 'amber-color'; if($ratiom > 1 ) echo 'red-color'; if($ratiom > 0 && $ratiom <= 0.84 ) echo 'green-color'; else echo 'gray-color';  ?>"> <div>

												<?php }else{ ?>

													<div class="hip-waist <?php if($ratiom >= 0.9 && $ratiom <= 1 ) echo 'amber-color'; if($ratiom > 1 ) echo 'red-color'; if($ratiom > 0 && $ratiom <= 0.89 ) echo 'green-color'; else echo 'gray-color';  ?>"> <div>
												
												<?php } ?>

												<?php //echo $ratiom; ?>
						
													<span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">The waist-hip ratio or waist-to-hip ratio (WHR) 
													is the dimensionless ratio of the circumference of the waist to that of the hips. According to the World Health Organization, a waist-to-hip ratio greater than 1.0 is indicative of a higher than normal 
													risk of developing heart disease. A healthy WHR for women is under . 85 and a healthy WHR for men is 90 or less.</span></span>
														Hip/Waist Ratio
														<span>
															<?php if($row->waistMeasurment>0 && $row->hipMeasurment>0) {
																$wh=$row->waistMeasurment/$row->hipMeasurment;
																echo number_point_format($wh,2) . '';
															} ?>
														</span>
														
													</div>
												</div><!--Hip/Waist Ratio-->

												<div class="QRISK gray-color">
													<div>
													    	<span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">QRISK is an algorithm for predicting cardiovascular risk. It estimates the risk of a person developing cardiovascular disease (CVD) over the next 10 years and can be applied to those aged between 35 and 74 years. Those with a score of 20 per cent or more are considered to be at high risk of developing CVD.</span></span>
						
														QRISK 
														<span style="color: #a19c9b"><?php if($row->qriskk!='' || $row->qriskk==0.00) echo $row->qriskk.' %'; else echo '---'; ?></span>
													</div>
												</div><!--QRISK-->

												<div class="Weight"
													<?php
														if($row->weight == 0 || $row->weight == ''){
													?>
															style="border-color: Grey;"
													<?php
														}
													?>
												>
													<div>
												
														Weight
														<span>
															<?php if($row->weight>0) {
																echo number_point_format($row->weight,1) . ' kg';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<?php if($row->weight>0 && $row->height>0) {
														$bmi=floatval((($row->weight/$row->height)/$row->height)*10000);
												} ?>

												<!-- <div class="BMI <?php //if($row->weight>0 && $row->height>0){ if($bmi < 18.5 || $bmi > 24.9) echo 'red-color'; }else{ echo 'gray-color'; } ?>"> -->
												<div class="BMI <?php if($row->weight>=0 && $row->height>=0){ if($bmi > 0 && $bmi <= 18.4){ echo 'green-color'; }elseif($bmi > 24.9){ echo 'red-color'; }elseif($bmi >= 18.5 && $bmi <= 24.9){ echo 'amber-color'; }else{ echo 'gray-color'; } } ?>">
													<div>
													    <span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">If your BMI (Body mass index) is 18.5 to <25, it falls within the normal. If your BMI is 25.0 to <30, it falls within the overweight range. If your BMI is 30.0 or higher, it falls within the obese range.</span></span>
						
														BMI
														<span>
															<?php if($row->weight>0 && $row->height>0) {
																$bmi=(($row->weight/$row->height)/$row->height)*10000;
																echo number_point_format($bmi,1) . '';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<div class="Heart-Age gray-color">
													<div>
													    <span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">Heart age is a way to understand your risk of a heart attack or stroke. Your heart age is calculated based on your risk factors for heart disease, such as age and family history, as well as diet, physical activity and smoking. A younger heart age means a lower risk of heart disease.</span></span>
						
														Heart Age
														<span style="color: #a19c9b"><?php if($row->heart_age!='') echo $row->heart_age; else echo '---'; ?></span>
													</div>
												</div><!--Heart Age-->

											</div><!-- /human body- -->

										</div><!-- /.col- -->

										<div class="col-lg-3 row m-0 text-center">


										<?php

											// $hrt_img = base_url().'assets/front/images/icons/Heartrate-icon-Amber.png';
											$hrt_img = base_url().'assets/front/images/icons/Heartrate-icon-Grey.png';
												
											if($row->restHeartRate > 59 && $row->restHeartRate <= 100){  // 60-100 BPM 
												$hrt_img = base_url().'assets/front/images/icons/Heartrate-icon-Green.png';
											}

										?>

									
											<div class="col-lg-12 col-md-12 col-xs-6 body-info body-info-mr">
													<img class="m-auto" src="<?php echo $hrt_img; ?>">
												<label>Heart Rate</label>

												<div class="b_ans"><?php if($row->restHeartRate>0){ echo number_format($row->restHeartRate).' bpm';}else{ echo '---';} ?></div>

											</div><!--body info-->


										<?php
										
											$bp_img = base_url().'assets/front/images/icons/bloodpressure-icon-Grey.png';
											if($row->systolic_bp > 0 && $row->systolic_bp < 140 && $row->bloodPressure > 0 && $row->bloodPressure < 90){  // If systolic < 140 & Diastolic < 90 then the symbol is the green one
												$bp_img = base_url().'assets/front/images/icons/bloodpressure-icon-Green.png';
											}
											if($row->systolic_bp > 140 && $row->bloodPressure > 90){
												$bp_img = base_url().'assets/front/images/icons/blood-pressure-icon-Red.png';
											}

										?>

											<div class="col-lg-12 col-md-12 col-xs-6 body-info">
												<img class="m-auto" src="<?php echo $bp_img; ?>">
												<label>Blood Pressure</label>

												<!-- <div class="b_ans"><?php if($row->bloodPressure>0){ echo number_format($row->bloodPressure).' mmHg';}else{ echo '---';} ?></div> -->
												<div class="b_ans"><?php if($row->bloodPressure > 0 ){ echo number_format($row->systolic_bp).'/'.number_format($row->bloodPressure).' mmHg';}else{ echo '---';} ?></div>

											</div><!--body info-->


										<?php
										
											// $cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-amber.png';
											$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-Grey.png';
											
											if($row->cholesterol >0 && $row->cholesterol < 200){  // 200 not included
												$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-green.png';
											}

											if($row->cholesterol > 239){  // 239 not included
												$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-red.png';
											}

										?>

											<div class="col-lg-12 col-md-12 col-xs-6 body-info body-info-mr">
											<img class="m-auto" src="<?php echo $cholesterol_img; ?>">
												<label>Cholesterol</label>
												<div class="b_ans"><?php if($row->cholesterol>0){ echo number_format($row->cholesterol).' ratio';}else{ echo '---';} ?></div>

											</div><!--body info-->

										
										<?php
										
											// $cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-amber.png';
											$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-Grey.png';
											
											if($row->alcoholUnits !==NULL){
												if($row->alcoholUnits == '0' || $row->alcoholUnits == '6' || $row->alcoholUnits == '8-12'){ 
													$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-green.png';
												}
												if( $row->alcoholUnits == '12-14'){
													$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-amber.png';
												}
	
												if($row->alcoholUnits == '15'){  
													$cholesterol_img = base_url().'assets/front/images/icons/cholesterol-icon-red.png';
												}
											}
											

										?>
                                            
                                            <div class="col-lg-12 col-md-12 col-xs-6 body-info">
											<img class="m-auto" src="<?php echo $cholesterol_img; ?>">
												<label>Blood Sugar</label>
												<div class="b_ans"><?php echo $row->alcoholUnits ?></div>
											</div>

										</div><!-- /.col- -->


										<div class="clearfix"></div>
									</div>
								</div><!--product list-->

<div>

<?php $pname = $row->f_name;  if(empty($row->f_name)) $pname = 'enc'; ?>
<!--<a target="_blank" href="https://www.facebook.com/share.php?title=Profile&u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>" class="btn btn-pay pull-right" style="color: #fff; background-color: #3b5998;; border-color: #3b5998;; width: 15%"><i class="fa fa-facebook" aria-hidden="true"> Share </i></a>-->



<ul class="list-inline pull-right" style="font-size: x-large; padding-top: 20px;">
		<li class="list-inline-item">														
			<a target="_blank" href="https://www.facebook.com/share.php?title=Nelson Asikoyo&amp;u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<i class="fa fa-facebook" aria-hidden="true"></i>
			</a>

			<script>

				function fbs_click() {
					u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');

					return false;
				}

				</script>
		</li>                           

		<li class="list-inline-item">
			<a target="_blank" href="https://twitter.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">								
				<i class="fa fa-twitter" aria-hidden="true"></i>							
			</a>																					
		</li>	
		
		<li class="list-inline-item">
			<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">								
				<i class="fa fa-linkedin" aria-hidden="true"></i>							
			</a>																					
		</li>	

		<li class="list-inline-item">								
			<a target="_blank" href="https://api.whatsapp.com/send?phone=+123456789&amp;text=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<i class="fa fa-whatsapp" aria-hidden="true"></i>								
			</a>																												
		</li>																										

		<li class="list-inline-item">															
			<a href="mailto:?subject=BMI&amp;body=Hi here is my BMI details. | <?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>" title="Share by Email">
				<i class="fa fa-envelope" aria-hidden="true"></i>								
			</a>														
		</li>
</ul>

<!--<table class="pull-right">
	<thead>
		<tr>
			<th style="padding: 5px;">
			<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<img src="https://tekeye.uk/md/images/face-but.png" alt="Facebook Button" title="Facebook Button">
			</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://twitter.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/tweet-but.png" alt="Twitter Button" title="Twitter Button">
				</a>
			</th>

			<th>reddit</th>
			<th>
				<a target="_blank" href="https://www.reddit.com/submit?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/reddit-but.png" alt="reddit Button" title="reddit Button">
				</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/linkin-but.png" alt="LinkedIn Button" title="LinkedIn Button">
				</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://plus.google.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/gplus-but.png" alt="Google+ Button" title="Google+ Button">
				</a>
			</th>
		</tr>
	</thead>
</table> -->



</div>
								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product" id="recommended">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>/product/Cholesterol.png" alt=""/> Recommended Products</h6>
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="row">
									<?php foreach ($recommended_products as $res){ ?>
									<div class="col-md-6 col-sm-6 col-xs-12 mix finance marketing">
										<div class="single-service">
											<a href="<?=base_url('tests/'.$res->slug)?>" class="add-to-cart">
												<div class="img"></div>
											</a>
											<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$res->testLogo?>" style="width: 60px;height: 60px;"  alt=""/></i>
											<div class="row">
												<p class="col-md-12"><?=$res->testName?></p>
												<p class="col-md-6 col-xs-5 " >
													<span class="member-price">Member Price</span>
													£<?=$res->originalPrice?></p>
												<p class="col-md-6 col-xs-7 price" >
													<span class="member-price price">Premium Members Price</span>
													<?php
													$mprice=$res->originalPrice;
													if($res->discountPercentage=='Yes')
													{
														if($res->discountPrice>0)
														{
															$mprice=$res->originalPrice-($res->originalPrice*($res->discountPrice/100));
														}

													}else
													{
														$mprice=$res->originalPrice-$res->discountPrice;
													}?>


													£<?=$mprice?></p>
											</div>
											<div class="clearfix"></div>
											<p class="description"><?=short_text($res->testDescription,90)?></p>
											<a href="<?=base_url('tests/'.$res->slug)?>" class="custom-btn">Learn More</a>
										</div> <!-- /.single-service -->
									</div> <!-- /.col-md-4 -->
									<?php  } ?>
									<div class="clearfix"></div>
								</div><!-- /.row -->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>/product/Cholesterol.png" alt=""/> Track your progress</h6>
									<div class="shorting-option clearfix">

									</div> <!-- /.shorting-option -->
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="product-list text-center">

									<div class="boxstyle text-left margin-bottom text-center">
									   
									   <div class="row">
									    <h6 class="chart_heading m-0">Monthly Report  </h6>
										
										<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

										 <div id="graph_loaderr" style="display:none">
											<i class="fa fa-spinner fa-spin"></i>Loading
										 </div>

										 <select id="m_report" class="form-control float-right" style="width: 20%" onchange="get_report(this.value)">
										 <option value="ALL">All</option>
											<option value="BMI">BMI</option>
											<option value="Hip/Waist Ratio">Hip/Waist Ratio</option>
											<option value="QRISK">QRISK</option>
											<option value="Heart Age">Heart Age</option>
										</select> 
										</div>
										 <div class="row">
										<div id="graph"></div>
										</div>
										<script>
											
											load_chart();
											function load_chart(){// Use Morris.Bar
												Morris.Line({
													element: 'graph',
													data:[
														<?php
														foreach($res_bmi as $month) {
															echo json_encode($month).',';
														}?>
													],
													xkey: 'y',
													ykeys: ['x','x1','x2','x3'],
													labels: ['BMI','Hip/Waist Ratio','QRisk','Heart Age'] ,
													xLabelFormat: function (x) {
														var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
														var month = IndexToMonth[ x.getMonth() ];
														var year = x.getFullYear();
														return year + ' ' + month;
													},
													dateFormat: function (x) {
														var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
														var month = IndexToMonth[ new Date(x).getMonth() ];
														var year = new Date(x).getFullYear();
														return year + ' ' + month;
													},
													resize: true

												});

												setTimeout(function(){ $("#graph_loaderr").hide(); }, 400);

											}


											function get_report(type){

												//$("#graph_loaderr").css("display", "block");
												$("#graph_loaderr").show();

												//return;
        
    												$.ajax({
                                						url: '<?=base_url('hub/filter_chart')?>',
                                						dataType: 'json',
                                						data:{'type':type},
                                						method: 'post'
                                					}).done(function (response) {
                                					    
                                					  
                                					    
                                	 $("#graph").empty();

												if(type == 'ALL'){
													load_chart();
													//$("#graph_loaderr").css("display", "none");
													setTimeout(function(){ $("#graph_loaderr").hide(); }, 400);
													return;
												}    
                                					    
                                			 Morris.Line({
												element: 'graph',
												data:response,

												xkey: 'y',
												ykeys: ['x'],
												labels: [type] ,

												xLabelFormat: function (x) {
													var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
													var month = IndexToMonth[ x.getMonth() ];
													var year = x.getFullYear();
													return year + ' ' + month;
												},
												dateFormat: function (x) {
													var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
													var month = IndexToMonth[ new Date(x).getMonth() ];
													var year = new Date(x).getFullYear();
													return year + ' ' + month;
												},
												resize: true

											});
                                					
                                					}).fail(function(){
                                						
													});
													
													//$("#graph_loaderr").css("display", "none");
													setTimeout(function(){ $("#graph_loaderr").hide(); }, 400);
													//$("#graph_loaderr").fadeOut();

											}

										</script>
										<div class="clearfix"></div>
									</div>

									<div class="clearfix"></div>

								</div><!--product list-->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product our-blog">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>images/product/Cholesterol.png" alt=""/> Latest Blog</h6>
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="row">
									<?php foreach ($blogs as $blog){ ?>
									<div class="col-lg-4 col-md-4 col-xs-6 home-blog">
										<div class="single-blog">
											<a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><div class="image"><img  src="<?=base_url('uploads/blog/'.$blog->blogImage)?>" alt=""></div></a>
											<div class="text float-left">
												<h6>Evergene.</h6><br>
												<h5><a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><?=$blog->blogTitle?></a></h5>

												<a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><i class="flaticon-arrows" aria-hidden="true"></i></a>
											</div>
										</div> <!-- /.single-blog -->
									</div>
									<?php } ?>
								</div> <!-- /.row -->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->



						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>


		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<!--
                =============================================
                    Home Blog Section
                ==============================================
                -->
	<div class="home-blog-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="single-blog color-one">
						<img src="<?=base_url('assets/front/')?>images/home/6.jpg" alt="">
						<h5>SSL certificate</h5>
						<p>All of our tests are carried out to the highest standards in an NHS accredited laboratory</p>
					</div> <!-- /.single-blog -->
				</div> <!-- /.col- -->
				<div class="col-md-6 col-xs-12">
					<div class="single-blog color-two">
						<img src="<?=base_url('assets/front/')?>images/home/7.jpg" alt="">
						<h5>Data protection</h5>
						<p>Your data belongs to you and we take it very seriously to ensure you have complete control of it</p>
					</div> <!-- /.single-blog -->
				</div> <!-- /.col- -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</div> <!-- /.home-blog-section -->

	<?php $this->load->view('includes/footer'); ?>

	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
    <script type="text/javascript">
        function resend_email()
        {
            $.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: '<?=base_url('hub/resend_email')?>',
						dataType: 'json',
						data:{'type':1},
						method: 'post'
					}).done(function (response) {
						self.close();

						if(response.code==0)
						{
							$.confirm({
								title: 'Error!',
								icon:  'fa fa-warning',
								closeIcon: true,
								content: response.message,
								type: 'red',
								autoClose: 'close|10000',
								typeAnimated: true,
								buttons: {
									close: function () {
									}
								}
							});
						}
						else
						{
							$.confirm({
								title: 'Success!',
								icon:  'fa fa-check',
								content: response.message,
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function(){
											
										}
									}
								}
							});
						}
					}).fail(function(){
						self.close();
						$.confirm({
							title: 'Encountered an error!',
							content: 'Something went wrong.',
							type: 'red',
							typeAnimated: true,
							buttons: {
								close: function () {
								}
							}
						});

					});
				},
				buttons: {
					close: function () { }
				}
			});
        }
    </script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
