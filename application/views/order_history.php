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
				<div class="col-lg-12">
					<div class="title-head">
						<h5 class="pull-left" style="padding: 15px 0;">My Orders<br />
							<span style="font-size: 14px;">Check the status of orders, or browse through your past purchases.</span>
						</h5>
						<div class=" display-hub-dsk"><?php $this->load->view('includes/recommend_friend');   ?></div>
						<div class=" display-hub-dsk"><?php $this->load->view('includes/upgarde_premium');   ?></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15  display-hub-dsk">
					<div class="shop-sidebar">
						<?php $this->load->view('includes/sidebar'); ?>
					</div> <!-- /.shop-sidebar -->
				</div>
				<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">
						<div class="row">
							<div class="col-lg-12 col-xs-12">
								<div class="single-product">
									<div class="product-list orders">

										<div class="table-header">
											<div class="col-lg-3 col-sm-3 col-xs-3">Date</div>
											<div class="col-lg-3 col-sm-3 col-xs-3">Order</div>
											<div class="col-lg-3 col-sm-3 col-xs-3">Total</div>
											<div class="col-lg-3 col-sm-3 col-xs-3"><span id="odr_status" style="display: none">Status</span></div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>

										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
											<?php if ($orders) {
												$this->load->view('components/order_history', array('orders' => $orders));
											} else { ?>
												<p style="margin-top: 10px" class="text-center">No Order Found</p>
											<?php } ?>
										</div>
										<?php if ($orders && count($orders) >= $resultsPerPage) {  ?>
											<div class="text-center" style="margin-top: 10px">
												<a href="javascript:;" class="loadmore tran3s custom-btn" page="2">View More</a>
											</div>
										<?php } ?>
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

		<script>
			function odr_status() {
				//$("#odr_status").hide();
				$("#odr_status").toggle();
			}
		</script>

		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<!-- Fancybox -->
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.mixitup.min.js"></script>

		<?php $this->load->view('includes/scripts'); ?>
		<script type="text/javascript">
			$(document).on('click', '.loadmore', function() {

				var ele = $(this);
				$.ajax({
					url: '<?= base_url() ?>orders/loadmore',
					type: 'POST',
					dataType: 'json',
					data: {
						page: $(this).attr('page')
					},
					success: function(response) {
						if (response.code == 1) {
							if (response.page == 0) {
								$('.loadmore').hide();
							} else {
								ele.attr('page', response.page)
							}

							if (response.html != '') {
								$('#accordion').append(response.html).fadeIn('slow');
							}
						}
					}
				});
			});
		</script>
		<script type="text/javascript">
			function cancel_subscription(id) {
				$.confirm({
					icon: 'fa fa-spinner fa-spin',
					title: 'Working!',
					content: function() {
						var self = this;
						return $.ajax({
							url: '<?php echo base_url(); ?>orders/cancel_subscription',
							data: {
								id: id
							},
							dataType: 'json',
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
	</div> <!-- /.main-page-wrapper -->
</body>

</html>