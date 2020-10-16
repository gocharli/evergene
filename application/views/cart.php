<?php $this->load->view('includes/head');   ?>
<style type="text/css">
	.custom-select {
		position: relative;
		display: inline-block;
		height: 3.35rem;
		border: 0.1rem solid #86c44c;
		border-radius: 4px;
	}

	.custom-select:hover,
	.custom-select:focus {
		background-color: transparent;
	}

	.custom-select:after {
		position: absolute;
		top: 50%;
		right: 5px;
		content: " ";
		display: block;
		height: 0;
		width: 0;
		margin-top: -0.3rem;
		border-top: 0.6rem solid #86c44c;
		border-left: 0.6rem solid transparent;
		border-right: 0.6rem solid transparent;
		pointer-events: none;
	}

	.is-ie8 .custom-select:after,
	.is-ie9 .custom-select:after {
		display: none;
	}

	.custom-select select {
		padding: 0 18px 0 5px;
		width: 100%;
		height: 100%;
		color: #86c44c;
		border: none;
		border-radius: 0;
		box-shadow: none;
		background-color: transparent;
		background-image: none;
		outline: none;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		font-size: 14px;
	}

	.custom-select select:focus {
		outline: none;
	}

	@media screen and (-ms-high-contrast: active),
	(-ms-high-contrast: none) {
		.custom-select select::-ms-expand {
			display: none;
		}

		.custom-select select:focus::-ms-value {
			background: transparent;
			color: #0088ce;
		}
	}

	.custom-select select:-moz-focusring {
		color: transparent;
		text-shadow: 0 0 0 #000;
	}
</style>
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
		<div class="shop-page hub-page">
			<div class="row">
				<div class="container">

					<div class="title-head col-md-12 p-0 m-p-15">
						<h5 class="pull-left" style="padding: 15px 0;">Cart</h5>

						<?php if (count($cart_data_new) > 0) { ?>
							<a href="javascript:;" onclick="go_checkout()" class="tran3s custom-btn small-btn pull-right">Check Out</a>
						<?php } ?>
						<a href="<?= base_url('tests') ?>" class="tran3s custom-btn small-btn pull-right">Continue</a>
						<?php $this->load->view('includes/upgarde_premium');   ?>
						<div class="clearfix"></div>
					</div>

					<div class="clearfix"></div> <br />
					<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
						<div class="shop-product-wrapper service-version-one">

							<div class="row">

								<div class="col-lg-12 col-xs-12">

									<div class="single-product shop-sidebar  cart-shop">
										<div class="product-header">
											<h6 style="margin:0px;">Order Summary</h6>
											<div class="clearfix"></div>
										</div>
										<!--product header-->

										<div class="single-service cart-mb">

											<div class="shopping-cart shopping-cart-mb">
												<!-- Product #1 -->
												<div class="item">
													<div class="image" style="width: 10%;font-size: 15px;font-weight: bold;">Image</div>
													<div class="description" style="width: 20%;font-size: 15px;font-weight: bold;">Title</div>
													<div class="total-price" style="width: 3%;font-size: 15px;font-weight: bold;">Qty</div>
													<div class="total-price" style="width: 10%;font-size: 15px;font-weight: bold;">Price</div>
													<div class="total-price" style="width: 10%;font-size: 15px;font-weight: bold;">Payment Type</div>
													<div class="total-price" style="width: 14%;font-size: 15px;font-weight: bold;">Scheduled</div>
													<div class="total-price" style="width: 23%;font-size: 15px;font-weight: bold;">Action</div>
												</div>
												<?php
												$saving = 0;

												if ($cart_data_new) {


													$grand = 0;
													foreach ($cart_data_new as $key => $item) {
														//echo '<pre>'; print_r($item); exit;
														$sub_total = 0;
														if ($item['payDebit'] == 'No') {

															$grand = $grand + ($item['qty'] * $item['price']);
															$sub_total = $item['qty'] * $item['price'];
														} else {
															$grand = $grand + $item['price'];
															$sub_total = $item['price'];
														}

												?>
														<div class="item" id="row_<?= $key ?>">
															<div class="image" style="width: 10%;">
																<img style="width: 80px;height: 60px;" src="<?= base_url('uploads/tests/logo/') . $item['options']['image'] ?>" alt="" />
															</div>

															<div class="description" style="width: 20%;">
																<span><?php echo $item['name']; ?></span>
																<span><?php echo $item['options']['productType']; ?></span>
															</div>
															<div class="total-price" style="width: 3%;"><?php echo $item['qty'];  ?></div>


															<div class="total-price" style="width: 10%;">£<?php echo number_format($sub_total, 2); ?></div>

															<div class="total-price" style="width: 10%;"><?php echo $item['options']['paymentType'];  ?></div>

															<div class="total-price" style="width: 14%;">

																<?php if ($item['options']['pType'] == 'One Time') {
																	echo date('d M Y', strtotime($item['options']['scheduleDate']));
																} else {
																	foreach ($item['scheduleDate'] as $sd) { ?>

																		<?php echo date('d M Y', strtotime($sd)); ?> <br />

																<?php }
																} ?>
															</div>
															<div class="total-price" style="width: 23%;">
																<option style="display: none;" value="No">Pay All</option>

																<a href="javascript:;" class="tran3s custom-btn small-btn hvr-trim-two" onclick="del('<?= $key ?>')"><span class="fa fa-trash-o"></span> </a>
															</div>
														</div>
													<?php
														if ($item['options']['paymentStatus'] == 'Yes') {
															$stest = $this->db->query('select tests.* from tests WHERE testId=' . $item['id'])->row();
															if ($stest) {
																$soriginalPrice = $stest->originalPrice;
																$sprice = 0;
																if ($stest->discountPercentage == 'Yes') {
																	if ($stest->discountPrice > 0) {
																		$sprice = $soriginalPrice - ($soriginalPrice * ($stest->discountPrice / 100));
																	}
																} else {
																	$sprice = $soriginalPrice - $stest->discountPrice;
																}
																if ($item['payDebit'] == 'Yes') {
																	$saving += 1 * ($soriginalPrice - $sprice);
																} else {
																	//$saving+= $item['qty']*($soriginalPrice-$sprice);  // edit by david
																	if ($item['options']['regularType'] == '') {
																		$saving += $item['qty'] * ($soriginalPrice - $sprice);
																	}
																}
															}
														}
													}
												} else { ?>
													<div class="alert alert-warning text-center" role="alert">
														<b>Cart </b> is empty</div>
											</div>
										<?php	} ?>

										</div>
										<div class="clearfix"></div>
									</div> <!-- /.single-product -->

									<?php
									if ($cart_data) { ?>
										<div class="alert alert-warning" role="alert">
											<b>Total </b> £ <span id="grand"><?= number_format($grand, 2) ?></span>

										<?php } ?>
										</div>
										<div class="col-md-12">
											<?php if (count($cart_data) > 0) { ?>
												<a href="javascript:;" onclick="go_checkout()" class="tran3s custom-btn small-btn hvr-trim-two pull-right">Check Out</a>
											<?php } ?>
											<a href="<?= base_url('tests') ?>" class="tran3s custom-btn small-btn hvr-trim-two pull-right">Continue</a>
										</div>
								</div>


							</div> <!-- /.col- -->

						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script type="text/javascript">
		function go_checkout() {
			<?php if ($this->membership_data->expire && $p_type == 1) { ?> // p_type 1 means there is atleast one One Time order to show popup
				$.confirm({
					icon: 'fa fa-tags',
					type: 'green',
					animationSpeed: 1000,
					title: 'Potential savings £<?= number_format($saving, 2) ?>',
					theme: 'modern',
					content: 'Do you want to become a member?',
					buttons: {
						Yes: {
							text: 'Yes',
							btnClass: 'btn-green',
							action: function() {
								top.location.href = '<?= base_url("memberships?redirect=cart") ?>';
							}
						},
						No: {
							text: 'No',
							action: function() {
								top.location.href = '<?= base_url('checkout') ?>';
							}
						}
						<?php if (!isset($this->session_data->userId)) { ?>,
							Login: {
								text: 'Already a member? Please Login',
								action: function() {
									$("#loginModal").modal("show");
								}
							}

						<?php } ?>
					}

				});
			<?php } else { ?>
				top.location.href = '<?= base_url('checkout') ?>';
			<?php } ?>
		}

		function status(rid, ithis) {
			var did = $(ithis);
			var type = did.val();
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: "<?= base_url() ?>cart/change_status",
						dataType: 'json',
						data: {
							id: rid,
							type: type
						},
						method: 'post'
					}).done(function(response) {
						self.close();

						if (response.code == 0) {
							if (type == 'Yes') {
								did.val("No");
							} else {
								did.val("Yes");
							}
							error_box(response.message, 10000);
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
						error_box();

					});
				},
				buttons: {
					close: function() {}
				}
			});

		}

		function del(rid) {
			$.confirm({
				title: 'Status!',
				content: 'Are you want to delete ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Yes: {
						text: 'Yes',
						btnClass: 'btn-red',
						action: function() {

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function() {
									var self = this;
									return $.ajax({
										url: "<?php echo base_url(); ?>cart/delete_item",
										dataType: 'json',
										data: {
											id: rid
										},
										method: 'post'
									}).done(function(response) {
										self.close();

										if (response.code == 0) {
											error_box(response.message, 5000);

										} else {
											location.reload();

										}

									}).fail(function() {
										self.close();
										error_box();

									});
								},
								buttons: {
									close: function() {}
								}
							});

						}
					},
					No: function() {}
				}
			});

		}
	</script>
	<?php $this->load->view('includes/scripts'); ?>

	</div> <!-- /.main-page-wrapper -->
</body>

</html>