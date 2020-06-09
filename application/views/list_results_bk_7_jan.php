<?php $this->load->view('includes/head');   ?>
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
	<div class="shop-page hub-page portfolio-details full-width">
		<div class="row">
			<div class="p-0 m-p-15">
				<div class="title-head">
					<h5 class="pull-left" style="padding: 15px 0;">Your Results</h5>
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

						<div class="col-lg-12 col-xs-12">

							<div class="single-product" id="loadmore_data">
								<?php if($results){
								 $this->load->view('components/list_results',array('results'=>$results));
								}else{ ?>
								<p class="text-center">No Result Found.</p>
								<?php } ?>
								<div class="clearfix"></div>
							</div> <!-- /.single-product -->
							<?php if($results && count($results)>=$resultsPerPage){  ?>
								<div class="col-md-12 text-center" style="margin-top: 10px">
									<a href="javascript:;" class="loadmore tran3s custom-btn"  page="2" >View More</a>
								</div>
							<?php } ?>

						</div> <!-- /.col- -->
					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>


		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>

	<?php $this->load->view('includes/scripts'); ?>
	<script type="text/javascript">
		$(document).on('click','.loadmore',function () {

			var ele = $(this);
			$.ajax({
				url: '<?=base_url()?>results/loadmore',
				type: 'POST',
				dataType: 'json',
				data: {
					page:$(this).attr('page')
				},
				success: function(response)
				{
					if(response.code==1)
					{
						if(response.page==0)
						{
							$('.loadmore').hide();
						}
						else
						{
							ele.attr('page',response.page)
						}

						if(response.html!='')
						{
							$('#loadmore_data').append(response.html).fadeIn('slow');
						}
					}
				}
			});
		});

	</script>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
