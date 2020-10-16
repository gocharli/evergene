<?php $this->load->view('admin/includes/head'); ?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/list-scroll/list.css">
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
											<h4 class="m-b-10">Notifications</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item"><a href="javascript:;">Notifications</a>
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
												<h5>Notifications</h5>
												<span>All Notifications</span>
											</div>
											<div class="card-block">

												<div class="row">

													<ul class="list-view" id="loadmore_data" style="width: 60%;margin-left: auto;margin-right: auto;">
														<?php
														if ($results) {
															$this->load->view('admin/components/notifications', array('results' => $results));
														} else { ?>
															<li class="text-center">No History Listed</li>
														<?php } ?>

													</ul>
													<?php if ($results) {  ?>
														<div class="col-md-12 text-center mb-10">
															<a href="javascript:;" class="loadmore btn btn-out btn-sm waves-effect waves-light btn-warning" page="2"><i class="fa fa-plus-square"></i> View More</a>
														</div>
													<?php } ?>


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
	<script type="text/javascript">
		function notifications_detail(notificationId) {
			if (notificationId == '') {
				return false;
			}
			$.ajax({

				type: "post",
				dataType: "json",
				url: admin_url + 'notifications/read',
				data: {
					'notificationId': notificationId
				},
				success: function(data) {
					if (data.code == 1) {
						$('#nt_' + notificationId).removeClass('bg-warning');
						window.open(admin_url + data.link, '_blank');
					}
				}
			});
		}
		$(document).on('click', '.loadmore', function() {
			var ele = $(this);
			$.ajax({
				url: '<?= $this->config->item('admin_url') ?>/notifications/load_more',
				type: 'POST',
				dataType: 'json',
				data: {
					page: $(this).attr('page')
				},
				success: function(response) {
					if (response.page == 0) {
						$('.loadmore').hide();
					} else {
						ele.attr('page', response.page)
					}

					if (response.html != '') {
						$('#loadmore_data').append(response.html).fadeIn('slow');

					}

				}
			});
		});
	</script>

</body>

</html>