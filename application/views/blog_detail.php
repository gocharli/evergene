<?php $this->load->view('includes/head_blog');   ?>
<style type="text/css">
	p{
		overflow-wrap: break-word;
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
	<!--
			=============================================
				Theme Inner Banner
			==============================================
			-->
	<div class="inner-page-banner">
		<div class="opacity header-product-detail blog">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->


	<!--
        =============================================
            Blog Details
        ==============================================
        -->
	<div class="blog-details blog-v3">
		<div class="container">
			<div class="wrapper">
				<div class="blog-main-post">
					<img src="<?=base_url('uploads/blog/'.$row->blogImage)?>" style="width: 100%; height: 400px" alt="<?php echo $row->PicAltText; ?>">
					<h6>Evergene.</h6>
					<h3><?=$row->blogTitle?></h3>
					<p><?=$row->blogDescription?></p>
							</div> <!-- /.blog-main-post -->
				<div class="tag-option clearfix">
					<ul class="float-left">
						<li>Date:</li>
						<li><a href="" class="tran3s"><?=date('d F Y',strtotime($row->createdAt))?></a></li>
					</ul>
				</div> <!-- /.tag-option -->
			</div> <!-- /.wrapper -->
		</div> <!-- /.container -->

	</div> <!-- /.blog-details -->

</div> <!-- /.shop-page -->

<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>

<?php $this->load->view('includes/scripts'); ?>

</div> <!-- /.main-page-wrapper -->
</body>
</html>
