<?php $this->load->view('includes/head');   ?>
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
        Our Blog / Blog V2
    ==============================================
    -->
	<div class="our-blog blog-v2">
		<div class="row" id="loadmore_data">
			<?php if($results){
				$this->load->view('components/blogs',array('blogs'=>$results));
			}else{ ?>
				<p style="margin-top: 10px" class="text-center">No Blog Found</p>
			<?php } ?>
		</div> <!-- /.row -->
		<?php if($results && count($results)>=$resultsPerPage){  ?>
			<div class="col-md-12 text-center" style="margin-top: 10px">
				<a href="javascript:;" class="loadmore load-more tran3s hvr-trim">Load More</a>
			</div>
		<?php } ?>
		<!-- <a href="#" class="load-more tran3s hvr-trim">Load More</a> -->
	</div> <!-- /.our-blog -->


</div> <!-- /.shop-page -->

<?php $this->load->view('includes/footer'); ?>
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>

<?php $this->load->view('includes/scripts'); ?>
<script type="text/javascript">
	$(document).on('click','.loadmore',function () {

		var ele = $(this);
		$.ajax({
			url: '<?=base_url()?>blog/loadmore',
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
