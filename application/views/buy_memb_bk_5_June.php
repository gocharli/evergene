<?php $this->load->view('includes/head');   ?>
</head>

<body>
<div class="main-page-wrapper">


	<?php $this->load->view('includes/menu');   ?>


	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->

	<div class="shop-page hub-page">
		<div class="row">
			<div class="container">
				<?php  //$cart_data=$this->cart->contents();echo $cart_data[0]['qty']; print_r($cart_data); ?>
				<div class="title-head col-md-12 p-0 m-p-15">
					<h5 class="pull-left" style="padding: 15px 0;">Membership Summary</h5>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div> <br />
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">
						<div class="row">
						        <div class="col-lg-5 col-xs-6">
								<div class="single-product shop-sidebar">
									<div class="product-header">
										<h6 style="margin: 0px;">Information
										</h6>
										<div class="clearfix"></div>
									</div><!--product header-->

									<div class="single-service m-bottom0">
									    <p><?php $p = $results[0]; echo ucfirst($p->planPeriod); ?> subscription will be charged on a <?php echo $p->planPeriod; ?> basis and contains <?php echo $p->planOrders; ?> orders per month.</p>
					            	</div>
					            	
									<div class="clearfix"></div>




								<?php if(!$_SESSION["coupon_code"]){ ?>

									<?php if($code !=""){ ?>



										<div id="sec_add_coupon" class="col-lg-12 p-0" style="margin-top:15px;">
											<div class="col-lg-7 p-0">
													<!-- <p class="mem-p">Limited time offer: 1 <?php echo $PlanDuration; ?> premium membership in £<?php echo $discounted_price; ?> with code: <b>"<?php echo $code; ?>" </b> </p> -->
													<input type="text" class="coupon-input form-control" id="coupon_code"  value="<?php echo $code; ?>" />
											</div>

											<div class="col-lg-5 text-right">
												<input type="button" class="btn btn-primary  btn-pay" value="APPLY CODE" onclick="apply_discount()" style="margin-top:0px; margin-left: 10px">
											</div>
										</div>



									<?php } ?>

								<?php }else{ ?>


								<div class="col-lg-12 text-center p-0" style="margin-top:15px;">

							

								<div class="col-md-2"></div>
									<div class="col-md-8" style="text-align: center;">
										<a href="<?php echo base_url(); ?>memberships/remove_coupon"><input type="button" class="btn btn-primary pull-left btn-pay" value="REMOVE DISCOUNT CODE" style="margin-top:0px; margin-left: 10px;"></a>
									</div>
									<div class="col-md-2 p-0">	
									</div>
								
								</div>

								<?php } ?>




									<!-- <div class="col-lg-12 text-center p-0" style="margin-top:15px;">
									    <div class="col-lg-7 p-0">
									    	<input type="text" class="coupon-input form-control" id="coupon_code" value="BUYFREE">
										</div>
										<div class="col-lg-5 text-right">
									    	<input type="button" class="btn btn-primary  btn-pay" value="APPLY CODE" onclick="apply_discount()" style="margin-top:0px; margin-left: 10px">
										</div>
									</div> -->









									<div class="clearfix"></div>
								</div> 

							</div>
								<div class="col-lg-7 col-xs-12">

								<div class="single-product shop-sidebar">
									<div class="product-header">
										<h6 style="margin:0px;">Summary</h6>
										<div class="clearfix"></div>
									</div><!--product header-->

									<div class="single-service">

										<div class="shopping-cart">
											<!-- Product #1 -->
                                            <div class="item">                                            
                                                 <div class="description" style="width: 20%;font-size: 15px;font-weight: bold;">Subscription</div>
    											 <div class="total-price" style="width: 20%;font-size: 15px;font-weight: bold;">Purchase Date</div>
    										   	 <div class="total-price" style="width: 20%;font-size: 15px;font-weight: bold;">Expiry Date</div>
                                                 <div class="total-price" style="width: 20%;font-size: 15px;font-weight: bold;">Price</div>
    										     <div class="total-price" style="width: 20%;font-size: 15px;font-weight: bold;">Action</div>
                                            </div>
                                            <div class="item" id="row_zSjduFOO">
														<div class="description" style="width: 20%;">
															<span><?php echo ucfirst($p->planPeriod); ?> Subscription</span>
														</div>


														<?php $today = date('d-m-Y'); ?>


                                                        <div class="total-price" style="width: 20%;"><?php echo $today; ?></div>                                              
														<div class="total-price" style="width: 20%;">
														<?php if($p->mpId == 2){ echo date("d-m-Y", strtotime("+1 year", strtotime($today))); }else{ echo date("d-m-Y", strtotime("+1 month", strtotime($today))); } ?>
														</div>
														<div class="total-price" style="width:20%;">£<?php echo $p->planAmount; ?></div>
														<div class="total-price" style="width: 20%;">
															<a href="<?php echo base_url(); ?>memberships" class="tran3s custom-btn small-btn hvr-trim-two" id="checkout-custombtn"><span class="fa fa-trash-o"></span> </a>
														</div>
										   </div>
										
										</div>
										<div class="clearfix"></div>
									</div> <!-- /.single-product -->

								
									</div>

									<div>
											<!-- <input type="checkbox" name="terms1" value="1"/><span class="simple-text">I have read and agree to</span> <a href="#"> Terms and conditions.</a> </br> -->
											<!-- <span style="display: inline-flex;"><input type="checkbox" name="terms2" value="1" /> <a  class="simple-text">We will only use your email address to contact you about when results are available.</a></span> -->
										<span style="display: inline-flex;color:#000;margin-top:5px;width:100%;line-height:28px;">
					                    <input type="checkbox" name="terms1" id="sign-up-checkbox2" style="margin-left: -3px;width:3%" value="1"><span id="agree_term" class="simple-text">I have read and agree to </span> <a target="_blank" href="<?php echo base_url(); ?>terms_of_use"> Terms and conditions.</a> <br>
								</span>
									</div>
								<div class="row">
                                 <div class="col-md-9"></div>
                                 <div class="col-md-3">
							    	<button type="button" onclick="validate_check(<?php echo $p->mpId; ?>)" class="tran3s cart-button btn-pay block hvr-trim-two">PROCEED</button>
								 </div>
								</div>
								</form>

							</div> <!-- /.col- -->

						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->



<script>

function validate_check(pid){

if($('#sign-up-checkbox2').is(":checked")){
	//$("#agree_term").css("color", "black");
	$("#pay_"+pid).trigger('click');
}else{
	//$("#agree_term").css("color", "red");
	$.confirm({
		title: 'Encountered an error!',
		content: 'Terms and conditions not checked',
		type: 'red',
		typeAnimated: true,
		buttons: {
			close: function () {
			}
		}
	});
}



}

</script>

	<div class="pricing-plan-list" style="display: none">
										<?php
                                         foreach ($results as $row){ ?>
										<div class="pricing-plan">
											<h2 class="pricing-plan__name" id="plan_title_<?php echo $row->mpId; ?>"><?=$row->planTitle?></h2>
											<?php if($bonus>1) {?>
												<h1 class="pricing-plan__price">£<?=$row->planAmount-$bonus?></h1>
												<small class="pricing-plan__feature">Referral discount <b style="text-decoration: line-through "><?=$row->planAmount?></b></small> <br>
											<?php }else{ ?>
											<h1 class="pricing-plan__price">£<span id="plan_price1_<?php echo $row->mpId; ?>"><?=$row->planAmount?></span></h1>
											<?php } ?>

											<small class="pricing-plan__disclosure">charged on a <?=$row->planPeriod?> basis</small>
											<ul class="pricing-plan__feature-list">
												<li class="pricing-plan__feature"><?=$row->planOrders?> orders per <?=$row->planOrderPeriod?></li>
											</ul><br />
											<div class="col-md-12">
												

                                                   
												<input type="hidden" id="plan_price_<?php echo $row->mpId; ?>" value="<?=$row->planAmount-$bonus?>" />
												<a id="pay_<?php echo $row->mpId; ?>" href="javascript:;" onclick="process(this,<?php echo $row->mpId; ?>)" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a>
												

											</div>

										</div>
										<?php } ?>

									</div>
    
	



	<form id="mem_form" method="post" action="<?php echo base_url(); ?>memberships/process">
		<input type="hidden" name="planId" id="planId" value="">
	</form>

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script type="text/javascript">
		var handler = StripeCheckout.configure
		({
			key: '<?=getenv('stripe_api_key')?>',
			image: '<?php echo base_url(); ?>assets/stripelogo.png',
			token: function(token)
			{
				$('#mem_form').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
				var frm=$('#mem_form');
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
												//top.location.href="<?=base_url('account?type=membership')?>";
												top.location.href="<?=base_url('hub')?>";
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
		});
		<?php if(isset($this->session_data->userId)){ ?>

		function process(e,gid) {
			var total_g=$('#plan_price_'+gid).val();
			var title=$('#plan_title_'+gid).text();
			if(title == "")
			{
				return false;
			}
			$('#planId').val(gid);
			total=total_g*100;
			handler.open({
				name: title,
				description: 'Charges( £'+total_g+' )',
				currency : 'GBP',
				amount: total
			});

		}
		window.addEventListener('popstate', function() {
			handler.close();
		});
		<?php } ?>
	</script>
	<?php $this->load->view('includes/scripts'); ?>

		<script>

			// function add_discount(){
			// 	$("#discount_field").toggle();
			// }

			function apply_discount(){
				
				var code = $("#coupon_code").val();

				var plan_id = '<?php echo $this->uri->segment(3); ?>'; 
				
				if(code != ""){

					$.post("<?php echo base_url(); ?>memberships/add_coupon",{code: code, plan_id: plan_id},function(resp){ 
						res = JSON.parse(resp);
						console.log(resp);
						
					if(res.code == 0){

						$.confirm({
								title: 'Encountered an error!',
								content: res.message,
								type: 'red',
								typeAnimated: true,
								buttons: {
									close: function () {
									}
								}
						});

					}else if(res.code == 1){

						//$("#plan_price_"+res.plan_id).val(res.new_price);
						//$("#plan_price1_"+res.plan_id).text(res.new_price);

						$.confirm({
							title: 'Success!',
							content: res.message,
							type: 'green',
							autoClose: 'close|5000',
							typeAnimated: true,
							buttons: {
								close: function () {
									location.reload();
								}
							}
						});
					}else{

						$.confirm({
								title: 'Error!',
								content: res.message,
								type: 'red',
								typeAnimated: true,
								buttons: {
									close: function () {
									}
								}
						});

					}

					});

				}
			}

		</script>


