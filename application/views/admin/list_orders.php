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
											<h4 class="m-b-10">Orders</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item"><a href="javascript:;">Orders</a>
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
												<h5>Orders</h5>
												<span>Orders Management</span>
											</div>
											<div class="card-block">
												<div class="dt-responsive table-responsive">
													<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
														<thead>
															<tr>
																<th style="width: 20px;"> ID</th>
																<th> Member</th>
																<th> Amount</th>
																<th> Trx_ID</th>
																<th> Address</th>
																<th> Date</th>
																<th style="width: 50px;"> Action</th>
															</tr>
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
		$('#dt-server-processing').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": admin_url + "orders/list_data",
				"dataType": "json",
				"type": "POST",
				"data": {}
			},
			"columns": [{
					"data": "id"
				},
				{
					"data": "name"
				},
				{
					"data": "amount"
				},
				{
					"data": "trx_id"
				},
				{
					"data": "address"
				},
				{
					"data": "date"
				},
				{
					"data": "action"
				}
			]
		});
	</script>

</body>

</html>