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
											<h4 class="m-b-10">Banner</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item"><a href="javascript:;">Banner</a>
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

												<div class="row col-md-12">

													<div class="col-md-3">
														<h5>Banner</h5>
														<span>Banner Management </span>
													</div>

													<div class="col-md-6">


														<?php if ($this->session->flashdata('error')) { ?>
															<div class="alert alert-block  alert-danger">

																<strong> <?php echo $this->session->flashdata('error'); ?> </strong>
															</div>
														<?php } ?>


														<?php if ($this->session->flashdata('success')) { ?>
															<div class="alert alert-block  alert-success">

																<strong> <?php echo $this->session->flashdata('success'); ?></strong>
															</div>
														<?php } ?>


													</div>
													<div class="col-md-3">
													</div>

												</div>
											</div>
											<div class="card-block">
												<div class="dt-responsive table-responsive">
													<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
														<thead>
															<tr>

																<th> Title </th>
																<th> Link</th>
																<th> Action</th>
															</tr>

															<tr>
																<td><?php echo $banner->title; ?></td>
																<td><?php echo $banner->link; ?></td>
																<td>
																	<a href="<?php echo base_url(); ?>admin/banner/edit/<?php echo $banner->ID; ?>" class="btn waves-effect waves-light btn-primary btn-sm"><i class="icofont icofont-edit"></i></a>
																</td>
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
		// $('#dt-server-processing').DataTable({
		// });
	</script>

</body>

</html>