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
						<h5 class="pull-left" style="padding: 15px 0;">My Transactions<br />
						</h5>
						<?php $this->load->view('includes/recommend_friend');   ?>
						<?php $this->load->view('includes/upgarde_premium');   ?>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div> <br />
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15">
					<div class="shop-sidebar">
						<?php $this->load->view('includes/sidebar'); ?>
					</div> <!-- /.shop-sidebar -->
				</div>
				<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">
						<div class="row">
							<div class="col-lg-12 col-xs-12">
								<div class="single-product">
									<div class="product-list orders">

										<div class="table-header">
											<div class="col-lg-3 col-sm-3">Date</div>
											<div class="col-lg-3 col-sm-3">Order</div>
											<div class="col-lg-3 col-sm-3">Transaction ID</div>
											<div class="col-lg-3 col-sm-3" style="text-align: center">Amount</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
										<?php if ($results) {
											$this->load->view('components/transactions', array('results' => $results));
										} else { ?>
											<p style="margin-top: 10px" class="text-center">No Transaction Found</p>
										<?php } ?>

										<?php if (count($results) >= $resultsPerPage) {  ?>
											<div class="col-md-12 text-center" style="margin-top: 10px">
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
		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<!-- Fancybox -->
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.mixitup.min.js"></script>

		<?php $this->load->view('includes/scripts'); ?>
		<script type="text/javascript">
			$(document).on('click', '.loadmore', function() {

				var ele = $(this);
				$.ajax({
					url: '<?= base_url() ?>transactions/loadmore',
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

	</div> <!-- /.main-page-wrapper -->
</body>

</html>