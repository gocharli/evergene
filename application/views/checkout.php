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
					<h5 class="pull-left" style="padding: 15px 0;">Checkout</h5>
					<?php if($this->membership_data->expire) { ?>
					<a href="<?=base_url('memberships')?>" class="tran3s custom-btn small-btn pull-right">Upgrade to Premium</a>
					<?php }else{
 						$month_number=date('m');
						$year=date('Y');
						$available_orders=$this->db->query('select sum(detailQty) as total from order_details WHERE userId='.$this->session_data->userId.'  
                        AND regularType="One Time" AND paymentType="Membership" AND YEAR(membershipDate)='.$year.'  AND MONTH(membershipDate)='.$month_number)->row();
						if($this->membership_data->orders>0)
						{

							if($available_orders)
							{
								$available_orders=$this->membership_data->orders-$available_orders->total;
							}
							else
							{
								$available_orders=$this->membership_data->orders;
							}
							if($available_orders<1)
							{
								$available_orders=0;
							}
						}
						else
						{
							$available_orders=0;
						}
						$cart=$this->cart->contents();
						/*foreach ($cart as $item)
						{
							if ($item['options']['membershipDate'] != '')
							{
								if(strtotime(date('Y-m',strtotime($item['options']['membershipDate']))) == strtotime($year.'-'.$month_number))
								{
									$available_orders-=$item['qty'];
								}
							}
						}*/
						?>
					<a href="<?=base_url('orders')?>" class="tran3s custom-btn small-btn pull-right"> <span style="display: block;width: 100%;height: 20px;"><?=$available_orders?>/<?=$this->membership_data->orders?> orders this month </span> <span>Renewal Date : <?=date('Y-m-d',$this->membership_data->period_end)?></span> </a>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div> <br />
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">
						<div class="row">
							<div class="col-lg-6 col-xs-6">



								<div class="single-product shop-sidebar">
									<div class="product-header">
										<h6 style="margin: 0px;">Shipping Address
										</h6>
										<div class="clearfix"></div>
									</div><!--product header-->

									<div class="single-service m-bottom0">
							<form id="frm_checkout" action="<?=base_url('checkout/process_payment')?>">
										<div class="form-group">
											<label>Email</label>
											<input type="text" class="form-control" id="inp_orderEmail" name="orderEmail" value="<?php if(isset($_POST['orderEmail'])){ echo $_POST['orderEmail']; }else{ if(isset($this->session_data)){ echo $this->session_data->userEmail; } } ?>">
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-md-6 col-xs-12">
													<label>First Name</label>
													<input type="text" name="first_name" id="inp_first_name" class="form-control" value="<?php if(isset($_POST['first_name'])){ echo $_POST['first_name']; }else{ if(isset($this->session_data)){ echo $this->session_data->userFirstName; } } ?>">
												</div>
												<div class="span1"></div>
												<div class="col-md-6 col-xs-12">
													<label>Last Name</label>
													<input type="text" name="last_name" id="inp_last_name" class="form-control" value="<?php if(isset($_POST['last_name'])){ echo $_POST['last_name']; }else{ if(isset($this->session_data)){ echo $this->session_data->userLastName; } } ?>">
												</div>
												<div class="clearfix"></div>
											</div>
										</div>

										<div class="form-group">
											<label>Phone Number</label>
											<input type="text" class="form-control" id="inp_orderPhone"  name="orderPhone" onkeypress="return isNumber(event)" value="<?php if(isset($_POST['orderPhone'])){ echo $_POST['orderPhone']; }else{ if(isset($this->session_data)){ echo $this->session_data->userPhone; } } ?>">
										</div>
										<div class="form-group">
											<label>Address 1</label>
											<input type="text" class="form-control" id="inp_orderShipAddress" name="orderShipAddress" value="<?php if(isset($_POST['orderShipAddress'])){ echo $_POST['orderShipAddress']; }else{ if(isset($this->session_data)){ echo $this->session_data->user_address1; } } ?>" />
										</div>
                                        <div class="form-group">
											<label>Address 2</label>
											<input type="text" class="form-control" id="inp_orderShipAddress2" name="orderShipAddress2" value="<?php if(isset($_POST['orderShipAddress2'])){ echo $_POST['orderShipAddress2']; }else{ if(isset($this->session_data)){ echo $this->session_data->user_address2; } } ?>" />
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label>City</label>
													<input type="text" class="form-control" id="inp_orderCity" name="orderCity" value="<?php if(isset($_POST['orderCity'])){ echo $_POST['orderCity']; }else{ if(isset($this->session_data)){ echo $this->session_data->user_city; } } ?>" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label>Country</label>
													<input type="text" class="form-control" id="inp_orderState" name="orderState" value="<?php if(isset($_POST['orderState'])){ echo $_POST['orderState']; }else{ if(isset($this->session_data)){ echo $this->session_data->user_country; } } ?>" />
												</div>
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
													<label>Postcode</label>
													<input type="text" class="form-control" onblur="isPostal(this)" placeholder="HA8 5HG" id="orderPostalCode" name="orderPostalCode" value="<?php if(isset($_POST['orderPostalCode'])){ echo $_POST['orderPostalCode']; }else{ if(isset($this->session_data)){ echo $this->session_data->user_post_code; } } ?>" style="text-transform: uppercase" />
												</div>
												<div class="clearfix"></div>
											</div>
										</div>
										
									</div>
									<div class="clearfix"></div>
								</div> <!-- /.single-product -->
								<!-- <div class="single-product shop-sidebar">
									<div class="product-header">
										<h6 style="margin: 0px;">Scheduled orders <br />
                                        <small style="display: none;">Pay later orders can be checked and paid by visiting pending orders section in your account page.</small>
                                        </h6>
										<div class="clearfix"></div>
									</div>

									<div class="single-service m-bottom0">

										<div class="shopping-cart">
                                            <div class="item">                                            
                                                 <div class="description" style="width: 45%;font-size: 15px;font-weight: bold;">Title</div>
    											 <div class="total-price" style="width: 10%;font-size: 15px;font-weight: bold;">Qty</div>
    										   	 <div class="total-price" style="width: 30%;font-size: 15px;font-weight: bold;">Scheduled</div>
                                            </div>
											<?php
                                           $empty=0;
                                     
											if($cart_data_new){

												foreach ($cart_data_new as $k=>$item){
												        if($item['options']['membershipStatus']=='Active')
                                                        {
                                                            $qqty=0;
                                                            if(count($item['scheduleDate'])<2)
                                                            {
                                                                continue;
                                                            }
													        $empty=1;
														?>
														<div class="item" id="row_<?=$k?>">
															<div class="description" style="width: 35%;">
																<span><?php echo $item['name']; ?></span>
																<span><?php echo $item['options']['productType']; ?></span>
															</div>
															<div class="total-price" style="width: 10%;"><?php echo $item['qty']-1;  ?></div>
															<div class="total-price" style="width: 25%;">
                                                            
                                                             <?php $kkk=1;
                                                              foreach($item['scheduleDate'] as $sd){ 
                                                                if($kkk!=1){
                                                                $qqty++;
                                                                echo date('M d, Y',strtotime($sd)); ?> <br />
                                                                
                                                                <?php } 
                                                                $kkk++;
                                                                } ?>                                                            
                                                            
                                                            </div>

														</div>
													<?php }
												} 
                                                ?>
                                                
                                                
									    	<?php //}	}
                                            } else { ?>
                                            <p class="text-center" style="margin-top: 20px;">No Record Found</p>
                                      <?php }       ?>
										</div>


										<div class="clearfix"></div>
									</div> 


								</div> -->


							</div>

							<div class="col-lg-6 col-xs-6">

								<div class="single-product shop-sidebar">
									<div class="product-header">
										<h6 style="margin:0px;">Order Summary</h6>
										<div class="clearfix"></div>
									</div><!--product header-->

									<div class="single-service">

										<div class="shopping-cart">
											<!-- Product #1 -->
                                            <div class="item">                                            
                                                 <div class="description" style="width: 20%;font-size: 15px;font-weight: bold;">Title</div>
    											 <div class="total-price" style="width: 10%;font-size: 15px;font-weight: bold;">Qty</div>
    										   	 <div class="total-price" style="width: 25%;font-size: 15px;font-weight: bold;">Schedule Date</div>
                                                 <div class="total-price" style="width: 15%;font-size: 15px;font-weight: bold;">Price</div>
    										     <div class="total-price" style="width: 15%;font-size: 15px;font-weight: bold;">Action</div>
                                            </div>
											<?php
                                           //echo '<pre>';
                                            //print_r($cart_data_new);
                                          //  exit();
											if($cart_data_new){
												function sortByOrder1($a, $b) {
													return $b['price'] - $a['price'];
												}
												usort($cart_data_new, 'sortByOrder1');
												$grand = 0;
                                                $sub_total=0;
                                                $total=0;
                                                $finalTotal =0;
                                                $totalItems = count($cart_data_new);
                                                $i=1;
											foreach ($cart_data_new as $key=>$item){
											 
											     if($item['payDebit']=='No')
                                                 {
                                                    $grand = $grand + ($item['qty']*$item['price']);
                                                    $sub_total=$item['qty']*$item['price'];
                                                    $qqty=$item['qty'];
                                                 }
                                                 else
                                                 {
                                                    $grand = $grand + $item['price'];
                                                    $sub_total=$item['price'];
                                                    $qqty=1;
                                                 }
                                                // echo $grand;
                                                 //echo $sub_total;
                                                 
                                                 //Updated Code/////////////////////////
                                                 
                                                  $Cday=date('m',strtotime($item['scheduleDate'][0]));
						                          $Cyear=date('Y',strtotime($item['scheduleDate'][0]));  
                                                  $date1= $Cday."-".$Cyear;
                                                  $startMonth=date('m',strtotime('now'));
                                                  $startYear=date('Y',strtotime('now'));   
                                                  $date2= $startMonth."-".$startYear;  
                                                  if($date1 == $date2)
                                                  {
                                                    if($item['qty'] > 1)
                                                    {
                                                        if($item['options']['membershipStatus'] == "Active")
                                                        {
                                                            if($item['options']['paymentType'] == "Membership")
                                                            {
                                                                $sub_total  =  $item['price'];
                                                                //$grand = $grand + $item['price'];
                                                                $grand = $grand + $item['price'];
                                                            }
                                                        }
                                                    }
                                                  }
                                                  if($date1 == $date2)
                                                  {
                                                    if($item['qty'] > 1)
                                                    {
                                                        if($item['options']['membershipStatus'] == "Active")
                                                        {
                                                            if($item['options']['paymentType'] == "Full Price")
                                                            {
                                                                $sub_total  =  $item['price'];
                                                                //$grand = $grand + $item['price'];
                                                                $grand = $grand + $item['price'];
                                                            }
                                                        }
                                                    }
                                                  }
                                                  //echo $grand;
                                                  
                                                  /// Updated Code ////////////////////////
                                                                           
                                                 
												?>
													<div class="item" id="row_<?= $item['options']['ref']?>">
														<div class="description" style="width: 20%;">
															<span><?php echo $item['name']; ?></span>
															<span><?php echo $item['options']['productType']; ?></span>
														</div>
                                                        <?php
                                                        /// Updated Code ////////////////////////
                                                        if($item['options']['membershipStatus'] == "Active")
                                                        {
                                                          // echo $item['options']['regularType'];
                                                          // echo $item['options']['paymentType'];
                                                            
                                                            if($item['options']['paymentType'] == "Membership" && $item['options']['regularType'] == "payFull")
                                                            {
                                                                
                                                                $qqty = $item['qty'];
                                                            }
                                                            if($item['options']['paymentType'] == "Membership" && $item['options']['regularType'] != "payFull")
                                                            {
                                                                
                                                                $qqty = $item['qty'];
                                                            }
                                                            if($item['options']['paymentType'] == "Membership" && $item['options']['regularType'] == "One Time")
                                                            {
                                                                
                                                                $qqty = $item['qty'];
                                                            }
                                                            if($item['options']['paymentType'] == "Full Price")
                                                            {
                                                                
                                                                $qqty = $item['qty'];
                                                            }
                                                        }
                                                        
                                                        
                                                      //  echo $i;
                                                          if($item['options']['regularType'] == "Month" || $item['options']['regularType'] == "Quarterly" 
                                                        || $item['options']['regularType'] == "Semi Annually" ) { 
                                                           // echo "c".$total;
                                                          //  echo "c".$sub_total;
                                                            
                                                           // $qqty = 1;
                                                            $total = $item['price']*$item['qty'];
                                                           // echo "a".$total;
                                                            
                                                         } else {
                                                           // echo $item['price']*$item['qty'];
                                                            $total = $item['price']*$item['qty'];
                                                          //  echo "b".$total;
                                                         } 
                                                         
                                                 
                                                         $finalTotal = $finalTotal + $total;
                                                         
                                                        
                                                      //  echo $item['options']['regularType'];
                                                        //echo $item['options']['paymentType'];
                                                          /// Updated Code ////////////////////////
                                                         ?>
                                                        
														<div class="total-price" style="width: 10%;"><?php echo $qqty;  ?></div>
														<div class="total-price" style="width: 25%;"><?php echo date("d-m-Y", strtotime($item['scheduleDate'][0]));//echo date('d F Y',strtotime($item['scheduleDate'][0])); ?></div>
                                                        <?php if($item['options']['regularType'] == "Month" || $item['options']['regularType'] == "Quarterly" 
                                                        || $item['options']['regularType'] == "Semi Annually" ) {
                                                            //echo $total;
                                                            ?>
														<div class="total-price" style="width: 15%;">£<?php echo number_format($total,2); ?></div>
                                                        <?php } else { ?>
                                                       	<div class="total-price" style="width: 15%;">£<?php echo number_format($total,2); ?></div>
                                                        <?php } ?>

														<div class="total-price" style="width: 15%;">
															<a href="javascript:;" class="tran3s custom-btn small-btn hvr-trim-two" id="checkout-custombtn" onclick="del('<?= $item['options']['ref'];?>')"><span class="fa fa-trash-o"></span> </a>
														</div>
													</div>
												<?php
											 $i++;
												
												}
											}else{ ?>
											<div class="alert alert-warning" role="alert">
												<b>Cart</b>  is empty</div>
											<?php	}?>
										</div>
										<div class="clearfix"></div>
									</div> <!-- /.single-product -->

									<div class="alert alert-warning" role="alert" >
										<?php
										if($cart_data){ ?>
										<b>Sub Total </b> &nbsp; £<span class="payNow_span"><?=number_format($finalTotal,2)?></span>
										<br>
									
									<!--	<b>Referral Discount </b> 
                                         £<span class="discount_span"><?php // number_format($discount,2) ?></span>-->
											
											<b>Total </b> &nbsp; £<span class="total_span"><?php  $ftotal=$finalTotal-$discount; echo number_format($ftotal,2);?></span>
									
										</div>
										<?php } ?>
									</div>

									<div>
											<!-- <input type="checkbox" name="terms1" value="1"/><span class="simple-text">I have read and agree to</span> <a href="#"> Terms and conditions.</a> </br> -->
											<!-- <span style="display: inline-flex;"><input type="checkbox" name="terms2" value="1" /> <a  class="simple-text">We will only use your email address to contact you about when results are available.</a></span> -->
											<span style="display: inline-flex;"><input type="checkbox" name="terms2" value="1" /> <a  class="simple-text">I want to receive emails including special offers and Evergene news.</a></span>
									</div>

								<button type="button" onclick="pay()" class="tran3s cart-button btn-pay block hvr-trim-two">PAY NOW</button>
								</form>

							</div> <!-- /.col- -->

						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->
    <form id="hdn_frm_checkout" method="POST">
        <input type="hidden" id="hd_orderEmail" name="orderEmail" >
        <input type="hidden" id="hd_first_name" name="first_name" >
        <input type="hidden" id="hd_last_name" name="last_name" >
        <input type="hidden" id="hd_orderPhone" name="orderPhone" >
        <input type="hidden" id="hd_orderShipAddress" name="orderShipAddress" >
        <input type="hidden" id="hd_orderShipAddress2" name="orderShipAddress2" >
        <input type="hidden" id="hd_orderCity" name="orderCity" >
        <input type="hidden" id="hd_orderState" name="orderState" >
        <input type="hidden" id="hd_orderPostalCode" name="orderPostalCode" >
    </form>
	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script type="text/javascript">

		
		function del(rid)
		{
			$.confirm({
				title: 'Status!',
				content: 'Are you want to delete ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Yes: {
						text: 'Yes',
						btnClass: 'btn-red',
						action: function(){

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function () {
									var self = this;
									return $.ajax({
										url: "<?php echo base_url(); ?>cart/delete_item",
										dataType: 'json',
										data:{id:rid},
										method: 'post'
									}).done(function (response) {
										self.close();
										if(response.code==0)
										{
											error_box(response.message,5000);
										}
										else
										{
										  $('#hd_orderEmail').val($("#inp_orderEmail").val());
                                          $('#hd_first_name').val($("#inp_first_name").val());
                                          $('#hd_last_name').val($("#inp_last_name").val());
                                          $('#hd_orderPhone').val($("#inp_orderPhone").val());
                                          $('#hd_orderShipAddress').val($("#inp_orderShipAddress").val());
                                          $('#hd_orderShipAddress2').val($("#inp_orderShipAddress2").val());
                                          $('#hd_orderCity').val($("#inp_orderCity").val());
                                          $('#hd_orderState').val($("#inp_orderState").val());
                                          $('#hd_orderPostalCode').val($("#orderPostalCode").val());
                                          document.getElementById("hdn_frm_checkout").submit();
                                          

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

						}
					},
					No: function () {
					}
				}
			});

		}
		function pay()
		{
			$(".agree_msg").html("<span style='display: inline-flex;'><input type='checkbox' name='terms2' id='sign-up-checkbox2' value='1' />We will only use your email address to contact you about when results are available.</span>");
			$("#why_i_need_account").show();
			$("#why_i_need_account").css("font-size", "small");
			var frm=$('#frm_checkout');
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: '<?=base_url('checkout/chk')?>',
						dataType: 'json',
						data:frm.serialize(),
						method: 'post'
					}).done(function (response) {
					   console.log(response.message);
						self.close();
						if(response.code === 2 )
						{  //login
							//$('#loginModal').modal('show');
							$('#signupModal').modal('show');
						}
						else if(response.code===0)
						{ //error
							error_box(response.message);
						}
						else
						{
							if(response.message>0)
							{//get payment //
								var total_g=response.message;
								var title='Checkout';
								var total=total_g*100;
								handler.open({
									name: title,
									description: 'Charges( £'+total_g+' )',
									currency : 'GBP',
									amount: total
								});
							}
							else
							{
							 
								$.confirm({
									icon: 'fa fa-spinner fa-spin',
									title: 'Working!',
									content: function () {
										var self = this;
										return $.ajax({
											url: '<?=base_url('checkout/process')?>',
											dataType: 'json',
											data:frm.serialize(),
											method: 'post'
										}).done(function (response) {
											self.close();
											if(response.code==0)
											{
												error_box(response.message,10000);
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
																top.location.href='<?=base_url('orders')?>';
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
							}

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
		}
		var handler = StripeCheckout.configure
		({
			key: '<?=getenv('stripe_api_key')?>',
			image: '<?php echo base_url(); ?>assets/stripelogo.png',
			token: function(token)
			{
				$('#frm_checkout').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
				var frm=$('#frm_checkout');
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
								error_box(response.message,10000);
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
												top.location.href='<?=base_url('orders')?>';
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


			}
		});

		window.addEventListener('popstate', function() {
			handler.close();
		});


		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}
		function isPostal(evt) {
			var value = evt.value;
			if(/^[a-zA-Z]{1,2}([0-9]{1,2}|[0-9][a-zA-Z])\s*[0-9][a-zA-Z]{2}$/i.test(value))
			{

			}
			else
			{
				error_box('Postcode not valid');
			}
		}
	</script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
