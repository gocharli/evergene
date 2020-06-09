<?php $this->load->view('admin/includes/head'); ?>
 <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/style.css"> 
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/pages.css">
  </head>

  <body themebg-pattern="theme1">
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->

    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    
                        <form id="frm_1" action="<?php echo base_url(); ?>admin/login/update_password_code" class="md-float-material form-material">
                            <div class="text-center">
                                <img src="<?=base_url()?>assets/admin/logo.png" alt="Helpsquad" style="margin-top: -10px;" />
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Reset Password</h3>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group form-primary">
                                        <input type="password" name="password" class="form-control" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Password</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password" name="c-password" class="form-control" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Confirm Password</label>
                                    </div>
                                    
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <input type="hidden" name="pass_code" value="<?php echo $pass_code; ?>">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Rest password</button>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p class="text-inverse text-left m-b-0">Thank you.</p>
                                            <p class="text-inverse text-left"><a href="<?=base_url()?>admin/login"><b>Back to Login</b></a></p>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="<?=base_url()?>assets/admin/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
<?php $this->load->view('admin/includes/scripts'); ?>

<script type="text/javascript" src="<?=base_url()?>assets/admin/assets/js/common-pages.js"></script>

<script type="text/javascript">
	var login_err;
	$('#frm_1').submit(function(evt){

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
						login_err=$.confirm({
							title: 'Error!',
							icon:  'fa fa-warning',
							closeIcon: true,
							content: response.message,
							type: 'red',
							autoClose: 'close',
							typeAnimated: true,
							buttons: {
								close: function () {
								}
							}
						});
					}
					else
					{
						top.location.href=admin_url+'login';
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

</body>

</html>
