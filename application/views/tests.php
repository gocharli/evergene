<?php $this->load->view('includes/head');   ?>
</head>

<body>
<div class="main-page-wrapper">
	<?php $this->load->view('includes/menu');   ?>

	<div class="inner-page-banner">
		<div class="opacity">
			<h2 class="pull-left" style="padding-left: 40px;">Our Home Health Tests</h2>
			<?php $this->load->view('includes/upgarde_premium');   ?>
			<div class="clearfix"></div>
		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<div class="service-version-one m-top-mins">
		<div class="container">
			<div class="mixitUp-menu">
				<ul>
					<li class="filter <?php if($slug=='all'){ ?>active<?php } ?> tran3s" data-filter="all" id="all-tests"> All</li>
					<?php $cat=$this->db->query('select * from categories WHERE categoryType="Tests"')->result();
					foreach ($cat as $cat_row){
					?>
						<li class="filter <?php if($slug==$cat_row->catSlug){ ?>active<?php } ?> tran3s" data-filter=".<?=$cat_row->catSlug?>"><?=$cat_row->categoryName?></li>
					<?php } ?>
					<li class="filter <?php if($slug=='mealprep'){ ?>active<?php } ?> tran3s" id="meal-prep" data-filter=".mealprep">Meal Prep</li>
					<li class="filter <?php if($slug=='items'){ ?>active<?php } ?> tran3s"  id="gen-items" data-filter=".items">General Items</li>
				</ul>
			</div> <!-- End of .mixitUp-menu -->
			<div class="row" id="mixitUp-item">

				<?php foreach ($results as $row) { ?>
				<div class="col-md-4 col-sm-4 col-xs-12 mix all <?=$row->catSlug?>">
					<div class="single-service">
					<?php if($row->coming_soon == 1 && $row->coming_soon_date > date('Y-m-d')){  ?>
						<!-- <a href="javascript:;" class="add-to-cart">
							<div class="img"></div>
						</a> -->
					<?php }else{ ?>
						<a href="<?=base_url('tests/'.$row->slug)?>" class="add-to-cart">
							<div class="img"></div>
						</a>
					<?php } ?>
						
							
						<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
						<div class="row">
							<p class="col-md-12"><?=short_text($row->testName,37)?> </p>

							<?php if($this->membership_data->expire) { ?>
							<p class="col-md-6 col-xs-6 price"  style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color:  rgba(9,9,19,0.4) !important;">Member Price</span>
								£<?=number_format($row->originalPrice,2)?></p>
							<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
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
							<?php }else{ ?>
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
								<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
									<span class="member-price" style="color: #86c44c !important;">Member Price</span>
									£<?=number_format($row->originalPrice,2)?></p>
							<?php } ?>


						</div>
						<div class="clearfix"></div>
						<p class="description"><?=short_text($row->testDescription,80)?></p>

						<?php if($row->coming_soon == 1 && $row->coming_soon_date > date('Y-m-d')){  ?>
							<a class="custom-btn coming-soon">Coming Soon (<?php echo date('d F Y', strtotime($row->coming_soon_date)); ?>)</a>
						<?php }else{ ?>
							<a href="<?=base_url('tests/'.$row->slug)?>" class="custom-btn">Learn More</a>
						<?php } ?>

					</div> <!-- /.single-service -->
				</div> <!-- /.col-md-4 -->
 				<?php } ?>
				<?php
				$mealprep=$this->db->query('select tests.*,(SELECT test_images.imageName FROM test_images WHERE tests.testId=test_images.testId ORDER BY rand() LIMIT 1) as otherImg from tests
 				WHERE productType="MealPrep"')->result(); ?>
				<?php if($this->uri->segment(3) != 'coming_soon'){ foreach ($mealprep as $row) { ?>
					<div class="col-md-4 col-sm-4 col-xs-12 mix all mealprep">
						<div class="single-service">
							<a href="<?=base_url('mealprep/'.$row->slug)?>" class="add-to-cart">
								<div class="img"></div>
							</a>
							<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
							<div class="row">
								<p class="col-md-12"><?=short_text($row->testName,37)?></p>
								<?php if($this->membership_data->expire) { ?>
									<p class="col-md-6 col-xs-6 price"  style="color: rgba(9,9,19,0.4) !important;">
										<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Member Price</span>
										£<?=number_format($row->originalPrice,2)?></p>
									<p class="col-md-6 col-xs-6 price" style="color:#86c44c !important;">
										<span class="member-price" style="color:  #86c44c  !important;">Premium Members Price</span>
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
									<p class="col-md-6 col-xs-6 price" style="color:rgba(9,9,19,0.4) !important;">
										<span class="member-price" style="color:rgba(9,9,19,0.4) !important;">Premium Members Price</span>
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
									<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
										<span class="member-price" style="color:  #86c44c  !important;">Member Price</span>
										£<?=number_format($row->originalPrice,2)?></p>
								<?php } ?>
							</div>
							<div class="clearfix"></div>
							<p class="description"><?=short_text($row->testDescription,80)?></p>
							<a href="<?=base_url('mealprep/'.$row->slug)?>" class="custom-btn">Learn More</a>
						</div> <!-- /.single-service -->
					</div> <!-- /.col-md-4 -->
				<?php } } ?>
				<?php
				$items=$this->db->query('select tests.*,(SELECT test_images.imageName FROM test_images WHERE tests.testId=test_images.testId ORDER BY rand() LIMIT 1) as otherImg from tests
 				WHERE productType="General items"')->result(); ?>
				<?php if($this->uri->segment(3) != 'coming_soon'){ foreach ($items as $row) { ?>
					<div class="col-md-4 col-sm-4 col-xs-12 mix all items">
						<div class="single-service">
							<a href="<?=base_url('items/'.$row->slug)?>" class="add-to-cart">
								<div class="img"></div>
							</a>
							<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
							<div class="row">
								<p class="col-md-12"><?=short_text($row->testName,37)?></p>
								<?php if($this->membership_data->expire) { ?>
									<p class="col-md-6 col-xs-6 price"  style="color: rgba(9,9,19,0.4) !important;">
										<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Member Price</span>
										£<?=number_format($row->originalPrice,2)?></p>
									<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
										<span class="member-price" style="color:  #86c44c !important;">Premium Members Price</span>
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
									<p class="col-md-6 col-xs-6 price" style="color: rgba(9,9,19,0.4) !important;">
										<span class="member-price" style="color:  rgba(9,9,19,0.4) !important;">Premium Members Price</span>
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
									<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
										<span class="member-price" style="color:#86c44c !important;">Member Price</span>
										£<?=number_format($row->originalPrice,2)?></p>
								<?php } ?>
							</div>
							<div class="clearfix"></div>
							<p class="description"><?=short_text($row->testDescription,80)?></p>
							<a href="<?=base_url('items/'.$row->slug)?>" class="custom-btn">Learn More</a>
						</div> <!-- /.single-service -->
					</div> <!-- /.col-md-4 -->
				<?php } } ?>





				<?php foreach ($coming_soon_tests as $row) { ?>
					<div class="col-md-4 col-sm-4 col-xs-12 mix all <?=$row->catSlug?>" style="display: inline-block;">

						<div class="single-service">
												<!-- <a href="javascript:;" class="add-to-cart">
									<div class="img"></div>
							</a> -->
											
							<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="width: 60px;height: 60px;" alt=""/></i>
						<div class="row">
							<p class="col-md-12"><?=short_text($row->testName,37)?> </p>

							<?php if($this->membership_data->expire) { ?>
							<p class="col-md-6 col-xs-6 price"  style="color:rgba(9,9,19,0.4)!important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Member Price</span>
								£<?=number_format($row->originalPrice,2)?></p>
							<p class="col-md-6 col-xs-6 price" style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c  !important;">Premium Members Price</span>
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
								<p class="col-md-6 col-xs-6 price" style="color:  rgba(9,9,19,0.4) !important;">
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
								<p class="col-md-6 col-xs-6 price" style="color:#86c44c  !important;">
									<span class="member-price" style="color: #86c44c !important;">Member Price</span>
									£<?=number_format($row->originalPrice,2)?></p>
							<?php } ?>


						</div>
						<div class="clearfix"></div>
						<p class="description"><?=short_text($row->testDescription,80)?></p>

						<a class="custom-btn coming-soon">Coming Soon (<?php echo date('d F Y', strtotime($row->coming_soon_date)); ?>)</a>
						
						
					</div> <!-- /.single-service -->
				</div> <!-- /.col-md-4 -->
				<?php }  ?>




			</div> <!-- /.row -->
			
			<!--<div class="row" id="mixitUp-item">
			    <div class="col-md-12 coming-soon-mb">
					<h3>Coming Soon Tests</h3>
					</br>
				</div>

				
				 
				 <!--<div class="col-md-4 col-sm-4 col-xs-12 mix all general-wellness" data-bound="" style="display: inline-block;">
					<div class="single-service">
											<!-- <a href="javascript:;" class="add-to-cart">
							<div class="img"></div>
						</a> ->
											
							
						<i class="tran3s"><img src="http://codeigniterexpert.com/evergene/uploads/tests/logo/c3d533b12f92c8d13dd5b0103d1b8f8a.jpg" style="width: 60px;height: 60px;" alt=""></i>
						<div class="row">
							<p class="col-md-12">Widal test </p>

														<p class="col-md-6 price" style="color: #86c44c !important;">
								<span class="member-price" style="color: #86c44c !important;">Member Price</span>
								£200.00</p>
							<p class="col-md-6 price" style="color: rgba(9,9,19,0.4) !important;">
								<span class="member-price" style="color: rgba(9,9,19,0.4) !important;">Premium Members Price</span>
								

								£160.00</p>
							

						</div>
						<div class="clearfix"></div>
						<p class="description">1896 and named after its inventor, Georges-Fernand Widal, is a presumptive serol...</p>

													<a class="custom-btn coming-soon">Coming Soon (15 April 2020)</a>
						
					</div> <!-- /.single-service ->
				</div> <!-- /.col-md-4 ->
 																				
			</div> -->

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
	<!--
    =============================================
        Footer
    ==============================================
    -->
	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.mixitup.min.js"></script>
	<script type="text/javascript">

		if ($("#mixitUp-item").length) {
			$("#mixitUp-item").mixItUp({
				load: {
					filter: '.<?=$slug?>' // show app tab on first load
				}
			})
		};

	</script>
	<?php $this->load->view('includes/scripts'); ?>

</div> <!-- /.main-page-wrapper -->
</body>
</html>
