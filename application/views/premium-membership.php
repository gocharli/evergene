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
					<div class="col-lg-12 p-0 m-p-15">
						<div class="title">
							<h5 style="padding: 15px 0;">Premium Membership</h5>
							<p>Lorem ipsum dolor sit amet, no mel ferri postea principes, mel ne wisi electram, duo te tantas malorum noluisse.
								Feugait expetenda sadipscing per id, vel ea graeci percipitur definitiones.
								Facilisis scribentur no mei, ea mei summo pertinacia, splendide vituperatoribus ex mel. Cum velit cotidieque at.</p>

							<div class="clearfix"></div>
						</div><br />
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
						<div class="shop-product-wrapper service-version-one" style="border: 0; padding: 0px;">

							<div class="row">

								<div class="col-lg-12 col-xs-12">

									<div class="single-product shop-sidebar" style="padding: 100px 0px;">

										<div class="pricing-plan-list">
											<?php
											foreach ($results as $row) { ?>
												<div class="pricing-plan">
													<h2 class="pricing-plan__name" id="plan_title_<?php echo $row->mpId; ?>"><?= $row->planTitle ?></h2>
													<?php if ($bonus > 1) { ?>
														<h1 class="pricing-plan__price">£<?= $row->planAmount - $bonus ?></h1>
														<small class="pricing-plan__feature">Referral discount <b style="text-decoration: line-through "><?= $row->planAmount ?></b></small> <br>
													<?php } else { ?>
														<h1 class="pricing-plan__price">£<?= $row->planAmount ?></h1>
													<?php } ?>

													<small class="pricing-plan__disclosure">charged on a <?= $row->planPeriod ?> basis</small>
													<ul class="pricing-plan__feature-list">
														<li class="pricing-plan__feature"><?= $row->planOrders ?> orders per <?= $row->planOrderPeriod ?></li>
													</ul><br />
													<div class="col-md-12">
														<?php
														if (isset($this->session_data->userId) && $this->response['membership_type']->mpId == $row->mpId) {
															if ($this->membership_data->expire == false) {
																echo '<p style="color:red">Current Package</p><p class="mb-4"><strong>Renew Date:</strong>' . date("d F Y", $this->response['membership_type']->period_end) . '</p>';
															} else { ?>
																<input type="hidden" id="plan_price_<?php echo $row->mpId; ?>" value="<?= $row->planAmount - $bonus ?>" />
																<a href="javascript:;" onclick="process(this,<?php echo $row->mpId; ?>)" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a>
															<?php } ?>

														<?php } elseif (isset($this->session_data->userId)) { ?>
															<input type="hidden" id="plan_price_<?php echo $row->mpId; ?>" value="<?= $row->planAmount - $bonus ?>" />
															<a href="javascript:;" onclick="process(this,<?php echo $row->mpId; ?>)" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a>
														<?php } else { ?>
															<a href="javascript:;" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two loginBtn">BUY NOW</a>
														<?php } ?>



													</div>

												</div>
											<?php } ?>

										</div>

										<div style="width: 100%">
											<div class="col-md-12 " style="margin-top: 20px;padding:0px">
												<div class="col-md-2"></div>
												<div class="col-md-8 d-inline-flex">
													<p class="mem-p">Limited time offer: 1 year premium membership free with code: BLOOMLYFREE </p>
													<input type="button" class="btn btn-primary pull-left btn-pay" value="APPLY CODE" onclick="apply_discount()" style="margin-top:0px;width: 20%;">
												</div>
												<div class="col-md-2 p-0">

												</div>
											</div>
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





		<form id="mem_form" method="post" action="<?php echo base_url(); ?>memberships/process">
			<input type="hidden" name="planId" id="planId" value="">
		</form>

		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<script src="https://checkout.stripe.com/checkout.js"></script>
		<script type="text/javascript">
			var handler = StripeCheckout.configure({
				key: '<?= getenv('stripe_api_key') ?>',
				image: '<?php echo base_url(); ?>assets/stripelogo.png',
				token: function(token) {
					$('#mem_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
					var frm = $('#mem_form');
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
										autoClose: 'close|10000',
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
													top.location.href = "<?= base_url('account?type=membership') ?>";
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
			});
			<?php if (isset($this->session_data->userId)) { ?>

				function process(e, gid) {
					var total_g = $('#plan_price_' + gid).val();
					var title = $('#plan_title_' + gid).text();
					if (title == "") {
						return false;
					}
					$('#planId').val(gid);
					total = total_g * 100;
					handler.open({
						name: title,
						description: 'Charges( £' + total_g + ' )',
						currency: 'GBP',
						amount: total
					});

				}
				window.addEventListener('popstate', function() {
					handler.close();
				});
			<?php } ?>
		</script>
		<?php $this->load->view('includes/scripts'); ?>



		<script>
			function add_discount() {
				$("#discount_field").toggle();
			}

			function apply_discount() {
				var code = $("#discount_code").val();
				if (code != "") {
					$.confirm({
						title: 'Success!',
						content: 'code is applied successfully.',
						type: 'green',
						typeAnimated: true,
						buttons: {
							close: function() {}
						}
					});
				}
			}
		</script>

</body>

</html>