<!--<p class="text-center">
	<div class="trustpilot-widget" data-locale="en-US" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="5b0e69035aa2e3000110e0c2" data-style-height="52px" data-style-width="100%">
	  	<a href="https://www.trustpilot.com/review/www.kycagency.com" target="_blank">Trustpilot</a>
	</div>
</p>-->
<footer class="bg-one">
	<div class="container">
	    <div class="footer-logo">
					<a href="<?=base_url()?>"><img src="<?=base_url('assets/front/')?>images/logo/logo-footer.png" alt="Logo"></a>
				</div>
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12 footer-list ">
			
				<h4>Useful links</h4>
				<ul>
					<li><a href="<?php echo base_url(); ?>contact" class="tran3s">Contact Us</a></li>
					<li><a href="<?php echo base_url(); ?>blog" class="tran3s">Blog</a></li>
					<li><a href="<?php echo base_url(); ?>how_it_works" class="tran3s">How it Works</a></li>
					<li><a href="<?php echo base_url(); ?>faq" class="tran3s">FAQ</a></li>
					<li><a href="<?php echo base_url(); ?>terms_of_use" class="tran3s">Terms of Use</a></li>
					<li><a href="<?php echo base_url(); ?>refund" class="tran3s">Refunds & Returns</a></li>
					<li><a href="<?php echo base_url(); ?>privacy" class="tran3s">Privacy Policy</a></li>
				</ul>
		
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-list">
				<h4>Quick Links</h4>
				<ul>
					<!-- <li><a href="<?php echo base_url(); ?>tests/#all-tests" class="tran3s">Tests</a></li>
					<li><a href="<?php echo base_url(); ?>tests" class="tran3s">General Wellness</a></li>
					<li><a href="<?php echo base_url(); ?>tests" class="tran3s">Mens Health</a></li>
					<li><a href="<?php echo base_url(); ?>tests" class="tran3s">Womens Health</a></li>
					<li><a href="<?php echo base_url(); ?>tests" class="tran3s">DNA</a></li>
					<li><a href="<?php echo base_url(); ?>tests/#meal-prep" class="tran3s">Meal Prep</a></li>
					<li><a href="<?php echo base_url(); ?>tests/#gen-items" class="tran3s">General Items</a></li> -->



					
								<li><a href="<?=base_url('tests')?>" class="tran3s">All Tests</a></li>
							
								<?php $cat=$this->db->query('select * from categories WHERE categoryType="Tests"')->result();
								foreach ($cat as $cat_row){
								?>
									<li><a class="tran3s" href="<?=base_url('tests/index/'.$cat_row->catSlug)?>"><?=$cat_row->categoryName?></a></li>

								<?php } ?>
								<li><a class="tran3s" href="<?=base_url('tests/index/mealprep')?>">Meal Prep</a></li>
								<li><a class="tran3s" href="<?=base_url('tests/index/items')?>">General Items</a></li>
								
							


				</ul>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-list">
				<h4>How does it work</h4>
				<ul>
					<li><a href="<?php echo base_url(); ?>memberships" class="tran3s">Premium Membership</a></li>
					<li><a href="<?php echo base_url(); ?>corporate" class="tran3s">Corporate Packages</a></li>
					<li><a href="#customer-home"  class="tran3s">What Our Customers Say</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-subscribe">
				<h4>Follow Us</h4>
				<form action="#" style="display: none;">
					<input type="text" placeholder="Enter your mail">
				</form>
				<ul>
					<li><a href="javascript:;" class="tran3s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="javascript:;" class="tran3s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a href="javascript:;" class="tran3s"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					<!--<li><a href="javascript:;" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>-->
				</ul>
			</div>
		</div> <!-- /.row -->
		<div class="bottom-footer clearfix">
			<p class="float-left">&copy; 2018 <a href="javascript:;" class="tran3s p-color">Evergene</a>. All rights reserved</p>
		</div>
	</div> <!-- /.container -->
</footer>

<?php
	if(!isset($this->session_data->userId)) {
?>


	<!-- Sign-Up Modal -->
	<div id="signupModal" class="modal fade signupModal theme-modal-box" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h3>Signup</h3>
					<form id="frm_signup" action="<?=base_url('signup/process')?>" method="post">
						<div class="wrapper p-0">
						    <div class="row">
						        <div class="col-md-6">
    							    <input type="text" placeholder="First Name" name="userFirstName">
    							</div>
    							<div class="col-md-6">
    						    	<input type="text" placeholder="Last Name" name="userLastName">
    						    	</div>
							</div>
							<input type="email" placeholder="Email" name="userEmail">
							<div class="row">
						        <div class="col-md-6">
							        <input type="password" placeholder="Password" name="userPassword">
						    	</div>
						    	<div class="col-md-6">
						        	<input type="password" placeholder="Confirm Password" name="cuserPassword">
						        </div>
						    </div>
	                        <input type="text" id="datetime" data-date-format="DD-MM-YYYY" placeholder="Date of Birth"  name="userDob">
	                        <label>Gender</label><br />
	                        <label class="radio-inline">
	                          <input type="radio" style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio1" value="Male" checked=""> Male
	                        </label>
	                        <label class="radio-inline">
	                          <input type="radio" style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio2" value="Female"> Female
	                        </label>
	                       
	                        <?php if($this->uri->segment(1) == 'checkout'){ ?>
							<ul class="clearfix" >
								<li class="float-left"><a id="why_i_need_account"  style="font-size: small;" href="javascript:;" onclick="open_dialogue()"  class="p-color">Why do I need to create an account?</a></li>
							</ul>
							<?php } ?>

							<div>
							<span class="agree_msg" style="display: inline-flex;color:#000;margin-top:5px;line-height:26px"> 
							
								

								<?php if($this->uri->segment(1) == 'checkout'){ ?>
									<input type="checkbox" id="sign-up-checkbox" style="margin-right:3px;"> We will only use your email address to contact you about when results are available.</span>
									<!--<input type="checkbox" style="display: none" name="terms1" style="width: auto; height: auto;" value="1" checked="checked" /><span class="simple-text">I have read and agree to</span> <a target="_blank" href="<?php echo base_url(); ?>terms_of_use"> Terms and conditions.</a> </br> -->
								<?php }else{ ?>
									<span style="display: inline-flex;color:#000;margin-top:5px;width:100%;line-height:28px;">
									<input type="checkbox" id="sign-up-checkbox"> Agree to Evergene using the email addess to contact them about results.</span>
									</span>
									
								<?php } ?>

				            <span style="display: inline-flex;color:#000;margin-top:5px;width:100%;line-height:28px;">
					            <input type="checkbox" name="terms1" id="sign-up-checkbox2"   style="margin-left: -3px;" value="1"/><span class="simple-text">I have read and agree to</span> <a target="_blank" href="<?php echo base_url(); ?>terms_of_use"> Terms and conditions.</a> </br>
								
								</span>
								</br>
								
							</div>
							<input type="hidden" id="ref_inp" name="ref" value="">
							<button type="submit" class="p-bg-color hvr-trim-two">Signup</button>
							<div class="clearfix"></div>
							<button type="button"  class="hvr-trim-two loginBtn" style="background: #000000b3;margin-top: 10px;">Login</button>

						</div>
					</form>
				</div> <!-- /.modal-body -->
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.signUpModal -->

	<div id="loginModal" class="modal fade loginModal theme-modal-box" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<h3>Login</h3>
					<form id="frm_login" action="<?=base_url('login/process')?>" method="post">
							<!--	<h6><span>or</span></h6> -->
						<div class="wrapper">
							<input type="email" placeholder="Email" name="userEmail">
							<input type="password" placeholder="Password" name="userPassword">
							<ul class="clearfix">
							<!-- <li class="float-left"><a id="why_i_need_account" style="display: none" style="font-size: small;" href="javascript:;" onclick="open_dialogue()"  class="p-color">Why do I need to create an account?</a></li> -->
							<li class="float-right"><a href="javascript:;" onclick="forget()"  class="p-color" style="font-size: small;">Lost Your Password?</a></li>
							</ul>

							
							<!-- <div>
							<span style="display: inline-flex;" class="agree_msg"> Agree to Evergene using the email addess to contact them about results.</span>
								<input type="checkbox" name="terms1" style="width: auto; height: auto;" value="1"/><span class="simple-text">I have read and agree to</span> <a target="_blank" href="<?php echo base_url(); ?>terms_of_use"> Terms and conditions.</a> </br>
								
							</div> -->
							

							<button type="submit" class="p-bg-color hvr-trim-two">Login</button>
							<div class="clearfix"></div>
							
							<button type="button"  class="hvr-trim-two signupBtn" style="background: #000000b3;margin-top: 10px;">Create an Account</button>
						</div>
					</form>
				</div> <!-- /.modal-body -->
			</div> <!-- /.modal-content -->
		</div> <!-- /.modal-dialog -->
	</div> <!-- /.signUpModal -->
<?php
	}
?>

<!-- Scroll Top Button -->
<button class="scroll-top tran3s">
	<i class="fa fa-angle-up" aria-hidden="true"></i>
</button>

<div id="svag-shape">
	<svg height="0" width="0">
		<defs>
			<clipPath id="shape-one">
				<path fill-rule="evenodd"  fill="rgb(168, 168, 168)"
					  d="M343.000,25.000 C343.000,25.000 100.467,106.465 25.948,237.034 C-30.603,336.119 15.124,465.228 74.674,495.331 C134.224,525.434 212.210,447.071 227.280,432.549 C242.349,418.028 338.889,359.517 460.676,506.542 C582.737,653.896 725.650,527.546 751.000,478.000 C789.282,403.178 862.636,-118.314 343.000,25.000 Z"/>
			</clipPath>
		</defs>
	</svg>
</div>

<!-- j Query -->
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.2.2.3.min.js"></script>

<!-- Bootstrap Select JS -->
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/bootstrap-select/dist/js/bootstrap-select.js"></script>
<!-- Bootstrap JS -->
<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/bootstrap/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/core/custom.js" type="text/javascript"></script>
<script type = "text/javascript" src = "<?=base_url()?>assets/front/ex_js/moment.js"></script>
<script type = "text/javascript" src = "<?=base_url()?>assets/front/ex_js/bootstrap-datetimepicker.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback"></script>


<script type="text/javascript">
function phone_only(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
    && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

$('.phone_check').on('keyup', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
<?php if(!isset($this->session_data->userId)){ ?>
	$('.loginBtn').click(function () {

		$('#signupModal').modal('hide');
		$('#loginModal').modal('show');
	});
	$('.signupBtn').click(function () {

		$('#loginModal').modal('hide');
		$('#signupModal').modal('show');
	});
 $(document).ready(function($) 
  {  
     $("#datetime").datetimepicker({
        format: 'YYYY-MM-DD'
    });
  }); 
	<?php if(isset($_GET['ref']) && $_GET['ref']!=''){ ?>
			$('#ref_inp').val('<?=$_GET['ref']?>');
			$('#loginModal').modal('hide');
			$('#signupModal').modal('show');
	<?php } ?>

	// frm signup
	$('#frm_signup').submit(function()
	{

		var url = "<?php echo $_SESSION['current_url']; ?>";
		//window.location = url;
		
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
					if(response.code == 0)
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

										<?php

											if(isset($_SESSION['current_url'])){
												$url=$_SESSION['current_url'];
											}
											else{
												$url=base_url().'hub';
											}

											if(strpos($url, 'memberships') === false){ ?>

												window.location = "<?php echo $url;?>";
											
											<?php }else{ ?>

												$("#signupModal").modal('hide');
												location.reload();

											<?php }

										?>
										//console.log('<?php echo $url; ?>');
									   //window.location = "<?php echo $url;?>";
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
	$('#frm_login').submit(function()
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
					if(response.code == 0)
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
						<?php
							if(isset($_SESSION['current_url'])){
								$url=$_SESSION['current_url'];
							}
							else{
								$url=base_url().'hub';
							}
						?>
					   window.location = "<?php echo $url;?>";
						//location.reload();
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
	function forget(){
		$.confirm({
			title: 'Forget Password ?',
			content: '' +
			'<form id="forget_frm" action="<?php echo base_url(); ?>login/forget_access" class="formName">' +
			'<div class="form-group">' +
			'<label>Enter your e-mail address below to reset your password. </label>' +
			'<input type="email" name="userEmail" placeholder="Email" class="name form-control" required />' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'Submit',
					btnClass: 'btn-blue',
					action: function () {
						var name = this.$content.find('.name').val();
						var fself = this;
						if(!name){
							$.alert('provide a valid Email');
							return false;
						}
						else
						{
							var frm=$('#forget_frm');
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
											fself.close();
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
															this.close();
														}
													}
												}
											});
										}
									}).fail(function(){
										fself.close();
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
						}

					}
				},
				cancel: function () {
					//close
				},
			}
		});
	}
<?php } ?>

function open_dialogue(){
	$.confirm({
		title: 'why do I need to create an account?',
		content: 'It is important to have the members basic details to enable you to order health tests on the site.',
		type: 'green',
		typeAnimated: true,
		buttons: {
			close: function () {
			}
		}
	});
}

</script>












<div id="ErrorModal" class="modal fade loginModal theme-modal-box" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body" style="height: 150px;">
				<h3>Session Expiring</h3>
				<div class="wrapper">
					<p id="err_text">Your session is expiring in 1 minute</p>
					<input id="updated_timout_value" type="hidden" value="0" />
					<button onclick="cancel_logout()" type="button" class="btn btn-primary" style="float: right; color: #fff;background-color: #337ab7;border-color: #2e6da4;}">Keep Session</button>
				</div>
			</div> <!-- /.modal-body -->
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.ErrorModal -->



<div id="FindOutMoreModal" class="modal fade loginModal theme-modal-box" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body" style="height: 150px;">
				<h3>Plan</h3>
				<div class="wrapper">
					<p id="mem_text" style="text-align: center">About Monthly Membership</p>
					
				</div>
			</div> <!-- /.modal-body -->
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.ErrorModal -->



<script type="text/javascript">
var idleTime = 0;
timer_func=0;
$(document).ready(function () {
    //Increment the idle time counter every minute.
	<?php if (isset($this->session_data->userId)){ ?>
		var idleInterval = setInterval(timerIncrement, 60000); // 1 minute = 60000
		//var idleInterval = setInterval(timerIncrement, 3300000); // 1000 = 1 sec, 60000(1 minut)*55 = 3300000
	<?php } ?>


    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
		$(this).mousemove(function (e) {});
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
	
    idleTime = idleTime + 1;
	$("#updated_timout_value").val(idleTime);
	console.log(idleTime);
    if (idleTime > 4) { // 4 minutes  //55
        //window.location.reload();

		$("#err_text").text("session is expiring in 1 minutes! You will be logout in 60 seconds");
        $("#ErrorModal").modal("show");
		var i = 60;  //set the countdown
		 (function timer(){
			if (--i <= 0) window.location.href = "<?php echo base_url(); ?>logout";;
			timer_func = setTimeout(function(){
				//console.log(i + ' secs');  
				$("#err_text").text("session is expiring in 1 minutes! You will be logout in "+i+" seconds");//do stuff here
				//if(idleTime < 2){ clearTimeout(timer_func); }
				//if($("#updated_timout_value").val() < 2 ){ clearTimeout(timer_func); }
				if(i>0){ timer(); }

			}, 1000);

		})();
		
        
    }
    
    // if(idleTime > 59){ // 61 = 61 minutes
    //     //alert("redirect to login automatically after 60 minutes!");
	// 			window.location.href = "<?php echo base_url(); ?>logout";
    // }
}


function hide_top_bar(){

	$("#top_bar_offer").hide();

	$.post("<?php echo base_url(); ?>memberships/hide_top_bar",function(resp){ 
					
		console.log(resp);
									
	});

}

function cancel_logout(){
	location.reload();
}


//function hide_why_i_need_account(){
//	$("#why_i_need_account").hide();
//	$(".agree_msg").text("Agree to Evergene using the email addess to contact them about results.");
//}
</script> 
