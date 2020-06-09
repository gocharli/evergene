<?php $this->load->view('includes/head');   ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
<div class="main-page-wrapper">


	<?php $this->load->view('includes/menu');   ?>

	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="shop-page hub-page full-width">
		<div class="row">
			<div class="col-lg-12 p-0 m-p-15">
				<div class="title">
					<h5 class="pull-left" style="padding: 15px 0;">Hello <?=$this->session_data->userFirstName?> / Welcome back <?=$this->session_data->userFirstName?></h5>
					<?php $this->load->view('includes/recommend_friend');   ?>
					<?php $this->load->view('includes/upgarde_premium');   ?>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="clearfix"></div> <br />

			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 p-0 m-p-15">
				<?php $this->load->view('includes/sidebar'); ?>
			</div>

			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 float-right p-0">
				<div class="shop-product-wrapper service-version-one">

					<div class="row">
                        <?php $uu=$this->db->query('select * from users WHERE userId='.$this->session_data->userId)->row(); ?>
                        <?php if($uu->userEmailStatus=='Unverified'){ ?>
                        <div class="col-lg-12">
							<div class="alert alert-warning" role="alert">
						      	Confirmation email has been sent to your register email address please verify you email. <button onclick="resend_email()" style="width: inherit;" class="tran3s cart-button btn-pay hvr-trim-two">Resend email</button>
							</div>
						</div><!-- /.col- -->
                        <?php } ?>
                    
						<div class="col-lg-12">
							<div class="alert alert-success" role="alert">
								Welcome to the Evergene Hub where you can track your health and manage your test results…….
							</div>
						</div><!-- /.col- -->
						<div class="col-lg-12 col-xs-12">


							<div class="single-product">

								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>images/product/Cholesterol.png" alt=""/> You</h6>

									<a href="<?=base_url('questionaire')?>" class="tran3s custom-btn">Update</a>
									<p class="update-date">
										<?php if($row->updatedAt!='0000-00-00 00:00:00') { ?>
										Last Updated: <?=date('d,F Y',strtotime($row->updatedAt))?>
										<?php } ?>
									</p>
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="product-list">

									<div class="row">
										<div class="col-lg-3 text-center">

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Exercise</label>
												<div class="b_ans"><?php if($row->excericseAvgWeek>0){ echo number_format($row->excericseAvgWeek).'/Week';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Sleep</label>
												<div class="b_ans"><?php if($row->sleepPerNight>0){ echo number_format($row->sleepPerNight).' Hours';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Steps</label>
												<div class="b_ans"><?php if($row->stepAvgDay>0){ echo number_format($row->stepAvgDay).'/Day';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Water</label>
												<div class="b_ans"><?php if($row->waterAvgDay>0){ echo number_format($row->waterAvgDay).'/Day';}else{ echo '---';} ?></div>

											</div><!--body info-->

										</div><!-- /.col- -->

										<div class="col-lg-6 text-center">

											<div class="human-body">

												<div class="age">
													<div>
														Years Old
														<span>
														<?php
														$age=age($row->dob);
														  if($age>0){ ?>
															<?=$age?> yrs
														  <?php } ?>
														</span>
													</div>
												</div><!--age-->

												<div class="height">
													<div>
														Height
														<span>
															<?php if($row->height>0) {
																echo number_point_format($row->height,1) . ' cm';
															} ?>
														</span>
													</div>
												</div><!--height-->

												<div class="hip-waist">
													<div>
														Hip/Waist Ratio
														<span>
															<?php if($row->waistMeasurment>0 && $row->hipMeasurment>0) {
																$wh=$row->waistMeasurment/$row->hipMeasurment;
																echo number_point_format($wh,1) . '';
															} ?>
														</span>
													</div>
												</div><!--Hip/Waist Ratio-->

												<div class="QRISK">
													<div>
														QRISK
														<span>2.5 .</span>
													</div>
												</div><!--QRISK-->

												<div class="Weight">
													<div>
														Weight
														<span>
															<?php if($row->weight>0) {
																echo number_point_format($row->weight,1) . ' kg';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<div class="BMI">
													<div>
														BMI
														<span>
															<?php if($row->weight>0 && $row->height>0) {
																$bmi=(($row->weight/$row->height)/$row->height)*10000;
																echo number_point_format($bmi,1) . '';
															} ?>
														</span>
													</div>
												</div><!--Weight-->

												<div class="Heart-Age">
													<div>
														Heart Age
														<span>###</span>
													</div>
												</div><!--Heart Age-->

											</div><!-- /human body- -->

										</div><!-- /.col- -->

										<div class="col-lg-3 text-center">

									
											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Heart Rate</label>

												<div class="b_ans"><?php if($row->restHeartRate>0){ echo number_format($row->restHeartRate).' bpm';}else{ echo '---';} ?></div>

											</div><!--body info-->


											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Blood Pressure</label>

												<div class="b_ans"><?php if($row->bloodPressure>0){ echo number_format($row->bloodPressure).' mmHg';}else{ echo '---';} ?></div>

											</div><!--body info-->

											<div class="body-info">
												<i class="fa fa fa-hospital-o fa-2x"></i><br />
												<label>Cholesterol</label>
												<div class="b_ans"><?php if($row->cholesterol>0){ echo number_format($row->cholesterol).' ratio';}else{ echo '---';} ?></div>

											</div><!--body info-->


										</div><!-- /.col- -->


										<div class="clearfix"></div>
									</div>
								</div><!--product list-->


								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>/product/Cholesterol.png" alt=""/> Recommended Products</h6>
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="row">
									<?php foreach ($recommended_products as $res){ ?>
									<div class="col-md-6 col-sm-6 col-xs-12 mix finance marketing">
										<div class="single-service">
											<a href="<?=base_url('tests/'.$res->slug)?>" class="add-to-cart">
												<div class="img"></div>
											</a>
											<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$res->testLogo?>" style="width: 60px;height: 60px;"  alt=""/></i>
											<div class="row">
												<p class="col-md-12"><?=$res->testName?></p>
												<p class="col-md-6 price">
													<span class="member-price">Member Price</span>
													£<?=$res->originalPrice?></p>
												<p class="col-md-6 price">
													<span class="member-price">Premium Members Price</span>
													<?php
													$mprice=$res->originalPrice;
													if($res->discountPercentage=='Yes')
													{
														if($res->discountPrice>0)
														{
															$mprice=$res->originalPrice-($res->originalPrice*($res->discountPrice/100));
														}

													}else
													{
														$mprice=$res->originalPrice-$res->discountPrice;
													}?>


													£<?=$mprice?></p>
											</div>
											<div class="clearfix"></div>
											<p class="description"><?=short_text($res->testDescription,90)?></p>
											<a href="<?=base_url('tests/'.$res->slug)?>" class="custom-btn">Learn More</a>
										</div> <!-- /.single-service -->
									</div> <!-- /.col-md-4 -->
									<?php  } ?>
									<div class="clearfix"></div>
								</div><!-- /.row -->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>/product/Cholesterol.png" alt=""/> Track your progress</h6>
									<div class="shorting-option clearfix">

									</div> <!-- /.shorting-option -->
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="product-list text-center">

									<div class="boxstyle text-left margin-bottom text-center">
										<h6 class="chart_heading">Monthly Report</h6>
										<div id="graph"></div>
										<script>
											// Use Morris.Bar
											Morris.Line({
												element: 'graph',
												data:[
													<?php
													foreach($res_bmi as $month) {
														echo json_encode($month).',';
													}?>
												],
												xkey: 'y',
												ykeys: ['x','x1','x2','x3'],
												labels: ['BMI','Hip/Waist Ratio','QRisk','Heart Age'] ,
												xLabelFormat: function (x) {
													var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
													var month = IndexToMonth[ x.getMonth() ];
													var year = x.getFullYear();
													return year + ' ' + month;
												},
												dateFormat: function (x) {
													var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
													var month = IndexToMonth[ new Date(x).getMonth() ];
													var year = new Date(x).getFullYear();
													return year + ' ' + month;
												},
												resize: true

											});
										</script>
										<div class="clearfix"></div>
									</div>

									<div class="clearfix"></div>

								</div><!--product list-->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

							<div class="single-product our-blog">
								<div class="product-header">
									<h6><img src="<?=base_url('assets/front/')?>images/product/Cholesterol.png" alt=""/> Latest Blog</h6>
									<div class="clearfix"></div>
								</div><!--product header-->

								<div class="row">
									<?php foreach ($blogs as $blog){ ?>
									<div class="col-lg-3 col-md-4 col-xs-6">
										<div class="single-blog">
											<div class="image"><img style="height: 160px" src="<?=base_url('uploads/blog/'.$blog->blogImage)?>" alt=""></div>
											<div class="text">
												<h6>Evergene.</h6>
												<h5><a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><?=$blog->blogTitle?></a></h5>

												<a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><i class="flaticon-arrows" aria-hidden="true"></i></a>
											</div>
										</div> <!-- /.single-blog -->
									</div>
									<?php } ?>
								</div> <!-- /.row -->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->



						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>


		</div> <!-- /.row -->
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
						<img src="<?=base_url('assets/front/')?>images/home/6.jpg" alt="">
						<h5>SSL certificate</h5>
						<p>All of our tests are carried out to the highest standards in an NHS accredited laboratory</p>
					</div> <!-- /.single-blog -->
				</div> <!-- /.col- -->
				<div class="col-md-6 col-xs-12">
					<div class="single-blog color-two">
						<img src="<?=base_url('assets/front/')?>images/home/7.jpg" alt="">
						<h5>Data protection</h5>
						<p>Your data belongs to you and we take it very seriously to ensure you have complete control of it</p>
					</div> <!-- /.single-blog -->
				</div> <!-- /.col- -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</div> <!-- /.home-blog-section -->

	<?php $this->load->view('includes/footer'); ?>

	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
    <script type="text/javascript">
        function resend_email()
        {
            $.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: '<?=base_url('hub/resend_email')?>',
						dataType: 'json',
						data:{'type':1},
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
        }
    </script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
