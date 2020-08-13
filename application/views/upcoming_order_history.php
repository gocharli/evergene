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
			<div class="col-lg-12 p-0 m-p-15">
				<div class="title-head">
					<h5 class="pull-left" style="padding: 15px 0;">Your Upcoming Orders</h5>
					<div class=" display-hub-dsk"><?php $this->load->view('includes/recommend_friend');   ?></div>
                    <div class=" display-hub-dsk"><?php $this->load->view('includes/upgarde_premium');   ?></div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15  display-hub-dsk">
				<?php $this->load->view('includes/sidebar'); ?>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 float-right p-0">
				<div class="shop-product-wrapper service-version-one">
					<div class="row">
						<div class="col-lg-12 col-xs-12">
							<?php if($orders){ foreach ($orders as $row) {	?>
								<div class="single-product">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>images/product/Cholesterol.png" alt=""/> <?=date('F',strtotime($row->scheduleDate))?> Orders</h6>
									<div class="clearfix"></div>
								</div><!--product header-->
								<?php
								$month=date('m',strtotime($row->scheduleDate));
								$year=date('Y',strtotime($row->scheduleDate));
								$detail=$this->db->query('select order_details.*,tests.testName,tests.testLogo,tests.testDescription FROM order_details
									LEFT JOIN tests ON order_details.testId=tests.testId
									WHERE order_details.order_cancel_status = 0 and userId='.$this->session_data->userId.' and scheduleDate >= CURDATE() and YEAR(scheduleDate) = '.$year.' and MONTH(scheduleDate)='.$month)->result();
								foreach ($detail as $d){

									$detailId = $d->detailId; //echo '<pre>'; print_r($row);
									$all_orders=$this->db->query('select @acount:=@acount+1 sub_id, order_details.detailId from (SELECT @acount:= 0) AS acount, order_details WHERE orderId='.$d->orderId)->result(); // all order items of the order
									$sub_id = 1;
									foreach($all_orders as $o){
										if($o->detailId == $detailId){
											$sub_id = $o->sub_id;
										}
									}


								?>
								<div class="product-list mb-2">
									<div class="row">
										<div class="col-md-12">
											<div class="btn-group-results">
<!--												<div class="btn-group" role="group" aria-label="...">-->
<!--													<a href="#!" class="btn btn-warning">-->
<!--														<i class="fa fa-edit"></i>-->
<!--													</a>-->
<!--													<a href="#!" class="btn btn-danger">-->
<!--														<i class="fa fa-trash"></i>-->
<!--													</a>-->
<!--												</div>-->
											</div>										
										</div>
									</div>
									<div class="row">

										<div class="col-md-3 col-sm-3 text-center">
											<div class="symbol-icon">
												<img class="img-responsive" src="<?=base_url('uploads/tests/logo/').$d->testLogo?>" alt=""/>
											</div>
											<div class="clearfix"></div>
											
										</div><!-- /.col- -->
										<div class="col-md-9 col-sm-9 ">
											<div class="results-info-list upcoming-order-history">
												<ul class="clearfix">
													<li>
														<div class="row">
															<div class="col-md-8 col-sm-8 col-xs-12 d-flex-mb" >
																<span class="heading">Name:</span>
																<span class="detail" style="width: 100%;"><?=$d->testName?></span>
																<div class="clearfix"></div>
															</div>

															<div class="col-md-4 col-sm-4 col-xs-12 d-flex-mb" >
																<span class="heading">Order ID:</span>
																<span class="detail" style="width: 100%;"><?=$d->orderId.'-'.$sub_id; ?></span>
																<div class="clearfix"></div>
															</div>

														</div>
													</li>
													<li>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 p-0">
														<span class="heading">Description:</span>
														<span class="detail" style="width: 100%; margin-top: 10px;margin-bottom:5px;"><?=short_text($d->testDescription,100)?></span>
														<div class="clearfix"></div>
                                                        </div>
													</li>
													<li>
														<div class="row">
															<div class="col-md-8 col-sm-8 col-xs-12 d-flex-mb" >
															<span class="heading" style="width: 100%">Scheduled Date:</span>
															<span class="detail" style="width: 100%; margin-top: 10px;"><?=date('d F Y',strtotime($d->scheduleDate))?></span>

															</div>
															<div class="col-md-4 col-sm-4  col-xs-12 d-flex-mb">
																<span class="heading">price:</span>
																<span class="detail" style="width: 100%; margin-top: 10px;">£<?=$d->detailPrice?></span>
															</div>
														</div>
													</li>
													<li>
														<div class="row">
															<div class="col-md-8 col-sm-8 col-xs-12 d-flex-mb" >
																<span class="heading" style="width: 100%">Type:</span>
																<span class="detail" style="width: 100%; margin-top: 10px;"><?=$d->paymentType?></span>

															</div>
															<div class="col-md-4 col-sm-4  col-xs-12 d-flex-mb">
																<span class="heading" style="width: 100%">payment:</span>
																<span class="detail" style="width: 100%; margin-top: 10px;"><?php if($d->paymentStatus=='Yes'){
																		echo 'Paid';
																	} else {
																		echo 'Not Paid';
																	}?></span>
															</div>
														</div>
													</li>

												</ul>
											</div> <!-- /.results list -->
										</div><!-- /.col- -->
										<div class="clearfix"></div>
									</div>
								</div><!--product list-->
								<div class="clearfix"></div>
								<?php } ?>
							</div>
							<?php }
							}else{ ?>
								<p style="margin-top: 10px" class="text-center">No upcoming orders</p>
						 <?php	} ?>
						
						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>

		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->
<input type="hidden" id="did" value="">
<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<?php $this->load->view('includes/scripts'); ?>
	<script type="text/javascript">
		function  change_month(e,id) {
			if(e.value!=="")
			{
				$.confirm({
					title: 'Change Date!',
					content: 'Are you sure you want to change date ?',
					type: 'blue',
					typeAnimated: true,
					buttons: {
						Yes: {
							text: 'Yes',
							btnClass: 'btn-blue',
							action: function(){
								$.confirm({
									icon: 'fa fa-spinner fa-spin',
									title: 'Working!',
									content: function () {
										var self = this;
										return $.ajax({
											url: "<?php echo base_url(); ?>orders/change_date",
											dataType: 'json',
											data:{id:id,date:e.value},
											method: 'post'
										}).done(function (response) {
											self.close();
											if(response.code===0)
											{
												error_box(response.message,5000);
											}
											else
											{
												location.reload();
											}
										}).fail(function(){
											self.close();
											error_box();
										});
									},
									buttons: {
										close: function () { }
									}
								});

							}
						},
						No: function () {
							$('.change_date option[value=""]').prop('selected', true);
						}
					}
				});
			}
		}
		function pay(amount,id) {
			if(amount>0)
			{
				$('#did').val(id);
				var total_g=amount;
				var title='Order Payment';
				var total=total_g*100;
				handler.open({
					name: title,
					description: 'Charges( £'+total_g+' )',
					currency : 'GBP',
					amount: total
				});
			}
		}

		var handler = StripeCheckout.configure
		({
			key: '<?=getenv('stripe_api_key')?>',
			image: '<?php echo base_url(); ?>assets/stripelogo.png',
			token: function(token)
			{
				var id=$('#did').val();
				$.confirm({
					icon: 'fa fa-spinner fa-spin',
					title: 'Working!',
					content: function () {
						var self = this;
						return $.ajax({
							url: '<?=base_url('orders/pay')?>',
							dataType: 'json',
							data:{'id':id,'token':token.id},
							method: 'post'
						}).done(function (response) {
							self.close();
							if(response.code==0)
							{
								error_box(response.message,10000);
							}
							else
							{
								location.reload();
							}
						}).fail(function(){
							self.close();
							error_box();
						});
					},
					buttons: {
						close: function () { }
					}
				});
			}
		});

		window.addEventListener('popstate', function() {
			handler.close();
		});
	</script>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
