<?php $this->load->view('includes/head');   ?>
</head>

<body>
<div class="main-page-wrapper">
	<?php $this->load->view('includes/menu');   ?>
	<div class="inner-page-banner">
		<div class="opacity header-product-detail">
		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->
	<div class="shop-page hub-page portfolio-details full-width">
		<div class="row">
			<div class="p-0 m-p-15">
				<div class="title-head">
					<h5 class="pull-left" style="padding: 15px 0;">Change Password</h5>
					<a href="#" class="tran3s custom-btn pull-right">Become A Friend</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div> <br />
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15">
				<?php $this->load->view('includes/sidebar'); ?>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 float-right p-0">
				<div class="shop-product-wrapper service-version-one" style="min-height: 520px;">
					<div class="row">
						<div class="col-lg-6 col-xs-6 col-lg-offset-3">
							<div class="single-service m-bottom0">
								<form id="frm_change_password" action="<?=base_url()?>account/password_code">
									<div class="form-group">
										<label>Old Password</label>
										<input type="password" class="form-control"  name="password" autocomplete="off"  value="">
									</div>
									<div class="form-group">
										<label>New Password</label>
										<input type="password" class="form-control" name="new_password" autocomplete="off" value="" />
									</div>
									<div class="form-group">
										<label>Confirm Password</label>
										<input type="password" class="form-control" name="c-password" autocomplete="off" value="" />
									</div>
									<div class="form-group">
										<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two">Change Password</button>
									</div>
								</form>
							</div>

						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script type="text/javascript">
		$('#frm_change_password').submit(function()
		{
			var frm=$(this);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data:frm.serialize(),
						method: 'post'
					}).done(function (response) {
						self.close();

						if(response.code==0)
						{
							$.confirm({
								title: 'Error!',
								icon:  'fa fa-warning',
								closeIcon: true,
								content: response.message,
								type: 'red',
								autoClose: 'close|10000',
								typeAnimated: true,
								buttons: {
									close: function () {
									}
								}
							});
						}
						else
						{
							$.confirm({
								title: 'Success!',
								icon:  'fa fa-check',
								content: response.message,
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function(){
											frm[0].reset();
										}
									}
								}
							});
						}
					}).fail(function(){
						self.close();
						$.confirm({
							title: 'Encountered an error!',
							content: 'Something went wrong.',
							type: 'red',
							typeAnimated: true,
							buttons: {
								close: function () {
								}
							}
						});

					});
				},
				buttons: {
					close: function () { }
				}
			});
			return false;
		});
	</script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
