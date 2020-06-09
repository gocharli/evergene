<?php $this->load->view('includes/head');   ?>
</head>

<body>
<div class="main-page-wrapper">

	<?php $this->load->view('includes/menu');   ?>

	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="service-version-one p-0">
		<div class="container">
			<div class="row">
				<?php foreach ($results as $row) { ?>
					<div class="col-md-12 col-xs-12">
						<div class="single-service p-0">

							<div class="col-md-6 col-sm-6 border-right">
								<div class="single-service no-border">
									<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
									<div class="row">
										<p class="col-md-12"><?=$row->testName?></p>
										<p class="col-md-6 price">
											<span class="member-price">Member Price</span>
											£<?=number_format($row->originalPrice,2)?></p>
										<p class="col-md-6 price">
											<span class="member-price">Premium Members Price</span>
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
									</div>
									<div class="clearfix"></div>
									<p class="description"><?=short_text($row->testDescription,150)?></p>
									<a href="<?=base_url('items/'.$row->slug)?>" class="custom-btn">Learn More</a>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 text-center">
								<?php if($row->otherImg==null){ ?>
									<img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="display: inline-block;height: 325px;" class="img-responsive" alt=""/>
								<?php }else{ ?>
									<img src="<?=base_url('uploads/tests/products/').$row->otherImg?>" style="display: inline-block;height: 325px;" class="img-responsive" alt=""/>
								<?php } ?>
							</div>
							<a href="#" class="add-to-cart">
								<div class="img"></div>

							</a>
							<div class="clearfix"></div>
						</div> <!-- /.single-service -->
					</div> <!-- /.col-md-4 -->

				<?php } ?>
			</div> <!-- /.row -->

		</div> <!-- /.container -->
	</div> <!-- /.service-version-one -->


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

	<?php $this->load->view('includes/scripts'); ?>

</div> <!-- /.main-page-wrapper -->
</body>
</html>
