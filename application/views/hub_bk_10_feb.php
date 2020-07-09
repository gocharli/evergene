<?php $this->load->view('includes/head');   ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
<div class="main-page-wrapper">


	<?php $this->load->view('includes/menu'); ?>

	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="shop-page hub-page full-width">
		<div class="row">
			<div class="col-lg-12 p-0 m-p-15">
				<div class="title">
					<h5 class="pull-left" style="padding: 15px 0;">Hello <?=$this->session_data->userFirstName?> / Welcome <?=$this->session_data->userFirstName?></h5>
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
						<?php $uu=$this->db->query('select * from users WHERE userId='.$this->session_data->userId)->row(); 
						//echo '<pre>'; print_r($uu); 
						?>
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
										<?php if($row){ if($row->updatedAt!='0000-00-00 00:00:00') { ?>
										Last Updated: <?=date('d,F Y',strtotime($row->updatedAt))?>
										<?php } } ?>
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

											<div class="human-body <?php if($row->gender == 'Male') echo 'human-body-male'; else echo 'human-body-female'; ?> ">

												<div class="age">
													<div>
														<span style="cursor: pointer" title="The age of a person"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
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
													<span style="cursor: pointer" title="The height of the average North American male is 175.5 centimeters, a little over 5 foot 9 inches. The average US female is 162.5 cm, or 5 feet 4 inches."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
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
													<span style="cursor: pointer" title="The waist-hip ratio or waist-to-hip ratio (WHR) is the dimensionless ratio of the circumference of the waist to that of the hips. According to the World Health Organization, a waist-to-hip ratio greater than 1.0 is indicative of a higher than normal risk of developing heart disease. A healthy WHR for women is under . 85 and a healthy WHR for men is . 90 or less."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
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
													<span style="cursor: pointer" title="QRISK is an algorithm for predicting cardiovascular risk. It estimates the risk of a person developing cardiovascular disease (CVD) over the next 10 years and can be applied to those aged between 35 and 74 years. Those with a score of 20 per cent or more are considered to be at high risk of developing CVD."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
														QRISK
														<span>2.5 .</span>
													</div>
												</div><!--QRISK-->

												<div class="Weight">
													<div>
													<span style="cursor: pointer" title="The average weight of an adult human is 137 pounds (62 kg) according to a league table of the world's 'fattest' nations from the London School of Hygiene & Tropical Medicine."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
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
													<span style="cursor: pointer" title="If your BMI (Body mass index) is 18.5 to <25, it falls within the normal. If your BMI is 25.0 to <30, it falls within the overweight range. If your BMI is 30.0 or higher, it falls within the obese range."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>
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
													<span style="cursor: pointer" title="Heart age is a way to understand your risk of a heart attack or stroke. Your heart age is calculated based on your risk factors for heart disease, such as age and family history, as well as diet, physical activity and smoking. A younger heart age means a lower risk of heart disease.">i</a></span>
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

<div>

<?php $pname = $row->f_name;  if(empty($row->f_name)) $pname = 'enc'; ?>
<!--<a target="_blank" href="https://www.facebook.com/share.php?title=Profile&u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>" class="btn btn-pay pull-right" style="color: #fff; background-color: #3b5998;; border-color: #3b5998;; width: 15%"><i class="fa fa-facebook" aria-hidden="true"> Share </i></a>-->



<ul class="list-inline pull-right" style="font-size: x-large; padding-top: 20px;">
		<li class="list-inline-item">														
			<a target="_blank" href="https://www.facebook.com/share.php?title=Nelson Asikoyo&amp;u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<i class="fa fa-facebook" aria-hidden="true"></i>
			</a>

			<script>

				function fbs_click() {
					u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');

					return false;
				}

				</script>
		</li>                           

		<li class="list-inline-item">
			<a target="_blank" href="https://twitter.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">								
				<i class="fa fa-twitter" aria-hidden="true"></i>							
			</a>																					
		</li>	
		
		<li class="list-inline-item">
			<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">								
				<i class="fa fa-linkedin" aria-hidden="true"></i>							
			</a>																					
		</li>	

		<li class="list-inline-item">								
			<a target="_blank" href="https://api.whatsapp.com/send?phone=+123456789&amp;text=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<i class="fa fa-whatsapp" aria-hidden="true"></i>								
			</a>																												
		</li>																										

		<li class="list-inline-item">															
			<a href="mailto:?subject=BMI&amp;body=Hi here is my BMI details. | <?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>" title="Share by Email">
				<i class="fa fa-envelope" aria-hidden="true"></i>								
			</a>														
		</li>
</ul>

<!--<table class="pull-right">
	<thead>
		<tr>
			<th style="padding: 5px;">
			<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
				<img src="https://tekeye.uk/md/images/face-but.png" alt="Facebook Button" title="Facebook Button">
			</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://twitter.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/tweet-but.png" alt="Twitter Button" title="Twitter Button">
				</a>
			</th>

			<th>reddit</th>
			<th>
				<a target="_blank" href="https://www.reddit.com/submit?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/reddit-but.png" alt="reddit Button" title="reddit Button">
				</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/linkin-but.png" alt="LinkedIn Button" title="LinkedIn Button">
				</a>
			</th>

			<th style="padding: 5px;">
				<a target="_blank" href="https://plus.google.com/share?url=<?php echo base_url(); ?>profile/view/<?php echo $pname.'_'.strtotime($this->session->userdata('users')->createdAt); ?>">
					<img src="https://tekeye.uk/md/images/gplus-but.png" alt="Google+ Button" title="Google+ Button">
				</a>
			</th>
		</tr>
	</thead>
</table> -->



</div>
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
										<h6 class="chart_heading">Monthly Report  </h6>
										
										<!-- <select id="m_report" class="form-control" style="width: 20%" onchange="get_report(this.value)">
											<option value="bmi">BMI</option>
											<option value="hip">Hip/Waist Ratio</option>
											<option value="qrisk">QRISK</option>
											<option value="heart_age">Heart Age</option>
										</select> -->
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




											function get_report(type){

												

											}

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
