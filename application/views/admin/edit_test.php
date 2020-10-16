<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/bower_components/select2/css/select2.min.css" />

<!-- jquery file upload Frame work -->
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">
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
											<h4 class="m-b-10">Edit Test</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/tests">
													tests
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">Edit Test</a>
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
									<!-- Page body start -->
									<div class="page-body">
										<div class="row">
											<div class="col-sm-12">
												<div class="card">
													<div class="card-header">
														<h5>Edit Test</h5>
														<span>Edit <?= $row->testName ?> information</span>
													</div>
													<div class="card-block">
														<div class="j-wrapper j-wrapper-640">
															<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/tests/edit_process/<?= $row->testId ?>" method="post" class="j-pro j-multistep" novalidate>
																<div class="j-content">
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 1/4 - Basic information</span>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Name</label>
																			<div class="j-input">
																				<label class="j-icon-right" for="testName">
																					<i class="icofont icofont-blood-test"></i>
																				</label>
																				<input type="text" id="testName" name="testName" value="<?= $row->testName ?>">
																				<span class="j-tooltip j-tooltip-right-top">Enter Test name</span>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Code</label>
																			<div class="j-input">
																				<label class="j-icon-right" for="testCode">
																					<i class="icofont icofont-blood-test"></i>
																				</label>
																				<input type="text" id="testCode" name="testCode" value="<?= $row->testCode ?>">
																				<span class="j-tooltip j-tooltip-right-top">Enter Test Code</span>
																			</div>
																		</div>
																		<div class="j-row">
																			<div class="j-span6 j-unit">
																				<label class="j-label">Original Price</label>
																				<div class="j-input">
																					<label class="j-icon-right" for="originalPrice">
																						<i class="icofont icofont-cur-pound"></i>
																					</label>
																					<input type="email" id="originalPrice" name="originalPrice" value="<?= $row->originalPrice ?>">
																					<span class="j-tooltip j-tooltip-right-top">Enter original price</span>
																				</div>
																			</div>
																			<div class="j-span6 j-unit">
																				<label class="j-label">Category</label>
																				<div class="j-input j-select">
																					<?php $cat = $this->db->query('select * from categories WHERE categoryType="Tests"')->result(); ?>
																					<select class="js-example-basic-single" name="categoryId" id="categoryId" style="width: 100% !important; height:30px!important">
																						<option value="" selected="">Choose a category</option>
																						<?php foreach ($cat as $cat_row) { ?>
																							<option value="<?= $cat_row->categoryId ?>" <?php if ($row->categoryId == $cat_row->categoryId) { ?> selected="" <?php } ?>><?= $cat_row->categoryName ?></option>
																						<?php } ?>
																					</select>
																				</div>
																			</div>
																		</div>
																		<div class="j-row">

																			<div class="j-span6 j-unit">
																				<label class="j-label">Discount Price</label>
																				<div class="j-input">
																					<label class="j-icon-right" for="discountPrice">
																						<i class="icofont icofont-sale-discount"></i>
																					</label>
																					<input type="email" id="discountPrice" name="discountPrice" value="<?= $row->discountPrice ?>">
																					<span id='message'></span>
																					<span class="j-tooltip j-tooltip-right-top">Enter discount price</span>
																				</div>
																			</div>
																			<div class="j-span6 j-unit">
																				<label class="j-label">Percentage</label>
																				<div class="j-input form-radio" style="margin-top: 15px;">
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" id="discountPercentageYes" name="discountPercentage" value="Yes" <?php if ($row->discountPercentage == 'Yes') {
																																														echo 'checked=""';
																																													} ?>>
																							<i class="helper"></i>Yes
																						</label>
																					</div>
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" id="discountPercentageNo" name="discountPercentage" value="No" <?php if ($row->discountPercentage == 'No') {
																																													echo 'checked=""';
																																												} ?>>
																							<i class="helper"></i>No
																						</label>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Description</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="testDescription" name="testDescription"><?= $row->testDescription ?></textarea>
																			</div>
																		</div>




																		<div class="j-row">
																			<div class="j-unit j-span4">
																				<label class="j-label">Select result type</label>
																				<div class="j-input j-select">
																					<select class="js-example-basic-single" name="testResultType" id="" style="width: 100% !important; height:30px!important">

																						<option value="Result 1" <?php if ($row->testResultType == 'Result 1') echo 'selected'; ?>>Result 1</option>
																						<option value="Result 2" <?php if ($row->testResultType == 'Result 2') echo 'selected'; ?>>Result 2</option>
																						<option value="Result 3" <?php if ($row->testResultType == 'Result 3') echo 'selected'; ?>>Result 3</option>
																						<option value="Result 4" <?php if ($row->testResultType == 'Result 4') echo 'selected'; ?>>Result 4</option>
																					</select>
																				</div>
																			</div>
																			<div class="j-unit j-span4">
																				<label class="j-label">Coming Soon Test</label>
																				<div class="j-input form-radio" style="margin-top: 15px;">
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" name="coming_soon" value="1" <?php if ($row->coming_soon == 1) echo 'checked'; ?> onclick="show2();">
																							<i class="helper"></i>Yes
																						</label>
																					</div>
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" name="coming_soon" value="0" <?php if ($row->coming_soon == 0) echo 'checked'; ?> onclick="show1();">
																							<i class="helper"></i>No
																						</label>
																					</div>
																				</div>
																			</div>

																			<div class="j-span4 j-unit">
																				<label class="j-label">Select Lab</label>
																				<div class="j-input j-select">
																					<select name="testLab" class="js-example-basic-single" name="testLab" id="" style="width: 100% !important; height:30px!important">

																						<?php foreach ($labs as $lab) { ?>
																							<option value="<?php echo $lab->ID; ?>" <?php if ($row->testLab == $lab->ID) echo 'selected'; ?>><?php echo $lab->title; ?></option>
																						<?php } ?>
																					</select>
																				</div>
																			</div>

																		</div>


																		<div class="j-unit j-span-12" id="div1" style="<?php if ($row->coming_soon == 0) echo 'display:none'; ?>">
																			<label class="j-label">Enter Date</label>
																			<div class="j-input">
																				<input type="date" name="coming_soon_date" id="sampleTakeen" class="form-control" value="<?php echo $row->coming_soon_date; ?>" required="true">
																				<span class="j-tooltip j-tooltip-right-top">Enter Date</span>
																			</div>
																		</div>

																		<div class="j-unit j-span-12" style="width: 100%;">
																			<label class="j-label">Price to Supplier</label>
																			<div class="j-input">
																				<label class="j-icon-right" for="originalPrice">
																					<i class="icofont icofont-cur-pound"></i>
																				</label>
																				<input type="text" value="<?= $row->price_to_supplier ?>" name="price_to_supplier">
																				<span class="j-tooltip j-tooltip-right-top">Enter price to suplier</span>
																			</div>
																		</div>
																	</fieldset>
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 2/4 - Tabs information</span>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Details</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="testDetails" name="testDetails"><?= $row->testDetails ?></textarea>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Symtoms</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="testSymtoms" name="testSymtoms"><?= $row->testSymtoms ?></textarea>
																			</div>
																		</div>
																	</fieldset>
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 3/4 - Test Markers</span>
																		</div>
																		<div class="j-unit">
																			<label class="j-label"> Test Markers </label>
																			<div class="j-input j-select">
																				<select class="js-example-tags col-sm-12" id="testMarkers" name="testMarkers[]" multiple="multiple" style="width: 100% !important; height:30px!important">
																					<?php $testMarkers = explode(',', $row->testMarkers);
																					foreach ($testMarkers as $tmarker) { ?>
																						<option value="<?= $tmarker ?>" selected=""><?= $tmarker ?></option>
																					<?php } ?>
																				</select>
																				<span class="j-tooltip j-tooltip-right-top">Enter Test Markers</span>
																			</div>
																		</div>

																		<div class="row">
																			<div class="col-lg-8"></div>
																			<div class="col-lg-4 text-center">
																				<button class="btn btn-success" id="addMarkerBtn"><i class="icofont icofont-plus"></i> Add Marker</button>
																			</div>
																		</div>

																		<div id="marker">
																			<?php
																			if (!empty($test_markers)) {
																				$no = 0;
																				foreach ($test_markers as $marker) {
																					$no++;
																			?>
																					<br>
																					<hr>
																					<div class="row">
																						<div class="col-lg-10">
																							<strong style="color: green;">
																								<?php echo $no . ' -'; ?>
																							</strong>
																						</div>
																						<div class="col-lg-2 text-right">
																							<i class="icofont icofont-trash icofont-2x text-danger" onclick="delete_marker(<?= $marker->tm_id ?>)"></i>
																						</div>
																					</div>

																					<br>
																					<div class="row">
																						<div class="col-lg-7">
																							<div class="j-unit">
																								<label class="j-label">Marker Title</label>
																								<div class="j-input">
																									<input type="text" name="markerTitle[]" id="markerTitle" class="col-sm-12" value="<?php echo $marker->tm_title; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Title</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-5">
																							<div class="j-unit">
																								<label class="j-label">Marker Unit</label>
																								<div class="j-input">
																									<input type="text" name="markerUnit[]" id="markerUnit" class="col-sm-12" value="<?php echo $marker->tm_unit; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Unit</span>
																								</div>
																							</div>
																						</div>
																					</div>
																					<br>
																					<div class="row" style="<?php if ($row->testResultType == 'Result 3') {
																												echo 'display:none';
																											} ?>">
																						<div class="col-lg-6">
																							<div class="j-unit">
																								<label class="j-label">Marker Range</label>
																								<div class="j-input">
																									<input type="text" class="col-sm-12" value="<?php echo $marker->tm_range; ?>" readonly>
																								</div>
																							</div>
																						</div>
																					</div>
																					<br>
																					<div class="row" style="<?php if ($row->testResultType == 'Result 3') {
																												echo 'display:none';
																											} ?>">
																						<div class="col-lg-3">
																							<div class="j-unit">
																								<label class="j-label">Min Value</label>
																								<div class="j-input">
																									<input type="text" name="minValue[]" id="minValue" class="col-sm-12 decimal" value="<?php echo $marker->tm_min_value; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Min Value</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-3">
																							<div class="j-unit">
																								<label class="j-label">Lower Value</label>
																								<div class="j-input">
																									<input type="text" name="lowerValue[]" id="lowerValue" class="col-sm-12 decimal" value="<?php echo $marker->tm_lower_value; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Lower Value</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-3">
																							<div class="j-unit">
																								<label class="j-label">Upper Value</label>
																								<div class="j-input">
																									<input type="text" name="upperValue[]" id="upperValue" class="col-sm-12 decimal" value="<?php echo $marker->tm_upper_value; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Upper Value</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-3">
																							<div class="j-unit">
																								<label class="j-label">Max Value</label>
																								<div class="j-input">
																									<input type="text" name="maxValue[]" id="maxValue" class="col-sm-12 decimal" value="<?php echo $marker->tm_max_vaue; ?>">
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Max Value</span>
																								</div>
																							</div>
																						</div>
																					</div>
																					<br>
																					<div class="row">
																						<div class="col-lg-4">
																							<div class="j-unit">
																								<label class="j-label">Standard Description</label>
																								<div class="j-input">
																									<textarea name="standard[]" id="standard" class="col-sm-12"><?php echo $marker->tm_standard_description; ?></textarea>
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Standard Description</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-4">
																							<div class="j-unit">
																								<label class="j-label">Normal Result</label>
																								<div class="j-input">
																									<textarea name="normal[]" id="normal" class="col-sm-12"><?php echo $marker->tm_normal_description; ?></textarea>
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Normal Description</span>
																								</div>
																							</div>
																						</div>
																						<div class="col-lg-4">
																							<div class="j-unit">
																								<label class="j-label">Abnormal Result</label>
																								<div class="j-input">
																									<textarea name="abnormal[]" id="abnormal" class="col-sm-12"><?php echo $marker->tm_abnormal_description; ?></textarea>
																									<span class="j-tooltip j-tooltip-right-top">Enter Marker Abnormal Description</span>
																								</div>
																							</div>
																						</div>
																					</div>
																					<hr>
																			<?php
																				}
																			}
																			?>

																		</div>
																	</fieldset>
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 4/4 - Images</span>
																		</div>
																		<div class="card">
																			<div class="card-header">
																				<h5>Test Logo</h5>
																			</div>
																			<div class="card-block">
																				<input type="file" name="testLogo" id="testLogo">
																				<div class="row">
																					<div class="col-lg-4 col-sm-6">
																						<div class="thumbnail">
																							<div class="thumb text-center">
																								<img src="<?= base_url() . '/uploads/tests/logo/' . $row->testLogo ?>" alt="" class="img-fluid img-thumbnail" style="max-height: 100px">
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="card">
																			<div class="card-header">
																				<h5>Other Images</h5>
																			</div>
																			<div class="card-block">
																				<input type="file" name="moreImages[]" id="moreImages" multiple="multiple">

																				<div class="row">
																					<?php $imoreImages = $this->db->query('select * from test_images WHERE testId=' . $row->testId)->result();
																					if ($imoreImages) {
																						foreach ($imoreImages as $image) { ?>
																							<div class="col-lg-4 col-sm-6" id="img_<?= $image->imageId ?>">
																								<div class="thumbnail">
																									<div class="thumb text-center">
																										<img src="<?= base_url() . '/uploads/tests/products/' . $image->imageName ?>" alt="" class="img-fluid img-thumbnail" style="height: 100px">
																									</div>
																									<button type="button" onclick="delete_img(<?= $image->imageId ?>)" class="btn btn-out waves-effect waves-light btn-danger btn-square w-100"><i class="icofont icofont-ui-delete"></i></button>

																								</div>
																							</div>
																						<?php
																						}
																					} else { ?>
																						<p class="text-center">No image Listed</p>
																					<?php }
																					?>
																				</div>


																			</div>
																		</div>

																	</fieldset>
																	<div class="j-response"></div>
																</div>
																<!-- end /.content -->
																<div class="j-footer">
																	<button type="submit" class="btn btn-primary">Update</button>
																	<button type="button" class="btn btn-primary j-multi-next-btn">Next</button>
																	<button type="button" class="btn btn-default m-r-20 j-multi-prev-btn">Back</button>
																</div>
																<!-- end /.footer -->
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Page body end -->
								</div>
							</div>
						</div>
					</div>
					<!-- Main-body end -->
				</div>
			</div>
		</div>
	</div>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/select2/js/select2.full.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/pages/j-pro/js/jquery.j-pro.js"></script>
	<!-- jquery file upload js -->
	<script src="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/filer/custom-filer.js" type="text/javascript"></script>




	<script>
		$(document).ready(function() {

			var radioValue = document.getElementById('discountPercentageYes').value;

			if (radioValue == 'Yes') {

				$('#discountPrice').on('keyup', function() {

					if (document.getElementById('discountPercentageYes').checked) {

						if ($('#discountPrice').val() >= 100) {

							$('#message').html('Should be less than 100').css('color', 'red');
						} else {

							$('#message').html(' ').css('color', 'green');
						}

					}


					if (document.getElementById('discountPercentageNo').checked) {


						var discountPrice = parseInt(document.getElementById('discountPrice').value);
						var originalPrice = parseInt(document.getElementById('originalPrice').value);
						//alert('discountPrice = '+discountPrice+'  originalPrice = '+originalPrice);
						if (discountPrice >= originalPrice) {
							$('#message').html('Should be less than orignal price').css('color', 'red');
						} else {
							$('#message').html(' ').css('color', 'green');
						}

					}

				});
			}

			$("#discountPercentageYes").click(function() {
				if (document.getElementById('discountPercentageYes').checked) {

					var discountPrice = document.getElementById('discountPrice').value;

					if (discountPrice >= 100) {

						$('#message').html('Should be less than 100').css('color', 'red');
					} else {
						$('#message').html(' ').css('color', 'green');
					}

				}
			});

			$("#discountPercentageNo").click(function() {
				if (document.getElementById('discountPercentageNo').checked) {

					var discountPrice = parseInt(document.getElementById('discountPrice').value);
					var originalPrice = parseInt(document.getElementById('originalPrice').value);

					if (discountPrice >= originalPrice) {

						$('#message').html('Should be less than orignal price').css('color', 'red');
					} else {
						$('#message').html(' ').css('color', 'green');
					}
				}
			});

		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			var current_marker_count = <?php echo sizeof($test_markers); ?>



			var max_fields = 100; //maximum OBX allowed
			var wrapper = $("#marker"); //Fields wrapper
			var add_button = $("#addMarkerBtn"); //Add button ID

			var x = current_marker_count + 1; //initlal OBX count
			$(add_button).click(function(e) { //on add input button click
				e.preventDefault();
				if (x <= max_fields) { //max input box allowed
					//text box increment
					$(wrapper).append('<div id="m"><br><hr><div class="row"><div class="col-lg-10"><strong style="color: green;">' + x + '</strong></div><div class="col-lg-2 text-right"><a href="#" class="remove_field"><i class="icofont icofont-trash icofont-2x text-danger"></i></a></div></div><div class="row"><div class="col-lg-7"><div class="j-unit"><label class="j-label">Marker Title</label><div class="j-input"><input type="text" name="markerTitle[]" id="markerTitle" class="col-sm-12"><span class="j-tooltip j-tooltip-right-top">Enter Marker Title</span></div></div></div><div class="col-lg-5"><div class="j-unit"><label class="j-label">Marker Unit</label><div class="j-input"><input type="text" name="markerUnit[]" id="markerUnit" class="col-sm-12"><span class="j-tooltip j-tooltip-right-top">Enter Marker Unit</span></div></div></div></div><br><div class="row"><div class="col-lg-3"><div class="j-unit"><label class="j-label">Min Value</label><div class="j-input"><input type="text" name="minValue[]" id="minValue" class="col-sm-12 decimal"><span class="j-tooltip j-tooltip-right-top">Enter Marker Min Value</span></div></div></div><div class="col-lg-3"><div class="j-unit"><label class="j-label">Lower Value</label><div class="j-input"><input type="text" name="lowerValue[]" id="lowerValue" class="col-sm-12 decimal"><span class="j-tooltip j-tooltip-right-top">Enter Marker Lower Value</span></div></div></div><div class="col-lg-3"><div class="j-unit"><label class="j-label">Upper Value</label><div class="j-input"><input type="text" name="upperValue[]" id="upperValue" class="col-sm-12 decimal"><span class="j-tooltip j-tooltip-right-top">Enter Marker Upper Value</span></div></div></div><div class="col-lg-3"><div class="j-unit"><label class="j-label">Max Value</label><div class="j-input"><input type="text" name="maxValue[]" id="maxValue" class="col-sm-12 decimal"><span class="j-tooltip j-tooltip-right-top">Enter Marker Max Value</span></div></div></div></div><br><div class="row"><div class="col-lg-4"><div class="j-unit"><label class="j-label">Standard Description</label><div class="j-input"><textarea name="standard[]" id="standard" class="col-sm-12"></textarea><span class="j-tooltip j-tooltip-right-top">Enter Marker Standard Value</span></div></div></div><div class="col-lg-4"><div class="j-unit"><label class="j-label">Normal Result</label><div class="j-input"><textarea name="normal[]" id="normal" class="col-sm-12"></textarea><span class="j-tooltip j-tooltip-right-top">Enter Marker Normal Description</span></div></div></div><div class="col-lg-4"><div class="j-unit"><label class="j-label">Abnormal Result</label><div class="j-input"><textarea name="abnormal[]" id="abnormal" class="col-sm-12"></textarea><span class="j-tooltip j-tooltip-right-top">Enter Marker Abnormal Description</span></div></div></div></div><hr></div></div>'); //add input box
					x++;


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
				}
			});

			$(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
				e.preventDefault();
				$("#m").remove();
				x--;
			})

		});
	</script>

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

	<script type="text/javascript">
		$('#testLogo').filer({
			extensions: ['jpg', 'jpeg', 'png', 'gif'],
			limit: 1,
			maxSize: 1,
			changeInput: true,
			showThumbs: true,
			addMore: false
		});
		//Example 2
		$('#moreImages').filer({
			limit: 10,
			maxSize: 10,
			extensions: ['jpg', 'jpeg', 'png', 'gif'],
			changeInput: true,
			showThumbs: true,
			addMore: true
		});
		/*document ckeditor*/
		CKEDITOR.replace('testDetails', {
			toolbar: [{
				name: 'document',
				items: ['Print']
			}, {
				name: 'clipboard',
				items: ['Undo', 'Redo']
			}, {
				name: 'styles',
				items: ['Format', 'Font', 'FontSize']
			}, {
				name: 'basicstyles',
				items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
			}, {
				name: 'colors',
				items: ['TextColor', 'BGColor']
			}, {
				name: 'align',
				items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
			}, {
				name: 'links',
				items: ['Link', 'Unlink']
			}, {
				name: 'paragraph',
				items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
			}, {
				name: 'insert',
				items: ['Table']
			}, {
				name: 'tools',
				items: ['Maximize']
			}, {
				name: 'editing',
				items: ['Scayt']
			}],
			customConfig: '',
			height: 200,
			contentsCss: ['<?= base_url() ?>assets/admin/assets/pages/ckeditor/contents.css', '<?= base_url() ?>assets/admin/assets/pages/ckeditor/document.css'],
			bodyClass: 'document-editor',
			format_tags: 'p;h1;h2;h3;pre',
			removeDialogTabs: 'image:advanced;link:advanced',
			stylesSet: [
				/* Inline Styles */
				{
					name: 'Marker',
					element: 'span',
					attributes: {
						'class': 'marker'
					}
				}, {
					name: 'Cited Work',
					element: 'cite'
				}, {
					name: 'Inline Quotation',
					element: 'q'
				},

				/* Object Styles */
				{
					name: 'Special Container',
					element: 'div',
					styles: {
						padding: '5px 10px',
						background: '#eee',
						border: '1px solid #ccc'
					}
				}, {
					name: 'Compact table',
					element: 'table',
					attributes: {
						cellpadding: '5',
						cellspacing: '0',
						border: '1',
						bordercolor: '#ccc'
					},
					styles: {
						'border-collapse': 'collapse'
					}
				}, {
					name: 'Borderless Table',
					element: 'table',
					styles: {
						'border-style': 'hidden',
						'background-color': '#E6E6FA'
					}
				}, {
					name: 'Square Bulleted List',
					element: 'ul',
					styles: {
						'list-style-type': 'square'
					}
				}
			]
		});
		CKEDITOR.replace('testSymtoms', {
			toolbar: [{
				name: 'document',
				items: ['Print']
			}, {
				name: 'clipboard',
				items: ['Undo', 'Redo']
			}, {
				name: 'styles',
				items: ['Format', 'Font', 'FontSize']
			}, {
				name: 'basicstyles',
				items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
			}, {
				name: 'colors',
				items: ['TextColor', 'BGColor']
			}, {
				name: 'align',
				items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
			}, {
				name: 'links',
				items: ['Link', 'Unlink']
			}, {
				name: 'paragraph',
				items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
			}, {
				name: 'insert',
				items: ['Table']
			}, {
				name: 'tools',
				items: ['Maximize']
			}, {
				name: 'editing',
				items: ['Scayt']
			}],
			customConfig: '',
			height: 200,
			contentsCss: ['<?= base_url() ?>assets/admin/assets/pages/ckeditor/contents.css', '<?= base_url() ?>assets/admin/assets/pages/ckeditor/document.css'],
			bodyClass: 'document-editor',
			format_tags: 'p;h1;h2;h3;pre',
			removeDialogTabs: 'image:advanced;link:advanced',
			stylesSet: [
				/* Inline Styles */
				{
					name: 'Marker',
					element: 'span',
					attributes: {
						'class': 'marker'
					}
				}, {
					name: 'Cited Work',
					element: 'cite'
				}, {
					name: 'Inline Quotation',
					element: 'q'
				},

				/* Object Styles */
				{
					name: 'Special Container',
					element: 'div',
					styles: {
						padding: '5px 10px',
						background: '#eee',
						border: '1px solid #ccc'
					}
				}, {
					name: 'Compact table',
					element: 'table',
					attributes: {
						cellpadding: '5',
						cellspacing: '0',
						border: '1',
						bordercolor: '#ccc'
					},
					styles: {
						'border-collapse': 'collapse'
					}
				}, {
					name: 'Borderless Table',
					element: 'table',
					styles: {
						'border-style': 'hidden',
						'background-color': '#E6E6FA'
					}
				}, {
					name: 'Square Bulleted List',
					element: 'ul',
					styles: {
						'list-style-type': 'square'
					}
				}
			]
		});

		CKEDITOR.replace('testDescription', {
			toolbar: [{
				name: 'document',
				items: ['Print']
			}, {
				name: 'clipboard',
				items: ['Undo', 'Redo']
			}, {
				name: 'styles',
				items: ['Format', 'Font', 'FontSize']
			}, {
				name: 'basicstyles',
				items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
			}, {
				name: 'colors',
				items: ['TextColor', 'BGColor']
			}, {
				name: 'align',
				items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
			}, {
				name: 'links',
				items: ['Link', 'Unlink']
			}, {
				name: 'paragraph',
				items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
			}, {
				name: 'insert',
				items: ['Table']
			}, {
				name: 'tools',
				items: ['Maximize']
			}, {
				name: 'editing',
				items: ['Scayt']
			}],
			customConfig: '',
			height: 200,
			contentsCss: ['<?= base_url() ?>assets/admin/assets/pages/ckeditor/contents.css', '<?= base_url() ?>assets/admin/assets/pages/ckeditor/document.css'],
			bodyClass: 'document-editor',
			format_tags: 'p;h1;h2;h3;pre',
			removeDialogTabs: 'image:advanced;link:advanced',
			stylesSet: [
				/* Inline Styles */
				{
					name: 'Marker',
					element: 'span',
					attributes: {
						'class': 'marker'
					}
				}, {
					name: 'Cited Work',
					element: 'cite'
				}, {
					name: 'Inline Quotation',
					element: 'q'
				},

				/* Object Styles */
				{
					name: 'Special Container',
					element: 'div',
					styles: {
						padding: '5px 10px',
						background: '#eee',
						border: '1px solid #ccc'
					}
				}, {
					name: 'Compact table',
					element: 'table',
					attributes: {
						cellpadding: '5',
						cellspacing: '0',
						border: '1',
						bordercolor: '#ccc'
					},
					styles: {
						'border-collapse': 'collapse'
					}
				}, {
					name: 'Borderless Table',
					element: 'table',
					styles: {
						'border-style': 'hidden',
						'background-color': '#E6E6FA'
					}
				}, {
					name: 'Square Bulleted List',
					element: 'ul',
					styles: {
						'list-style-type': 'square'
					}
				}
			]
		});
	</script>
	<!-- data-table js -->
	<script type="text/javascript">
		$(".js-example-basic-single").select2();
		// Tagging Suppoort
		$(".js-example-tags").select2({
			tags: true
		});

		$("#frm_1").justFormsPro({
			rules: {
				"testName": {
					required: true
				},
				"testCode": {
					required: true
				},
				"originalPrice": {
					required: true,
					number: true
				},
				"categoryId": {
					required: true
				},
				"discountPrice": {
					required: true,
					number: true
				},
				"testDescription": {
					required: true
				},
				"price_to_supplier": {
					required: true
				},
				"testMarkers[]": {
					required: true
				},
				"markerTitle[]": {
					required: true
				},
				"markerUnit[]": {
					required: true
				},
				"minValue[]": {
					required: true
				},
				"lowerValue[]": {
					required: true
				},
				"upperValue[]": {
					required: true
				},
				"maxValue[]": {
					required: true
				},
				"standard[]": {
					required: true
				},
				"normal[]": {
					required: true
				},
				"abnormal[]": {
					required: true
				}
			},
			messages: {
				"testName": {
					required: "Enter test name"
				},
				"testCode": {
					required: "Enter test code"
				},
				"originalPrice": {
					required: "Enter original price",
					number: "Field only numbers allowed"
				},
				"categoryId": {
					required: "Select Category"
				},
				"discountPrice": {
					required: "Enter Discount Price",
					number: "Field only numbers allowed"
				},
				"testDescription": {
					required: "Enter Description"
				},
				"price_to_supplier": {
					required: "Enter Price to Supplier"
				},
				"testMarkers[]": {
					required: "Enter Test Markers"
				},
				"markerTitle[]": {
					required: "Enter Marker Title"
				},
				"markerUnit[]": {
					required: "Enter Marker Unit"
				},
				"minValue[]": {
					required: "Enter Marker Min Value"
				},
				"lowerValue[]": {
					required: "Enter Marker Lower Value"
				},
				"upperValue[]": {
					required: "Enter Marker Upper Value"
				},
				"maxValue[]": {
					required: "Enter Marker Max Value"
				},
				"standard[]": {
					required: "Enter Standard Description"
				},
				"normal[]": {
					required: "Enter Normal Description"
				},
				"abnormal[]": {
					required: "Enter Abnormal Description"
				}
			},
			debug: true,
			formType: {
				multistep: true
			},
			submit: false,
			afterSubmitHandler: function(result) {
				//$('#');
				return true;
			}
		});
		$('#frm_1').submit(function(evt) {
			var frm = $(this);
			var formData = new FormData($('form#frm_1').get(0));
			var testDetails = CKEDITOR.instances.testDetails.getData();
			var testSymtoms = CKEDITOR.instances.testSymtoms.getData();
			formData.set('testDetails', testDetails);
			formData.set('testSymtoms', testSymtoms);
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


		function delete_img(id) {
			$.confirm({
				title: 'Status!',
				content: 'Are you want to delete ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Yes: {
						text: 'Yes',
						btnClass: 'btn-red',
						action: function() {

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function() {
									var self = this;
									return $.ajax({
										url: "<?php echo base_url(); ?>admin/tests/delete_img",
										dataType: 'json',
										data: {
											id: id
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
												autoClose: 'close|5000',
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function() {
															$('#img_' + id).remove();
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

		function delete_marker(id) {
			alert(id);
			$.confirm({
				title: 'Status!',
				content: 'Are you want to delete ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Yes: {
						text: 'Yes',
						btnClass: 'btn-red',
						action: function() {

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function() {
									var self = this;
									return $.ajax({
										url: "<?php echo base_url(); ?>admin/tests/delete_marker",
										dataType: 'json',
										data: {
											id: id
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
												autoClose: 'close|5000',
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function() {
															$('#marker').load(' #marker', function() {});
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
	</script>


	<script>
		function show1() {
			document.getElementById('div1').style.display = 'none';
		}

		function show2() {
			document.getElementById('div1').style.display = 'block';
		}
	</script>

</body>

</html>