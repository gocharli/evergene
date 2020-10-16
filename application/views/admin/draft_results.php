<?php $this->load->view('admin/includes/head'); ?>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/list-scroll/list.css">
<!-- owl carousel css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/owl.carousel/css/owl.theme.default.css">
<!-- Data Table Css -->
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


</body>

</html>