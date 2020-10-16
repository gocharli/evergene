<?php $this->load->view('includes/head');   ?>
</head>

<body>
	<div class="main-page-wrapper">
		<!--
    =============================================
        Theme Header
    ==============================================
    -->
		<?php $this->load->view('includes/menu');   ?>
		<!--
    =============================================
        Theme Inner Banner
    ==============================================
    -->
		<div class="inner-page-banner">
			<div class="opacity header-product-detail">

			</div> <!-- /.opacity -->
		</div> <!-- /inner-page-banner -->
		<!--
    =============================================
        Shop Page
    ==============================================
    -->
		<div class="shop-page hub-page portfolio-details full-width">
			<div class="row">
				<div class="p-0 m-p-15">
					<div class="title-head">
						<h5 class="pull-left" style="padding: 15px 0;">Membership</h5>
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

							<div class="col-lg-12 col-xs-12">

								<div class="single-product">


									<div class="product-list mb-2">

										<div class="row">

											<a href="#" class="order-again">Membership</a>


											<div class="col-lg-9">
												<?php if ($row) {
													$currnet = strtotime('now');
												?>
													<div class="results-info-list">
														<ul class="clearfix">
															<li>
																<span class="heading"><?php echo $row->planTitle; ?> MemberShip:</span>
																<span class="detail">£ <?php echo $row->planAmount; ?> / <?php echo $row->PlanDuration; ?></span>
																<div class="clearfix"></div>
															</li>
															<li>
																<span class="heading">Period Start Date :</span>
																<span class="detail"><?php echo date('F j, Y, g:i a', $row->period_start); ?></span>
																<div class="clearfix"></div>
															</li>
															<li>
																<span class="heading">Period End Date :</span>
																<span class="detail"><?php echo date('F j, Y, g:i a', $row->period_end); ?></span>
																<div class="clearfix"></div>
															</li>
															<li>
																<span class="heading">Created Date :</span>
																<span class="detail"><?php echo date('F j, Y, g:i a', strtotime($row->createdAt)); ?></span>
																<div class="clearfix"></div>
															</li>
															<li>
																<span class="heading">Orders :</span>
																<span class="detail"><?php echo $row->planOrders; ?>/<?php echo $row->planOrderPeriod; ?></span>
																<div class="clearfix"></div>
															</li>
															<?php $tchk = 0;
															if ($row->StripeSubscriptionEnded > 0) {
																$tchk = 1; ?>
																<li>
																	<span class="heading">Subscription End :</span>
																	<span class="detail"><?php echo date('F j, Y, g:i a', $row->StripeSubscriptionEnded); ?></span>
																	<div class="clearfix"></div>
																</li>
															<?php } ?>
															<?php if ($currnet < $row->period_end) {
																if ($tchk == 0) {
															?>
																	<a class="cart-button btn-pay block hvr-trim-two" href="javascript:;" onclick="cancel()">Cancel Subscription</a>
																<?php
																}
															} else {
																?>
																<p style="text-align: center;">Your current membership is expired kindly visit our member ship page to renew your memberships <a style="color: #fb821e;" href="<?php echo base_url(); ?>memberships">Memberships</a>.</p>
															<?php } ?>

														</ul>
													</div> <!-- /.results list -->
												<?php } else { ?>
													<p style="text-align: center;">Currently you are not subscribed with any of our packages. Please click here to get membership packages <a style="color: #fb821e;" href="<?php echo base_url(); ?>memberships">Memberships</a>.</p>
												<?php } ?>

											</div><!-- /.col- -->
											<div class="clearfix"></div>
										</div>
									</div>
									<!--product list-->



									<div class="clearfix"></div>
								</div> <!-- /.single-product -->

							</div> <!-- /.col- -->
						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>


			</div> <!-- /.row -->
		</div> <!-- /.shop-page -->

		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<script type="text/javascript">
			function cancel() {
				$.confirm({
					icon: 'fa fa-spinner fa-spin',
					title: 'Working!',
					content: function() {
						var self = this;
						return $.ajax({
							url: '<?php echo base_url(); ?>account/cancel_membership',
							dataType: 'json',
							method: 'get'
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
												location.reload();
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
		</script>
		<?php $this->load->view('includes/scripts'); ?>
	</div> <!-- /.main-page-wrapper -->
</body>

</html>