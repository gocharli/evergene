<?php $this->load->view('includes/head');   ?>
<style type="text/css">
	.ckeditr p {
		margin: 0px !important;
	}

	.ckeditr ul,
	.ckeditr ol {
		list-style: inside !important;
		padding: 10px;
	}

	.item>img {
		display: inline-block !important;
	}
</style>
</head>

<body>
	<div class="main-page-wrapper">

		<?php $this->load->view('includes/menu');   ?>
		<div class="inner-page-banner">
			<div class="opacity header-product-detail">
			</div> <!-- /.opacity -->
		</div> <!-- /inner-page-banner -->
		<!--
    =============================================
        Shop Page
    ==============================================
    -->
		<?php
		$originalPrice = $row->originalPrice;
		$mprice = $row->originalPrice;
		if ($row->discountPercentage == 'Yes') {
			if ($row->discountPrice > 0) {
				$mprice = $row->originalPrice - ($row->originalPrice * ($row->discountPrice / 100));
			}
		} else {
			$mprice = $row->originalPrice - $row->discountPrice;
		}
		?>
		<div class="shop-page shop-details">
			<div class="container">
				<div class="procuct-details">
					<div class="row">
						<div class="col-md-6 col-xs-12">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<!-- Indicators -->
								<ol class="carousel-indicators">
									<?php $imoreImages = $this->db->query('select * from test_images WHERE testId=' . $row->testId)->result();
									if ($imoreImages) {
										$i = 0;
										foreach ($imoreImages as $image) { ?>
											<li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>" class="<?php if ($i == 0) { ?>active<?php } ?>"></li>
									<?php $i++;
										}
									} ?>
								</ol>
								<!-- Wrapper for slides -->
								<div class="carousel-inner" role="listbox">
									<?php if ($imoreImages) {
										$i = 0;
										foreach ($imoreImages as $image) { ?>
											<div class="item text-center <?php if ($i == 0) { ?>active<?php } ?>">
												<img class="" style="height:400px; " src="<?= base_url('uploads/tests/products/' . $image->imageName) ?>" alt="...">
											</div>
									<?php $i++;
										}
									} ?>
								</div>
								<!-- Controls -->
								<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
									<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
									<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
							</div>
							<br><br>
							<?php if ($this->membership_data->expire) { ?>
								<div class="field-radio upgrade-p-mb">
									<div class="box-radio-option">
										<label for="address-service">Upgrade your account - find out how it works <a href="<?= base_url('memberships') ?>"><span id="disc_reg_price"> £<?= number_format($mprice, 2) ?></span></a></span></label>
									</div>
								</div>
							<?php } else { ?>
								<div class="field-radio">
									<div class="box-radio-option">
										<label style="margin: auto;" for="address-service">Non Member Price <a href="javascript:;"> £<?= number_format($originalPrice, 2) ?></a></span></label>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="product-info">
								<form id="cart_frm" action="<?= base_url('cart/add') ?>" type="post">
									<div class="row">
										<div class="col-md-8 col-sm-8 col-xs-8 cart-heading-mb">
											<h3 style="line-height: inherit;margin: 0px; margin-top: 5px;"><?= $row->testName ?></h3>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4 text-right"><strong class="price">
												<?php if ($this->membership_data->expire) { ?>

													£<?php echo number_format($originalPrice, 2) ?>
												<?php } else { ?>

													£<?= number_format($mprice, 2) ?>
												<?php } ?>
											</strong></div>
										<div class="clearfix"></div>
									</div>

									<p><?= $row->testDescription ?></p>
									<h6><?= $row->categoryName ?></h6>

									<fieldset>
										<div class="field-radio">
											<input type="radio" class="purchaseType" name="purchaseType" value="Regular" id="purchase-subscribe">
											<div class="box-radio-option">
												<label for="purchase-subscribe"> Setup a regular Tests &nbsp; <a href="javascript:;" onclick="ToolTip()" title="Learn More">Learn More</a></label>
											</div>
										</div>
										<div class="field-radio">
											<input type="radio" class="purchaseType" name="purchaseType" value="One Time" id="purchase-onetime" checked>
											<div class="box-radio-option">
												<label for="purchase-onetime">One-time Purchase</label>
											</div>
										</div>
									</fieldset>

									<hr />
									<ul class="order-box pull-left">
										<li><button type="button" onclick="ChangeNumber()" id="value-decrease">-</button></li>
										<li><input type="text" name="Qty" min="1" max="10" value="1" class="val only_number" id="product-value"></li>
										<li><button type="button" id="value-increase">+ </button></li>
									</ul>
									<i style="margin-left: 4px;" onclick="ShowMessage()" class="fa fa-info-circle info-circle-mb"></i>

									<div class="dropdown pull-right" id="regular_type" style="display: none;">
										<select class="form-control regular_type" name="regularType">
											<option value="">Select Increment</option>
											<option value="Month">Monthly</option>
											<option value="Quarterly">quarterly</option>
											<option value="Semi Annually">Semi Annually </option>
										</select>
									</div>

									<div class="clearfix"></div>
									<input type="hidden" name="testId" value="<?= $row->testId ?>">
									<button type="submit" style="width: 100%;" class="tran3s cart-button btn-pay block hvr-trim-two next-step">ADD TO CART</button>
									<div class="clearfix"></div><br />
									<?php if (!$this->membership_data->expire) { ?>
										<div class="input-group" style="visibility: hidden">
											<select class="form-control" name="startMonth">
												<option value="">Select a Month</option>
												<option value="01">January</option>
												<option value="02">February</option>
												<option value="03">March</option>
												<option value="04">April</option>
												<option value="05">May</option>
												<option value="06">June</option>
												<option value="07">July</option>
												<option value="08">August</option>
												<option value="09">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
											</select>
										</div>
									<?php } ?>
								</form>
							</div> <!-- /.product-info -->
						</div> <!-- /.col- -->
					</div> <!-- /.row -->
				</div> <!-- /.procuct-details -->
				<?php
				$faqs = $this->db->query('select * from faq_relations
										LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId
										WHERE testId=' . $row->testId)->result();
				?>
				<div class="product-review-tab review-tab">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#menu11">Details</a></li>
						<?php if ($row->testMarkers != '') { ?>
							<li><a data-toggle="tab" href="#menu12">Markers</a></li>
						<?php }
						if ($row->testSymtoms != '') { ?>
							<li><a data-toggle="tab" href="#menu21">symptoms</a></li>
						<?php } ?>
						<?php if ($faqs) { ?>
							<li><a data-toggle="tab" href="#menu22">FAQs</a></li>
						<?php } ?>
					</ul>
					<div class="tab-content ckeditr">
						<div id="menu11" class="tab-pane fade in active" style="margin-top: 15px;">
							<?php if ($row->testDetails != '') {  ?>
								<p><?= $row->testDetails ?></p>
							<?php } else { ?>
								<p>No Details.</p>
							<?php } ?>
						</div>
						<div id="menu12" class="tab-pane fade" style="margin-top: 15px;">
							<p><?php
								if ($row->testMarkers != '') {
									$testMarkers = explode(',', $row->testMarkers);
									foreach ($testMarkers as $tm) { ?>
										<span class="label label-success" style="font-size: 16px;"><?= $tm ?></span>
								<?php }
								}
								?></p>
						</div>
						<div id="menu21" class="tab-pane fade" style="margin-top: 15px;">
							<p><?= $row->testSymtoms ?></p>
						</div>
						<div id="menu22" class="tab-pane fade">

							<div class="faq-content">
								<?php
								foreach ($faqs as $rfaq) {
								?>
									<div class="faq-question">
										<input id="q<?= $rfaq->faqId ?>" type="checkbox" class="panel">
										<div class="plus">+</div>
										<label for="q<?= $rfaq->faqId ?>" class="panel-title"><?= $rfaq->faqTitle ?></label>
										<div class="panel-content"><?= $rfaq->faqDescription ?></div>
									</div>
								<?php } ?>

							</div>

						</div>
					</div>
				</div> <!-- /.product-review-tab -->
				<?php if ($related) { ?>
					<div class="realated-product service-version-one shop-product-wrapper p-0">
						<h2>Related Products</h2>
						<div class="row">
							<div class="related-product-slider">

								<?php foreach ($related as $ritem) { ?>
									<div class="item">
										<div class="single-service">
											<a href="#" class="add-to-cart">
												<div class="img"></div>
											</a>
											<i class="tran3s"><img src="<?= base_url('uploads/tests/logo/') . $ritem->testLogo ?>" style="width: 60px; height: 60px;" alt="" /></i>
											<div class="row">
												<p class="col-md-12"><?= $ritem->testName ?></p>
												<p class="col-md-12 price">£<?= $ritem->originalPrice ?></p>
											</div>
											<div class="clearfix"></div>
											<p class="description"><?= short_text($ritem->testDescription, 80) ?></p>
											<a href="<?= base_url('tests/' . $ritem->slug) ?>" class="custom-btn">Learn More</a>
										</div> <!-- /.single-product -->
									</div> <!-- /.col- -->
								<?php } ?> </div> <!-- /.related-product-slider -->
						</div> <!-- /.row -->
					</div>
				<?php } ?>

				<!-- ==================== Team ====================== -->
				<div class="our-team-styleOne inner-page style-two">
					<div class="">
						<div class="row margin-tab-0">
							<div class="theme-title text-center">
								<h2>Meet Our Team</h2><br /><br />
							</div> <!-- /.theme-title -->
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="single-team-member">
									<div class="image">
										<img src="<?= base_url('assets/front/') ?>images/team/1.jpg" alt="">
										<div class="opacity tran3s">
											<ul class="tran3s">
												<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div> <!-- /.image -->
									<h6>Lynne Blears</h6>
									<p>CO-Founder</p>
								</div> <!-- /.single-team-member -->
							</div> <!-- /.col- -->
							<div class="col-md-4 col-sm-4  col-xs-6">
								<div class="single-team-member">
									<div class="image">
										<img src="<?= base_url('assets/front/') ?>images/team/2.jpg" alt="">
										<div class="opacity tran3s">
											<ul class="tran3s">
												<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div> <!-- /.image -->
									<h6>Sophie Gilbert</h6>
									<p>Solicitor</p>
								</div> <!-- /.single-team-member -->
							</div> <!-- /.col- -->
							<div class="col-md-4  col-sm-4  col-xs-6">
								<div class="single-team-member">
									<div class="image">
										<img src="<?= base_url('assets/front/') ?>images/team/3.jpg" alt="">
										<div class="opacity tran3s">
											<ul class="tran3s">
												<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
												<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</div> <!-- /.image -->
									<h6>Brendan Doherty</h6>
									<p>CEO</p>
								</div> <!-- /.single-team-member -->
							</div> <!-- /.col- -->
							<div class="text-center col-md-12 ">
								<a href="javascript:;" class="tran3s custom-btn">Find Out More</a>
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.our-team-styleOne -->
			</div> <!-- /.container -->
		</div> <!-- /.shop-page -->

		<!--
                =============================================
                    Home Blog Section
                ==============================================
                -->
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



		<div id="cartModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-body">
						<h6 class="text-center">Membership Schedule Calender (Plan)</h6>
						<ul style="list-style: inside;font-size: 13px;margin: 10px;">
							<li>If quantity > available order in same month you will pay full price of extra quantity.</li>
							<li>If user not pay membership fees of future order than order will be canceled.</li>
						</ul>
						<form class="frm_add_cart" action="<?= base_url('cart/add') ?>">
							<table class="table">
								<thead>
									<tr>
										<th class="text-center" style="width: 20%;">Quantity</th>
										<th class="text-center" style="width: 50%;">Schedule Month</th>
										<th class="text-center" style="width: 30%;">Available orders</th>
									</tr>
								</thead>
								<tbody id="cart_html">

								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">
											<input type="hidden" name="testId" value="<?= $row->testId ?>">
											<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two next-step pull-right">Save</button></td>
									</tr>
								</tfoot>
							</table>
						</form>
					</div> <!-- /.modal-body -->
				</div> <!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div> <!-- /.signUpModal -->
		<div id="cartModalRegular" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-body">
						<h6 class="text-center">Membership Schedule Calender (Plan)</h6>
						<ul style="list-style: inside;font-size: 13px;margin: 10px;">
							<li>If quantity > available order in same month you will pay full price of extra quantity.</li>
							<li>If user not pay membership fees of future order than order will be canceled.</li>
						</ul>
						<form class="frm_add_cart" action="<?= base_url('cart/add') ?>">
							<table class="table">
								<thead>
									<tr>
										<th class="text-center" style="width: 20%;">Quantity</th>
										<th class="text-center" style="width: 35%;">Schedule Month</th>
										<th class="text-center" style="width: 20%;">Membership Orders</th>
										<th class="text-center" style="width: 25%;">Available orders</th>
									</tr>
								</thead>
								<tbody id="cart_html_regular">

								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<input type="hidden" name="testId" value="<?= $row->testId ?>">
											<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two next-step pull-right">Save</button>
										</td>
									</tr>
								</tfoot>
							</table>
						</form>
					</div> <!-- /.modal-body -->
				</div> <!-- /.modal-content -->
			</div> <!-- /.modal-dialog -->
		</div> <!-- /.signUpModal -->
		<?php $this->load->view('includes/footer'); ?>
		<script type="text/javascript" src="<?= base_url('assets/front/') ?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




		<script>
			window.addEventListener("pageshow", function(event) {
				var historyTraversal = event.persisted ||
					(typeof window.performance != "undefined" &&
						window.performance.navigation.type === 2);
				if (historyTraversal) {
					// Handle page restore.
					window.location.reload();
				}
			});
		</script>

		<?php $this->load->view('includes/scripts'); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				if ($("#purchase-onetime").is(':checked')) {
					$("#product-value").val(1);
				}

			});

			function ShowMessage() {
				var radioValue = $('input[name=purchaseType]:checked').val();
				if (radioValue == "Regular") {
					<?php if ($this->membership_data->expire) { ?>
						swal("Choose the number of items you would like to receive and over what time scales. (Min 4 orders)");
					<?php } else { ?>
						swal("Choose the number of items you would like to receive and over what time scales. (Min 2 orders)");
					<?php } ?>
				} else {
					<?php if ($this->membership_data->expire) { ?>
						swal("Choose the number of items you would like to receive and over what time scales. (Min 4 orders)");
					<?php } else { ?>
						swal("Choose the number of items you would like to receive and over what time scales. (Min 2 orders)");
					<?php } ?>
				}


			}

			function ChangeNumber() {
				var radioValue = $('input[name=purchaseType]:checked').val();
				var inputValue = $("#product-value").val();
				if (radioValue == "Regular") {

					<?php if ($this->membership_data->expire) { ?>
						if (inputValue == 4) {
							console.log("aa");
							$.confirm({
								title: 'Product Limit Error!',
								content: 'Product in regular price can not be less than 4',
								type: 'red',
								typeAnimated: true,
								buttons: {
									tryAgain: {
										text: 'OK',
										btnClass: 'btn-red',
										action: function() {}
									}
								}
							});
						}

					<?php } else if (!$this->membership_data->expire) { ?>
						if (inputValue == 4) {
							console.log("bb");
							$.confirm({
								title: 'Product Limit Error!',
								content: 'Product in regular price can not be less than 4',
								type: 'red',
								typeAnimated: true,
								buttons: {
									tryAgain: {
										text: 'OK',
										btnClass: 'btn-red',
										action: function() {}
									}
								}
							});
						}



					<?php }  ?>

				} else {
					console.log("cc");
					var value = parseInt(inputValue) - 1;
					if (value < 1) {
						$.confirm({
							title: 'Product Limit Error!',
							content: 'Product in regular price can not be less than 1',
							type: 'red',
							typeAnimated: true,
							buttons: {
								tryAgain: {
									text: 'OK',
									btnClass: 'btn-red',
									action: function() {}
								}
							}
						});
					} else {
						$("#product-value").val(value);
					}

				}

			}



			function ToolTip() {
				$.confirm({
					title: 'What are regular Tests',
					content: 'Regular products are based on recurring payments including (Monthly, Quarterly, Semi Annually).',
					type: 'green',
					typeAnimated: true,
					buttons: {
						tryAgain: {
							text: 'OK',
							btnClass: 'btn-green',
							action: function() {}
						}
					}
				});
			}
			<?php if (!$this->membership_data->expire) { ?>
				$("#product-value").attr('min', 4);
				$("#product-value").val(4);
			<?php } ?>

			$('.purchaseType').change(function(e) {

				// Added by david
				var original_price = '£<?php echo number_format($originalPrice, 2); ?>';
				var mprice = '£<?php echo number_format($mprice, 2); ?>';
				var discounted_price = '£<?php echo number_format(($originalPrice - $mprice), 2); ?>';
				// Added by david						
				var radioValue = $('input[name=purchaseType]:checked').val();

				if (this.value === 'Regular') {
					$(".price").text(mprice); // added by david
					$("#disc_reg_price").text(discounted_price); // added by david

					$('#regular_type').show();
					$('.regular_type option[value=""]').prop('selected', true);

					<?php if ($this->membership_data->expire) {

					?>

						$("#product-value").attr('min', 4);
						$("#product-value").val(4);
					<?php } else { ?>

						$("#product-value").attr('min', 4);
						$("#product-value").val(4);
					<?php } ?>
				} else {

					<?php if (!$this->membership_data->expire) { ?>

						$("#product-value").attr('min', 1);
						$("#product-value").val(1);
					<?php } else { ?>
						$(".price").text(original_price); // added by david
						$("#disc_reg_price").text(mprice); // added by david
						$("#product-value").attr('min', 4);
						$("#product-value").val(4);
					<?php } ?>

					$('#regular_type').hide();
				}
			});

			$('.frm_add_cart').submit(function() {
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
							if (response.code === 0) {
								error_box(response.message, 5000);
							} else {
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
												top.location.href = "<?= base_url('cart') ?>";
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
				return false;
			});

			$('#cart_frm').submit(function() {
				var frm = $(this);
				var purchaseType = $('input[name=purchaseType]:checked').val();
				if (purchaseType === 'Regular') {
					var regular_type = $('select[name=regularType]').val();
					if (regular_type === '') {
						error_box('Increment Type is missing', 0);
						return false;
					}
				}

				$.confirm({
					icon: 'fa fa-spinner fa-spin',
					title: 'Working!',
					content: function() {
						var self = this;
						return $.ajax({
							url: '<?= base_url('cart/add') ?>',
							dataType: 'json',
							data: frm.serialize(),
							method: 'post'
						}).done(function(response) {
							self.close();
							if (response.code === 0) {
								error_box(response.message, 5000);
							} else {
								top.location.href = "<?= base_url('cart') ?>";
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


				return false;
			});

			$(document).ready(function() {
				$(".only_number").keydown(function(e) {
					// Allow: backspace, delete, tab, escape, enter and .
					if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
						// Allow: Ctrl/cmd+A
						(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+C
						(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: Ctrl/cmd+X
						(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
						// Allow: home, end, left, right
						(e.keyCode >= 35 && e.keyCode <= 39)) {
						// let it happen, don't do anything
						return;
					}
					// Ensure that it is a number and stop the keypress
					if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
					}
				});
			});
		</script>

	</div> <!-- /.main-page-wrapper -->
</body>

</html>