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
											<h4 class="m-b-10">Cancel Order</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/orders_items/index/new">
													Order Items
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">Authenticate</a>
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
										<br><br>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-8">
												<fieldset class="form-control" style="background-color: transparent;">
													<legend>Authenticate Yourself</legend>
													<form method="post" id="authForm">
														<label>Authentication Pin</label>
														<input class="form-control col-md-6" type="password" name="pin" id="pin" placeholder="enter your pin">
														<br>
														<input type="submit" name="auth_btn" id="auth_btn" class="btn btn-primary" value="Authenticate"><br><br>
													</form>
												</fieldset>
											</div>
										</div>
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


	<script type="text/javascript">
		$(document).ready(function() {
			$(function() {
				$('#auth_btn').click(function(e) {
					$('#authForm').submit(function(e) {

						e.preventDefault();

						var frm = $(this);
						var formData = new FormData($('form#authForm').get(0));

						$.confirm({
							icon: 'fa fa-spinner fa-spin',
							title: 'Working!',
							content: function() {
								var self = this;
								return $.ajax({
									url: '<?php echo base_url() . 'admin/Orders_items/resultEditAuthCheck'; ?>',
									dataType: 'json',
									data: formData,
									processData: false,
									contentType: false,
									method: 'POST',
									cache: false,
								}).done(function(response) {
									console.log(response);
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
												ok: {
													text: 'Ok',
													btnClass: 'btn-red',
													action: function() {
														window.location = "<?php echo base_url() . 'admin/orders_items/index/new'; ?>";
													}

												}
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
														window.location = "<?php echo base_url() . 'admin/orders_items/index/new'; ?>";
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
				});
			});
		});
	</script>
</body>

</html>