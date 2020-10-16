<?php $this->load->view('admin/includes/head'); ?>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/list-scroll/list.css">
<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.theme.default.css">
<!-- jquery file upload Frame work -->
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">

<style>
	.upload-file .jFiler.jFiler-theme-default .jFiler-input-button {
		height: 44px !important;
		line-height: 30px !important;
		border-radius: 0px !important;

	}

	.upload-file .jFiler.jFiler-theme-default .jFiler-input {
		margin-bottom: 0px !important;
		height: 44px !important;
	}
</style>

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
											<h4 class="m-b-10"><?php echo $order_details[0]->testName; ?> detail</h4>
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
												<a href="javascript:;"><?php echo $order_details[0]->testName; ?> detail</a>
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
												<br><br>
												<h2>Upload Results</h2>
												<?php //print_r($order_details); 
												?>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-lg-12">
												<table class="table m-0">
													<thead>
														<tr>
															<th>ID</th>
															<th>Member</th>
															<th>Item</th>
															<th>Amount</th>
															<th>Scheduled</th>
															<th>Status</th>
															<th>Payment</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><?php echo $order_details[0]->detailId; ?></td>
															<td><?php echo $order_details[0]->userFirstName . ' ' . $value->userLastName; ?></td>
															<td><?php echo $order_details[0]->testName; ?></td>
															<td><b>&pound;</b> <?php echo $order_details[0]->orderAmount; ?></td>
															<td><?php echo date("d F Y", strtotime($order_details[0]->scheduleDate)); ?></td>
															<td><?php echo $order_details[0]->detailStatus; ?></td>
															<td>
																<?php
																if ($order_details[0]->paymentStatus == 'Yes') {

																	echo 'Paid';
																} else {
																	echo 'Un-Paid';
																}
																?>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<br><br><br>
										<form id="uploadResultForm" enctype="multipart/form-data" method="POST">
											<div class="row">
												<div class="col-lg-1">

													<!-- <label>Result Test ID</label> -->
													<input type="hidden" name="resultTest" id="resultTest" class="form-control" value="<?php echo $order_details[0]->testId; ?>">


													<input type="hidden" name="userId" id="userId" value="<?php echo $order_details[0]->userId; ?>">
													<input type="hidden" name="testId" id="testId" value="<?php echo $order_details[0]->testId; ?>">
													<input type="hidden" name="detailId" id="detailId" value="<?php echo $order_details[0]->detailId; ?>">
													<input type="hidden" name="orderId" id="orderId" value="<?php echo $order_details[0]->orderId; ?>">

												</div>
												<div class="col-lg-3">
													<label>Test Name</label>
													<input type="text" name="testName" value="<?php echo $order_details[0]->testName ?>" id="testName" class="form-control" readonly>
												</div>
												<div class="col-lg-3">
													<label>Sample Taken On</label>
													<input type="date" name="sampleTakeen" id="sampleTakeen" class="form-control" required="true">
												</div>
												<div class="col-lg-3">
													<label>Result Processed On</label>
													<input type="date" name="resultProcessed" id="resultProcessed" class="form-control" required="true">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3">
													<!-- <label>Lab/Department</label> -->
													<input type="hidden" name="lab" id="lab" class="form-control" value="Lab 1">
												</div>
												<div class="col-lg-3">
													<!-- <label>Result Type</label> -->
													<input type="hidden" name="resultType" id="resultType" class="form-control" value="OBX">
												</div>
											</div>
											<?php
											$limit = $order_details[0]->no_of_markers;
											for ($i = 0; $i < $limit; $i++) {
											?>
												<hr>
												<fieldset class="form-control">
													<div class="row">
														<div class="col-lg-4">
															<div class="j-unit j-span4">
																<label class="j-label">Select Result</label>
																<div class="j-input j-select">
																	<select class="js-example-basic-single" name="result3[]" style="width: 100% !important; height:30px!important" required>
																		<option value="">Select Result</option>
																		<option value="Positive">Positive</option>
																		<option value="Negative">Negative</option>

																	</select>
																</div>
															</div>
														</div>
													</div>
													<br><br>

													<div class="row">
														<div class="col-lg-4">
															<label class="j-label">Standard Description</label>
															<textarea name="standard[]" id="standard" class="col-sm-12 form-control"><?php echo $order_details[$i]->tm_standard_description; ?></textarea>
														</div>
														<div class="col-lg-4">
															<label class="j-label">Negative Result</label>
															<textarea name="normal[]" id="normal" class="col-sm-12 form-control"><?php echo $order_details[$i]->tm_normal_description; ?></textarea>
														</div>
														<div class="col-lg-4">
															<label class="j-label">Positive Result</label>
															<textarea name="abnormal[]" id="abnormal" class="col-sm-12 form-control"><?php echo $order_details[$i]->tm_abnormal_description; ?></textarea>
														</div>
													</div>
												</fieldset>
											<?php
											}
											?>

											<br><br>
											<div class="row">
												<div class="col-lg-6"></div>
												<div class="col-lg-3 text-right">
													<div class="card-block upload-file">
														<input type="file" name="resultFile" id="testLogo1">
													</div>
												</div>
												<div class="col-lg-1 text-right">
													<a href="<?php echo base_url() . 'admin/orders_items/index/inprogress'; ?>" class="btn btn-primary">Back</a>
												</div>
												<div class="col-lg-2 text-left">
													<input type="submit" name="upload_result_btn" id="upload_result_btn" value="Save and Preview" class="btn btn-primary">
												</div>
											</div>
										</form>
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

	<script src="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
	<script type="text/javascript">
		$('#testLogo1').filer({
			//extensions: ['*'],
			limit: 1,
			maxSize: 1,
			changeInput: true,
			showThumbs: true,
			addMore: false
		});
	</script>
	<script type="text/javascript">
		var tomorrow = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);

		$("#sampleTakeen").val(getFormattedDate(tomorrow));
		$("#resultProcessed").val(getFormattedDate(tomorrow));

		// Get date formatted as YYYY-MM-DD
		function getFormattedDate(date) {
			return date.getFullYear() +
				"-" +
				("0" + (date.getMonth() + 1)).slice(-2) +
				"-" +
				("0" + date.getDate()).slice(-2);
		}
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
		// $(document).ready(function () {

		$('#uploadResultForm').submit(function(e) {

			e.preventDefault();

			var frm = $(this);
			var formData = new FormData($('form#uploadResultForm').get(0));

			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: '<?php echo base_url() . 'admin/Orders_items/addTestResult3'; ?>',
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						method: 'POST',
						cache: false,
					}).done(function(response) {
						console.log(response);
						// self.close();
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
											window.location = "<?php echo base_url() . 'admin/orders_items/view/' . $order_details[0]->detailId; ?>";
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
		// });
	</script>

</body>

</html>