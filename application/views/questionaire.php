<?php $this->load->view('includes/head');   ?>
<link type="text/css" rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap-datepicker-master/bootstrap-datetimepicker.min.css')?>" />
<style type="text/css">
	.add_detail{
		margin-top: 10px;
		display: none;
	}
	.show{
		display: block;
	}


</style>
</head>
<body>
<div class="main-page-wrapper">

	<?php $this->load->view('includes/menu');   ?>

	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="shop-page hub-page" id="quest-step">
		<div class="row">
			<div class="container">
				<div class="title-head col-md-12 p-0 m-p-15">
					<h5 class="pull-left" style="padding: 15px 0;">Questionnaire</h5>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div> <br />
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">

						<div class="row">

							<div class="col-lg-12 col-xs-12">

								<div class="single-product shop-sidebar">

									<section>
										<div class="wizard">
											<div class="wizard-inner">
												<div class="connecting-line"></div>
												<ul class="nav nav-tabs" role="tablist">
													<li role="presentation" class="active">
														<a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
															<span class="round-tab">
																<i class="glyphicon glyphicon-list-alt"></i>
															</span>
														</a>
													</li>
													<li role="presentation" class="">
														<a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
														<span class="round-tab">
															<i class="glyphicon glyphicon-list-alt"></i>
														</span>
														</a>
													</li>
													<li role="presentation" class="">
														<a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
														<span class="round-tab">
															<i class="glyphicon glyphicon-list-alt"></i>
														</span>
														</a>
													</li>
													<li role="presentation" class="">
														<a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="Step 4">
														<span class="round-tab">
															<i class="glyphicon glyphicon-list-alt"></i>
														</span>
														</a>
													</li>
													<li role="presentation" class="">
														<a href="#step5" data-toggle="tab" aria-controls="step5" role="tab" title="Step 5">
														<span class="round-tab">
															<i class="glyphicon glyphicon-list-alt"></i>
														</span>
														</a>
													</li>

												</ul>
											</div>
										    <div class="col-lg-12 p-0">
                    							<div class="questionnaire-info-box">
                    							    Please complete what you know, if you do not know it please leave blank.
                    							</div>
                    						</div>

											<form role="form" id="frm_1" action="<?=base_url('questionaire/process')?>">
												<div class="tab-content">
													<div class="tab-pane active" role="tabpanel" id="step1">
														<div class="single-service m-bottom0">

																<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>First Name*</label>
																		<input type="text" class="form-control" name="f_name" value="<?php if(empty($row->f_name)) echo $user->userFirstName; else echo $row->f_name; ?>" readonly onKeyPress="return ValidateAlpha(event);" />
																	</div>
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Second Name*</label>
																		<input type="text" class="form-control" name="l_name" value="<?php if(empty($row->l_name)) echo $user->userLastName; else echo $row->l_name; ?>" readonly onKeyPress="return ValidateAlpha(event);" />
																	</div>
																</div>
															</div>


															<div class="form-group">

																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="quest-gender">
																				<label>Gender*</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input disabled class="alergies rc" <?php if($user->userGender=='Male' || $user->userGender=='') { echo 'checked'; } ?> id="male" value="Male" type="radio" name="gender" >
																				<label for="male">Male </label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input  class="alergies rc" <?php if($user->userGender=='Female') { echo 'checked'; } ?>
																					   id="female" value="Female" type="radio" name="gender" disabled>
																				<label for="female" disabled>Female</label>
																			</div>
																		</div>
																		
																	</div>




																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Date of Birth*</label>
																		<input type="text" class="form-control" name="dob" readonly value="<?php if(trim($user->userDob) != '0000-00-00'){ echo $user->userDob; }?>" />
																	</div>
																	<div class="clearfix"></div>
																</div>

															</div>



															<div class="form-group">
																<div class="row">
																

																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Ethnicity</label>
																		<select name="ethnicity" class="form-control ethnicity">
																			<option value="" selected="selected" disabled="disabled">-- select one --</option>
																			
																			
																			<option value="White or not stated">White or not stated</option>
																			<option value="Asian Indian">Indian</option>
																			<option value="Asian Pakistani">Pakistani</option>
																			<option value="Asian Bangladeshi">Bangladeshi</option>
																			<option value="Other Asian">Other Asian</option>

																			<option value="Black Caribbean">Black Caribbean</option>
																			<option value="Black African">Black African</option>
																			<option value="Asian Chinese">Chinese</option>
																			<option value="Other">Other ethnic group</option>
																		</select>

																	</div>

																</div>
															</div>


															<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label style="color: red">* Fields can be amended in the accounts settings section</label>
																	</div>
																</div>
															</div>


														</div>
														<ul class="list-inline pull-right">
															<li><button id="stp1" type="button" class="tran3s cart-button btn-pay block hvr-trim-two next-step">Next</button></li>
														</ul>
													</div>
													<div class="tab-pane" role="tabpanel" id="step2">
														<div class="single-service m-bottom0">
															<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Height (cm)</label>
																		<input type="text" id="qheight" class="form-control number" name="height" value="<?=$row->height?>" />
																	</div>
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Weight (KG)</label>
																		<input type="text" id="qweight" class="form-control number" name="weight" value="<?=$row->weight?>"  />
																	</div>

																	<div class="clearfix"></div>

																</div>

															</div>


																<div class="form-group" id="question-info">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Hip Measurement (cm) <span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">Hip Measurement</span></span></label>
																		<input type="text" class="form-control number" id="qhipMeasurment" name="hipMeasurment" value="<?=$row->hipMeasurment?>" />
																	</div>
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Waist Measurement (cm) <span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">Waist Measurement</span></span></label></label>
																		<input type="text" class="form-control number" id="qwaistMeasurment" name="waistMeasurment" value="<?=$row->waistMeasurment?>" />
																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>



																<div class="form-group" id="question-info">
																<div class="row">

																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Body Type <span style="cursor: pointer" class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="custom critical">Body Type</span></span></label></label>
																		<select  name="bodyType" class="form-control bodyType">
																			<option value="" selected disabled>Select One</option>
																			<option value="Skinny">Skinny</option>
																			<option value="Slim">Slim</option>
																			<option value="Normal">Normal</option>
																			<option value="Curvy">Curvy</option>
																			<option value="Sporty">Sporty</option>
																			<option value="Muscular">Muscular</option>
																			<option value="Overweight">Overweight</option>

																			
																		</select>
																	</div>
																
																	<div class="clearfix"></div>

																</div>

															</div>

														</div>
														<ul class="list-inline pull-right">
															<li><button type="button" class="tran3s cart-button btn-defualt block hvr-trim-two prev-step">Previous</button></li>
															<li><button id="stp2" type="button" class="tran3s cart-button btn-pay block hvr-trim-two next-step">Next</button></li>
														</ul>
													</div>


													<div class="tab-pane" role="tabpanel" id="step3">
														<div class="single-service m-bottom0">

																<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Avg exercise a week (Hours)</label>
																		<select name="excericseAvgWeek" class="form-control">

																			<option value="<?php echo $row->excericseAvgWeek; ?>" selected hidden>
																				<?php 
																					if($row->excericseAvgWeek!=''){
																						echo $row->excericseAvgWeek; echo ' hour'; if($row->excericseAvgWeek != '0-1'){echo 's'; } 
																					}
																					
																				?>
																			</option>
																			<option value="0-1" >0-1  hour</option>
																			<option value="1 – 1.5">1 – 1.5  hours</option>
																			<option value="1.5 - 2">1.5 - 2  hours</option>
																			<option value="2 – 2.5">2 – 2.5  hours</option>
																			<option value="2.5 – 3">2.5 – 3  hours</option>
																			<option value="3 – 3.5">3 – 3.5  hours</option>
																			<option value="3.5 – 4">3.5 – 4  hours</option>
																			<option value="4 – 4.5">4 – 4.5  hours</option>
																			<option value="4.5 +">4.5 +  hours</option>
																			
																		</select>
																	
																	</div>
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Avg steps per day</label>

																	<select name="stepAvgDay" class="form-control">
																		
																			<option value="<?php echo $row->stepAvgDay; ?>" selected hidden><?php echo $row->stepAvgDay; ?></option>
																			<option value="0000-2999 ">0-2999 </option>
																			<option value="3000-5999 ">3000-5999 </option>
																			<option value="6000-7999 ">6000-7999 </option>
																			<option value="8000-9999 ">8000-9999 </option>
																			<option value="10000-12999 ">10000-12999 </option>
																			<option value="13000-14999 ">13000-14999</option>
																			<option value="15000-20000 ">15000+</option>

																		</select>
																	

																	
																	<div class="clearfix"></div>

																</div>
															</div>
														</div>


															<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you track this?</label>
																		<div class="radio-group">



																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->trackExercise=='Yes') { echo 'checked=""'; } ?> id="exercise_Yes" value="Yes" type="radio" name="exercise" >
																				<label for="exercise_Yes">Yes</label>
																			</div>



																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->trackExercise=='No' || $row->trackExercise=='') { echo 'checked=""'; } ?> checked id="exercise_No" value="No" type="radio" name="exercise" >
																				<label for="exercise_No">No</label>
																			</div>




																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->trackExercise=='Yes') { echo 'show'; } ?> " id="exerciseDetail">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="exerciseDetail"><?=$row->exerciseDetails?></textarea>
																		</div>


																	</div>

																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you track your steps?</label>
																		<div class="radio-group">



																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->stepTrack=='Yes') { echo 'checked=""'; } ?> id="steps_Yes" value="Yes" type="radio" name="step" >
																				<label for="steps_Yes">Yes</label>
																			</div>



																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->stepTrack=='No' || $row->stepTrack=='') { echo 'checked=""'; } ?> checked id="steps_No" value="No" type="radio" name="step" >
																				<label for="steps_No">No</label>
																			</div>




																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->trackExercise=='Yes') { echo 'show'; } ?> " id="stepDetail">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="stepDetails"><?=$row->stepDetails?></textarea>
																		</div>


																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>









														



															<div class="form-group">
																<div class="row">

																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Avg Sleep per night (hours)</label>

																		<select  name="sleepPerNight" class="form-control bodyType">

																			<option value="<?php echo $row->sleepPerNight; ?>" selected hidden><?php echo $row->sleepPerNight; ?></option>
																			
																			<option value="2">Less than 3</option>
																			<option value="3">3</option>
																			<option value="4">4</option>
																			<option value="5">5</option>
																			<option value="6">6</option>
																			<option value="7">7</option>
																			<option value="8">8</option>
																			<option value="9">9</option>
																			<option value="10">10</option>
																			<option value="11">11</option>
																			<option value="12+">12+</option>

																		</select>
																	</div>


																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Smoking status per day</label>

																		<select  name="per_day_smoking" class="form-control bodyType">

																			<option value="<?php echo $row->smoker; ?>" selected hidden><?php echo $row->smoker; ?></option>
																			
																			<option value="no smoker">No smoker</option>
																			<option value="ex smoker">Ex smoker</option>
																			<option value="9">less than 10 </option>
																			<option value="11">More than 10</option>
																			<option value="21">More than 20</option>

																		</select>
																	</div>

																</div>
															</div>

															<div class="form-group">
																<div class="row">
																	
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you track your sleep?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="sleepTrack_Yes" <?php //if($row->sleepTrack=='Yes') { echo 'checked=""'; } ?> value="Yes" type="radio" name="sleepTrack" >
																				<label for="sleepTrack_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="sleepTrack_No" <?php //if($row->sleepTrack=='No' || $row->sleepTrack=='') { echo 'checked=""'; } ?> checked value="No" type="radio" name="sleepTrack" >
																				<label for="sleepTrack_No">No</label>
																			</div>
																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->sleepTrack =='Yes') { echo 'show'; } ?>" id="sleepDetail">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="sleepDetails"><?=$row->sleepDetails?></textarea>
																		</div>


																	</div>

																		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you actively track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="smoke_Yes" <?php //if($row->trackSmoking=='Yes') { echo 'checked=""'; } ?> value="Yes" type="radio" name="smokeTrack" >
																				<label for="smoke_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="smoke_No" <?php //if($row->trackSmoking=='No' || $row->trackSmoking=='') { echo 'checked=""'; } ?> checked value="No" type="radio" name="smokeTrack" >
																				<label for="smoke_No">No</label>
																			</div>
																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->trackSmoking =='Yes') { echo 'show'; } ?>" id="smokeDetail">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="smokeDetail"><?=$row->smookingDetails?></textarea>
																		</div>


																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>



																<div class="form-group">
																<div class="row">

																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Avg water consumed a day (in litres)</label>

																		<select  name="avg_water" class="form-control bodyType">

																			<option value="<?php echo $row->waterAvgDay; ?>" selected hidden><?php echo $row->waterAvgDay; ?></option>

																			<option value="0.5">less than 1 </option>
																			<option value="1 – 1.2">1 – 1.2</option>
																			<option value="1.3 – 1.9">1.3 – 1.9</option>
																			<option value="2 – 2.4">2 – 2.4</option>
																			<option value="2.5 – 2.9">2.5 – 2.9</option>
																			<option value="3 – 3.5">3 – 3.5</option>
																			<option value="3.6+">3.6+</option>
																					
																		</select>
																	</div>


																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Avg units of alcohol do you consume a week (in units)</label>

																		<select  name="avg_alcohol" class="form-control bodyType">
																			<option value="<?php echo $row->alcoholUnits; ?>" selected hidden><?php echo $row->alcoholUnits; ?></option>

																			<option value="0">0</option>
																			<option value="6">Less than 7</option>
																			<option value="8-12">8-12</option>
																			<option value="12-14">12-14</option>
																			<option value="15">15+</option>
						
																			
																		</select>
																	</div>

																</div>
															</div>

															<div class="form-group">
																<div class="row">
																	
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you actively track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="water_Yes" <?php //if($row->trackWater=='Yes') { echo 'checked=""'; } ?> value="Yes" type="radio" name="waterTrack" >
																				<label for="water_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="water_No" <?php //if($row->trackWater=='No' || $row->trackWater=='') { echo 'checked=""'; } ?> checked value="No" type="radio" name="waterTrack" >
																				<label for="water_No">No</label>
																			</div>
																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->trackWater =='Yes') { echo 'show'; } ?>" id="waterDetails">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="waterDetails"><?=$row->waterDetails?></textarea>
																		</div>


																	</div>


																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you actively track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="alcohol_Yes" <?php //if($row->trackAlcohol=='Yes') { echo 'checked=""'; } ?> value="Yes" type="radio" name="alcoholTrack" >
																				<label for="alcohol_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="sleepTrack" id="alcohol_No" <?php //if($row->trackAlcohol=='No' || $row->trackAlcohol=='') { echo 'checked=""'; } ?> checked value="No" type="radio" name="alcoholTrack" >
																				<label for="alcohol_No">No</label>
																			</div>
																		</div>


																		<div class="add_detail trackHeart_detail <?php //if($row->trackAlcohol =='Yes') { echo 'show'; } ?>" id="alcoholDetails">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="alcoholDetails"><?=$row->alcoholDetails?></textarea>
																		</div>


																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>




														
														</div>
														<ul class="list-inline pull-right">
															<li><button type="button" class="tran3s cart-button btn-defualt block hvr-trim-two prev-step">Previous</button></li>
													    	<li><button type="button" class="tran3s cart-button btn-pay block hvr-trim-two next-step">Next</button></li>
														</ul>
													</div>


													<div class="tab-pane" role="tabpanel" id="step4">
														<div class="single-service m-bottom0">

															<div class="form-group" style="margin-bottom:10px;">
																<div class="row">
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Alergies</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="alergies rc" <?php //if($row->alergies=='Yes') { echo 'checked=""'; } ?> id="alergies_Yes" value="Yes" type="radio" name="alergies" >
																				<label for="alergies_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="alergies rc" <?php //if($row->alergies=='No' || $row->alergies=='') { echo 'checked=""'; } ?> checked
																					   id="alergies_No" value="No" type="radio" name="alergies" >
																				<label for="alergies_No">No</label>
																			</div>
																		 	

																		</div>
												<div class="add_detail alergies_detail <?php //if($row->alergies=='Yes') { echo 'show'; } ?>">

												<ul>
													<li>
													<input type="checkbox" value="Peanuts" name="alerg[]"> Peanuts
												    </li>

												    <li>
													<input type="checkbox" value="Tree nuts" name="alerg[]"> Tree nuts
													</li>
													<li>
													<input type="checkbox" value="Fish" name="alerg[]"> Fish
													</li>
													<li>
													<input type="checkbox" value="Shellfish" name="alerg[]"> Shellfish
													</li>
													<li>
													<input type="checkbox" value="Egg" name="alerg[]"> Egg
													</li>
													<li>
													<input type="checkbox" value="Dairy" name="alerg[]"> Dairy
													</li>
													<li>
													<input type="checkbox" value="Wheat" name="alerg[]"> Wheat
													</li>
													<li>
													<input type="checkbox" value="Soy" name="alerg[]"> Soy
													</li>
													<li>
													<input type="checkbox" value="other" name="alerg[]"> other
													</li>
												</ul>

												</div>
											</div>
                                                                	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Do you follow a particular diet?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="alergies rc" <?php //if($row->trackDiet=='Yes') { echo 'checked=""'; } ?> id="diet_Yes" value="Yes" type="radio" name="diet" >
																				<label for="diet_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="alergies rc" <?php //if($row->trackDiet=='No' || $row->trackDiet=='') { echo 'checked=""'; } ?> checked
																					   id="diet_No" value="No" type="radio" name="diet" >
																				<label for="diet_No">No</label>
																			</div>
																		</div>
																		<!-- <div class="add_detail alergies_detail <?php //if($row->trackDiet=='Yes') { echo 'show'; } ?>" id="follow_diet"> -->
																		<div class="add_detail <?php //if($row->trackDiet=='Yes') { echo 'show'; } ?>" id="follow_diet">

																		<select  name="dietDetails" class="form-control diabetesStatus" id="dietDetails">
																			<option value="<?php echo $row->dietDetails; ?>" selected hidden><?php echo $row->dietDetails; ?></option>
																			<option value="none">none</option>
																			<option value="Vegan">Vegan</option>
																			<option value="Vegetarian">Vegetarian</option>
																			<option value="Pescatarian">Pescatarian</option>
																			<option value="Gluten free">Gluten free</option>
																			<option value="Coeliac">Coeliac</option>
																			<option value="ketogenic">low carb/high fat (ketogenic)</option>
																			<option value="atkins">low carb other (i.e atkins)</option>
																			<option value="Calorie controlled">Calorie controlled</option>
																			<option value="other">other</option>

																		</select>

																		</div>

																			<!-- <div class="add_detail alergies_detail <?php if($row->dietDetails=='other') { echo 'show'; } ?>" id="not_follow_diet"> -->
																			<div class="add_detail <?php if($row->dietDetails=='other') { echo 'show'; } ?>" id="not_follow_diet">

																				<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="diet_other_details"><?php echo $row->diet_other_details; ?></textarea>

																		    </div>
																		<!-- <div  id="new_nt_goals" style="display:none"> -->
																		<div>
																		<label>What are your nutritional goals?</label>
																	
																		<div class="nutritional_detail">
																			

																		<select  name="nutritional_goals" class="form-control diabetesStatus">
																			<option value="<?php echo $row->nutritional_goals; ?>" selected hidden><?php echo $row->nutritional_goals; ?></option>
																			<option value="Lose weight">Lose weight</option>
																			<option value="maintain weight">maintain weight</option>
																			<option value="Gain weight/build muscle">Gain weight/build muscle</option>

																		</select>
																	</div>
																	<div class="clearfix"></div>
															    	</div>
                                                                  

																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Intolerances</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="intolerances rc" <?php //if($row->intolerances=='Yes') { echo 'checked=""'; } ?> id="intolerances_Yes" value="Yes" type="radio" name="intolerances" >
																				<label for="intolerances_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="intolerances rc" <?php //if($row->intolerances=='No' || $row->intolerances=='') { echo 'checked=""'; } ?> checked id="intolerances_No" value="No" type="radio" name="intolerances">
																				<label for="intolerances_No">No</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="intolerances rc" <?php //if($row->intolerances=='unsure') { echo 'checked=""'; } ?>
																					   id="unsure" value="unsure" type="radio" name="intolerances" >
																				<label for="unsure">unsure</label>
																			</div>

																		</div>


																		<input id="intolerances_detail" type="text" class="form-control" name="intolerances_other_detail" placeholder="intolerances other details" style="display: none; width: 80%; margin-top: 5px">
																		<!-- <select id="intolerances_detail"  name="intolerancesDetails" class="form-control diabetesStatus" style="display: none; margin-top: 10px;">
																			<option value="<?php echo $row->intolerancesDetails; ?>" selected hidden><?php echo $row->intolerancesDetails; ?></option>
																			<option value="very_controlled">Very controlled</option>
																			<option value="balanced">Balanced</option>
																			<option value="unhealthy">Unhealthy</option>

																		</select> -->
																      <!-- <div  id="new_nt_goals_diet" style="display:none"> -->
																	  <div style="display: none">
																		<label>What are your nutritional goals?</label>
																	
																		<div class="nutritional_detail">
						

																			<select  name="intolerancesDetails" class="form-control diabetesStatus" >
																				<option value="<?php echo $row->intolerancesDetails; ?>" selected hidden><?php echo $row->intolerancesDetails; ?></option>
																				<option value="very_controlled">Very controlled</option>
																				<option value="balanced">Balanced</option>
																				<option value="unhealthy">Unhealthy</option>

																			</select>
			
																		</div>
																		<div class="clearfix"></div>
																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>

													
													</div>
												        </div>
												        <ul class="list-inline pull-right" style="margin-top:20px;">
															<li><button type="button" class="tran3s cart-button btn-defualt block hvr-trim-two prev-step">Previous</button></li>
															<li><button type="button" class="tran3s cart-button btn-pay block hvr-trim-two next-step">Next</button></li>
														</ul>
											</div>
									

			<div class="tab-pane" role="tabpanel" id="step5">
														<div class="single-service m-bottom0" >




														<div class="form-group">
																<div class="row">

																	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

																		<!-- <label>Cholesterol/HDL ratio</label> -->
																		<label>Total cholesterol ratio <span class="text-info">(range from 1 to 11)</span></label>
																		<input type="text" class="form-control number" name="cholesterol" value="<?=$row->cholesterol?>" />
																	</div>
																	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
																		<label>Date last checked cholesterol</label>
																		<input type="text" class="form-control date" name="cholesterolLastCheck" value="<?php if($row->cholesterolLastCheck!='0000-00-00'){ echo $row->cholesterolLastCheck; }?>" />
																	</div>
																		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->activelyTrack=='Yes') { echo 'checked=""'; } ?> id="trackCholesterol_Yes" value="Yes" type="radio" name="trackCholesterol" >
																				<label for="trackCholesterol_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->activelyTrack=='No' || $row->activelyTrack=='') { echo 'checked=""'; } ?> checked id="trackCholesterol_No" value="No" type="radio" name="trackCholesterol" >
																				<label for="trackCholesterol_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackCholesterol_detail <?php //if($row->activelyTrack=='Yes') { echo 'show'; } ?> " id="cholesterol_detail">
																			<textarea placeholder="Please write Detail" class="form-control trackCholesterol_inp" name="trackCholesterolDetail"><?=$row->activelyDetail?></textarea>
																		</div>
																	</div>
																	<div class="clearfix"></div>

																</div>

															</div>

																	

																<div class="form-group">
																<div class="row">
																	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
																		<label>Resting heart rate (bpm)</label>
																		<input type="text" class="form-control number" name="restHeartRate" value="<?=$row->restHeartRate?>" />
																	</div>
																	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
																		<label>Date last measured</label>
																		<input type="text" class="form-control date" name="heartLastCheck" value="<?php if($row->heartLastCheck!='0000-00-00'){ echo $row->heartLastCheck; }?>" />
																	</div>
																		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
																		<label>Do you track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->trackHeart=='Yes') { echo 'checked=""'; } ?> id="trackHeart_Yes" value="Yes" type="radio" name="trackHeart" >
																				<label for="trackHeart_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->trackHeart=='No' || $row->trackHeart=='') { echo 'checked=""'; } ?> checked id="trackHeart_No" value="No" type="radio" name="trackHeart" >
																				<label for="trackHeart_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackHeart_detail <?php //if($row->trackHeart=='Yes') { echo 'show'; } ?> ">
																			<textarea placeholder="Please write Detail" class="form-control trackHeart_inp" name="trackHeartDetail"><?=$row->trackHeartDetail?></textarea>
																		</div>
																	</div>
																	<div class="clearfix"></div>

																</div>

															</div>
																<div class="form-group">
																<div class="row">
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Diastolic blood pressure (mm Hg)</label>
																		<input type="text" class="form-control number" name="bloodPressure" value="<?=$row->bloodPressure?>" />
																	</div>
																	
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<!-- <label>Date last measured</label>
																		<input type="text" class="form-control date" name="bloodPressureLastCheck" value="<?php if($row->bloodPressureLastCheck!='0000-00-00'){ echo $row->bloodPressureLastCheck; }?>" /> -->
																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<!-- <label>Do you track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackBlookPressure rc" <?php //if($row->trackBlookPressure=='Yes') { echo 'checked=""'; } ?> id="trackBlookPressure_Yes" value="Yes" type="radio" name="trackBlookPressure" >
																				<label for="trackBlookPressure_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackBlookPressure rc" <?php //if($row->trackBlookPressure=='No' || $row->trackBlookPressure=='') { echo 'checked=""'; } ?> checked id="trackBlookPressure_No" value="No" type="radio" name="trackBlookPressure">
																				<label for="trackBlookPressure_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackBlookPressure_detail <?php if($row->trackBlookPressure=='Yes') { echo 'show'; } ?> ">
																			<textarea placeholder="Please write Detail" class="form-control trackBlookPressure_inp" name="trackBlookPressureDetails"><?=$row->trackBlookPressureDetails?></textarea>
																		</div> -->
																	</div>

																	
																	<div class="clearfix"></div>
																</div>
															</div>


															<div class="form-group">
																<div class="row">
																    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Systolic blood pressure (mm Hg) </label>
																		<input type="text" class="form-control number" name="systolic_bp" value="<?=$row->systolic_bp ?>" />
																			
																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Date last measured</label>
																		<input type="text" class="form-control date" name="bloodPressureLastCheck" value="<?php if($row->bloodPressureLastCheck!='0000-00-00'){ echo $row->bloodPressureLastCheck; }?>" />
																	</div>
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Do you track this?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackBlookPressure rc" <?php //if($row->trackBlookPressure=='Yes') { echo 'checked=""'; } ?> id="trackBlookPressure_Yes" value="Yes" type="radio" name="trackBlookPressure" >
																				<label for="trackBlookPressure_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackBlookPressure rc" <?php //if($row->trackBlookPressure=='No' || $row->trackBlookPressure=='') { echo 'checked=""'; } ?> checked id="trackBlookPressure_No" value="No" type="radio" name="trackBlookPressure">
																				<label for="trackBlookPressure_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackBlookPressure_detail <?php //if($row->trackBlookPressure=='Yes') { echo 'show'; } ?> ">
																			<textarea placeholder="Please write Detail" class="form-control trackBlookPressure_inp" name="trackBlookPressureDetails"><?=$row->trackBlookPressureDetails?></textarea>
																		</div>
																	</div>

																	

																	<div class="clearfix"></div>
																</div>
															</div>

															<div class="form-group">
																<div class="row">
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Standard deviation of Systolic blood pressure </label>
																		<input type="text" class="form-control number" name="deviation_systolic_bp" value="<?=$row->deviation_systolic_bp; ?>" />
																			
																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>


													
														<div class="form-group" style="display:none">
																<div class="row">
																	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Diabetes Status</label>
																		<select  name="diabetesStatus" class="form-control diabetesStatus">
																			<option value="0" selected="">none</option>
																			<option value="1">type 1</option>
																			<option value="2">type 2</option>
																		</select>
																	</div>
																		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>Chronic kidney disease</label>

																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="chronicKidneyDisease" <?php //if($row->chronicKidneyDisease=='Yes') { echo 'checked=""'; } ?> id="chronicKidneyDisease_Yes" value="Yes" type="radio" name="chronicKidneyDisease" >
																				<label for="chronicKidneyDisease_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="chronicKidneyDisease" <?php //if($row->chronicKidneyDisease=='No' || $row->chronicKidneyDisease=='') { echo 'checked=""'; } ?> checked id="chronicKidneyDisease_No" value="No" type="radio" name="chronicKidneyDisease" >
																				<label for="chronicKidneyDisease_No">No</label>
																			</div>
																		</div>
																	</div>
																		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
																		<label>On blood pressure treatment? </label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="bloodPressureTreatment" <?php //if($row->bloodPressureTreatment=='Yes') { echo 'checked=""'; } ?> id="bloodPressureTreatment_Yes" value="Yes" type="radio" name="bloodPressureTreatment" >
																				<label for="bloodPressureTreatment_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="bloodPressureTreatment" <?php //if($row->bloodPressureTreatment=='No' || $row->bloodPressureTreatment=='') { echo 'checked=""'; } ?> checked id="bloodPressureTreatment_No" value="No" type="radio" name="bloodPressureTreatment" >
																				<label for="bloodPressureTreatment_No">No</label>
																			</div>
																		</div>


																	</div>
																	<div class="clearfix"></div>
																</div>
															</div>
														
															<div class="form-group" style="display:none">
															    <div class="row">
															        
															        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															            <div class="add_detail medi_his_detail"  style="display:block;margin:0px">
                        													<ul>
                        														<li>
                        														<input type="checkbox" value="angina or heart attack aged <60" name="family_medical[]"> Angina
                        													    </li>
                        
                        													    <li>
                        														<input type="checkbox" value="dementia" name="family_medical[]"> heart attack in a 1st degree relative < 60
                        														</li>
                        														<li>
                        														<input type="checkbox" value="diabetes" name="family_medical[]"> Atrial fibrillation
                        														</li>
                        														<li>
                        														<input type="checkbox" value="high blood pressure" name="family_medical[]"> Rheumatoid arthritis
                        														</li>
                        													</ul>
															        </div>
															            
															        </div>
															        
															    </div>
															    
															</div>


													<?php if($user->userGender=='Male'){ ?>


																<div class="form-group">
																<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Have you been checked for testicular cancer?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->testicular_cancer=='Yes') { echo 'checked=""'; } ?> id="testicular_Yes" value="Yes" type="radio" name="testicular_cancer" >
																				<label for="testicular_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->testicular_cancer=='No' || $row->testicular_cancer=='') { echo 'checked=""'; } ?> checked id="testicular_No" value="No" type="radio" name="testicular_cancer" >
																				<label for="testicular_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackHeart_detail <?php if($row->testicular_cancer=='Yes') { echo 'show'; } ?> " id="testicular_lastcheck">
																		<label>Date last measured</label>
																		<input type="text" class="form-control date" name="testicular_lastcheck" value="<?php if($row->testicular_lastcheck!='0000-00-00'){ echo $row->testicular_lastcheck; }?>" />
																		</div>
																	</div>
									                                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Have you been checked for prostate cancer?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->prostateCancer=='Yes') { echo 'checked=""'; } ?> id="prostate_Yes" value="Yes" type="radio" name="prostateCancer" >
																				<label for="prostate_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->prostateCancer=='No' || $row->prostateCancer=='') { echo 'checked=""'; } ?> checked id="prostate_No" value="No" type="radio" name="prostateCancer" >
																				<label for="prostate_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackHeart_detail <?php if($row->prostateCancer=='Yes') { echo 'show'; } ?> " id="prostateCancerLastCheck">
																			<label>Date last measured</label>
																		<input type="text" class="form-control date" name="prostateCancerLastCheck"  value="<?php if($row->prostateCancerLastCheck!='0000-00-00'){ echo $row->prostateCancerLastCheck; }?>" />
																		</div>
																		</div>
													

																</div>
															</div>

															<div class="form-group">
																<div class="row">
																    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Existing Medical conditions </label>
																		<div class="radio-group" style="display:none">
																			<div class="md-radio md-radio-inline">
																				<input class="medical rc" <?php //if($row->trackMedical=='Yes') { echo 'checked=""'; } ?> checked id="medical_Yes" value="Yes" type="radio" name="medical" >
																				<label for="medical_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="medical rc" <?php //if($row->trackMedical=='No' || $row->trackMedical=='') { echo 'checked=""'; } ?>
																					   id="medical_No" value="No" type="radio" name="medical" >
																				<label for="medical_No">No</label>
																			</div>
																			

                    													</div>
                    													<div class="add_detail medical_detail <?php if($row->trackMedical=='Yes') { echo 'show'; } ?>" style="display:block;margin:0px">
                    
                    													<ul>
																			<li>
                    															<input type="checkbox" value="diabetes type 1" <?php if (strpos($row->medical_conditions, 'diabetes type 1') !== false) echo 'checked'; ?> name="medical_conditions[]"> Diabetes type 1
                    													    </li>
                    
                    													    <li>
                    															<input type="checkbox" value="diabetes type 2" <?php if (strpos($row->medical_conditions, 'diabetes type 2') !== false) echo 'checked'; ?> name="medical_conditions[]"> Diabetes type 2 <!--, uts-->
                    														</li>
                    														<li>
                    															<input type="checkbox" value="overactive thyroid" <?php if (strpos($row->medical_conditions, 'overactive thyroid') !== false) echo 'checked'; ?> name="medical_conditions[]"> Overactive thyroid
                    														</li>
                    														<li>
                    															<input type="checkbox" value="high blood pressure" <?php if (strpos($row->medical_conditions, 'high blood pressure') !== false) echo 'checked'; ?> name="medical_conditions[]"> Systemic lupus erythematosus (SLE)
                    														</li>
                    														<li>
                    															<input type="checkbox" value="heart disease" <?php if (strpos($row->medical_conditions, 'heart disease') !== false) echo 'checked'; ?> name="medical_conditions[]"> Chronic Kidney Disease (Stage 3, 4 or 5) <!--? -->
                    														</li>
                    													
                    														<li>
                    															<input type="checkbox" value="Atrial fibrillation" <?php if (strpos($row->medical_conditions, 'Atrial fibrillation') !== false) echo 'checked'; ?> name="medical_conditions[]"> Atrial fibrillation
                    														</li>
                    														<li>
                    															<input type="checkbox" value="Rheumatoid arthritis" <?php if (strpos($row->medical_conditions, 'Rheumatoid arthritis') !== false) echo 'checked'; ?> name="medical_conditions[]"> Rheumatoid arthritis
                    														</li>
                    														<li>
                    															<input type="checkbox" value="Severe mental illness" <?php if (strpos($row->medical_conditions, 'Severe mental illness') !== false) echo 'checked'; ?> name="medical_conditions[]"> Severe mental illness
                    														</li>
                    														<li>
                    															<input type="checkbox" value="On blood pressure treatment" <?php if (strpos($row->medical_conditions, 'On blood pressure treatment') !== false) echo 'checked'; ?> name="medical_conditions[]"> On blood pressure treatment
                    														</li>
                    														<!--<li>
                    														<input type="checkbox" value="Atrial migraines" name="medical_conditions[]"> Atrial migraines
                    														</li>-->
                    														<li>
                    															<input type="checkbox" value="On atypical antipsychotic medication" <?php if (strpos($row->medical_conditions, 'On atypical antipsychotic medication') !== false) echo 'checked'; ?> name="medical_conditions[]"> On atypical antipsychotic medication
                    														</li>
                    														<li>
                    															<input type="checkbox" value="A diagnosis of or treatment for erectile disfunction" <?php if (strpos($row->medical_conditions, 'A diagnosis of or treatment for erectile disfunction') !== false) echo 'checked'; ?> name="medical_conditions[]"> A diagnosis of or treatment for erectile disfunction
                    														</li>
                    														<li>
                    															<input type="checkbox" value="Are you on regular steroid tablets?" <?php if (strpos($row->medical_conditions, 'Are you on regular steroid tablets?') !== false) echo 'checked'; ?> name="medical_conditions[]"> Are you on regular steroid tablets?
                    														</li>
                    														<li>
                    															<input type="checkbox" value="Do you have migraines" <?php if (strpos($row->medical_conditions, 'Do you have migraines') !== false) echo 'checked'; ?> name="medical_conditions[]"> Do you have migraines?
                    														</li>
                    														
                    													</ul>
                    
                    													
                    													</div>
												            </div>

														
																								
                        											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        												<label>Do you have a family medical history of any of the following? </label>
                        												<div class="radio-group" style="display:none">
                        													<div class="md-radio md-radio-inline">
                        														<input class="medi_his rc" <?php //if($row->track_family_med=='Yes') { echo 'checked=""'; } ?> id="medi_his_Yes" value="Yes" type="radio" name="track_family_med" >
                        														<label for="medi_his_Yes">Yes</label>
                        													</div>
                        													<div class="md-radio md-radio-inline">
                        														<input class="medi_his rc" <?php //if($row->track_family_med=='No' || $row->track_family_med=='') { echo 'checked=""'; } ?> checked
                        															   id="medi_his_No" value="No" type="radio" name="track_family_med" >
                        														<label for="medi_his_No">No</label>
                        													</div>
                        													
                        
                        																			</div>
                        													<div class="add_detail medi_his_detail  <?php if($row->track_family_med=='Yes') { echo 'show'; } ?>" id="medi_his_detail" style="display:block;margin:0px">
                        
                        													<ul>
                        														<li>
                        														<input type="checkbox" value="angina or heart attack aged <60" <?php if (strpos($row->family_medical, 'angina or heart attack aged <60') !== false) echo 'checked'; ?> name="family_medical[]"> Angina or heart attack aged &lt;60
                        													    </li>
                        
                        													    <li>
                        														<input type="checkbox" value="dementia" <?php if (strpos($row->family_medical, 'dementia') !== false) echo 'checked'; ?> name="family_medical[]"> Dementia 
                        														</li>
                        														<li>
                        														<input type="checkbox" value="diabetes" <?php if (strpos($row->family_medical, 'diabetes') !== false) echo 'checked'; ?> name="family_medical[]"> Diabetes
                        														</li>
                        														<li>
                        														<input type="checkbox" value="high blood pressure" <?php if (strpos($row->family_medical, 'high blood pressure') !== false) echo 'checked'; ?> name="family_medical[]"> High blood pressure
                        														</li>
                        													
                        														
                        														</ul>
                        
                        															</div>
                        														</div>
																	</div>
																	<div class="clearfix"></div>
																</div>
													<?php } ?>


													<?php if($user->userGender=='Female'){ ?>
														<div class="form-group">
															<div class="row">
																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																		<label>Have you been checked for ovarian cancer ?</label>
																		<div class="radio-group">
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->ovarian_cancer=='Yes') { echo 'checked=""'; } ?> id="ovarian_cancer_Yes" value="Yes" type="radio" name="ovarian_cancer" >
																				<label for="ovarian_cancer_Yes">Yes</label>
																			</div>
																			<div class="md-radio md-radio-inline">
																				<input class="trackHeart rc" <?php //if($row->ovarian_cancer=='No' || $row->ovarian_cancer=='') { echo 'checked=""'; } ?> checked id="ovarian_cancer_No" value="No" type="radio" name="ovarian_cancer" >
																				<label for="ovarian_cancer_No">No</label>
																			</div>
																		</div>
																		<div class="add_detail trackHeart_detail <?php if($row->ovarian_cancer=='Yes') { echo 'show'; } ?> " id="ovarian_lastcheck">
																			<label>Date last measured</label>
																			<input type="text" class="form-control date" name="ovarian_lastcheck"  value="<?php if($row->ovarian_lastcheck!='0000-00-00'){ echo $row->ovarian_lastcheck; } ?>" />
																		</div>
																	</div>












																	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        												<label>Do you have a family medical history of any of the following? </label>
																			
																			
																			<div class="radio-group" style="display:none">
																				<div class="md-radio md-radio-inline">
																					<input class="medi_his rc" <?php //if($row->track_family_med=='Yes') { echo 'checked=""'; } ?> id="medi_his_Yes" value="Yes" type="radio" name="track_family_med" >
																					<label for="medi_his_Yes">Yes</label>
																				</div>
																				<div class="md-radio md-radio-inline">
																					<input class="medi_his rc" <?php //if($row->track_family_med=='No' || $row->track_family_med=='') { echo 'checked=""'; } ?> checked id="medi_his_No" value="No" type="radio" name="track_family_med" >
																					<label for="medi_his_No">No</label>
																				</div>
																				
							
																			</div>

																			
                        													<div class="add_detail medi_his_detail  <?php if($row->track_family_med=='Yes') { echo 'show'; } ?>" id="medi_his_detail" style="display:block;margin:0px">
                        
																				<ul>
																					<li>
																					<input type="checkbox" value="angina or heart attack aged <60" name="family_medical[]"> Angina or heart attack aged &lt;60
																					</li>
							
																					<li>
																					<input type="checkbox" value="dementia" name="family_medical[]"> Dementia 
																					</li>
																					<li>
																					<input type="checkbox" value="diabetes" name="family_medical[]"> Diabetes
																					</li>
																					<li>
																					<input type="checkbox" value="high blood pressure" name="family_medical[]"> High blood pressure
																					</li>
																				
																					
																				</ul>
                        
                        													</div>


                        														<!-- </div> -->
																	</div>

















																	

																	<div class="clearfix"></div>
															</div>
														</div>
													<?php } ?>


															<div class="form-group">
																<div class="row">
																	


										</div>
									</div>






														</div>



														<ul class="list-inline pull-right">
															<li><button type="button" class="tran3s cart-button btn-defualt block hvr-trim-two prev-step">Previous</button></li>
															<li><button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two next-step">Save</button></li>
														</ul>
													</div>
												</div>
											</div>








													<div class="clearfix"></div>
												</div>
											</form>
										</div>
									</section>
								</div>

							</div> <!-- /.col- -->

						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script type="text/javascript" src="<?=base_url('assets/plugins/bootstrap-datepicker-master/moment.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/plugins/bootstrap-datepicker-master/bootstrap-datetimepicker.min.js')?>"></script>
	<script type="text/javascript">
		$('.gender option[value="<?=$user->userGender?>"]').prop('selected', true);
		$('.bodyType option[value="<?=$row->bodyType?>"]').prop('selected', true);
		$('.smoker option[value="<?=$row->smoker?>"]').prop('selected', true);
		$('.diabetesStatus option[value="<?=$row->diabetesStatus?>"]').prop('selected', true);
		$('.chronicKidneyDisease option[value="<?=$row->chronicKidneyDisease?>"]').prop('selected', true);
	</script>


	<script type="text/javascript">
		

	function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
        return false;
        return true;
	}
		   
    function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }


	</script>



	<script type="text/javascript">
		$(document).ready(function () {
			$('.date').datetimepicker({
				format: 'DD-MM-YYYY'
			});
			$('.rc').change(function (e) {
				var id=this.id;
				var res = id.split("_");
				if(this.value=='Yes')
				{
					$('.'+res[0]+'_detail').show();
				}
				else
				{
					$('.'+res[0]+'_detail').hide();
					$('.'+res[0]+'_detail').removeClass('show');
					$('.'+res[0]+'_inp').val('');
				}
			});

			$('.number').keypress(function(event) {
				if(event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)
					return true;
				else if((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
					event.preventDefault();
			});

			//Initialize tooltips
			$('.nav-tabs > li a[title]').tooltip();

			//Wizard
			$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

				var $target = $(e.target);

				if ($target.parent().hasClass('disabled')) {
					return false;
				}
			});

			$(".next-step").click(function (e) {
				
				// Added By david
				if(this.id == 'stp2'){
					var qheight = $("#qheight").val();
					var qweight = $("#qweight").val();
					var qhipMeasurment = $("#qhipMeasurment").val();
					var qwaistMeasurment = $("#qwaistMeasurment").val();

					if(countDecimals(qheight) > 1 || countDecimals(qweight) > 1 || countDecimals(qhipMeasurment) > 1 || countDecimals(qwaistMeasurment) > 1){
						show_err("Please enter value upto 1 decimal only"); 
						return false;
					}

					// if(qheight <= 0 || qweight <= 0 || qhipMeasurment <= 0 || qwaistMeasurment <= 0){
					// 	show_err("No negative values accepted. Please enter a positive value"); 
					// 	return false;
					// }

					if(qheight < 0 || qweight < 0 || qhipMeasurment < 0 || qwaistMeasurment < 0){
						show_err("No negative values accepted."); 
						return false;
					}

					if(qheight > 300){
						show_err("Height must be less than or equals to 300 cm"); 
						return false;	
					}

					if(qweight > 700){
						show_err("Weight must be less than or equals to 700 cm"); 
						return false;	
					}

					if(qhipMeasurment > 300){
						show_err("HipMeasurment must be less than or equals to 300 cm"); 
						return false;	
					}

					if(qwaistMeasurment > 300){
						show_err("WaistMeasurment must be less than or equals to 300 cm"); 
						return false;
					}
				}

				// End

				var $active = $('.wizard .nav-tabs li.active');
				$active.next().removeClass('disabled');
				nextTab($active);

			});
			$(".prev-step").click(function (e) {

				var $active = $('.wizard .nav-tabs li.active');
				prevTab($active);

			});
		});

		function nextTab(elem) {
			$(elem).next().find('a[data-toggle="tab"]').click();
		}
		function prevTab(elem) {
			$(elem).prev().find('a[data-toggle="tab"]').click();
		}
		$('#frm_1').submit(function()
		{
			var frm=$(this);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data:frm.serialize(),
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
											location.href = "<?php echo base_url(); ?>hub";
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
			return false;
		});


		var countDecimals = function (value) { 
			if ((value % 1) != 0) 
				return value.toString().split(".")[1].length;  
			return 0;
		};
	</script>

</div> <!-- /.main-page-wrapper -->
</body>
</html>


<script type="text/javascript">
		
	$("input[type='radio'][name='exercise']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#exerciseDetail').css("display","block");

      }

      if(value == "No"){
      		$('#exerciseDetail').removeClass("show");
      		$('#exerciseDetail').css("display","none");

      }


      
});

	$("input[type='radio'][name='sleepTrack']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#sleepDetail').css("display","block");

      }

      if(value == "No"){

      		$('#sleepDetail').removeClass("show");
      		$('#sleepDetail').css("display","none");

      }


      
});


	$("input[type='radio'][name='step']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#stepDetail').css("display","block");

      }

      if(value == "No"){

      		$('#stepDetail').removeClass("show");
      		$('#stepDetail').css("display","none");

      }


      
});

	$("input[type='radio'][name='smokeTrack']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#smokeDetail').css("display","block");

      }

      if(value == "No"){

      		$('#smokeDetail').removeClass("show");
      		$('#smokeDetail').css("display","none");

      }


      
});

$("input[type='radio'][name='waterTrack']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#waterDetails').css("display","block");

      }

      if(value == "No"){

      		$('#waterDetails').removeClass("show");
      		$('#waterDetails').css("display","none");

      }


      
});

$("input[type='radio'][name='alcoholTrack']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#alcoholDetails').css("display","block");

      }

      if(value == "No"){

      		$('#alcoholDetails').removeClass("show");
      		$('#alcoholDetails').css("display","none");

      }


      
});

$("input[type='radio'][name='diet']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#follow_diet').css("display","block");
			$('#new_nt_goals').css("display","block");

      }

      if(value == "No"){

      		$('#follow_diet').removeClass("show");
      		$('#follow_diet').css("display","none");

			$('#new_nt_goals').css("display","none");

      }


      
});

$("#dietDetails").on('change',function() {


      var value = $(this).val();


     if(value == 'other'){

     	$('#not_follow_diet').css("display","block");

     }else{

     	$('#not_follow_diet').css("display","none");

     }



      
});






$("input[type='radio'][name='testicular_cancer']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#testicular_lastcheck').css("display","block");

      }

      if(value == "No"){

      		$('#testicular_lastcheck').removeClass("show");
      		$('#testicular_lastcheck').css("display","none");

      }


      
});


$("input[type='radio'][name='prostateCancer']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#prostateCancerLastCheck').css("display","block");

      }

      if(value == "No"){

      		$('#prostateCancerLastCheck').removeClass("show");
      		$('#prostateCancerLastCheck').css("display","none");

      }


      
});


$("input[type='radio'][name='ovarian_cancer']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#ovarian_lastcheck').css("display","block");

      }

      if(value == "No"){

      		$('#ovarian_lastcheck').removeClass("show");
      		$('#ovarian_lastcheck').css("display","none");

      }


      
});


$("input[type='radio'][name='intolerances']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#intolerances_detail').css("display","block");
			$('#new_nt_goals_diet').css("display","block"); // added by david
			  

      }

      if(value == "No"){

      		$('#intolerances_detail').removeClass("show");
      		$('#intolerances_detail').css("display","none");
			$('#new_nt_goals_diet').css("display","none"); // added by david

      }

       if(value == "unsure"){

      		$('#intolerances_detail').removeClass("show");
      		$('#intolerances_detail').css("display","none");
			$('#new_nt_goals_diet').css("display","none"); // added by david

      }


      
});

$("input[type='radio'][name='track_family_med']").click(function() {


      var value = $(this).val();


      if(value == "Yes"){

      		$('#medi_his_detail').css("display","block");

      }

      if(value == "No"){

      		$('#medi_his_detail').removeClass("show");
      		$('#medi_his_detail').css("display","none");

      }

    


      
});



function show_err(msg){
	$.confirm({
			title: 'Error!',
			icon:  'fa fa-warning',
			closeIcon: true,
			content: msg,
			type: 'red',
			autoClose: 'close|5000',
			typeAnimated: true,
			buttons: {
				close: function () {
				}
			}
	});
}





</script>