<?php $this->load->view('admin/includes/head'); ?>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/pages/list-scroll/list.css">
<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/bower_components/owl.carousel/css/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/pages.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/test.css">
<link rel="stylesheet" href="<?=base_url('assets/plugins/morris')?>/morris.css">
</head>
<body>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
	<div class="loader-bar"></div>
</div>
<!-- [ Pre-loader ] end -->
<div id="pcoded" class="pcoded">
	<div class="pcoded-overlay-box"></div>
	<div class="pcoded-container navbar-wrapper">
		<!-- [ Header ] start -->
		<?php $this->load->view('admin/includes/menu'); ?>
		<!-- [ Header ] end -->
		<div class="pcoded-main-container">
			<div class="pcoded-wrapper">
				<!-- [ navigation menu ] start -->
				<?php $this->load->view('admin/includes/sidebar'); ?>
				<!-- [ navigation menu ] end -->

				<div class="pcoded-content">
					<!-- [ breadcrumb ] start -->
					<div class="page-header">
						<div class="page-block">
							<div class="row align-items-center">
								<div class="col-md-8">
									<div class="page-header-title">
										<h4 class="m-b-10"><?=$test->testName?> detail</h4>
									</div>
									<ul class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=$this->config->item('admin_url')?>">
												<i class="feather icon-home"></i>
											</a>
										</li>
										<li class="breadcrumb-item">
											<a href="<?=$this->config->item('admin_url')?>/orders_items">
												Order Items
											</a>
										</li>
										<li class="breadcrumb-item">
											<a href="javascript:;"><?=$test->testName?> detail</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- [ breadcrumb ] end -->
					<div class="pcoded-inner-content">
						<div class="main-body">
							<div class="page-wrapper">
								<!-- Page-body start -->
								<div class="page-body">
									<div class="row">
										<div class="col-lg-12">
											<!-- tab header start -->
											<div class="tab-header card">
												<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
													<?php $s='active';
													 if($order_details->productType=='Test') {
														if($order_details->detailStatus=='Recieved' || $order_details->detailStatus=='Completed') {?>
															<li class="nav-item">
																<a class="nav-link active" data-toggle="tab" href="#results" role="tab">Results</a>
																<div class="slide"></div>
															</li>
													<?php $s=''; }
													 	} ?>
													 <?php
													 if($order_details->productType=='Test') {
														if($order_details->detailStatus=='Draft') {?>
															<li class="nav-item">
																<a class="nav-link active" data-toggle="tab" href="#results" role="tab">Results</a>
																<div class="slide"></div>
															</li>
													<?php $s='';}
													 	} ?>
													<li class="nav-item">
														<a class="nav-link <?=$s?>" data-toggle="tab" href="#personal" role="tab">Orders Information</a>
														<div class="slide"></div>
													</li>
													<?php if($order_details->productType=='MealPrep'){ ?>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#exta_info" role="tab">Extra Information</a>
														<div class="slide"></div>
													</li>
													<?php } ?>
													<li class="nav-item">
														<a class="nav-link" data-toggle="tab" href="#shipping" role="tab">Shipping Address</a>
														<div class="slide"></div>
													</li>

												</ul>
											</div>
											<!-- tab header end -->
											<!-- tab content start -->
											<div class="tab-content">
												<!-- tab panel personal start -->
												<?php
												if($order_details->productType=='Test') {
												

												if($order_details->detailStatus=='Draft' || $order_details->detailStatus=='Recieved' || $order_details->detailStatus=='Completed'){
												?>
													<div class="tab-pane active" id="results" role="tabpanel">
														<form id="updateResultForm" method="POST">
															<!-- personal card start -->
															<div class="card">
																<div class="card-header">
																	<div class="row">
																		<div class="col-lg-6">
																			<h5 class="card-header-text">Preview Test Results </h5>
																		</div>
																		
																		
																		<?php 
																			if($order_details->detailStatus=='Draft'){
																		?>
																				<!-- <div class="col-lg-2 text-right">
																					 <a href="<?php echo base_url().'admin/orders_items/index/draft'; ?>" class="btn btn-primary">Back</a> 
																				</div> -->
																				<div class="col-lg-2 text-center">
																					<input type="submit" id="saveOnlyBtn" value="Save Only" class="btn btn-primary">
																				</div>
																				<div class="col-lg-2 text-left">
																					<input type="submit" id="savePublishBtn" value="Save and Publish" class="btn btn-primary">
																				</div>
																		<?php
																			}
																			if($order_details->detailStatus=='Completed'){
																		?>
																				<!-- <div class="col-lg-3 text-right">
																					<a href="<?php echo base_url().'admin/orders_items/index/completed'; ?>" class="btn btn-primary">Back</a> 
																				</div> -->
																				<?php
																					if(isset($_SESSION['pin'])){
																				?>
																						<div class="col-lg-4 text-right">
																							<input type="submit" id="savePublishBtn" value="Save and Publish" class="btn btn-primary">
																						</div>
																				<?php
																					}
																					else{
																				?>
																						<div class="col-lg-4 text-right">
																							<a href="<?php echo base_url().'admin/orders_items/loadEditPassView/'.$order_details->detailId; ?>" class="btn btn-primary">Edit</a>
																						</div>
																				<?php
																					}
																				?>
																				
																		<?php
																			}
																		?>

																		  
																		<div class="dropdown col-lg-2">
																		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		    Select Results
																		  </button>
																		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																		  	<?php
																		  		if(!empty($same_test_results)){
																		  			foreach ($same_test_results as $result) {
																		  	?>
																		  				<a class="dropdown-item" href="<?php echo $result->detailId; ?>"><?php echo $result->sample_taken_on; ?></a>
																		  	<?php
																		  			}
																		  		}
																		  	?>
																		    
																		  </div>
																		</div>
																	</div>																	
																</div>

																<div class="card-block">
																	
																		<div class="view-info">
																			<div id="html-2-pdfwrapper">
																				<div class="row">
																					<div class="col-lg-12">
																						<table class="table table-borderless table-sm">
																						  	<thead>
																						    	<tr>
																						      		<td scope="col">
																						      			<strong>Test Name:</strong>
																						      			<?=$results[0]->testName?>
																						      		</td>
																						      		<td scope="col">
																						      			<strong>Sample Taken:</strong>
																						      			<?=$results[0]->sample_taken_on?>
																						      		</td>
																						      		<td scope="col">
																						      			<strong>Result Recieved:</strong>
																						      			<?=$results[0]->result_processed_on?>
																						      		</td>
																						    	</tr>
																						    	<tr>
																						    		<td scope="col">
																						      			<strong>Patient ID:</strong>
																						      			<?php echo $order_details->userId; ?>
																						      		</td>
																						      		<td scope="col">
																						      			<strong>First Name:</strong>
																						      			<?php echo $order_details->userFirstName; ?>
																						      		</td>
																						      		<td scope="col">
																						      			<strong>Last Name:</strong>
																						      			<?php echo $order_details->userLastName; ?>
																						      		</td>
																						    	</tr>
																						    	<tr>
																						      		<!-- <td scope="col">
																						      			<strong>Age:</strong>

																						      			<?php
																						      				$dateOfBirth = $order_details->dob;
																											$today = date("Y-m-d");
																											$diff = date_diff(date_create($dateOfBirth), date_create($today));
																											echo 'Age is '.$diff->format('%y');
																						      			?>
																						      			30
																						      		</td> -->
																						      		<td scope="col">
																						      			<strong>DoB:</strong>
																						      			<?php echo $order_details->dob; ?>
																						      		</td>
																						      		<td scope="col" colspan="2">
																						      			<strong>Gender:</strong>
																						      			<?php echo $order_details->gender; ?>
																						      		</td>
																						    	</tr>
																						    	<tr>
																						      		<td scope="col" colspan="3">
																						      			<strong>Address:</strong>
																						      			<?php echo $order_details->userAddress; ?>
																						      		</td>
																						    	</tr>
																						  	</thead>
																						</table>
																					</div>
																				</div>
																				
																				
																			<?php
																			// print_r($results);
																			$i=0;
																				foreach ($results as $res){
																					$i++;

																					
																				

																					?>
																				<h4 style="text-decoration: underline;"><?php echo $res->marker_title;?></h4>
																					<div class="row col-lg-12">
																						<!-- <div class="col-lg-2"></div> -->
																						<div class="col-lg-12">
																							<br>
																							<?php
																								if($order_details->detailStatus=='Completed' && !isset($_SESSION['pin'])){
																							?>
																								<?php echo $res->topText?>
																							<?php
																								}
																								else{
																							?>
																<div class="row">
																	<div class="col-lg-5">
																		<label class="j-label"><b>Test Result Value</b></label>
																		<input type="text" name="resultValue[]" id="<?php echo 'resultValue'.$i ?>"   value="<?php echo $res->resultValue; ?>" class="col-sm-12 form-control decimal" required="true" onkeyup="var resultValue=$('<?php echo '#resultValue'.$i ?>').val();	var minValue=$('<?php echo '#minValue'.$i ?>').val(); var maxValue=$('<?php echo '#maxValue'.$i ?>').val();  if ( parseInt(resultValue) < parseInt(minValue) || parseInt(resultValue) > parseInt(maxValue) )  { $('<?php echo '#message'.$i ?>').html('Result value should be in between the Min and Max value').css('color', 'red'); } else { $('<?php echo '#message'.$i ?>').html('').css('color', 'red'); }">
																		<span id='<?php echo 'message'.$i ?>'></span>
																	</div>
																</div>
																<br><br>

																<div class="row">
																	<div class="col-lg-3">
																		<label class="j-label">Min Value</label>
																		<input type="text" name="minValue[]" id="<?php echo 'minValue'.$i ?>" class="col-sm-12 form-control decimal"  value="<?php echo $res->min_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue'.$i ?>').val();	var minValue=$('<?php echo '#minValue'.$i ?>').val(); var maxValue=$('<?php echo '#maxValue'.$i ?>').val(); var lowerValue=$('<?php echo '#lowerValue'.$i ?>').val(); var uperValue=$('<?php echo '#uperValue'.$i ?>').val(); if ( parseInt(resultValue) < parseInt(minValue) || parseInt(maxValue) < parseInt(minValue) || parseInt(lowerValue) < parseInt(minValue) || parseInt(uperValue) < parseInt(minValue) )  { $('<?php echo '#min_message'.$i ?>').html('Min Value cannot be greater than Result Value or Max Value or Lower Value or Upper Value').css('color', 'red'); } else { $('<?php echo '#min_message'.$i ?>').html('').css('color', 'red'); }">
																		<span id='<?php echo 'min_message'.$i ?>'></span>
																	</div>
																	<div class="col-lg-3">
																		<label class="j-label">Lower Value</label>
																		<input type="text" name="lowerValue[]" id="<?php echo 'lowerValue'.$i ?>" class="col-sm-12 form-control decimal"  value="<?php echo $res->lower_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue'.$i ?>').val(); var maxValue=$('<?php echo '#maxValue'.$i ?>').val(); var lowerValue=$('<?php echo '#lowerValue'.$i ?>').val(); var uperValue=$('<?php echo '#uperValue'.$i ?>').val(); var minValue=$('<?php echo '#minValue'.$i ?>').val();  if (parseInt(maxValue) < parseInt(lowerValue) || parseInt(uperValue) < parseInt(lowerValue) || parseInt(minValue) > parseInt(lowerValue) )  { $('<?php echo '#lower_message'.$i ?>').html('Lower Value cannot be smaller than Min Value and  Lower Value cannot be greater than Upper Value or Max Value').css('color', 'red'); } else { $('<?php echo '#lower_message'.$i ?>').html('').css('color', 'red'); }">
																		<span id='<?php echo 'lower_message'.$i ?>'></span>
																	</div>
																	<div class="col-lg-3">
																		<label class="j-label">Upper Value</label>
																		<input type="text" name="upperValue[]" id="<?php echo 'uperValue'.$i ?>" class="col-sm-12 form-control decimal"  value="<?php echo $res->upper_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue'.$i ?>').val(); var maxValue=$('<?php echo '#maxValue'.$i ?>').val(); var lowerValue=$('<?php echo '#lowerValue'.$i ?>').val(); var uperValue=$('<?php echo '#uperValue'.$i ?>').val(); var minValue=$('<?php echo '#minValue'.$i ?>').val();  if (parseInt(maxValue) < parseInt(uperValue) || parseInt(lowerValue) > parseInt(uperValue) || parseInt(minValue) > parseInt(uperValue) )  { $('<?php echo '#upper_message'.$i ?>').html('Upper Value cannot be smaller than Min Value or Lower Value and  Lower Upper cannot be greater than Max Value').css('color', 'red'); } else { $('<?php echo '#upper_message'.$i ?>').html('').css('color', 'red'); }">
																		<span id='<?php echo 'upper_message'.$i ?>'></span>
																	</div>
																	<div class="col-lg-3">
																		<label class="j-label">Max Value</label>
																		<input type="text" name="maxValue[]" id="<?php echo 'maxValue'.$i ?>" class="col-sm-12 form-control decimal"  value="<?php echo $res->max_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue'.$i ?>').val(); var maxValue=$('<?php echo '#maxValue'.$i ?>').val(); var lowerValue=$('<?php echo '#lowerValue'.$i ?>').val(); var uperValue=$('<?php echo '#uperValue'.$i ?>').val(); var minValue=$('<?php echo '#minValue'.$i ?>').val();  if ( parseInt(resultValue) > parseInt(maxValue) || parseInt(lowerValue) > parseInt(maxValue) || parseInt(uperValue) > parseInt(maxValue) || parseInt(minValue) > parseInt(maxValue) )  { $('<?php echo '#max_message'.$i ?>').html('Max Value cannot be smaller than Result Value or Lower Value or Upper Value or Min Value').css('color', 'red'); } else { $('<?php echo '#max_message'.$i ?>').html('').css('color', 'red'); }">
																		<span id='<?php echo 'max_message'.$i ?>'></span>
																	</div>
																</div>
																<br><br>

																								<textarea class="form-control col-lg-12" name="topText[]" id="topText" rows="3"><?php echo $res->topText?></textarea>
																							<?php
																								}
																							?>
																							
																							<input type="hidden" name="resultId[]" id="resultId" value="<?php echo $res->resultId;?>">
																							<input type="hidden" name="detailId" id="detailId" value="<?php echo $results[0]->detailId;?>">
																						</div>
																					</div>
																					<br><br>
																					<div class="single-service">
																						<div class="clearfix"></div>
																						<div class="price-ranger col-lg-12">

																						<div class="row">
																							<div class="col-md-1"></div>
																							<div class="col-md-10">
      																							<div id = "<?php echo 'container'.$i; ?>" style = "width: 100%; height: 100px; margin: 0 auto">
      																							</div>
																							</div>
																						</div>
																						<br>

																						</div> <!-- /price-ranger -->
																						<div class="clearfix"></div>
																						<div class="res_div">Result = <?php echo $res->resultValue?> <?php echo $res->resultUnit?></div>
																						<div class="clearfix"></div>
																					</div> <!-- /.single-service -->

																					<div class="row col-lg-12">
																						<!-- <div class="col-lg-2"></div> -->
																						<div class="col-lg-12">
																							<br>
																							<?php
																								if($order_details->detailStatus=='Completed' && !isset($_SESSION['pin'])){
																							?>
																									
																									<?php echo $res->bottomText?>
																							<?php
																								}
																								else{
																							?>
																									<textarea class="form-control col-lg-12" name="bottomText[]" id="bottomText" rows="3"><?php echo $res->bottomText?></textarea>
																										
																							<?php
																								}
																							?>
																						</div>
																					</div>
																			<!-- </fieldset> -->
																					<hr>

																			<?php  } ?>
																			</div>
																		</div>
																		<!-- end of view-info -->
																	<?php
																		if($order_details->detailStatus=='Completed' && !isset($_SESSION['pin'])){
																	?>
																			<div class="row">
																				<div class="col-lg-4">
																					<a href="javascript:;" onclick="generate()" class="btn btn-success">Download Results</a>
																				</div>
																			</div>
																	<?php
																		}
																	?>
																</div>
																<!-- end of card-block -->
															</div>
														</form>
													</div>
												<?php
												}
												} ?>
												<div class="tab-pane <?=$s?>" id="personal" role="tabpanel">
													<!-- personal card start -->
													<div class="card">
														<div class="card-header">
															<h5 class="card-header-text"><?=$test->testName?></h5>
														</div>
														<div class="card-block">
															<div class="view-info">
																<div class="row">
																	<div class="col-lg-12">
																		<div class="general-info">
																			<div class="row">
																				<div class="col-lg-12 col-xl-6">
																					<div class="table-responsive">
																						<table class="table m-0">
																							<tbody>
																							<tr>
																								<th scope="row">Name</th>
																								<td><?=$test->testName?></td>
																							</tr>
																							<tr>
																								<th scope="row">Product Type</th>
																								<td><?=$order_details->productType?></td>
																							</tr>
																							<tr>
																								<th scope="row">Original Price</th>
																								<td><i class="icofont icofont-cur-pound"></i> <?=$order_details->orginalPrice?></td>
																							</tr>

																							<?php if($order_details->membershipStatus!='') { ?>
																								<tr>
																									<th scope="row">Membership Status</th>
																									<td><?=$order_details->membershipStatus?></td>
																								</tr>
																							<?php }else{ ?>
																								<tr>
																									<th scope="row">Membership Status</th>
																									<td>Inactive</td>
																								</tr>
																							<?php } ?>
																							<?php if($order_details->membershipDate!='0000-00-00') { ?>
																								<tr>
																									<th scope="row">Membership Date</th>
																									<td><?=$order_details->membershipDate?></td>
																								</tr>
																							<?php } ?>

																							<tr>
																								<th scope="row">created Date</th>
																								<td><?=$order_details->createdAt?></td>
																							</tr>
																							<tr>
																								<th scope="row">Updated Date</th>
																								<td><?=$order_details->updatedAt?></td>
																							</tr>

																							</tbody>
																						</table>
																					</div>
																				</div>
																				<!-- end of table col-lg-6 -->
																				<div class="col-lg-12 col-xl-6">
																					<table class="table m-0">
																						<tbody>
																						<tr>
																							<th scope="row">Member Name</th>
																							<td><?=$order_details->userFirstName?> <?=$order_details->userLastName?></td>
																						</tr>
																						<tr>
																							<th scope="row">Status</th>
																							<td>

																								<?php if($order_details->detailStatus=='Pending')
																								{
																									echo '<label class="label label-primary">Pending</label>';
																								}
																								else if($order_details->detailStatus=='Completed')
																								{
																									echo '<label class="label label-success">Completed</label>';
																								}
																								else if($order_details->detailStatus=='Canceled')
																								{
																									echo '<label class="label label-danger">Canceled</label>';
																								}
																								else if($order_details->detailStatus=='Inprogress')
																								{
																									echo '<label class="label label-info">In Progress</label>';
																								}
																								?></td>
																						</tr>
																						<tr>
																							<th scope="row">Schedule Date</th>
																							<td><?=$order_details->scheduleDate?></td>
																						</tr>
																						<tr>
																							<th scope="row">Paid Price</th>
																							<td><i class="icofont icofont-cur-pound"></i> <?=$order_details->detailPrice?></td>
																						</tr>
																						<tr>
																							<th scope="row">Quantity</th>
																							<td><?=$order_details->detailQty?></td>
																						</tr>
																						<tr>
																							<th scope="row">Payment Status</th>
																							<td>
																								<?php if($order_details->paymentStatus=='Yes')
																								{
																									echo '<label class="label label-success">Paid</label>';
																								}
																								else
																								{
																									echo '<label class="label label-danger">UnPaid</label>';
																								}?></td>
																						</tr>
																						<tr>
																							<th scope="row">Payment Type</th>
																							<td><?=$order_details->paymentType?></td>
																						</tr>

																						</tbody>
																					</table>

																				</div>
																				<!-- end of table col-lg-6 -->
																			</div>
																			<!-- end of row -->
																			<div class="row">
																				<div class="col-md-12 text-right">

																					<?php if($order_details->productType!='Test') { ?>
																						<?php if($order_details->detailStatus=='Pending') { ?>
																							<button type="button" onclick="sta('Completed')" class="btn btn-primary">Mark as Completed</button>
																						<?php } ?>
																					<?php }else { ?>
																						<?php if($order_details->detailStatus=='Pending') { ?>
																							<button type="button" onclick="sta('Inprogress')" class="btn btn-primary">Mark as In Progress</button>
																						<?php } ?>
																						<?php if($order_details->detailStatus=='Inprogress') { ?>
																							<label class="label label-primary"> Wait for Result </label>
																						<?php } ?>

																					<?php } ?>
																				</div>
																			</div>

																		</div>
																		<!-- end of general info -->
																	</div>
																	<!-- end of col-lg-12 -->
																</div>
																<!-- end of row -->
															</div>
															<!-- end of view-info -->

														</div>
														<!-- end of card-block -->
													</div>

												</div>
												<!-- tab pane personal end -->
												<!-- tab pane info start -->
												<?php if($order_details->productType=='MealPrep'){ ?>
												<div class="tab-pane" id="exta_info" role="tabpanel">
													<!-- info card start -->
													<?php $extra=json_decode($order_details->extra); ?>
													<div class="card">
														<div class="card-header">
															<h5 class="card-header-text">Extra Information</h5>
														</div>
														<div class="card-block">
															<div class="row">
																<div class="col-lg-12">
																	<div class="general-info">
																		<div class="row">
																			<div class="col-lg-12 col-xl-6">
																				<div class="table-responsive">
																					<table class="table table-hover m-0">
																						<tbody>
																						<tr>
																							<th scope="row">Diet</th>
																							<td><?=$extra->diet?></td>
																						</tr>
																						<tr>
																							<th scope="row">Meals</th>
																							<td><?=$extra->meals?></td>
																						</tr>
																						<tr>
																							<th scope="row">Want More</th>
																							<td><?=$extra->wantMore?></td>
																						</tr>
																						<tr>
																							<th scope="row">Additional</th>
																							<td><?=$extra->additional?></td>
																							</tr>

																						</tbody>
																					</table>
																				</div>
																			</div>
																			<!-- end of table col-lg-6 -->
																			<div class="col-lg-12 col-xl-6">
																				<table class="table table-hover m-0">
																					<tbody>
																					<tr>
																						<th scope="row">Alergies</th>
																						<td><?=$extra->alergies?> <br>
																						<?php if($extra->alergies_detail!=''){ ?>
																							<b>Detail</b><br>
																							<?=$extra->alergies_detail?>
																						<?php } ?>

																						</td>
																					</tr>
																					<tr>
																						<th scope="row">Delivery</th>
																						<td><?=$extra->delivery?></td>
																					</tr>
																					<tr>
																						<th scope="row">No Want More</th>
																						<td><?=$extra->notWant?></td>
																					</tr>


																					</tbody>
																				</table>

																			</div>
																			<!-- end of table col-lg-6 -->
																		</div>
																		<!-- end of row -->

																	</div>
																	<!-- end of general info -->
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php } ?>
												<!-- tab pane info end -->
												<div class="tab-pane" id="shipping" role="tabpanel">
													<!-- info card start -->
													<div class="card">
														<div class="card-header">
															<h5 class="card-header-text">Shipping Address</h5>
														</div>
														<div class="card-block">
															<div class="row">
																<div class="col-lg-12">
																	<div class="general-info">
																		<div class="row">
																			<div class="col-lg-12 col-xl-6">
																				<div class="table-responsive">
																					<table class="table table-hover m-0">
																						<tbody>
																						<tr>
																							<th scope="row">Name</th>
																							<td><?=$order->orderShipName?></td>
																						</tr>
																						<tr>
																							<th scope="row">Address 1</th>
																							<td><?=$order->orderShipAddress?></td>
																						</tr>
                                                                                        <tr>
																							<th scope="row">Address 2</th>
																							<td><?=$order->orderShipAddress2?></td>
																						</tr>
																						<tr>
																							<th scope="row">State</th>
																							<td><?=$order->orderState?></td>
																						</tr>
																						<tr>
																							<th scope="row">Phone</th>
																							<td><?=$order->orderPhone?></td>
																						</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<!-- end of table col-lg-6 -->
																			<div class="col-lg-12 col-xl-6">
																				<table class="table table-hover m-0">
																					<tbody>
																					<tr>
																						<th scope="row">Email</th>
																						<td><?=$order->orderEmail?></td>
																					</tr>
																					<tr>
																						<th scope="row">City</th>
																						<td><?=$order->orderCity?></td>
																					</tr>
																					<tr>
																						<th scope="row">Postal Code</th>
																						<td><?=$order->orderPostalCode?></td>
																					</tr>



																					</tbody>
																				</table>

																			</div>
																			<!-- end of table col-lg-6 -->
																		</div>
																		<!-- end of row -->

																	</div>
																	<!-- end of general info -->
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<!-- tab content end -->
					</div>
				</div>
			</div>
			<!-- Page-body end -->
		</div>
	</div>
</div>


<!-- Warning Section Starts -->
<?php $this->load->view('admin/includes/scripts'); ?>


<script type="text/javascript">
	$(function () {
 
	    $('.decimal').bind('paste', function () {

	        var self = this;
	        setTimeout(function () {
	            if (!/^\d*(\.\d{1,2})+$/.test($(self).val())) $(self).val('');
	        }, 0);
	    });
	    
	    $('.decimal').keypress(function (e) {

	        var character = String.fromCharCode(e.keyCode)
	        var newValue = this.value + character;
	        if (isNaN(newValue) || hasDecimalPlace(newValue, 5)) {
	            e.preventDefault();
	            return false;
	        }
	    });
	    
	    function hasDecimalPlace(value, x) {
	        var pointIndex = value.indexOf('.');
	        return  pointIndex >= 0 && pointIndex < value.length - x;
	    }
	});
</script>

<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"></script>
<script type = "text/javascript"> google.charts.load('current', {packages: ['corechart']});</script>
      

<script>

    function drawChart() {

    	<?php
    			$i=0;
    		foreach ($results as $res){
    			$i++;
    	?>

    	<?php
	        $themin= $res->min_value;
	        $themax= $res->max_value;
	        $theupper= $res->upper_value;
	        $thelower= $res->lower_value;
	        $thevalue= $res->resultValue;
        ?>
        // Define the chart to be drawn.
        var data = google.visualization.arrayToDataTable([
           ['Year', 'Asia', 'Europe', 'Pk' , 'value'],
           	['Result',  <?php echo $thelower?>, <?php echo $theupper - $thelower?>,<?php echo $themax - $theupper?> , <?php echo $thevalue?> ],
          ]);
            var options = {
				isStacked:'absolute',
                allowHtml:true,
				legend:'none',
                displayAnnotations: true,
				'is3D':true,
			 	colors: ['red', 'green', 'red'],
                'tooltip' : {
                  trigger: 'none'
                },
                hAxis: { 
                    viewWindow: { 
                        min:<?php echo $themin?>, 
                        max:<?php echo  $themax ?>
                    },
                    gridlines: {
                        count: Math.ceil(120 * 1.1 /10),
                    }
                    
                },
                orientation: 'vertical',
                      series: {
                        3: {
                          color: 'yellow',
                          type: 'line',
                          lineWidth: 5,
                          showR2: true,
                          
                        }
                      },
                      seriesType: 'bars',
			};  
        // Instantiate and draw the chart.
        var chart = new google.visualization.BarChart(document.getElementById('<?php echo 'container'.$i; ?>'));
        chart.draw(data, options);
        
        <?php
    		}
    	?> 
     }
     google.charts.setOnLoadCallback(drawChart);
     
</script>

<script type="text/javascript">

	function generate()
		{

			var divToPrint=document.getElementById('html-2-pdfwrapper');

			var newWin=window.open('','Print-Window');

			newWin.document.open();

			newWin.document.write("<html><head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' ><link rel='stylesheet' type='text/css' href='<?=base_url('assets/front/')?>css/style.css'><style type='text/css'>.ruler_active {background: #86c44c !important;height: 34px !important;border-left: 0px !important;width: 11% !important; -webkit-print-color-adjust: exact; }</style></head><body onload='window.print()'><h2 style='text-align:center'>Results <?=$order_details->testName?></h2>"+divToPrint.innerHTML+"</body></html>");

			newWin.document.close();

			setTimeout(function(){newWin.close();},10);
		}

	$(document).ready(function(){
	    $(function() {
		   $('#saveOnlyBtn').click(function(e) {
		       $('#updateResultForm').submit(function(e){

					e.preventDefault();

		 			var frm=$(this);
				    var formData = new FormData($('form#updateResultForm').get(0));

					$.confirm({
						icon: 'fa fa-spinner fa-spin',
						title: 'Working!',
						content: function () {
							var self = this;
							return $.ajax({
								url: '<?php echo base_url().'admin/Orders_items/onlySaveResult'; ?>',
								dataType: 'json',
								data: formData,
								processData: false,
								contentType: false,
								method: 'POST',
								 cache: false,
							}).done(function (response) {
								console.log(response);
								// self.close();
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
													location.reload();
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
		    });

		   $('#savePublishBtn').click(function(e) {
		        $('#updateResultForm').submit(function(e){

					e.preventDefault();

		 			var frm=$(this);
				    var formData = new FormData($('form#updateResultForm').get(0));

					$.confirm({
						icon: 'fa fa-spinner fa-spin',
						title: 'Working!',
						content: function () {
							var self = this;
							return $.ajax({
								url: '<?php echo base_url().'admin/Orders_items/saveAndPublishResult'; ?>',
								dataType: 'json',
								data: formData,
								processData: false,
								contentType: false,
								method: 'POST',
								 cache: false,
							}).done(function (response) {
								console.log(response);
								// self.close();
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
													location.reload();
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
		    });
		});
	});


	$('#frm_edit_result').submit(function(evt){
		var frm=$(this);
		var formData = new FormData($('form#frm_edit_result').get(0));
		$.confirm({
			icon: 'fa fa-spinner fa-spin',
			title: 'Working!',
			content: function () {
				var self = this;
				return $.ajax({
					url: frm.attr('action'),
					dataType: 'json',
					data: formData,
					processData: false,
					contentType: false,
					method: 'post',
					cache: false,
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
										location.reload();
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


	function sta(type) {
		$.confirm({
			title: 'Status!',
			content: 'Are you want to change ?',
			type: 'blue',
			typeAnimated: true,
			buttons: {
				Yes: {
					text: 'Yes',
					btnClass: 'btn-green',
					action: function(){
						$.confirm({
							icon: 'fa fa-spinner fa-spin',
							title: 'Working!',
							content: function () {
								var self = this;
								return $.ajax({
									url: "<?=base_url()?>admin/orders_items/change_status",
									dataType: 'json',
									data:{id:<?=$order_details->detailId?>,type:type},
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
														location.reload();
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
				},
				No: function () {
				}
			}
		});
	}
	
</script>
</body>

</html>
