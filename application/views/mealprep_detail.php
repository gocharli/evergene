<?php $this->load->view('includes/head');   ?>
<link rel="stylesheet" href="<?=base_url()?>assets/admin/bower_components/select2/css/select2.min.css" />
<style type="text/css">
	.ckeditr p{
		margin: 0px !important;
	}
	.ckeditr ul,.ckeditr ol{ list-style: inside !important; padding: 10px; }
	.item > img {
		display: inline-block !important;
	}
	.add_detail{
		margin-top: 10px;
	}


</style>
</head>
<?php
$originalPrice=$row->originalPrice;
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
}
?>
<body>
<div class="main-page-wrapper">

	<?php $this->load->view('includes/menu');   ?>
	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->
	<!--
    =============================================
        Shop Page
    ==============================================
    -->
	<div class="shop-page shop-details">
		<div class="container">
			<div class="procuct-details">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<!-- Indicators -->
							<ol class="carousel-indicators">
								<?php $imoreImages=$this->db->query('select * from test_images WHERE testId='.$row->testId)->result();
								if($imoreImages) {
									$i=0;
									foreach ($imoreImages as $image) { ?>
										<li data-target="#carousel-example-generic" data-slide-to="<?=$i?>"
											class="<?php if($i==0){?>active<?php } ?>"></li>
										<?php $i++; }
								}?>
							</ol>
							<!-- Wrapper for slides -->
							<div class="carousel-inner" role="listbox">
								<?php if($imoreImages) {
									$i=0;
									foreach ($imoreImages as $image) { ?>
										<div class="item text-center <?php if($i==0){?>active<?php } ?>">
											<img class="" style="height:400px; " src="<?=base_url('uploads/tests/products/'.$image->imageName)?>" alt="...">
										</div>
										<?php $i++; }
								}?>
							</div>
							<!-- Controls -->
							<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						<br><br>
						<?php if($this->membership_data->expire) { ?>
							<div class="field-radio">
								<div class="box-radio-option">
									<label for="address-service">Upgrade your account - find out how it works <a href="<?=base_url('memberships')?>"> £<?=number_format($mprice,2)?></a></span></label>
								</div>
							</div>
						<?php }else{ ?>
							<div class="field-radio">
								<div class="box-radio-option">
									<label style="margin: auto;" for="address-service">Non Member Price <a href="javascript:;"> £<?=number_format($originalPrice,2)?></a></span></label>
								</div>
							</div>
						<?php } ?>

					</div>
					<div class="col-md-6 col-xs-12">
						<div class="product-info">
							<form id="cart_frm" action="<?=base_url('cart/add')?>" type="post">
							<div class="row">
								<div class="col-md-8"><h3 style="line-height: inherit;margin: 0px; margin-top: 5px;"><?=$row->testName?></h3></div>
								<div class="col-md-4 text-right"><strong class="price">

										<?php if($this->membership_data->expire) { ?>
											£<?=$originalPrice?>
										<?php }else{ ?>
											£<?=$mprice?>
										<?php } ?>

									</strong></div>
								<div class="clearfix"></div>
							</div>
							<p><?=$row->testDescription?></p>

							<div class="regular-form">

								<div class="row" style="margin-bottom: 15px">
									<div class="col-md-6 col-sm-6" >
										<label>Diet</label>
										<select class="form-control" name="diet">
											<option value="">select diet</option>
											<option value="Vegetarian">Vegetarian</option>
											<option value="Pescatarian">Pescatarian</option>
											<option value="Vegetarian">Vegetarian</option>
											<option value="vegan">vegan</option>
										</select>

									</div><!--ol md 6-->
									<div class="col-md-6 col-sm-6" >
										<label>Alergies/Intolerancies</label>
										<select class="form-control" onchange="rc(this.value)" name="alergies">
											<option value="Yes">Yes</option>
											<option value="No" selected>No</option>
										</select>
										<div class="add_detail" style="display: none">
											<textarea placeholder="Please write Detail" class="form-control" name="alergies_detail"></textarea>
										</div>
									</div><!--ol md 6-->
								</div>
								<div class="row" style="margin-bottom: 15px">
									<div class="col-md-6 col-sm-6">
										<label>How many meals?</label>
										<select class="form-control" name="meals">
											<option value="">How many meals</option>
											<option value="10">10</option>
											<option value="15">15</option>
										</select>
									</div><!--ol md 6-->
									<div class="col-md-6 col-sm-6">
										<label>Day delivery?</label>
										<select class="form-control" name="delivery">
											<option value="">Day delivery</option>
											<option value="Mon">Mon</option>
											<option value="Wed">Wed</option>
										</select>
									</div><!--ol md 6-->
								</div>
								<div class="row" style="margin-bottom: 15px">
									<div class="col-md-6 col-sm-6" >
										<label>Give me more?</label>
										<select class="form-control js-example-tags" name="wantMore[]" multiple>
											<option value="Chicken">Chicken</option>
											<option value="Seafood">Seafood</option>
											<option value="Sandwich">Sandwich</option>
											<option value="Vegetables">Vegetables</option>
											<option value="Fruit">Fruit</option>
										</select>
									</div><!--ol md 6-->
									<div class="col-md-6 col-sm-6" >
										<label>I don't want?</label>
										<select class="form-control js-example-tags" name="notWant[]" multiple>
											<option value="Chicken">Chicken</option>
											<option value="Seafood">Seafood</option>
											<option value="Sandwich">Sandwich</option>
											<option value="Vegetables">Vegetables</option>
											<option value="Fruit">Fruit</option>
										</select>
									</div><!--ol md 6-->
								</div>
								<div class="row" style="margin-bottom: 15px">
									<div class="col-md-12 col-sm-12" >
												<textarea class="form-control" name="additional" placeholder="Additional info"></textarea>
									</div><!--ol md 6-->
								</div>

								<div class="clearfix"></div>
							</div>
							<fieldset>
								<div class="field-radio">
									<input type="radio" class="purchaseType" name="purchaseType" value="Regular" id="purchase-subscribe">
									<div class="box-radio-option">
										<label for="purchase-subscribe"> Setup a regular Tests &nbsp;  <a href="javascript:;">Learn More</a></label>
									</div>
								</div>
								<div class="field-radio">
									<input type="radio" class="purchaseType" name="purchaseType" value="One Time" id="purchase-onetime" checked>
									<div class="box-radio-option">
										<label for="purchase-onetime">One-time Purchase</label>
									</div>
								</div>
							</fieldset>
							<hr />
							<ul class="order-box pull-left">
								<li><button type="button" id="value-decrease">-</button></li>
								<li><input type="text" name="Qty" min="1" max="10" value="1" class="val only_number"  id="product-value"></li>
								<li><button type="button" id="value-increase">+ </button></li>
							</ul>

							<div class="dropdown pull-right" id="regular_type" style="display: none;" >
								<select class="form-control regular_type" name="regularType">
									<option value="">Select Increment</option>
									<option value="Month">Monthly</option>
									<option value="Quarterly">quarterly</option>
									<option value="Semi Annually">Semi Annually </option>
								</select>
							</div>

							<div class="clearfix"></div>
							<input type="hidden" name="testId" value="<?=$row->testId?>">
							<button type="submit" style="width: 100%;" class="tran3s cart-button btn-pay block hvr-trim-two next-step">ADD TO CART</button>
							<div class="clearfix"></div><br />
							<?php if(!$this->membership_data->expire) { ?>
								<div class="input-group">
									<select class="form-control" name="startMonth" style="visibility: hidden">
										<option value="">Select a Month</option>
										<option value="01">January</option>
										<option value="02">February</option>
										<option value="03">March</option>
										<option value="04">April</option>
										<option value="05">May</option>
										<option value="06">June</option>
										<option value="07">July</option>
										<option value="08">August</option>
										<option value="09">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
								</div>
							<?php } ?>
							</form>


						</div> <!-- /.product-info -->
					</div> <!-- /.col- -->
				</div> <!-- /.row -->
			</div> <!-- /.procuct-details -->
			<?php
			$faqs = $this->db->query('select * from faq_relations
										LEFT JOIN faqs ON faq_relations.faqId=faqs.faqId
										WHERE testId='.$row->testId)->result();

			?>
			<div class="product-review-tab">
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#menu11">Details</a></li>
                    <?php if($row->menu){ ?>
					<li><a data-toggle="tab" href="#menu12">Menu</a></li>
                    <?php } if($row->howItsWork){ ?>
					<li><a data-toggle="tab" href="#menu21">How Its Work</a></li>
					<?php } if($faqs){ ?>
					<li><a data-toggle="tab" href="#menu22">FAQs</a></li>
					<?php } ?>
				</ul>
				<div class="tab-content ckeditr" style="margin-top: 15px;">
					<div id="menu11" class="tab-pane fade in active">
						<?php if($row->testDetails!=''){  ?>
						<p><?=$row->testDetails?></p>
                        <?php }else{ ?>                        
                        <p>No Details.</p>
                         <?php } ?>
					</div>
					<div id="menu12" class="tab-pane fade">
						<p><?=$row->menu?></p>
					</div>
					<div id="menu21" class="tab-pane fade">
						<p><?=$row->howItsWork?></p>
					</div>
					<div id="menu22" class="tab-pane fade">
						<div class="faq-content">
							<?php
							foreach ($faqs as $rfaq)
							{
								?>
								<div class="faq-question">
									<input id="q<?=$rfaq->faqId?>" type="checkbox" class="panel">
									<div class="plus">+</div>
									<label for="q<?=$rfaq->faqId?>" class="panel-title"><?=$rfaq->faqTitle?></label>
									<div class="panel-content"><?=$rfaq->faqDescription?></div>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div> <!-- /.product-review-tab -->

			<?php if($related){ ?>
				<div class="realated-product service-version-one shop-product-wrapper p-0">
					<h2>Releted Products</h2>
					<div class="row">
						<div class="related-product-slider">

							<?php  foreach ($related as $ritem){ ?>
								<div class="item">
									<div class="single-service">
										<a href="#" class="add-to-cart">
											<div class="img"></div>
										</a>
										<i class="tran3s"><img src="<?=base_url('uploads/tests/logo/').$ritem->testLogo?>" style="width: 60px; height: 60px;" alt=""/></i>
										<div class="row">
											<p class="col-md-12"><?=$ritem->testName?></p>
											<p class="col-md-12 price">£<?=$ritem->originalPrice?></p>
										</div>
										<div class="clearfix"></div>
										<p class="description"><?=short_text($ritem->testDescription,80)?></p>
										<a href="<?=base_url('mealprep/'.$ritem->slug)?>" class="custom-btn">Learn More</a>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
							<?php } ?>					</div> <!-- /.related-product-slider -->
					</div> <!-- /.row -->
				</div>
			<?php } ?>


			<!-- ==================== Team ====================== -->
			<div class="our-team-styleOne inner-page style-two">
				<div class="container">
					<div class="row">
						<div class="theme-title text-center">
							<h2>Meet Our Team</h2><br /><br />
						</div> <!-- /.theme-title -->
						<div class="col-md-4 col-xs-6">
							<div class="single-team-member">
								<div class="image">
									<img src="<?=base_url('assets/front/')?>images/team/1.jpg" alt="">
									<div class="opacity tran3s">
										<ul class="tran3s">
											<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div> <!-- /.image -->
								<h6>Lynne Blears</h6>
								<p>CO-Founder</p>
							</div> <!-- /.single-team-member -->
						</div> <!-- /.col- -->
						<div class="col-md-4 col-xs-6">
							<div class="single-team-member">
								<div class="image">
									<img src="<?=base_url('assets/front/')?>images/team/2.jpg" alt="">
									<div class="opacity tran3s">
										<ul class="tran3s">
											<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div> <!-- /.image -->
								<h6>Sophie Gilbert</h6>
								<p>Solicitor</p>
							</div> <!-- /.single-team-member -->
						</div> <!-- /.col- -->
						<div class="col-md-4 col-xs-6">
							<div class="single-team-member">
								<div class="image">
									<img src="<?=base_url('assets/front/')?>images/team/3.jpg" alt="">
									<div class="opacity tran3s">
										<ul class="tran3s">
											<li><a href="" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div> <!-- /.image -->
								<h6>Brendan Doherty</h6>
								<p>CEO</p>
							</div> <!-- /.single-team-member -->
						</div> <!-- /.col- -->
						<div class="text-center">
							<a href="javascript:;" class="tran3s custom-btn">Find Out More</a>
						</div>
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.our-team-styleOne -->
		</div> <!-- /.container -->
	</div> <!-- /.shop-page -->

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
	<div id="cartModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<h6 class="text-center">Membership Schedule Calender (Plan)</h6>
					<ul style="list-style: inside;font-size: 13px;margin: 10px;">
						<li>If quantity > available order in same month you will pay full price of extra quantity.</li>
						<li>If user not pay membership fees of future order than order will be canceled.</li>
					</ul>
					<form class="frm_add_cart" action="<?=base_url('cart/add')?>">
						<table class="table">
							<thead>
							<tr>
								<th class="text-center" style="width: 20%;">Quantity</th>
								<th class="text-center" style="width: 50%;">Schedule Month</th>
								<th class="text-center" style="width: 30%;">Available orders</th>
							</tr>
							</thead>
							<tbody id="cart_html">

							</tbody>
							<tfoot>
							<tr>
								<td colspan="3">
									<input type="hidden" name="testId" value="<?=$row->testId?>">
									<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two next-step pull-right">Save</button></td>
							</tr>
							</tfoot>
						</table>
					</form>
				</div> <!-- /.modal-body -->
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.signUpModal -->
	<div id="cartModalRegular" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<h6 class="text-center">Membership Schedule Calender (Plan)</h6>
					<ul style="list-style: inside;font-size: 13px;margin: 10px;">
						<li>If quantity > available order in same month you will pay full price of extra quantity.</li>
						<li>If user not pay membership fees of future order than order will be canceled.</li>
					</ul>
					<form class="frm_add_cart" action="<?=base_url('cart/add')?>">
						<table class="table">
							<thead>
							<tr>
								<th class="text-center" style="width: 20%;">Quantity</th>
								<th class="text-center" style="width: 35%;">Schedule Month</th>
								<th class="text-center" style="width: 20%;">Membership Orders</th>
								<th class="text-center" style="width: 25%;">Available orders</th>
							</tr>
							</thead>
							<tbody id="cart_html_regular">

							</tbody>
							<tfoot>
							<tr>
								<td colspan="4">
									<input type="hidden" name="testId" value="<?=$row->testId?>">
									<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two next-step pull-right">Save</button>
								</td>
							</tr>
							</tfoot>
						</table>
					</form>
				</div> <!-- /.modal-body -->
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.signUpModal -->
	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/admin/bower_components/select2/js/select2.full.min.js"></script>
	<?php $this->load->view('includes/scripts'); ?>
	<script type="text/javascript">
		$('.js-example-tags').select2({
			tags: true
		});
		function rc(val)
		{
			if(val=="Yes")
			{
				$('.add_detail').show();
			}
			else
			{
				$('.add_detail').hide();
			}
		}

		$('.purchaseType').change(function (e) {
			if(this.value === 'Regular')
			{
				$('#regular_type').show();
				$('.regular_type option[value=""]').prop('selected', true);
                
                   <?php if($this->membership_data->expire) { ?>           
                    $("#product-value").attr('min',4);
                    $("#product-value").val(4);
                <?php } ?> 
			}
			else
			{
			     <?php if($this->membership_data->expire) { ?>           
                    $("#product-value").attr('min',1);
                    $("#product-value").val(1);
                <?php } ?>
                
				$('#regular_type').hide();
			}
		});

		$('.frm_add_cart').submit(function () {
			var frm=$(this);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data:frm.serialize(),
						method: 'post'
					}).done(function (response) {
						self.close();
						if(response.code===0)
						{
							error_box(response.message,5000);
						}
						else
						{
							$.confirm({
								title: 'Success!',
								icon:  'fa fa-check',
								content: response.message,
								type: 'green',
								autoClose: 'ok|5000',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function(){
											top.location.href="<?=base_url('cart')?>";
										}
									}
								}
							});
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
			return false;
		});

		$('#cart_frm').submit(function () {
			var frm=$(this);
			var purchaseType=$('input[name=purchaseType]:checked').val();
			if(purchaseType === 'Regular')
			{
				var regular_type=$('select[name=regularType]').val();
				if(regular_type === '')
				{
					error_box('Increment Type is missing',0);
					return false;
				}
			}

			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: '<?=base_url('cart/add')?>',
						dataType: 'json',
						data:frm.serialize(),
						method: 'post'
					}).done(function (response) {
						self.close();
						if(response.code===0)
						{
							error_box(response.message,5000);
						}
						else
						{
							top.location.href="<?=base_url('cart')?>";
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


			return false;
		});
         $(document).ready(function() {
            $(".only_number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                     // Allow: Ctrl/cmd+A
                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                     // Allow: Ctrl/cmd+C
                    (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                     // Allow: Ctrl/cmd+X
                    (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                         // let it happen, don't do anything
                         return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });


	</script>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
