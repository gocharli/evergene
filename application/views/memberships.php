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
				<div class="col-lg-12 p-0 m-p-15">
					<div class="title">
						<h5 class="pull-left" style="padding: 15px 0;">Memberships</h5>

						<div class="clearfix"></div>
					</div><br />
				</div>
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one" style="border: 0; padding: 0px;">

						<div class="row">

							<div class="col-lg-12 col-xs-12">

								<div class="single-product shop-sidebar" style="padding: 100px 0px;">

									<div class="pricing-plan-list">
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

										<!--	<small class="pricing-plan__disclosure"></small>-->
											<ul class="pricing-plan__feature-list">
											    <li class="pricing-plan__feature">charged on a <?=$row->planPeriod?> basis</li>
												<li class="pricing-plan__feature"><?=$row->planOrders?> orders per <?=$row->planOrderPeriod?></li>
											</ul><br />
											<div class="col-md-12">
												<?php


												$subbb = 'inactive';
												if(isset($this->session_data->userId)) {
													$sss = $this->db->query('SELECT mpId, period_end FROM memberships WHERE userId='. $this->session_data->userId.' order by membershipId desc')->row();
													if($sss){
														if($sss->period_end >= strtotime(date('Y-m-d'))){ // subb is active
															$subbb = 'active';
														}
													}
												}
//echo $subbb;
                                                 if(isset($this->session_data->userId) && $this->response['membership_type']->mpId==$row->mpId) {
        												    if($this->membership_data->expire==false) {
        												        //date("F j, Y, g:i a", $this->response['membership_type']->period_end)
        												        echo '<p style="color:red;margin-bottom:18px">Current Package</p><p class="mb-13 fs-14"><strong class="fs-14">Renew Date:</strong>'. date("d F Y", $this->response['membership_type']->period_end).'</p>';
        												    }else{?>
        												        <input type="hidden" id="plan_price_<?php echo $row->mpId; ?>" value="<?=$row->planAmount-$bonus?>" />
									                           <!-- <a id="pay_<?php echo $row->mpId; ?>" href="javascript:;" onclick="process(this,<?php echo $row->mpId; ?>)" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a> -->
															   <a id="pay_<?php echo $row->mpId; ?>" href="<?php if($subbb=='active') echo 'script:;'; else echo base_url().'memberships/buy_memb/'.$row->mpId; ?>" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a>
        												    <?php }?>

												<?php }elseif(isset($this->session_data->userId)){?>
																<input type="hidden" id="plan_price_<?php echo $row->mpId; ?>" value="<?=$row->planAmount-$bonus?>" />
									                            <a style="<?php if($subbb=='active') echo 'background: #f3eded;pointer-events: none;'; ?>" id="pay_<?php echo $row->mpId; ?>" href="<?php if($subbb=='active') echo 'script:;'; else echo base_url().'memberships/buy_memb/'.$row->mpId; ?>" class="mt-39 tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two">BUY NOW</a>
												<?php }else{?>
									                           <a href="javascript:;" onclick="update_current_url(<?php echo $row->mpId; ?>)" class="tran3s custom-btn small-btn cart-button btn-pay block hvr-trim-two loginBtn">BUY NOW</a>
												<?php } ?>

												

											</div>

											<div class="col-md-12">
											<a href="javascript:;" onclick="find_out_more(<?php echo $row->mpId; ?>)" class="mt-39 tran3s primary-btn small-btn cart-button btn-pay block hvr-trim-two"> Find Out More </a>
											</div>

										</div>
										<?php } ?>

									</div>


									<script>


function update_current_url(plan_id){

        localStorage['plan_id'] = plan_id;
	
	// $.post("<?php echo base_url(); ?>memberships/update_current_url",{plan_id: plan_id},function(resp){ 
	// 					//res = JSON.parse(resp);
	// });
}

function find_out_more(id){

	$("#mem_text").text("About Monthly Membership");
	if(id==2){
		$("#mem_text").text("About Yearly Membership");
	}
	$("#FindOutMoreModal").modal("show");

}

									</script>


									<?php if(!$_SESSION["coupon_code"]){ ?>

										<?php if($code !=""){ ?>
										<!--	<div style="width: 100%">
												
												<div id="sec_add_coupon" class="col-md-12 " style="margin-top: 20px;padding:0px">
													<div class="col-md-2"></div>
													<div class="col-md-8 text-center" >
														
															<p class="mem-p">Limited time offer: 1 <?php echo $PlanDuration; ?> premium membership in £<?php echo $discounted_price; ?> with code: <b>"<?php echo $code; ?>" </b> </p>
														
														</br>
													</div>
													<div class="col-md-2 p-0">	
													</div>

												</div>

												<div class="col-md-12 " style="padding:0px">

												<div class="col-md-2"></div>
													<div class="col-md-8 text-center" >
														<input type="text" class="coupon-input" id="coupon_code"  value="<?php echo $code; ?>" />
														<input type="button" class="btn btn-primary  btn-pay" value="APPLY CODE" onclick="apply_discount()" 
														style="margin-top:0px;width: 20%; margin-left: 10px">
													</div>
													<div class="col-md-2 p-0">	
													</div>
												</div>
											</div>-->
										<?php } ?>

									<?php }else{ ?>


									<div style="width: 100%">
										
										<div class="col-md-12 " style="margin-top: 20px;padding:0px">

										<div class="col-md-2"></div>
										    <div class="col-md-8" style="float: right;">
												<a href="<?php echo base_url(); ?>memberships/remove_coupon"><input type="button" class="btn btn-primary pull-left btn-pay" value="REMOVE DISCOUNT CODE" style="margin-top:0px; margin-left: 10px;"></a>
											</div>
											<div class="col-md-2 p-0">	
											</div>
										</div>
									</div>

									<?php } ?>

									<div class="clearfix"></div>
								</div> <!-- /.single-product -->
							</div> <!-- /.col- -->

						</div> <!-- /.row -->
					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->





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
												top.location.href="<?=base_url('account?type=membership')?>";
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

				if(code != ""){

					$.post("<?php echo base_url(); ?>memberships/add_coupon",{code: code},function(resp){ 
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







<script>


$(document).ready(function($) 
  {  
	var plan_id = localStorage['plan_id'];
	if(plan_id){
		if(plan_id > 0){
			$("#pay_"+plan_id).trigger('click');
		}
	}
  }); 


var plan_id = '<?php echo $_GET['plan_id'] ?>';
if(plan_id > 0){
	$("#pay_"+plan_id).trigger('click');
}




</script>



</body>
</html>
