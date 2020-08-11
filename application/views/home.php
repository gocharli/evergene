<?php $this->load->view('includes/head');   ?>
<style type="text/css">

.theme-menu-wrapper.fixed .label-success{
    background:#fff;
    color: #86c44c;
}
header.theme-menu-wrapper.menu-style-two #mega-menu-wrapper .nav .login-button a:hover {
    background: #5cb85c;
    border-color: #FFF;
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
        Theme Main Banner
    ==============================================
    -->
	<div id="theme-main-banner" class="banner-two">
		<div data-src="<?=base_url('assets/front/')?>images/home/slide-2.jpg">
			<div class="camera_caption">
				<div class="container text-center">
                    <h1>Convenient at home health testing <br> with expert medical advice.</h1>
					<h5>Start your health journey today with our convenient,  <br>  confidential and accurate
					home health testing for women and men,  <br> with online results in a matter of days.</h5>
					
				
					<a href="<?php echo base_url(); ?>tests" class="tran3s hvr-trim p-bg-color button-one" >View Our Tests</a>
					<!--	<div class="play-option wow fadeInRight animated" data-wow-delay="0.255s">
                            <div class="watch-video">
                                <h6>Watch</h6>
                                <h4>Intro Video</h4>
                                <a data-fancybox href="https://www.youtube.com/embed/r-AuLm7S3XE?rel=0&amp;showinfo=0" class="tran3s"><i class="fa fa-play" aria-hidden="true"></i></a>
                            </div>
                        </div> -->
				</div> <!-- /.container -->
			</div> <!-- /.camera_caption -->
		</div>
		<!--<div data-src="<?=base_url('assets/front/')?>images/home/slide-2.jpg">
			<div class="camera_caption">
				<div class="container">
                    <h1 class="wow fadeInUp animated" data-wow-delay="0.2s">Track your health<br> where you want and when you want.</h1>
					<h5 class="wow fadeInUp animated">Start your health journey today with our convenient, <br>  confidential and accurate 
					home health testing for women and men,  <br>  with online results in a matter of days.</h5>
					
					<a href="<?php echo base_url(); ?>how_it_works" class="tran3s hvr-trim wow fadeInUp animated p-bg-color button-one" data-wow-delay="0.3s">How it works </a>
					<!--	<div class="play-option wow fadeInRight animated" data-wow-delay="0.255s">
                            <div class="watch-video">
                                <h6>Watch</h6>
                                <h4>Intro Video</h4>
                                <a data-fancybox href="https://www.youtube.com/embed/r-AuLm7S3XE?rel=0&amp;showinfo=0" class="tran3s"><i class="fa fa-play" aria-hidden="true"></i></a>
                            </div>
                        </div> -->
				<!--</div> <!-- /.container -->
			<!--</div> <!-- /.camera_caption -->
		<!--</div>-->
		<div data-src="<?=base_url('assets/front/')?>images/home/slide-2.jpg">
			<div class="camera_caption">
				<div class="container text-center">
                    <h1> Become a premium member and Save <br> on your regular testing</h1>
					<h5>Start your health journey today with our convenient, <br> confidential and accurate 
					home health testing for women and men,  <br> with online results in a matter of days.</h5>
					
					<a href="<?php echo base_url(); ?>memberships" class="tran3s hvr-trim  p-bg-color button-one" >Find out more</a>
					<!--	<div class="play-option wow fadeInRight animated" data-wow-delay="0.255s">
                            <div class="watch-video">
                                <h6>Watch</h6>
                                <h4>Intro Video</h4>
                                <a data-fancybox href="https://www.youtube.com/embed/r-AuLm7S3XE?rel=0&amp;showinfo=0" class="tran3s"><i class="fa fa-play" aria-hidden="true"></i></a>
                            </div>
                        </div> -->
				</div> <!-- /.container -->
			</div> <!-- /.camera_caption -->
		</div>
	</div> <!-- /#theme-main-banner -->



	<!--
    =============================================
        What We Do
    ==============================================
    -->
	<div class="what-we-do">
		<div class="container">
			<h3>How it Works</h3>
			<h6>we work with business &amp; provide solution to client with their business problem</h6>

			<div class="row">
				<div class="col-md-4 col-xs-12 wow fadeInLeft">
					<div class="single-block">
						<div class="icon color-one"><i class="fa fa-laptop"></i></div>
						<h6>Order your test online</h6>
						<h5><a href="#" class="tran3s">We will then send your kit and it will arrive next working day through your letterbox.</a></h5>
					</div> <!-- /.single-block -->
				</div> <!-- /.col- -->
				<div class="col-md-4 col-xs-12 wow fadeInUp">
					<div class="single-block">
						<div class="icon color-two middle-block"><i class="fa fa-envelope-o"></i></div>
						<h6>Postbox</h6>
						<h5><a href="#" class="tran3s">Everything you need will be in your kit. When you're done, use the free-post envelope</a></h5>
					</div> <!-- /.single-block -->
				</div> <!-- /.col- -->
				<div class="col-md-4 col-xs-12 wow fadeInRight">
					<div class="single-block">
						<div class="icon color-three"><i class="fa fa-flask"></i></div>
						<h6>Laboratories</h6>
						<h5><a href="#" class="tran3s">Your sample is tested in one of our NHS accredited laboratories.</a></h5>
					</div> <!-- /.single-block -->
				</div> <!-- /.col- -->


			</div> <!-- /.row -->
			<a href="<?php echo base_url(); ?>tests" class="tran3s custom-btn">See our tests</a>

			<div class="clearfix"></div>
		</div> <!-- /.container -->
	</div> <!-- /.what-we-do -->
	
	<div class="service-version-one pb-0" id="mixitUp-item">
		<div class="container">
		    <div class="theme-title">
				<h2>Most<br> Popular Tests</h2>
			</div>

<div class="row">

			<?php foreach ($results as $row) { ?>
				<div class="col-md-4 col-sm-4 col-xs-12 mix all <?=$row->catSlug?>" data-bound="" style="display: inline-block;">
					<div class="single-service">
						<a href="<?=base_url('tests/'.$row->slug)?>" class="add-to-cart">
							<div class="img"></div>
						</a>
						<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
						<div class="row">
							<p class="col-md-12"><?=short_text($row->testName,37)?></p>

							<?php if($this->membership_data->expire) { ?>
							 <p class="col-md-6 col-xs-6 price"  style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c !important;">Member Price</span>
								£<?=number_format($row->originalPrice,2)?></p>
							<p class="col-md-6 col-xs-6 price" style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Premium Members Price</span>
								<?php
								$mprice=$row->originalPrice;
								if($row->discountPercentage=='Yes')
								{
									if($row->discountPrice>0)
									{
										$mprice=$row->originalPrice-($row->originalPrice*($row->discountPrice/100));
									}

								}else
								{
									$mprice=$row->originalPrice-$row->discountPrice;
								}?>


								£<?=number_format($mprice,2)?></p>
                           
							<?php }else{ ?>
                            <p class="col-md-6 col-xs-6  price" style="color: rgba(9,9,19,0.4) !important;">
									<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Member Price</span>
									£<?=number_format($row->originalPrice,2)?></p>
								<p class="col-md-6  col-xs-6 price" style="color: #86c44c !important;">
									<span class="member-price" style="color: #86c44c !important;">Premium Members Price</span>
									<?php
									$mprice=$row->originalPrice;
									if($row->discountPercentage=='Yes')
									{
										if($row->discountPrice>0)
										{
											$mprice=$row->originalPrice-($row->originalPrice*($row->discountPrice/100));
										}

									}else
									{
										$mprice=$row->originalPrice-$row->discountPrice;
									}?>


									£<?=number_format($mprice,2)?></p>
								
							<?php } ?>


						</div>
						<div class="clearfix"></div>
						<p class="description"><?=short_text($row->testDescription,80)?></p>
						<a href="<?=base_url('tests/'.$row->slug)?>" class="custom-btn">Learn More</a>
					</div> <!-- /.single-service -->
				</div> <!-- /.col-md-4 -->
				 <?php } ?>
				 
								</div>
								</div>
								</div>


	        <!--<div class="col-md-4 col-sm-4 col-xs-12 mix all general-wellness" data-bound="" style="display: inline-block;">
					<div class="single-service">
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="add-to-cart">
							<div class="img"></div>
						</a>
						<i class="tran3s"><img src="http://codeigniterexpert.com/evergene/uploads/tests/logo/abf5f1f6068c43c96d235451d0388145.jpg" style="width: 60px;height: 60px;" alt=""></i>
						<div class="row">
							<p class="col-md-12">Blood Test</p>

														<p class="col-md-6 price" style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c !important;">Member Price</span>
								£100.00</p>
							<p class="col-md-6 price" style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Premium Members Price</span>
								

								£80.00</p>
							

						</div>
						<div class="clearfix"></div>
						<p class="description">Aspernatur eveniet veritatis maxime. Dolor nisi repudiandae eius ea. Quis conseq...</p>
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="custom-btn">Learn More</a>
					</div> <!-- /.single-service ->
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 mix all general-wellness" data-bound="" style="display: inline-block;">
					<div class="single-service">
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="add-to-cart">
							<div class="img"></div>
						</a>
						<i class="tran3s"><img src="http://codeigniterexpert.com/evergene/uploads/tests/logo/abf5f1f6068c43c96d235451d0388145.jpg" style="width: 60px;height: 60px;" alt=""></i>
						<div class="row">
							<p class="col-md-12">Blood Test</p>

														<p class="col-md-6 price" style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c !important;">Member Price</span>
								£100.00</p>
							<p class="col-md-6 price" style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Premium Members Price</span>
								

								£80.00</p>
							

						</div>
						<div class="clearfix"></div>
						<p class="description">Aspernatur eveniet veritatis maxime. Dolor nisi repudiandae eius ea. Quis conseq...</p>
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="custom-btn">Learn More</a>
					</div> <!-- /.single-service ->
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 mix all general-wellness" data-bound="" style="display: inline-block;">
					<div class="single-service">
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="add-to-cart">
							<div class="img"></div>
						</a>
						<i class="tran3s"><img src="http://codeigniterexpert.com/evergene/uploads/tests/logo/abf5f1f6068c43c96d235451d0388145.jpg" style="width: 60px;height: 60px;" alt=""></i>
						<div class="row">
							<p class="col-md-12">Blood Test</p>

														<p class="col-md-6 price" style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c !important;">Member Price</span>
								£100.00</p>
							<p class="col-md-6 price" style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Premium Members Price</span>
								

								£80.00</p>
							

						</div>
						<div class="clearfix"></div>
						<p class="description">Aspernatur eveniet veritatis maxime. Dolor nisi repudiandae eius ea. Quis conseq...</p>
						<a href="http://codeigniterexpert.com/evergene/tests/blood-test" class="custom-btn">Learn More</a>
					</div> <!-- /.single-service ->
				</div>
			  </div>
			</div>-->
	<!--
    =============================================
        Theme Counter
    ==============================================
    -->
	<div class="theme-counter-styleTwo" id="statistics-icon">
		<div class="container">
            <div class="text-center h-i-text">
		    	<h3>The Numbers</h3>
			    <h6 class="num-para">Assisting people to understand their health and take action to avoid illness.</h6>
            </div>
			<ul class="clearfix">
				<li class="float-left">
				    <i class="fa fa-flask mb-15" aria-hidden="true"></i>
					<h2 class="number  mb-15"><span class="timer counting"  data-count="<?php echo $tests_performed; ?>">0</span></h2>
				    <p>Tests Performed</p>
				</li>
				<li class="float-left">
					<i class="fa fa-cog  mb-15" aria-hidden="true"></i>
					<h2 class="number  mb-15"><span class="timer counting"  data-count="<?php echo $infections_detected; ?>" >0</span></h2>
				   <p>Infections Detected</p>
				</li>
				<li class="float-left">
					<i class="fa fa-file-text-o  mb-15" aria-hidden="true"></i>
					<h2 class="number  mb-15"><span class="timer counting"  data-count="<?php echo $abnormal_results_detected; ?>" data-refresh-interval="5">0</span></h2>
					<p>Abnormal Results Detected</p>
				</li>
			</ul>
		</div> <!-- /.container -->
	</div> <!-- /.theme-counter -->


	<!--
    =============================================
        More About Us
    ==============================================
    -->
	<div class="more-about-us" id="home-more-about-us">
	<!--	<div class="image-box">
			<!--<svg  version="1.1" class="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="854" height="632">
				<clipPath class="clip1">
					<use xlink:href="#shape-one" />
				</clipPath>
				<g clip-path="url(#shape-one)">
				    
				    <video width="320" height="240" controls>
                       <source  src="<?php echo base_url(); ?>assets/videoplayback.mp4" type="video/mp4">
                    </video>
					<!--<image width="854" height="632" href="<?=base_url('assets/front/')?>images/home/2.jpg" class="image-shape">
					</image>-->
				<!--</g>-->
			<!--</svg>-->
			
		<!--</div>-->
		
		<!---->
		
		<div class="container p-0-mb">
			<div class="row">
			    <div class="col-md-5 p-0-mb">
        		    <video class="h-i-w-video" width="100%" height="20%" controls >
                            <source src="<?php echo base_url(); ?>assets/videoplayback.mp4" type="video/mp4" >
                    </video>
                    <div class="video-wrap">
                     <div class="play-btn"><a href="<?php echo base_url(); ?>how_it_works"><i class="fa fa-play"></i></a></div>
                     </div>
        		</div>
				<div class="col-lg-7 ">
					<div class="main-content">
						<h2>Quick. Easy. <br />Convenient.</h2>
						<div class="main-wrapper">
							<h4>Holding your hand/arm download</h4>
							<p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirements. We work with you, not for you. Although we have great resources.</p>
							<a href="<?php echo base_url(); ?>tests" class="tran3s custom-btn">View Our Tests</a>
						</div> <!-- /.main-wrapper -->
					</div> <!-- /.main-content -->
				</div> <!-- /.col- -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
		<div class="theme-shape-three"></div>
	</div> <!-- /.more-about-us -->
	
	



	<!--
    =============================================
        Our Portfolio
    ==============================================
    -->
	<div class="our-portfolio" id="premium-home">
		<div class="container">
			<div class="theme-title">
				<h2>How<br /> Premium Works</h2>
				<a href="<?php echo base_url(); ?>memberships" class="tran3s">Find out more</a>
			</div> <!-- /.theme-title -->
		</div> <!-- /.container -->

		<div class="wrapper">
			<div class="row">
				<div class="portfolio-slider">
					<div class="item">
						<div class="image">
							<img src="<?=base_url('assets/front/')?>images/portfolio/1.jpg" alt="">
							<div class="opacity tran4s"><a data-fancybox="project" href="images/portfolio/1.jpg" class="tran3s" title="We’ve done lot’s of work, Let’s Check"></a></div>
						</div>
					</div>
					<div class="item">
						<div class="image">
							<img src="<?=base_url('assets/front/')?>images/portfolio/2.jpg" alt="">
							<div class="opacity tran4s"><a data-fancybox="project" href="images/portfolio/2.jpg" class="tran3s" title="We’ve done lot’s of work, Let’s Check"></a></div>
						</div>
					</div>
					<div class="item">
						<div class="image">
							<img src="<?=base_url('assets/front/')?>images/portfolio/3.jpg" alt="">
							<div class="opacity tran4s"><a data-fancybox="project" href="images/portfolio/3.jpg" class="tran3s" title="We’ve done lot’s of work, Let’s Check"></a></div>
						</div>
					</div>
					<div class="item">
						<div class="image">
							<img src="<?=base_url('assets/front/')?>images/portfolio/4.jpg" alt="">
							<div class="opacity tran4s"><a data-fancybox="project" href="images/portfolio/4.jpg" class="tran3s" title="We’ve done lot’s of work, Let’s Check"></a></div>
						</div>
					</div>
				</div> <!-- /.portfolio-slider -->
			</div> <!-- /.row -->
		</div> <!-- /.wrapper -->
	</div> <!-- /.our-portfolio -->


	<div class="testimonial-section homeThree" id="customer-home">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xs-12 float-right">
					<div class="main-container">
						<div class="theme-title-two">
							<h2>What <br> Our Customers Say</h2>
						</div> <!-- /.theme-title -->
						<div class="testimonial-slider">
							<div class="item">
								<div class="wrapper">
									<p>Their testimonial videos aren't production quality, but they get the message across, cover useful &amp; relevant information which goes to show you don't need to investthousands in production get some testimonial videos up with quality.</p>
								</div> <!-- /.wrapper -->
							</div> <!-- /.item -->
							<div class="item">
								<div class="wrapper">
									<p>Their testimonial videos aren't production quality, but they get the message across, cover useful &amp; relevant information which goes to show you don't need to investthousands in production get some testimonial videos up with quality.</p>
								</div> <!-- /.wrapper -->
							</div> <!-- /.item -->
						</div> <!-- /.testimonial-slider -->
					</div> <!-- /.main-container -->
				</div>
				<div class="col-md-6 col-xs-12"><img src="<?=base_url('assets/front/')?>images/home/16.jpg" alt=""></div>
			</div>
		</div> <!-- /.container -->
	</div> <!-- /.testimonial-section -->

	<!-- ==================== TWO SECTION WRAPPER ====================== -->
	<div class="two-section-wrapper homeThree">
		<!--
        =============================================
            Pricing Plan Style One
        ==============================================
        -->
		<div class="pricing-plan-one sp" id="corporate-package">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-xs-12 wow fadeInLeft">
						<div class="theme-title">
							<h2>We also do <br>Corporate Packages</h2>
							<p>We have different type of pricing table to choose with <br>your need with reasonable price. </p>
						</div> <!-- /.theme-title -->
						<br />
					

						<div class="clearfix"></div><br />
					</div> <!-- /.col- -->

					<div class="col-md-6 col-xs-12 wow fadeInRight">
						<div class="tab-content">
							<div id="monthly" class="tab-pane fade in active">
								<div class="clearfix">
									<div class="float-left left-side  ">
										<span class="pricing-text"><sub>Bespoke packages to suit your business</span>
									<div class="sp-bottom">
										<span class="span">Find out more <br> <a href="<?php echo base_url(); ?>corporate"><i class="fa fa-arrow-right fs-43" aria-hidden="true"></i></a></span> 
									</div>
									</div> <!-- /.left-side -->
									<div class="right-side float-left">
										<h6>40% OFF</h6>
										<h4>Weekly Package</h4>
										<ul>
											<li>50GB Bandwidth</li>
											<li>Business & Finance Analysing</li>
											<li>24 hour support</li>
											<li>Customer Managemet</li>
										</ul>
									</div> <!-- /.right-side -->
								</div>
							</div> <!-- /#monthly -->
							<div class="clearfix"></div>
						</div>
					</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.pricing-plan-one -->
	</div> <!-- /.two-section-wrapper -->



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
    <div class="hub-page shop-page br-0 pb-0">
        <div class="container">
            <div class="shop-product-wrapper br-0">
            <div class="row">
							<div class="single-product our-blog home-blog">
								<div class="theme-title">
        							<h2>Latest Blogs</h2>
        						</div>

								<div class="row">
									<?php foreach ($blogs as $blog){ ?>
									<div class="col-lg-4 col-md-4 col-xs-6">
										<div class="single-blog">
											<a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><div class="image"><img  src="<?=base_url('uploads/blog/'.$blog->blogImage)?>" alt=""></div></a>
											<div class="text float-left">
												<h6>Evergene.</h6><br>
												<h5><a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><?=$blog->blogTitle?></a></h5>

												<a href="<?=base_url('blog/view/'.$blog->blogSlug)?>" class="tran3s"><i class="flaticon-arrows" aria-hidden="true"></i></a>
											</div>
										</div> <!-- /.single-blog -->
									</div>
									<?php } ?>
								</div> <!-- /.row -->

								<div class="clearfix"></div>
							</div> <!-- /.single-product -->

            </div>
            </div>
        </div>
    </div>
	<!--
    =============================================
        Footer
    ==============================================
    -->
    <?php $this->load->view('includes/footer'); ?>
	<!-- Camera Slider -->
	<script type='text/javascript' src='<?=base_url('assets/front/')?>vendor/Camera-master/scripts/jquery.mobile.customized.min.js'></script>
	<script type='text/javascript' src='<?=base_url('assets/front/')?>vendor/Camera-master/scripts/jquery.easing.1.3.js'></script>
	<script type='text/javascript' src='<?=base_url('assets/front/')?>vendor/Camera-master/scripts/camera.min.js'></script>
	<script>
    var counted = 0;
    $(window).scroll(function() {
      var oTop = $('.counting').offset().top - window.innerHeight;
      if (counted == 0 && $(window).scrollTop() > oTop) {
        $('.counting').each(function() {
              var $this = $(this),
                  countTo = $this.attr('data-count');

              $({ countNum: $this.text()}).animate({
                countNum: countTo
              },
              {
                duration: 1000,
                easing:'linear',
                step: function() {
                  $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                  $this.text(this.countNum);
                  //alert('finished');
                }
              });  
        });
        counted = 1;
      }

    });
	</script>
	<script type="text/javascript">

		<?php if($this->session->flashdata('verification')){ ?>
		$.confirm({
			icon:  'fa fa-smile-o',
			type: 'green',
			animationSpeed: 1000,
			title : 'Congratulations',
			theme: 'modern',
			content: '<?=$this->session->flashdata('verification')?>',
			buttons: {
				ok: {
					text: 'Ok',
					btnClass: 'btn-green',
					action: function(){
						this.close();
						$('.loginBtn').click();
					}
				}
			}
		});
		<?php } ?>


	</script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
