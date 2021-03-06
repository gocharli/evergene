<?php $this->load->view('admin/includes/head'); ?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
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
											<h4 class="m-b-10">Coupons Used</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item"><a href="javascript:;">Coupons Used</a>
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
									<div class="page-body">
										<!-- Server Side Processing table start -->
										<div class="card">
											<div class="card-header">
												<h5>Coupons Used</h5>

											</div>
											<div class="card-block">
												<div class="dt-responsive table-responsive">
													<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
														<thead>
															<tr>
																<th> ID </th>
																<th> Code </th>
																<th> Plan </th>

																<th> planAmount </th>
																<th> Percentage </th>
																<th> Amount Paid </th>

																<th> Username</th>
																<th> createdAt</th>

															</tr>


															<?php foreach ($coupon_used as $c) { ?>

																<tr>
																	<th> <?php echo $c->ID; ?> </th>
																	<th> <?php echo $c->code; ?> </th>
																	<th> <?php echo $c->planTitle; ?> </th>

																	<th> <?php echo $c->planAmount; ?> </th>
																	<th> <?php echo $c->percentage; ?> </th>
																	<th> <?php echo $c->paid_amount; ?> </th>


																	<th><?php echo $c->user_name; ?> </th>
																	<th> <?php echo $c->createdAt; ?></th>
																</tr>

															<?php } ?>

														</thead>
													</table>
												</div>
											</div>
										</div>
										<!-- Server Side Processing table end -->
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>

	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script><!-- Custom js -->
	<script type="text/javascript">
		// Server side processing Data-table

		function delete_coupon(e, id) {
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
										url: "<?php echo base_url(); ?>admin/coupons/delete_coupon",
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
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function() {
															$(e).closest("tr").remove();
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

</body>

</html>