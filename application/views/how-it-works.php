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

<div class="main-page-wrapper">
	<!--
    =============================================
        Theme Header
    ==============================================
    -->
	<?php $this->load->view('includes/menu');   ?>
    <!--
    =============================================
        More About Us
    ==============================================
    -->
	<div class="more-about-us " id="how-it-works">
	    
		<div class="container">
		    <div class="text-center h-i-text">
		    	<h3 class="howitwork-text">How it Works</h3>
			<h6>We work with business &amp; provide solution to client with their business problem</h6>
            </div>
			<div class="row">
			     <div class="col-md-12">
        		    <video width="100%" height="700" controls="" autoplay>
                            <source src="<?php echo base_url(); ?>assets/videoplayback.mp4" type="video/mp4" >
                    </video>
        		</div>
				 <!-- /.col- -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</div> <!-- /.more-about-us -->
    
    <!--
    =============================================
        What We Do
    ==============================================
    -->
    <div class="more-about-us m-0" id="h-i-w">
		<div class="container">
			<div class="row">
                <div class="col-lg-12">
					<div class="main-content">
						<h2>Quick. Easy. Convenient.</h2>
						<div class="main-wrapper">
							<h4>Holding your hand/arm download</h4>
							<p>We provide marketing services to startups and small businesses to looking for a partner of their digital media, design &amp; dev, lead generation, and communications requirements. We work with you, not for you. Although we have great resources.</p>
			
						</div> <!-- /.main-wrapper -->
					</div> <!-- /.main-content -->
				</div>
			</div>
		</div>
	</div>
	<div class="what-we-do">
		<div class="container">
		
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
						$('.loginBtn').click();
					}
				}
			}
		});
		<?php } ?>


	</script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->

