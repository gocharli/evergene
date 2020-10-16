<?php $this->load->view('admin/includes/head'); ?>
<!-- slick css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/slick-carousel/css/slick.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/slick-carousel/css/slick-theme.css">

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
					<!-- [ navigation menu ] end -->
					<div class="pcoded-content">
						<!-- [ breadcrumb ] start -->
						<div class="page-header">
							<div class="page-block">
								<div class="row align-items-center">
									<div class="col-md-8">
										<div class="page-header-title">
											<h4 class="m-b-10">View Test</h4>
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
												<a href="javascript:;">View Test</a>
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
											<div class="col-md-12">
												<!-- Product detail page start -->
												<div class="card product-detail-page">
													<div class="card-block">
														<div class="row">
															<div class="col-lg-5 col-xs-12">
																<div class="port_details_all_img row">
																	<div class="col-lg-12 m-b-15">
																		<div id="big_banner">
																			<?php $imoreImages = $this->db->query('select * from test_images WHERE testId=' . $row->testId)->result();
																			if ($imoreImages) {
																				foreach ($imoreImages as $image) { ?>
																					<div class="port_big_img">
																						<img class="img img-fluid" src="<?= base_url() . '/uploads/tests/products/' . $image->imageName ?>" alt="Images" style="height: 350px;">
																					</div>
																			<?php
																				}
																			} ?>
																		</div>
																	</div>
																	<div class="col-lg-12 product-right">
																		<div id="small_banner">
																			<?php
																			if ($imoreImages) {
																				foreach ($imoreImages as $image) { ?>
																					<div>
																						<img class="img img-fluid" src="<?= base_url() . '/uploads/tests/products/' . $image->imageName ?>" alt="small" style="height: 80px;">
																					</div>
																			<?php
																				}
																			} ?>
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-lg-7 col-xs-12 product-detail" id="product-detail">
																<div class="row">
																	<div>
																		<div class="col-lg-12">
																			<span class="txt-muted d-inline-block">Product Code: <a href="#!"> EGT<?= $row->testId ?> </a> </span><br />
																			<span class="txt-muted d-inline-block">Test Code: <a href="#!"> <?= $row->testCode ?> </a> </span>

																		</div>
																		<div class="col-lg-12">
																			<h4 class="pro-desc"><?= $row->testName ?></h4>
																		</div>
																		<div class="col-lg-12">
																			<span class="txt-muted"> <?= $row->categoryName ?> </span>
																		</div>
																		<div class="col-lg-12">
																			<span class="text-primary product-price"><i class="icofont icofont-cur-pound"></i> <?= $row->originalPrice ?></span>
																			<?php if ($row->discountPercentage == 'Yes') {  ?>
																				<span class="label label-danger"><?= $row->discountPrice ?> %</span>
																			<?php } else { ?>
																				<span class="label label-danger"><i class="icofont icofont-cur-pound"></i> <?= $row->discountPrice ?></span>
																			<?php } ?>

																			<hr>
																			<p><?= $row->testDescription ?></p>

																			<p><b>Result History Required : </b> <?= $row->resultHistory ?> </p>
																		</div>


																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- Product detail page end -->
											</div>
										</div>
										<!-- Nav tabs start-->
										<div class="card product-detail-page">
											<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist">
												<li class="nav-item">
													<a class="nav-link active f-18 p-b-0" data-toggle="tab" href="#description" role="tab">Test Details</a>
													<div class="slide"></div>
												</li>
												<li class="nav-item m-b-0">
													<a class="nav-link f-18 p-b-0" data-toggle="tab" href="#review" role="tab">Test Markers</a>
													<div class="slide"></div>
												</li>
												<li class="nav-item m-b-0">
													<a class="nav-link f-18 p-b-0" data-toggle="tab" href="#sizeguide" role="tab">Test Symtoms</a>
													<div class="slide"></div>
												</li>
											</ul>
										</div>
										<!-- Nav tabs start-->

										<!-- Nav tabs card start-->
										<div class="card">
											<div class="card-block">
												<!-- Tab panes -->
												<div class="tab-content bg-white">
													<div class="tab-pane active" id="description" role="tabpanel">
														<?= $row->testDetails ?>
													</div>
													<div class="tab-pane" id="review" role="tabpanel">
														<?php
														if ($row->testMarkers != '') {
															$testMarkers = explode(',', $row->testMarkers);
															foreach ($testMarkers as $tm) { ?>
																<span class="label label-inverse"><?= $tm ?></span>
														<?php }
														}

														?>
													</div>
													<div class="tab-pane" id="sizeguide" role="tabpanel">
														<?= $row->testSymtoms ?>
													</div>

												</div>
											</div>
										</div>
										<!-- Nav tabs card end-->
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
	<!-- slick js -->
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/slick-carousel/js/slick.min.js"></script>
	<!-- product detail js -->
	<script type="text/javascript">
		$('#big_banner').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: false,
			fade: true,
			autoplay: true,
			autoplaySpeed: 2000,
			asNavFor: '#small_banner'
		});
		$('#small_banner').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			asNavFor: '#big_banner',
			dots: false,
			centerMode: true,
			autoplay: true,
			arrows: true,
			autoplaySpeed: 2000,
			focusOnSelect: true,
			responsive: [, {
				breakpoint: 480,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			}, ]
		});
	</script>
</body>

</html>