<?php $this->load->view('admin/includes/head'); ?>
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">

</head>

<body themebg-pattern="theme1">
	<!-- Pre-loader start -->
	<div class="theme-loader">
		<div class="loader-track">
			<div class="preloader-wrapper">
				<div class="spinner-layer spinner-blue">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
				<div class="spinner-layer spinner-red">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-yellow">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>

				<div class="spinner-layer spinner-green">
					<div class="circle-clipper left">
						<div class="circle"></div>
					</div>
					<div class="gap-patch">
						<div class="circle"></div>
					</div>
					<div class="circle-clipper right">
						<div class="circle"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Pre-loader end -->

	<section class="login-block">
		<!-- Container-fluid starts -->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<!-- Authentication card start -->

					<form id="frm_login" action="<?php echo base_url(); ?>admin/login/login_access" class="md-float-material form-material">
						<div class="text-center">
							<img src="<?= base_url() ?>assets/admin/logo.png" alt="" style="margin-top: -10px;" />
						</div>
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center">Sign In</h3>
									</div>
								</div>
								<div class="form-group form-primary">
									<input type="text" name="email" class="form-control" required="">
									<span class="form-bar"></span>
									<label class="float-label">Your Email Address</label>
								</div>
								<div class="form-group form-primary">
									<input type="password" name="password" class="form-control" required="">
									<span class="form-bar"></span>
									<label class="float-label">Password</label>
								</div>
								<div class="row m-t-25 text-left">
									<div class="col-12">

										<div class="forgot-phone text-right float-right">
											<a href="javascript:;" onclick="forget()" class="text-right f-w-600"> Forgot Password?</a>
										</div>
									</div>
								</div>
								<div class="row m-t-30">
									<div class="col-md-12">
										<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
									</div>
								</div>
								<hr />
								<div class="row">
									<div class="col-md-10">
										<p class="text-inverse text-left m-b-0">Thank you.</p>
										<p class="text-inverse text-left"><a href="<?= base_url() ?>"><b>Back to website</b></a></p>
									</div>
									<div class="col-md-2">
										<img src="<?= base_url() ?>assets/admin/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
									</div>
								</div>
							</div>
						</div>
					</form>
					<!-- end of form -->
				</div>
				<!-- end of col-sm-12 -->
			</div>
			<!-- end of row -->
		</div>
		<!-- end of container-fluid -->
	</section>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>

	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/js/common-pages.js"></script>

	<script type="text/javascript">
		var login_err;

		function forget() {
			$.confirm({
				title: 'Forget Password ?',
				content: '' +
					'<form id="forget_frm" action="' + admin_url + 'login/forgot" class="formName">' +
					'<div class="form-group">' +
					'<label>Enter your e-mail address below to reset your password. </label>' +
					'<input type="email" name="email" placeholder="Email" class="name form-control" required />' +
					'</div>' +
					'</form>',
				buttons: {
					formSubmit: {
						text: 'Submit',
						btnClass: 'btn-blue',
						action: function() {
							var name = this.$content.find('.name').val();
							var fself = this;
							if (!name) {
								$.alert('provide a valid Email');
								return false;
							} else {

								var frm = $('#forget_frm');

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
												fself.close();
												$.confirm({
													title: 'Success!',
													icon: 'fa fa-check',
													content: response.message,
													type: 'green',
													autoClose: 'ok|5000',
													typeAnimated: true,
													buttons: {
														ok: {
															text: 'Ok',
															btnClass: 'btn-green',
															action: function() {
																frm[0].reset();
															}
														}
													}
												});

											}

										}).fail(function() {
											fself.close();
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
							}

						}
					},
					cancel: function() {
						//close
					},
				}
			});
		}
		$('#frm_login').submit(function(evt) {

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
							login_err = $.confirm({
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
							top.location.href = admin_url;
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