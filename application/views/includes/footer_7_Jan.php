<p class="text-center">
	<div class="trustpilot-widget" data-locale="en-US" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="5b0e69035aa2e3000110e0c2" data-style-height="52px" data-style-width="100%">
	  	<a href="https://www.trustpilot.com/review/www.kycagency.com" target="_blank">Trustpilot</a>
	</div>
</p>
<footer class="bg-one">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="footer-logo">
					<a href="<?=base_url()?>"><img src="<?=base_url('assets/front/')?>images/logo/logo-footer.png" alt="Logo"></a>
					<h5><a href="mailto:evergene@gmail.com" class="tran3s">evergene@gmail.com</a></h5>
					<h6 class="p-color"><a style="color: black;" href="javascript:;">111-222-3333</a></h6>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-list">
				<h4>Quick Links</h4>
				<ul>
					<li><a href="#" class="tran3s">How it Works</a></li>
					<li><a href="#" class="tran3s">Guarantee</a></li>
					<li><a href="#" class="tran3s">Security</a></li>
					<li><a href="#" class="tran3s">Report Bug</a></li>
					<li><a href="#" class="tran3s">Pricing</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6 col-xs-12 footer-list">
				<h4>About Us</h4>
				<ul>
					<li><a href="#" class="tran3s">About Singleton</a></li>
					<li><a href="#" class="tran3s">Jobs</a></li>
					<li><a href="#" class="tran3s">Team</a></li>
					<li><a href="#" class="tran3s">Testimonials</a></li>
					<li><a href="<?=base_url('blog')?>" class="tran3s">Blog</a></li>
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
					<li><a href="javascript:;" class="tran3s"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
					<li><a href="javascript:;" class="tran3s"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div> <!-- /.row -->
		<div class="bottom-footer clearfix">
			<p class="float-left">&copy; 2018 <a href="#" class="tran3s p-color">Evergene</a>. All rights reserved</p>
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
						<div class="wrapper">
							<input type="text" placeholder="First Name" name="userFirstName">
							<input type="text" placeholder="Last Name" name="userLastName">
							<input type="email" placeholder="Email" name="userEmail">
							<input type="password" placeholder="Password" name="userPassword">
	                        <input type="text" id="datetime" data-date-format="DD-MM-YYYY" placeholder="Date of Birth"  name="userDob">
	                        <label>Gender</label><br />
	                        <label class="radio-inline">
	                          <input type="radio" style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio1" value="Male" checked=""> Male
	                        </label>
	                        <label class="radio-inline">
	                          <input type="radio" style="width: auto !important; height:auto !important;" name="userGender" id="inlineRadio2" value="Female"> Female
	                        </label>
	                       
	                        
							<ul class="clearfix">
							</ul>
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
								<li class="float-right"><a href="javascript:;" onclick="forget()"  class="p-color">Lost Your Password?</a></li>
							</ul>
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
										?>
									   window.location = "<?php echo $url;?>";
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
</script>
