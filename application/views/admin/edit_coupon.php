<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<!-- Style.css -->
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />



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
											<h4 class="m-b-10">Edit Coupon</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/coupons">
													Coupons
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">Edit Coupon</a>
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
														<h5>Edit Coupon</h5>
														<span>Edit Coupon information</span>
													</div>
													<div class="card-block">
														<div class="j-wrapper j-wrapper-640">
															<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/coupons/edit_process/<?= $row->ID ?>" method="post" class="j-pro">
																<div class="j-content">

																	<div class="j-unit">
																		<label class="j-label">Code</label>
																		<div class="j-input">

																			<input type="text" id="code" name="code" required="true" value="<?php echo $row->code; ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter Code</span>
																		</div>
																	</div>

																	<div class="j-unit">
																		<label class="j-label">Percentage</label>
																		<div class="j-input">

																			<input type="number" id="percentage" class="form-control" name="percentage" max="99" required="true" value="<?php echo $row->percentage; ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter Percentage</span>
																		</div>
																	</div>



																	<div class="j-unit">
																		<label class="j-label">Frequency</label>
																		<div class="j-input">

																			<input type="number" class="form-control" id="frequency" name="frequency" required="true" value="<?php echo $row->frequency; ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter Frequency</span>
																		</div>
																	</div>


																	<div class="j-unit">
																		<label class="j-label">Package</label>
																		<select name="pkg_id" required="true">
																			<?php foreach ($coupons as $c) { ?>
																				<option value="<?php echo $c->mpId; ?>" <?php if ($c->mpId == $row->pkg_id) echo 'selected'; ?>><?php echo $c->planTitle; ?></option>
																			<?php } ?>

																		</select>
																		<span class="j-tooltip j-tooltip-right-top"> Select Package </span>

																	</div>


																	<div class="j-unit" id="div1">
																		<label class="j-label">Start Date</label>
																		<div class="j-input">
																			<input type="date" name="start_date" id="start_date" class="form-control" required="true" value="<?php echo $row->start_date; ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter Start Date</span>
																		</div>
																	</div>

																	<div class="j-unit" id="div2">
																		<label class="j-label">Expiry Date</label>
																		<div class="j-input">
																			<input type="date" name="expiry_date" id="expiry_date" class="form-control" required="true" value="<?php echo $row->expiry_date; ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter Expiry Date</span>
																		</div>
																	</div>


																</div>
																<!-- end /.content -->
																<div class="j-footer">
																	<button type="submit" class="btn btn-primary">Update</button>
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
	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/pages/j-pro/js/jquery.j-pro.js"></script>
	<!-- jquery file upload js -->
	<script src="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
	<!-- data-table js -->
	<script type="text/javascript">
		$('#frm_1').submit(function(evt) {
			var frm = $(this);
			var formData = new FormData($('form#frm_1').get(0));

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
	</script>
</body>

</html>