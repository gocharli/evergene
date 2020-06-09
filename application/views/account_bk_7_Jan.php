<?php $this->load->view('includes/head');   ?>
</head>

<body>
<div class="main-page-wrapper">
	<?php $this->load->view('includes/menu');   ?>
	<div class="inner-page-banner">
		<div class="opacity header-product-detail">
		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->
	<div class="shop-page hub-page portfolio-details full-width">
		<div class="row">
			<div class="p-0 m-p-15">
				<div class="title-head">
					<h5 class="pull-left" style="padding: 15px 0;">General Setting</h5>
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
				<div class="shop-product-wrapper service-version-one" style="min-height: 465px;">
					<div class="row">
						<div class="single-product shop-sidebar">
							<div class="product-header">
								<div class="clearfix"></div>
							</div><!--product header-->
							<div class="single-service m-bottom0" style="min-height: 680px;">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#a_profile">Profile</a></li>
									<li><a data-toggle="tab" href="#a_change_password">Change Password</a></li>
									<li><a data-toggle="tab" id="clk_membership" href="#a_membership">Your membership</a></li>
								</ul>
								<div class="tab-content" style="margin-top: 15px;">
									<div id="a_profile" class="tab-pane fade in active">
										<div class="col-lg-8 col-sm-12 col-xs-8 col-lg-offset-2">
											<div class="single-service m-bottom0">
												<form id="frm_1" action="<?php echo base_url(); ?>account/process" method="post">
														<div class="form-group">
															<label>First Name</label>
															<input type="text" class="form-control"  name="userFirstName"   value="<?=$row->userFirstName?>">
														</div>
														<div class="form-group">
															<label>Last Name</label>
															<input type="text" class="form-control"  name="userLastName"   value="<?=$row->userLastName?>">
														</div>
														<div class="form-group">
															<label>Email</label>
															<input type="text" class="form-control"  name="userEmail"   value="<?=$row->userEmail?>" readonly>
														</div>
														<div class="form-group">
															<label>Address 1</label>
															<textarea id="address1" name="address1" class="form-control"><?=$row->user_address1?></textarea>
														</div>
														<div class="form-group">
															<label>Address 2</label>
															<textarea id="address2" name="address2" class="form-control"><?=$row->user_address2?></textarea>
														</div>
														<div class="row">
															<div class="col-lg-4">
																<div class="form-group">
																	<label>City</label>
																	<input type="text" class="form-control" name="userCity" value="<?=$row->user_city?>">
																</div>
															</div>
															<div class="col-lg-4">
																<div class="form-group">
																	<label>Country</label>
																	<input type="text" class="form-control" name="userCountry" value="<?=$row->user_country?>">
																</div>
															</div>
															<div class="col-lg-4">
																<div class="form-group">
																	<label>Post Code</label>
																	<input type="text" class="form-control" name="userPostCode" value="<?=$row->user_post_code?>">
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>Phone</label>
															<input type="text" class="form-control phone_check" onkeypress="return phone_only(event)"  name="userPhone"   value="<?=$row->userPhone?>">
														</div>
                                                        <div class="form-group">
															<label>Date of Birth</label>
															<input id="datetime" type="text" class="form-control"  name="userDob"   value="<?=$row->userDob?>">
														</div>
                                                        
                                                         <div class="form-group">														
                                                            <label>Gender</label><br />
                                                            <label class="radio-inline">
                                                              <input type="radio" <?php if($row->userGender=='Male') { echo 'checked=""'; } ?> style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio1" value="Male" checked=""> Male
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" <?php if($row->userGender=='Female') { echo 'checked=""'; } ?> style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio2" value="Female"> Female
                                                            </label>
                                                       	</div>
                                                        
														<div class="form-group">
															<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two">Update</button>
														</div>
													</form>
											</div>
										</div> <!-- /.col- -->
									</div>
									<div id="a_change_password" class="tab-pane fade">
										<div class="col-lg-6 col-xs-6 col-lg-offset-3">
											<div class="single-service m-bottom0">
												<form id="frm_change_password" action="<?=base_url()?>account/password_code">
													<div class="form-group">
														<label>Old Password</label>
														<input type="password" class="form-control"  name="password" autocomplete="off"  value="">
													</div>
													<div class="form-group">
														<label>New Password</label>
														<input type="password" class="form-control" name="new_password" autocomplete="off" value="" />
													</div>
													<div class="form-group">
														<label>Confirm Password</label>
														<input type="password" class="form-control" name="c-password" autocomplete="off" value="" />
													</div>
													<div class="form-group">
														<button type="submit" class="tran3s cart-button btn-pay block hvr-trim-two">Change Password</button>
													</div>
												</form>
											</div>

										</div> <!-- /.col- -->
									</div>
									<div id="a_membership" class="tab-pane fade">
										<div class="col-lg-12 col-xs-12">

											<div class="single-product">


												<div class="product-list mb-2">

													<div class="row">

														<a href="<?=base_url()?>memberships" class="order-again">Membership</a>


														<div class="col-lg-9">
															<?php if($membership){
																$currnet=strtotime('now');
																?>
																<div class="results-info-list">
																	<ul class="clearfix">
																		<li>
																			<span class="heading"><?php echo $membership->planTitle; ?> MemberShip:</span>
																			<span class="detail">£ <?php echo $membership->planAmount; ?> / <?php echo $membership->PlanDuration; ?></span>
																			<div class="clearfix"></div>
																		</li>
																		<li>
																			<span class="heading">Period Start Date :</span>
																			<span class="detail"><?php echo date('F j, Y, g:i a',$membership->period_start); ?></span>
																			<div class="clearfix"></div>
																		</li>
																		<li>
																			<span class="heading">Period End Date :</span>
																			<span class="detail"><?php echo date('F j, Y, g:i a',$membership->period_end); ?></span>
																			<div class="clearfix"></div>
																		</li>
																		<li>
																			<span class="heading">Created Date :</span>
																			<span class="detail"><?php echo date('F j, Y, g:i a',strtotime($membership->createdAt)); ?></span>
																			<div class="clearfix"></div>
																		</li>
																		<li>
																			<span class="heading">Orders :</span>
																			<span class="detail"><?php echo $membership->planOrders; ?>/<?php echo $membership->planOrderPeriod; ?></span>
																			<div class="clearfix"></div>
																		</li>
																		<?php $tchk=0; if($membership->StripeSubscriptionEnded>0){  $tchk=1; ?>
																			<li>
																				<span class="heading">Subscription End :</span>
																				<span class="detail"><?php echo date('F j, Y, g:i a',$membership->StripeSubscriptionEnded); ?></span>
																				<div class="clearfix"></div>
																			</li>
																		<?php } ?>
																		<?php  if($currnet< $membership->period_end)
																		{
																			if($tchk==0) {
																				?>
																				<button class="tran3s cart-button btn-pay block hvr-trim-two" href="javascript:;" onclick="cancel()">Cancel Subscription</button>
																				<?php
																			} }else{
																			?>
																			<p style="text-align: center;">Your current membership is expired kindly visit our member ship page to renew your memberships <a style="color: #fb821e;" href="<?php echo base_url(); ?>memberships">Memberships</a>.</p>
																		<?php } ?>

																	</ul>
																</div> <!-- /.results list -->
															<?php }else { ?>
																<p style="text-align: center;">Currently you are not subscribed with any of our packages. Please click here to get membership packages <a style="color: #fb821e;" href="<?php echo base_url(); ?>memberships">Memberships</a>.</p>
															<?php } ?>

														</div><!-- /.col- -->
														<div class="clearfix"></div>
													</div>
												</div><!--product list-->



												<div class="clearfix"></div>
											</div> <!-- /.single-product -->

										</div> <!-- /.col- -->
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div> <!-- /.single-product -->


					</div> <!-- /.row -->

				</div> <!-- /.shop-product-wrapper -->
			</div>
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->

	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
  $(document).ready(function($) 
  {  
     $("#datetime").datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    <?php if(isset($_GET['type'])){ ?>
        $('#clk_membership').click();
    <?php } ?>
    
  }); 
	$('#frm_1').submit(function()
	{
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
					if(response.code==0)
					{
						$.confirm({
							title: 'Error!',
							icon:  'fa fa-warning',
							closeIcon: true,
							content: response.message,
							type: 'red',
							autoClose: 'close|5000',
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
							autoClose: 'ok|5000',
							typeAnimated: true,
							buttons: {
								ok: {
									text: 'Ok',
									btnClass: 'btn-green',
									action: function(){
										location.reload();
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
		return false;
	});
	$('#frm_change_password').submit(function()
	{
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
										frm[0].reset();
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
		return false;
	});
	</script>
	<script type="text/javascript" >
		function  cancel() {
		  
          swal({
              title: "Are you sure?",
              text: "You want to cancel subscription?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
               		$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function () {
					var self = this;
					return $.ajax({
						url: '<?php echo base_url(); ?>account/cancel_membership',
						dataType: 'json',
						method: 'get'
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
											location.reload();
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
              } else {
                swal("Your subscription is safe!");
              }
            });
          
          
	
            
            
		}
	</script>
	<?php $this->load->view('includes/scripts'); ?>
</div> <!-- /.main-page-wrapper -->
</body>
</html>
