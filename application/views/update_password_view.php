<?php $this->load->view('includes/head');   ?>
</head>

<body>
	<div class="main-page-wrapper">

		<?php $this->load->view('includes/menu');   ?>

		<div class="inner-page-banner">
			<div class="opacity header-product-detail">

			</div> <!-- /.opacity -->
		</div> <!-- /inner-page-banner -->

		<div class="shop-page hub-page">
			<div class="row">
				<div class="container">

					<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
						<div class="shop-product-wrapper service-version-one" style="border: 0; padding: 0px;">

							<div class="row">

								<div class="col-lg-6 col-xs-6 col-lg-offset-3">
									<div class="single-product shop-sidebar">
										<div class="product-header">
											<h6 style="margin: 0px;">Reset Password
											</h6>
											<div class="clearfix"></div>
										</div>
										<!--product header-->
										<div class="single-service m-bottom0">
											<form id="frm_update_pass" action="<?php echo base_url(); ?>login/update_password_code" method="post">
												<div class="form-group">
													<label>Password</label>
													<input type="password" class="form-control" name="password" autocomplete="off" value="">
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<input type="password" class="form-control" name="c-password" autocomplete="off" value="" />
												</div>
												<div class="form-group">
													<input type="hidden" name="pass_code" value="<?php echo $pass_code; ?>">
													<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two">Rest password</button>
												</div>
											</form>
										</div>
										<div class="clearfix"></div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->

							</div> <!-- /.row -->

						</div> <!-- /.shop-product-wrapper -->
					</div>

				</div> <!-- /.container -->
			</div> <!-- /.row -->
		</div> <!-- /.shop-page -->


		<div class="home-blog-section">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div class="single-blog color-one">
							<img src="<?= base_url('assets/front/') ?>images/home/6.jpg" alt="">
							<h5>SSL certificate</h5>
							<p>All of our tests are carried out to the highest standards in an NHS accredited laboratory</p>
						</div> <!-- /.single-blog -->
					</div> <!-- /.col- -->
					<div class="col-md-6 col-xs-12">
						<div class="single-blog color-two">
							<img src="<?= base_url('assets/front/') ?>images/home/7.jpg" alt="">
							<h5>Data protection</h5>
							<p>Your data belongs to you and we take it very seriously to ensure you have complete control of it</p>
						</div> <!-- /.single-blog -->
					</div> <!-- /.col- -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.home-blog-section -->

		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<script type="text/javascript">
			$('#frm_update_pass').submit(function(evt) {

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
									autoClose: 'ok|3000',
									typeAnimated: true,
									buttons: {
										ok: function() {
											location.reload();
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
		<?php $this->load->view('includes/scripts'); ?>

	</div> <!-- /.main-page-wrapper -->
</body>

</html>