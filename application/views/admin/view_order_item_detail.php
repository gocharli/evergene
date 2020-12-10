<?php $this->load->view('admin/includes/head'); ?>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/list-scroll/list.css">
<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/test.css">
<link rel="stylesheet" href="<?= base_url('assets/plugins/morris') ?>/morris.css">


<style>
	.upload_result_file {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 6px 12px;
		cursor: pointer;
	}
</style>

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
											<h4 class="m-b-10"><?= $test->testName ?> detail</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/orders_items">
													Order Items
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;"><?= $test->testName ?> detail</a>
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
														<?php $s = 'active';
														if ($order_details->productType == 'Test') {
															if ($order_details->detailStatus == 'Recieved' || $order_details->detailStatus == 'Completed') { ?>
																<li class="nav-item">
																	<a class="nav-link active" data-toggle="tab" href="#results" role="tab">Results</a>
																	<div class="slide"></div>
																</li>
														<?php $s = '';
															}
														} ?>
														<?php
														if ($order_details->productType == 'Test') {
															if ($order_details->detailStatus == 'Draft') { ?>
																<li class="nav-item">
																	<a class="nav-link active" data-toggle="tab" href="#results" role="tab">Results</a>
																	<div class="slide"></div>
																</li>
														<?php $s = '';
															}
														} ?>
														<li class="nav-item">
															<a class="nav-link <?= $s ?>" data-toggle="tab" href="#personal" role="tab">Orders Information</a>
															<div class="slide"></div>
														</li>
														<?php if ($order_details->productType == 'MealPrep') { ?>
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
													if ($order_details->productType == 'Test') {


														if ($order_details->detailStatus == 'Draft' || $order_details->detailStatus == 'Recieved' || $order_details->detailStatus == 'Completed') {
													?>
															<div class="tab-pane active" id="results" role="tabpanel">



																<?php if ($results[0]->testResultType == 'Result 4' && ($order_details->detailStatus != 'Completed' || isset($_SESSION['pin']))) { ?>
																	<div class="card">
																		<div class="card-header">
																			<div class="row">
																				<div class="col-lg-12">

																					<label for="file-upload" class="upload_result_file">
																						<i class="fa fa-cloud-upload"></i> Upload New Result File
																					</label>
																					<form id="upload_result4_form" method="post" action="<?php echo base_url(); ?>admin/orders_items/upload_result4" enctype="multipart/form-data">
																						<input id="file-upload" name="upload_result4_up[]" type="file" multiple onchange="upload_result4()" style="display: none" />

																						<input type="hidden" name="detailId_up" value="<?php echo $results[0]->detailId; ?>" />
																						<input id="upload_result4_btn" type="submit" style="display: none" />
																					</form>
																				</div>
																			</div>
																		</div>
																	</div>

																<?php } ?>


																<form id="updateResultForm" method="POST">
																	<!-- personal card start -->
																	<div class="card">
																		<div class="card-header">
																			<div class="row">
																				<div class="col-lg-6">
																					<h5 class="card-header-text">Preview Test Results </h5>
																				</div>
																				<div class="col-lg-3 text-right">
																					<?php if (strlen($results[0]->resultFile) > 1) { ?>
																						<a target="_blank" href="<?php echo base_url() . 'uploads/results/' . $results[0]->resultFile; ?>" class="btn btn-primary">View File</a>
																					<?php } else { ?>
																						<a href="javascript:;" class="btn btn-primary">View File</a>
																					<?php } ?>
																				</div>

																				<?php
																				if ($order_details->detailStatus == 'Draft') {
																				?>

																					<div class="col-lg-2 text-center">
																						<input type="submit" id="saveOnlyBtn" value="Save Only" class="btn btn-primary">
																					</div>
																					<div class="col-lg-2 text-left">
																						<input type="submit" id="savePublishBtn" value="Save and Publish" class="btn btn-primary">
																					</div>
																				<?php
																				}
																				if ($order_details->detailStatus == 'Completed') {
																				?>

																					<?php
																					if (isset($_SESSION['pin'])) {
																					?>
																						<div class="col-lg-4 text-right">
																							<input type="submit" id="savePublishBtn" value="Save and Publish" class="btn btn-primary">
																						</div>
																					<?php
																					} else {
																					?>
																						<div class="col-lg-1 text-right">
																							<a href="<?php echo base_url() . 'admin/orders_items/loadEditPassView/' . $order_details->detailId; ?>" class="btn btn-primary">Edit</a>
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
																						if (!empty($same_test_results)) {
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
																											<?= $results[0]->testName ?>
																										</td>
																										<td scope="col">
																											<strong>Sample Taken:</strong>
																											<?= date('d F Y', strtotime($results[0]->sample_taken_on)) ?>
																										</td>
																										<td scope="col">
																											<strong>Result Recieved:</strong>
																											<?= date('d F Y', strtotime($results[0]->result_processed_on)) ?>
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

																										<td scope="col">
																											<strong>DoB:</strong>
																											<?php echo date('d F Y', strtotime($order_details->dob)); ?>

																										</td>
																										<td scope="col">
																											<strong>Gender:</strong>
																											<?php echo $order_details->gender; ?>
																										</td>
																										<td scope="col">
																											<strong>Result Added By:</strong>
																											<?php echo $results[0]->res_added_by; ?>
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
																					$i = 0;
																					foreach ($results as $res) {
																						$i++;




																					?>
																						<h4 style="text-decoration: underline;"><?php echo $res->marker_title; ?></h4>
																						<div class="row col-lg-12">
																							<div class="col-lg-12">
																								<br>
																								<?php
																								if ($order_details->detailStatus == 'Completed' && !isset($_SESSION['pin'])) {
																								?>
																									<?php if ($results[0]->testResultType != 'Result 3') {
																										echo $res->topText;
																									} ?>
																								<?php
																								} else {
																								?>


																									<?php if ($results[0]->testResultType == 'Result 4') { ?>


																										<?php $var = explode(',', $results[0]->result4File);
																										$c = 1;
																										if (!empty($results[0]->result4File)) {
																											foreach ($var as $f) { ?>
																												<div class="row">
																													<div class="col-lg-12">
																														<label class="j-label" style="width:95%"><b>Result Files <?php echo $c; ?> <span style="float: right"><a style="cursor:pointer; color: white" class="btn btn-danger btn-sm" onclick="remove_file('<?php echo $results[0]->detailId; ?>', '<?php echo $f; ?>')">Remove File</a></span></b></label>
																														<?php if (strpos($f, 'pdf') !== false) { ?>
																															<p><iframe src="<?php echo base_url() . 'uploads/results/' . $f; ?>" frameborder="0" height="400" width="95%"></iframe></p>
																														<?php } else { ?>
																															<a target="_blank" href="<?php echo base_url() . 'uploads/results/' . $f; ?>"><?php echo $f; ?></a>
																														<?php } ?>

																													</div>
																												</div>
																												<br><br>
																										<?php $c++;
																											}
																										}  ?>

																									<?php } else if ($results[0]->testResultType == 'Result 3') { ?>

																										<hr>
																										<fieldset class="form-control">
																											<div class="row">
																												<div class="col-lg-4">
																													<div class="j-unit j-span4">
																														<label class="j-label">Select Test Result</label>
																														<div class="j-input j-select">
																															<select class="js-example-basic-single" name="result3[]" id="result3_<?php echo $res->resultId; ?>" onchange="update_result3('<?php echo $res->resultId; ?>', this.value)" style="width: 100% !important; height:30px!important" required>
																																<option value="">Select Result</option>
																																<option value="Positive" <?php if ($res->result3 == 'Positive') echo 'selected'; ?>>Positive</option>
																																<option value="Negative" <?php if ($res->result3 == 'Negative') echo 'selected'; ?>>Negative</option>

																															</select>
																														</div>
																													</div>
																												</div>
																											</div>

																											<div class="row">
																												<div class="col-lg-3">
																													<label class="j-label">Standard Description</label>
																													<textarea name="standard[]" id="standard_<?php echo $res->resultId; ?>" class="col-sm-12 form-control"><?php echo $res->topText; //echo $marker->tm_standard_description; 
																																																							?></textarea>
																												</div>
																												<div class="col-lg-3">
																													<label class="j-label">Negative Result</label>
																													<textarea name="normal[]" id="normal_<?php echo $res->resultId; ?>" class="col-sm-12 form-control"><?php if ($res->result3 == 'Negative') echo $res->bottomText;
																																																						else echo $marker->tm_normal_description; ?></textarea>
																												</div>
																												<div class="col-lg-3">
																													<label class="j-label">Positive Result</label>
																													<textarea name="abnormal[]" id="abnormal_<?php echo $res->resultId; ?>" class="col-sm-12 form-control"><?php if ($res->result3 == 'Positive')  echo $res->bottomText;
																																																							else echo $marker->tm_abnormal_description; ?></textarea>
																												</div>
																												<div class="col-lg-3">
																													<button type="button" class="btn btn-primary" style="margin-top: 35px;" onclick="update_result3_desc('<?php echo $res->resultId; ?>');">Update</button>
																												</div>
																											</div>
																										</fieldset>

																									<?php } else { ?>


																										<div class="row">
																											<div class="col-lg-5">
																												<label class="j-label"><b>Test Result Value</b></label>
																												<input type="text" name="resultValue[]" id="<?php echo 'resultValue' . $i ?>" value="<?php echo $res->resultValue; ?>" class="col-sm-12 form-control decimal" required="true" onkeyup="var resultValue=$('<?php echo '#resultValue' . $i ?>').val();	var minValue=$('<?php echo '#minValue' . $i ?>').val(); var maxValue=$('<?php echo '#maxValue' . $i ?>').val();  if ( parseInt(resultValue) < parseInt(minValue) || parseInt(resultValue) > parseInt(maxValue) )  { $('<?php echo '#message' . $i ?>').html('Result value should be in between the Min and Max value').css('color', 'red'); } else { $('<?php echo '#message' . $i ?>').html('').css('color', 'red'); }">
																												<span id='<?php echo 'message' . $i ?>'></span>
																											</div>
																										</div>
																										<br><br>

																										<div class="row">
																											<div class="col-lg-3">
																												<label class="j-label">Min Value</label>
																												<input type="text" name="minValue[]" id="<?php echo 'minValue' . $i ?>" class="col-sm-12 form-control decimal" value="<?php echo $res->min_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue' . $i ?>').val();	var minValue=$('<?php echo '#minValue' . $i ?>').val(); var maxValue=$('<?php echo '#maxValue' . $i ?>').val(); var lowerValue=$('<?php echo '#lowerValue' . $i ?>').val(); var uperValue=$('<?php echo '#uperValue' . $i ?>').val(); if ( parseInt(resultValue) < parseInt(minValue) || parseInt(maxValue) < parseInt(minValue) || parseInt(lowerValue) < parseInt(minValue) || parseInt(uperValue) < parseInt(minValue) )  { $('<?php echo '#min_message' . $i ?>').html('Min Value cannot be greater than Result Value or Max Value or Lower Value or Upper Value').css('color', 'red'); } else { $('<?php echo '#min_message' . $i ?>').html('').css('color', 'red'); }">
																												<span id='<?php echo 'min_message' . $i ?>'></span>
																											</div>
																											<div class="col-lg-3">
																												<label class="j-label">Lower Value</label>
																												<input type="text" name="lowerValue[]" id="<?php echo 'lowerValue' . $i ?>" class="col-sm-12 form-control decimal" value="<?php echo $res->lower_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue' . $i ?>').val(); var maxValue=$('<?php echo '#maxValue' . $i ?>').val(); var lowerValue=$('<?php echo '#lowerValue' . $i ?>').val(); var uperValue=$('<?php echo '#uperValue' . $i ?>').val(); var minValue=$('<?php echo '#minValue' . $i ?>').val();  if (parseInt(maxValue) < parseInt(lowerValue) || parseInt(uperValue) < parseInt(lowerValue) || parseInt(minValue) > parseInt(lowerValue) )  { $('<?php echo '#lower_message' . $i ?>').html('Lower Value cannot be smaller than Min Value and  Lower Value cannot be greater than Upper Value or Max Value').css('color', 'red'); } else { $('<?php echo '#lower_message' . $i ?>').html('').css('color', 'red'); }">
																												<span id='<?php echo 'lower_message' . $i ?>'></span>
																											</div>
																											<div class="col-lg-3">
																												<label class="j-label">Upper Value</label>
																												<input type="text" name="upperValue[]" id="<?php echo 'uperValue' . $i ?>" class="col-sm-12 form-control decimal" value="<?php echo $res->upper_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue' . $i ?>').val(); var maxValue=$('<?php echo '#maxValue' . $i ?>').val(); var lowerValue=$('<?php echo '#lowerValue' . $i ?>').val(); var uperValue=$('<?php echo '#uperValue' . $i ?>').val(); var minValue=$('<?php echo '#minValue' . $i ?>').val();  if (parseInt(maxValue) < parseInt(uperValue) || parseInt(lowerValue) > parseInt(uperValue) || parseInt(minValue) > parseInt(uperValue) )  { $('<?php echo '#upper_message' . $i ?>').html('Upper Value cannot be smaller than Min Value or Lower Value and  Lower Upper cannot be greater than Max Value').css('color', 'red'); } else { $('<?php echo '#upper_message' . $i ?>').html('').css('color', 'red'); }">
																												<span id='<?php echo 'upper_message' . $i ?>'></span>
																											</div>
																											<div class="col-lg-3">
																												<label class="j-label">Max Value</label>
																												<input type="text" name="maxValue[]" id="<?php echo 'maxValue' . $i ?>" class="col-sm-12 form-control decimal" value="<?php echo $res->max_value; ?>" onkeyup="var resultValue=$('<?php echo '#resultValue' . $i ?>').val(); var maxValue=$('<?php echo '#maxValue' . $i ?>').val(); var lowerValue=$('<?php echo '#lowerValue' . $i ?>').val(); var uperValue=$('<?php echo '#uperValue' . $i ?>').val(); var minValue=$('<?php echo '#minValue' . $i ?>').val();  if ( parseInt(resultValue) > parseInt(maxValue) || parseInt(lowerValue) > parseInt(maxValue) || parseInt(uperValue) > parseInt(maxValue) || parseInt(minValue) > parseInt(maxValue) )  { $('<?php echo '#max_message' . $i ?>').html('Max Value cannot be smaller than Result Value or Lower Value or Upper Value or Min Value').css('color', 'red'); } else { $('<?php echo '#max_message' . $i ?>').html('').css('color', 'red'); }">
																												<span id='<?php echo 'max_message' . $i ?>'></span>
																											</div>
																										</div>
																										<br><br>

																										<textarea class="form-control col-lg-12" name="topText[]" id="topText" rows="3"><?php echo $res->topText ?></textarea>

																									<?php } ?>


																								<?php }	?>

																								<input type="hidden" name="resultId[]" id="resultId" value="<?php echo $res->resultId; ?>">
																								<input type="hidden" name="detailId" id="detailId" value="<?php echo $results[0]->detailId; ?>">
																							</div>
																						</div>



																						<?php if ($results[0]->testResultType != 'Result 3' && $results[0]->testResultType != 'Result 4') { ?>
																							<br><br>
																							<div class="single-service" style="<?php if ($results[0]->testResultType == 'Result 3') echo 'display:none'; ?>">
																								<div class="clearfix"></div>
																								<div class="price-ranger col-lg-12">

																									<div class="row">
																										<div class="col-md-1"></div>
																										<div class="col-md-10">
																											<div id="<?php echo 'container' . $i; ?>" style="width: 100%; height: 100px; margin: 0 auto">
																											</div>
																										</div>
																									</div>
																									<br>

																								</div> <!-- /price-ranger -->
																								<div class="clearfix"></div>


																								<div class="res_div">Result = <?php echo $res->resultValue ?> <?php echo $res->resultUnit ?></div>

																								<div class="clearfix"></div>
																							</div> <!-- /.single-service -->



																							<div class="row col-lg-12">
																								<!-- <div class="col-lg-2"></div> -->
																								<div class="col-lg-12">
																									<br>


																									<?php
																									if ($order_details->detailStatus == 'Completed' && !isset($_SESSION['pin'])) {
																									?>

																										<?php echo $res->bottomText ?>
																									<?php
																									} else {
																									?>
																										<textarea class="form-control col-lg-12" name="bottomText[]" id="bottomText" rows="3"><?php echo $res->bottomText ?></textarea>

																									<?php
																									}
																									?>

																								</div>
																							</div>

																							<hr>

																						<?php } ?>
																						<!-- </fieldset> -->


																					<?php  } ?>
																				</div>
																			</div>
																			<!-- end of view-info -->
																			<?php
																			if ($order_details->detailStatus == 'Completed' && !isset($_SESSION['pin'])) {
																			?>

																				<?php if ($results[0]->testResultType == 'Result 4') { ?>

																					<div style="margin-left: 20px">

																						<h5><u>View Results</u></h5><br>
																						<?php $var = explode(',', $results[0]->result4File);
																						$c = 1;
																						foreach ($var as $f) { ?>
																							<div class="row">
																								<div class="col-lg-4">
																									<label class="j-label"><b>Result Files <?php echo $c; ?></b></label>
																									<a target="_blank" href="<?php echo base_url() . 'uploads/results/' . $f; ?>"><?php echo $f; ?></a>
																								</div>
																							</div>

																						<?php $c++;
																						}  ?>

																					</div>

																				<?php } else if ($results[0]->testResultType == 'Result 3') { ?>

																					<div style="">

																						<?php $j = 1;
																						foreach ($results as $res) { ?>

																							<div class="row">
																								<div class="col-lg-4">
																									<label class="j-label">Result: <b> <?php echo $res->result3; ?></b></label>
																								</div>
																							</div>



																							<div class="row">
																								<div class="col-lg-4">
																									<label class="j-label">Standard Description</label>
																									<textarea name="standard[]" id="standard" readonly class="col-sm-12 form-control"><?php echo $marker->tm_standard_description; ?></textarea>
																								</div>
																								<div class="col-lg-4">
																									<label class="j-label">Negative Result</label>
																									<textarea name="normal[]" id="normal" readonly class="col-sm-12 form-control"><?php echo $res->topText; // echo $marker->tm_normal_description; 
																																													?></textarea>
																								</div>
																								<div class="col-lg-4">
																									<label class="j-label">Positive Result</label>
																									<textarea name="abnormal[]" id="abnormal" readonly class="col-sm-12 form-control"><?php echo $res->bottomText; //echo $marker->tm_abnormal_description; 
																																														?></textarea>
																								</div>
																							</div>



																						<?php $j++;
																						} ?>

																					</div>

																				<?php } else { ?>
																					<div class="row">
																						<div class="col-lg-4">
																							<a href="javascript:;" onclick="generate()" class="btn btn-success">Download Results</a>
																						</div>
																					</div>




																					<?php if ($results[0]->testResultType == 'Result 2'  && count($results) > 1) { ?>
																						<div class="col-lg-11">
																							<select id="m_report" name="m_report" class="form-control d-print-none" style="width: 20%; margin: 10px; margin-left: 80%;" onchange="get_report(this.value, '<?php echo $order_details->testId; ?>')" >

																								<option value="">Result Value</option>

																								<?php $ii = 0;
																								$m = 1;
																								foreach ($results as $r) { ?>

																									<option class="<?php echo $res_unit[$ii]; ?>" value="<?php echo str_replace(" ", "_", $r->marker_title); ?>"> <?php echo $r->marker_title; ?></option>

																								<?php $m++;
																									$ii++;
																								} ?>

																							</select>
																						</div>
																					<?php } ?>


																				<?php } ?>





																				<!--   Added by daivid for Graph 19-May-2020 -->

																				<!-- <div class="row">
																					<div class="col-lg-12">
																						<div id="chart_div" style="height: 400px;"></div>
																					</div>
																				</div> -->


																					<?php if ($results[0]->testResultType == 'Result 2'  && count($results) > 1) { ?>

																						<!-- <div id="chart_div" style="height: 400px;"></div> -->

																						<?php $o=1; foreach($test_marker_results as $t){  ?>

																							<div style="display: block" class="<?php echo str_replace(" ", "_", $t[0]->marker_title); ?> chart_div single-service" >


																								<div id="chart_div<?php echo $o; ?>" style="height: 400px;" ></div>
																							
																								<!-- <div id="chart_div" style="height: 400px;"></div> -->
																								<div class="boxstyle text-left margin-bottom text-center">	
																								</div>

																								<div class="clearfix"></div>

																							</div>

																						<?php $o++; } ?> 


																					<?php } ?>





																				<?php if ($results[0]->testResultType == 'Result 2') { ?>

																					<?php

																					$lbls = "['";


																					$p = 0;
																					foreach ($results as $res) {
																						$m_title = $markers[$p]->tm_title;
																						if (empty($markers[$p]->tm_title)) {

																							$m_title = $res->marker_title;
																							if (empty($res->marker_title)) {
																								$m_title = explode(",", $res->testMarkers)[$p];
																							}
																						}

																						$lbls .= $m_title . " (" . $res_unit[$p] . ") ','";

																						$p++;
																					}

																					$lbls = substr($lbls, 0, -3) . "']";



																					$kkk = array();
																					$result_analytics = array();
																					$last_year = date("Y-m-d", strtotime("-1 year"));
																					$date = $last_year;
																					for ($i = 1; $i < 13; $i++) {
																						if ($i != 0) {
																							$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
																						}
																						$new = array();
																						$new['y'] = date('Y-m-d', strtotime($date));
																						$new['x'] = 0;



																						for ($g = 1; $g <= $results[0]->no_of_markers; $g++) {
																							$new['x' . $g] = 0;
																						}

																						$result_analytics[] = $new;
																					}
																					$result_track_graph = $this->db->query('select * from results WHERE  DATE(createdAt)>="' . $last_year . '" and  userId=' . $order_details->userId . ' and testId=' . $order_details->testId . ' and resType="OBX" ')->result();

																					foreach ($result_track_graph as $r) {
																						foreach ($result_analytics as $key => $row) {
																							if (count($previous_results) > 1) {
																								if (date('Y-m', strtotime($row['y'])) == date('Y-m', strtotime($r->createdAt))) {
																									$result_analytics[$key]['y'] = date('Y-m-d', strtotime($r->sample_taken_on)); // added on 20 may
																									$result_analytics[$key]['x'] = $r->resultValue;
																									if (count($previous_results) <= 1) {
																										$result_analytics[$key]['x'] = 0;
																									}


																									$mrkrs = $this->db->query("select * from results where detailId = '" . $r->detailId . "'  ")->result();
																									$p = 1;
																									foreach ($mrkrs as $mm) {
																										$result_analytics[$key]['x' . $p] = $mm->resultValue;
																										if (count($previous_results) <= 1) {
																											$result_analytics[$key]['x' . $p] = 0;
																										}
																										$p++;
																									}

																									$kkk[$key] = $result_analytics[$key];
																								} else {
																								}
																							} else {

																								$kkk[$key] = $result_analytics[$key];
																							}
																						}
																					}

																					?>


																					<link rel="stylesheet" href="<?= base_url('assets/plugins/morris') ?>/morris.css">

																					<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
																					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
																					<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
																					<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

																					<script>
																						// $(document).ready(function() {
																						// 	get_report('', '<?php echo $order_details->testId; ?>');
																						// });

																						$( window ).on( "load", function() {

																							var m11 = '<?php echo str_replace(" ", "_", $test_marker_results[0][0]->marker_title); ?>';
																							//alert(m11);
																							setTimeout(function(){ 
																								$("#m_report").val(m11).trigger("change");
																							}, 0);

																							// $(".chart_div").attr("style", "display:none");
																							// $('.chart_div:first').attr("style", "display:block");
																						});


																						function get_report(marker_title, testId) {

																							$(".chart_div").attr("style", "display:none");
																							$("."+marker_title).attr("style", "display:block");

																							// var user_id = '<?php //echo $order_details->userId; ?>';
																							// var m_unit = $('select[name="m_report"] :selected').attr('class');

																							// $.ajax({
																							// 	url: '<?php // echo base_url('admin/orders_items/filter_chart'); ?>',
																							// 	dataType: 'json',
																							// 	data: {
																							// 		'marker_title': marker_title,
																							// 		'testId': testId,
																							// 		'user_id': user_id
																							// 	},
																							// 	method: 'post'
																							// }).done(function(response) {



																							// 	$("#graph").empty();

																							// 	if (marker_title == "") {
																							// 		Morris.Line({
																							// 			element: 'graph',
																							// 			data: response, //[{"y":"2019-04-18","x":10,"x1":20},{"y":"2019-05-18","x":20,"x1":33},{"y":"2020-03-18","x":37,"x1":42}],  //response,

																							// 			xkey: 'y',

																							// 			<?php

																							// 			$ykeys = "['x'";

																							// 			for ($i = 1; $i < $results[0]->no_of_markers; $i++) {

																							// 				$ykeys .= ", 'x" . $i . "'";
																							// 			}

																							// 			$ykeys .= "]";
																							// 			//$labels.="]";

																							// 			?>

																							// 			ykeys: <?php //echo $ykeys; ?>,
																							// 			labels: <?php //echo $lbls; ?>,

																							// 			padding: 100,

																							// 			xLabelFormat: function(x) {
																							// 				return formatDate(new Date(x));
																							// 			},
																							// 			dateFormat: function(x) {
																							// 				return formatDate(new Date(x));
																							// 			},
																							// 			resize: true

																							// 		});
																							// 	} else {

																							// 		Morris.Line({
																							// 			element: 'graph',
																							// 			data: response, //[{"y":"2019-04-18","x":10,"x1":20},{"y":"2019-05-18","x":20,"x1":33},{"y":"2020-03-18","x":37,"x1":42}],  //response,

																							// 			xkey: 'y',
																							// 			ykeys: ['x'],
																							// 			labels: [marker_title + ' (' + m_unit + ')'], //['Result Vlaue'] ,

																							// 			padding: 100,

																							// 			xLabelFormat: function(x) {
																							// 				return formatDate(new Date(x));
																							// 			},
																							// 			dateFormat: function(x) {

																							// 				return formatDate(new Date(x));
																							// 			},
																							// 			resize: true

																							// 		});
																							// 	}



																							// }).fail(function() {

																							// });

																						}


																						function formatDate(date) {
																							var d = new Date(date),
																								month = '' + (d.getMonth() + 1),
																								day = '' + d.getDate(),
																								year = d.getFullYear();

																							if (month.length < 2)
																								month = '0' + month;
																							if (day.length < 2)
																								day = '0' + day;

																							return [day, month, year].join('/');
																						}



																						<?php

																						$IndexToMonth = '[';
																						foreach ($kkk as $month) {
																							$m = date('M', strtotime($month['y']));
																							$IndexToMonth .= '"' . $m . '",';
																						}
																						$IndexToMonth = substr($IndexToMonth, 0, -1) . ']';
																						?>
																						Morris.Line({
																							element: 'graph',
																							data: [
																								<?php
																								foreach ($kkk as $month) {
																									echo json_encode($month) . ',';
																								} ?>
																							],
																							xkey: 'y',

																							<?php

																							$ykeys = "['x'";

																							for ($i = 1; $i < $results[0]->no_of_markers; $i++) {

																								$ykeys .= ", 'x" . $i . "'";
																								$labels .= ", 'Result Vlaue'";
																							}

																							$ykeys .= "]";
																							$labels .= "]";

																							?>

																							ykeys: <?php echo $ykeys; ?>,
																							labels: <?php echo $lbls; ?>,

																							padding: 100,

																							xLabelFormat: function(x) {
																								return formatDate(new Date(x));
																							},
																							dateFormat: function(x) {
																								return formatDate(new Date(x));
																							},
																							resize: true
																						});
																					</script>



																				<?php } ?>

																				<!-- End ----------------------- 19-May-2020 -->







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
													<div class="tab-pane <?= $s ?>" id="personal" role="tabpanel">
														<!-- personal card start -->
														<div class="card">
															<div class="card-header">
																<h5 class="card-header-text"><?= $test->testName ?></h5>
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
																										<td><?= $test->testName ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Order ID</th>
																										<td><?php echo $order->orderId . '-' . $sub_id; ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Order Item No</th>
																										<td><?= $order_details->detailId ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Product Type</th>
																										<td><?= $order_details->productType ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Original Price</th>
																										<td><i class="icofont icofont-cur-pound"></i> <?= $order_details->orginalPrice ?></td>
																									</tr>

																									<?php if ($order_details->membershipStatus != '') { ?>
																										<tr>
																											<th scope="row">Membership Status</th>
																											<td><?= $order_details->membershipStatus ?></td>
																										</tr>
																									<?php } else { ?>
																										<tr>
																											<th scope="row">Membership Status</th>
																											<td>Inactive</td>
																										</tr>
																									<?php } ?>
																									<?php if ($order_details->membershipDate != '0000-00-00') { ?>
																										<tr>
																											<th scope="row">Membership Date</th>
																											<td><?= date('d F Y', strtotime($order_details->membershipDate)) ?></td>
																										</tr>
																									<?php } ?>

																									<tr>
																										<th scope="row">created Date</th>
																										<td><?= date('d F Y', strtotime($order_details->createdAt)) ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Updated Date</th>
																										<td><?= date('d F Y', strtotime($order_details->updatedAt)) ?></td>
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
																									<td><?= $order_details->userFirstName ?> <?= $order_details->userLastName ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Status</th>
																									<td>

																										<?php if ($order_details->detailStatus == 'Pending') {
																											if ($order_details->scheduleDate >= date('Y-m-d')) {
																												echo '<label class="label label-primary">Scheduled</label>';
																											} else {
																												echo '<label class="label label-primary">Pending</label>';
																											}
																										} else if ($order_details->detailStatus == 'Completed') {
																											echo '<label class="label label-success">Completed</label>';
																										} else if ($order_details->detailStatus == 'Canceled') {
																											echo '<label class="label label-danger">Canceled</label>';
																										} else if ($order_details->detailStatus == 'Inprogress') {
																											echo '<label class="label label-info">In Progress</label>';
																										}
																										?></td>
																								</tr>
																								<tr>
																									<th scope="row">Schedule Date</th>
																									<td><?= date('d F Y', strtotime($order_details->scheduleDate)) ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Paid Price</th>
																									<td><i class="icofont icofont-cur-pound"></i> <?= $order_details->detailPrice ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Quantity</th>
																									<td> <?php if ($order_details->regularType == 'One Time') echo '1';
																											else echo $order_details->detailQty; // echo $order_details->detailQty; 
																											?></td>
																								</tr>
																								<tr>
																									<th scope="row">Payment Status</th>
																									<td>
																										<?php if ($order_details->paymentStatus == 'Yes') {
																											echo '<label class="label label-success">Paid</label>';
																										} else {
																											echo '<label class="label label-danger">UnPaid</label>';
																										} ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Payment Type</th>
																									<td><?= $order_details->paymentType ?></td>
																								</tr>

																							</tbody>
																						</table>

																					</div>
																					<!-- end of table col-lg-6 -->
																				</div>
																				<!-- end of row -->
																				<div class="row">
																					<div class="col-md-12 text-right">

																						<?php if ($order_details->productType != 'Test') { ?>
																							<?php if ($order_details->detailStatus == 'Pending') { ?>
																								<button type="button" onclick="sta('Completed')" class="btn btn-primary">Mark as Completed</button>
																							<?php } ?>
																						<?php } else { ?>
																							<?php if ($order_details->detailStatus == 'Pending') { ?>
																								<button type="button" onclick="sta('Inprogress')" class="btn btn-primary">Mark as In Progress</button>
																							<?php } ?>
																							<?php if ($order_details->detailStatus == 'Inprogress') { ?>
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
													<?php if ($order_details->productType == 'MealPrep') { ?>
														<div class="tab-pane" id="exta_info" role="tabpanel">
															<!-- info card start -->
															<?php $extra = json_decode($order_details->extra); ?>
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
																										<td><?= $extra->diet ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Meals</th>
																										<td><?= $extra->meals ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Want More</th>
																										<td><?= $extra->wantMore ?></td>
																									</tr>
																									<tr>
																										<th scope="row">Additional</th>
																										<td><?= $extra->additional ?></td>
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
																									<td><?= $extra->alergies ?> <br>
																										<?php if ($extra->alergies_detail != '') { ?>
																											<b>Detail</b><br>
																											<?= $extra->alergies_detail ?>
																										<?php } ?>

																									</td>
																								</tr>
																								<tr>
																									<th scope="row">Delivery</th>
																									<td><?= $extra->delivery ?></td>
																								</tr>
																								<tr>
																									<th scope="row">No Want More</th>
																									<td><?= $extra->notWant ?></td>
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
																									<td><?= $order->orderShipName ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Address 1</th>
																									<td><?= $order->orderShipAddress ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Address 2</th>
																									<td><?= $order->orderShipAddress2 ?></td>
																								</tr>
																								<tr>
																									<th scope="row">State</th>
																									<td><?= $order->orderState ?></td>
																								</tr>
																								<tr>
																									<th scope="row">Phone</th>
																									<td><?= $order->orderPhone ?></td>
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
																								<td><?= $order->orderEmail ?></td>
																							</tr>
																							<tr>
																								<th scope="row">City</th>
																								<td><?= $order->orderCity ?></td>
																							</tr>
																							<tr>
																								<th scope="row">Postal Code</th>
																								<td><?= $order->orderPostalCode ?></td>
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
		$(function() {

			$('.decimal').bind('paste', function() {

				var self = this;
				setTimeout(function() {
					if (!/^\d*(\.\d{1,2})+$/.test($(self).val())) $(self).val('');
				}, 0);
			});

			$('.decimal').keypress(function(e) {

				var character = String.fromCharCode(e.keyCode)
				var newValue = this.value + character;
				if (isNaN(newValue) || hasDecimalPlace(newValue, 5)) {
					e.preventDefault();
					return false;
				}
			});

			function hasDecimalPlace(value, x) {
				var pointIndex = value.indexOf('.');
				return pointIndex >= 0 && pointIndex < value.length - x;
			}
		});
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {
			packages: ['corechart']
		});
	</script>


	<script>
		function drawChart() {

			<?php
			$i = 0;
			foreach ($results as $res) {
				$i++;
			?>

				<?php
				$themin = $res->min_value;
				$themax = $res->max_value;
				$theupper = $res->upper_value;
				$thelower = $res->lower_value;
				$thevalue = $res->resultValue;
				?>
				// Define the chart to be drawn.
				var data = google.visualization.arrayToDataTable([
					['Year', 'Asia', 'Europe', 'Pk', 'value'],
					['Result', <?php echo $thelower ?>, <?php echo $theupper - $thelower ?>, <?php echo $themax - $theupper ?>, <?php echo $thevalue ?>],
				]);
				var options = {
					isStacked: 'absolute',
					allowHtml: true,
					legend: 'none',
					displayAnnotations: true,
					'is3D': true,
					colors: ['red', 'green', 'red'],
					'tooltip': {
						trigger: 'none'
					},
					hAxis: {
						viewWindow: {
							min: <?php echo $themin ?>,
							max: <?php echo  $themax ?>
						},
						gridlines: {
							count: Math.ceil(120 * 1.1 / 10),
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
				var chart = new google.visualization.BarChart(document.getElementById('<?php echo 'container' . $i; ?>'));
				chart.draw(data, options);

			<?php
			}
			?>
		}
		google.charts.setOnLoadCallback(drawChart);
	</script>

	<script type="text/javascript">
		function generate() {

			var divToPrint = document.getElementById('html-2-pdfwrapper');

			var newWin = window.open('', 'Print-Window');

			newWin.document.open();

			newWin.document.write("<html><head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' ><link rel='stylesheet' type='text/css' href='<?= base_url('assets/front/') ?>css/style.css'><style type='text/css'>.ruler_active {background: #86c44c !important;height: 34px !important;border-left: 0px !important;width: 11% !important; -webkit-print-color-adjust: exact; }</style></head><body onload='window.print()'><h2 style='text-align:center'>Results <?= $order_details->testName ?></h2>" + divToPrint.innerHTML + "</body></html>");

			newWin.document.close();

			setTimeout(function() {
				newWin.close();
			}, 10);
		}

		$(document).ready(function() {
			$(function() {
				$('#saveOnlyBtn').click(function(e) {
					$('#updateResultForm').submit(function(e) {

						e.preventDefault();

						var frm = $(this);
						var formData = new FormData($('form#updateResultForm').get(0));

						$.confirm({
							icon: 'fa fa-spinner fa-spin',
							title: 'Working!',
							content: function() {
								var self = this;
								return $.ajax({
									url: '<?php echo base_url() . 'admin/Orders_items/onlySaveResult'; ?>',
									dataType: 'json',
									data: formData,
									processData: false,
									contentType: false,
									method: 'POST',
									cache: false,
								}).done(function(response) {
									console.log(response);
									if (response.code == 0) {
										$.confirm({
											title: 'Error!',
											icon: 'fa fa-warning',
											closeIcon: true,
											content: response.message,
											type: 'red',
											autoClose: 'close|10000',
											typeAnimated: true,
											buttons: {
												close: function() {}
											}
										});
									} else {

										$.confirm({
											title: 'Success!',
											icon: 'fa fa-check',
											content: response.message,
											type: 'green',
											typeAnimated: true,
											buttons: {
												ok: {
													text: 'Ok',
													btnClass: 'btn-green',
													action: function() {
														location.reload();
													}

												}
											}
										});


									}
								}).fail(function() {
									self.close();
									$.confirm({
										title: 'Encountered an error!',
										content: 'Something went wrong.',
										type: 'red',
										typeAnimated: true,
										buttons: {
											close: function() {}
										}
									});
								});
							},
							buttons: {
								close: function() {}
							}
						});
						return false;
					});
				});

				$('#savePublishBtn').click(function(e) {
					$('#updateResultForm').submit(function(e) {

						e.preventDefault();

						var frm = $(this);
						var formData = new FormData($('form#updateResultForm').get(0));

						$.confirm({
							icon: 'fa fa-spinner fa-spin',
							title: 'Working!',
							content: function() {
								var self = this;
								return $.ajax({
									url: '<?php echo base_url() . 'admin/Orders_items/saveAndPublishResult'; ?>',
									dataType: 'json',
									data: formData,
									processData: false,
									contentType: false,
									method: 'POST',
									cache: false,
								}).done(function(response) {
									console.log(response);
									if (response.code == 0) {
										$.confirm({
											title: 'Error!',
											icon: 'fa fa-warning',
											closeIcon: true,
											content: response.message,
											type: 'red',
											autoClose: 'close|10000',
											typeAnimated: true,
											buttons: {
												close: function() {}
											}
										});
									} else {

										$.confirm({
											title: 'Success!',
											icon: 'fa fa-check',
											content: response.message,
											type: 'green',
											typeAnimated: true,
											buttons: {
												ok: {
													text: 'Ok',
													btnClass: 'btn-green',
													action: function() {
														location.reload();
													}

												}
											}
										});


									}
								}).fail(function() {
									self.close();
									$.confirm({
										title: 'Encountered an error!',
										content: 'Something went wrong.',
										type: 'red',
										typeAnimated: true,
										buttons: {
											close: function() {}
										}
									});
								});
							},
							buttons: {
								close: function() {}
							}
						});
						return false;
					});
				});
			});
		});


		$('#frm_edit_result').submit(function(evt) {
			var frm = $(this);
			var formData = new FormData($('form#frm_edit_result').get(0));
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						method: 'post',
						cache: false,
					}).done(function(response) {
						self.close();
						if (response.code == 0) {
							$.confirm({
								title: 'Error!',
								icon: 'fa fa-warning',
								closeIcon: true,
								content: response.message,
								type: 'red',
								autoClose: 'close|10000',
								typeAnimated: true,
								buttons: {
									close: function() {}
								}
							});
						} else {
							$.confirm({
								title: 'Success!',
								icon: 'fa fa-check',
								content: response.message,
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function() {
											location.reload();
										}

									}
								}
							});
						}
					}).fail(function() {
						self.close();
						$.confirm({
							title: 'Encountered an error!',
							content: 'Something went wrong.',
							type: 'red',
							typeAnimated: true,
							buttons: {
								close: function() {}
							}
						});
					});
				},
				buttons: {
					close: function() {}
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
						action: function() {
							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function() {
									var self = this;
									return $.ajax({
										url: "<?= base_url() ?>admin/orders_items/change_status",
										dataType: 'json',
										data: {
											id: <?= $order_details->detailId ?>,
											type: type
										},
										method: 'post'
									}).done(function(response) {
										self.close();
										if (response.code == 0) {
											$.confirm({
												title: 'Error!',
												icon: 'fa fa-warning',
												closeIcon: true,
												content: response.message,
												type: 'red',
												autoClose: 'close|10000',
												typeAnimated: true,
												buttons: {
													close: function() {}
												}
											});
										} else {
											$.confirm({
												title: 'Success!',
												icon: 'fa fa-check',
												content: response.message,
												type: 'green',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function() {
															location.reload();
														}

													}
												}
											});

										}

									}).fail(function() {
										self.close();
										$.confirm({
											title: 'Encountered an error!',
											content: 'Something went wrong.',
											type: 'red',
											typeAnimated: true,
											buttons: {
												close: function() {}
											}
										});

									});
								},
								buttons: {
									close: function() {}
								}
							});
						}
					},
					No: function() {}
				}
			});
		}


		function remove_file(detailId, file) {

			if (confirm("Are you sure! Delete file ?")) {

				$.ajax({
					url: "<?= base_url() ?>admin/orders_items/remove_file",
					type: "POST",
					data: {
						"detailId": detailId,
						"file": file
					},
					success: function(resp) {
						if (resp == 1) {
							$.confirm({
								title: 'Success!',
								icon: 'fa fa-check',
								content: 'Result File has been deleted',
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function() {
											location.reload();
										}

									}
								}
							});
						} else {
							location.reload();
						}
					}
				});

			}

		}

		function upload_result4() {

			$("#upload_result4_btn").click();
		}

		function update_result3(resultId, result3) {}

		function update_result3_desc(resultId) {

			var result3 = $("#result3_" + resultId).val();
			var topText = $("#standard_" + resultId).val();
			var bottomText = $("#normal_" + resultId).val(); // result is negative
			if (result3 == 'Positive') { // if result is Positive then bnormal text
				bottomText = $("#abnormal_" + resultId).val();
			}

			$.ajax({
				url: "<?= base_url() ?>admin/orders_items/update_result3",
				type: "POST",
				data: {
					"resultId": resultId,
					"result3": result3,
					"topText": topText,
					"bottomText": bottomText
				},
				success: function(resp) {
					if (resp == 1) {
						$.confirm({
							title: 'Success!',
							icon: 'fa fa-check',
							content: 'Result Status has been updated!',
							type: 'green',
							typeAnimated: true,
							buttons: {
								ok: {
									text: 'Ok',
									btnClass: 'btn-green',
									action: function() {
										//location.reload();
									}

								}
							}
						});
					} else {
						location.reload();
					}
				}
			});



		}
	</script>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load('visualization', '1', {
			packages: ['corechart']
		});
	</script>
	<script type="text/javascript">

		function drawVisualization() {
				<?php

				$q=1;
				foreach($test_marker_results as $test_marker_res){

					$data = "[";
					$data .="['No Value', 'Abnormal Range','Normal Range','Abnormal Range','Your Result Value'],";

					$is_max = 0;
					$is_upper = 0;
					$is_lower = 0;
					$is_true = false;
					$no = 0;
					foreach ($test_marker_res as $res) {

						$no++;

						if($no == 1){
							
							$is_max = $res->max_value;
							$is_upper = $res->upper_value;
							$is_lower = $res->lower_value;
						}
						
						if($is_max == $res->max_value && $is_upper == $res->upper_value && $is_lower == $res->lower_value){

							$is_true = true;
						}

						if($is_max < $res->max_value){

							$is_true = false;

							$is_max = $res->max_value;
						}
						if($is_upper < $res->upper_value){

							$is_true = false;

							$is_upper = $res->upper_value;
						}
						if($is_lower < $res->lower_value){

							$is_true = false;
							
							$is_lower = $res->lower_value;
						}
					}

					if($is_true == true){
						foreach ($test_marker_res as $res) {

							$upper_value = $res->upper_value - $res->lower_value;
							$max_value = $res->max_value - $res->upper_value;
		
							//$data .="['',".$res->lower_value.",".$upper_value.",".$max_value.",".$res->resultValue."],";
							$data .="['".date('Y-m-d', strtotime($res->createdAt))."',".$res->lower_value.",".$upper_value.",".$max_value.",".$res->resultValue."],";
						}
					}
					else{

						foreach ($test_marker_res as $res) {

							$upper_value = $is_upper - $is_lower;
							$max_value = $is_max - $is_upper;
		
							$data .="['".date('Y-m-d', strtotime($res->createdAt))."',".$is_lower.",".$upper_value.",".$max_value.",".$res->resultValue."],";
						}
					}

					$data .= "]";
				?>

				//Raw data
				var data = google.visualization.arrayToDataTable(<?php echo $data; ?>);

				var options = {
				title : 'Test Results Comparison',
				vAxis: {title: ""},
				//Horizontal axis text vertical
				hAxis: {title: ""},
				seriesType: "bars",
				series: {
					0:{color:'red'},
					1:{color:'green'},
					2:{color:'red'},
					3: {type: "line", color: "yellow",pointShape: 'circle',pointSize: 10}
				},
				isStacked: true,
				bar: { groupWidth: '100%' },
				};

				var chart = new google.visualization.ComboChart(document.getElementById('chart_div<?php echo $q; ?>'));
				chart.draw(data, options);
			<?php $q++; } ?>
			
		}
		google.setOnLoadCallback(drawVisualization);
	</script>

</body>

</html>