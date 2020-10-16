<?php $this->load->view('admin/includes/head'); ?>
<!-- Select 2 css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/front/ex_css/bootstrap-datetimepicker.min.css" />
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
											<h4 class="m-b-10">Edit Member</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/members">
													Members
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">edit Member</a>
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
														<h5>Edit Client</h5>
														<span>Edit <?= $row->userFirstName ?> information</span>
													</div>
													<div class="card-block">
														<div class="j-wrapper j-wrapper-640">
															<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/members/edit_process/<?= $row->userId ?>" method="post" class="j-pro">
																<div class="j-content">

																	<div class="j-unit">
																		<label class="j-label">First Name</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<i class="icofont icofont-ui-user"></i>
																			</label>
																			<input type="text" id="userFirstName" name="userFirstName" value="<?= $row->userFirstName ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter first name</span>
																		</div>
																	</div>
																	<div class="j-unit">
																		<label class="j-label">Last Name</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userLastName">
																				<i class="icofont icofont-ui-user"></i>
																			</label>
																			<input type="text" id="userLastName" name="userLastName" value="<?= $row->userLastName ?>">
																			<span class="j-tooltip j-tooltip-right-top">Enter last name</span>
																		</div>
																	</div>

																	<div class="j-unit">
																		<label class="j-label">Email</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userEmail">
																				<i class="icofont icofont-ui-email"></i>
																			</label>
																			<input type="email" id="userEmail" name="userEmail" readonly="" value="<?= $row->userEmail ?>">
																			<span class="j-tooltip j-tooltip-right-top">Email not editable</span>
																		</div>
																	</div>
																	<div class="j-unit">
																		<label class="j-label">Date of Birth</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userDob">
																				<i class="feather icon-calendar"></i>
																			</label>
																			<input type="text" id="userDob" name="userDob" value="<?= date('y-m-d', strtotime($row->userDob)) ?>">
																			<span class="j-tooltip j-tooltip-right-top">Date of Birth</span>
																		</div>
																	</div>

																	<div class="j-unit">
																		<label class="j-label">Gender</label>
																		<div class="j-input form-radio" style="margin-top: 15px;">
																			<div class="radio radio-inline">
																				<label>
																					<input type="radio" name="userGender" value="Male" <?php if ($row->userGender == 'Male') {
																																			echo 'checked=""';
																																		} ?>>
																					<i class="helper"></i>Male
																				</label>
																			</div>
																			<div class="radio radio-inline">
																				<label>
																					<input type="radio" name="userGender" value="Female" <?php if ($row->userGender == 'Female') {
																																				echo 'checked=""';
																																			} ?>>
																					<i class="helper"></i>Female
																				</label>
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
	<script type="text/javascript" src="<?= base_url() ?>assets/front/ex_js/moment.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/front/ex_js/bootstrap-datetimepicker.min.js"></script>

	<!-- Select 2 js -->
	<!-- data-table js -->
	<script type="text/javascript">
		$(document).ready(function($) {
			$("#userDob").datetimepicker({
				format: 'YYYY-MM-DD'
			});
		});
		$('#frm_1').submit(function(evt) {
			var frm = $(this);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data: frm.serialize(),
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
								autoClose: 'close',
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
								autoClose: 'ok',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function() {

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