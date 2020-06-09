<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
 <!-- Style.css -->
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/style.css"> 
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/pages.css">
 
</head>
<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    <!-- [ Pre-loader ] end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- [ Header ] start -->
         <?php $this->load->view('admin/includes/menu'); ?>
            <!-- [ Header ] end -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- [ navigation menu ] start -->
                <?php $this->load->view('admin/includes/sidebar'); ?>
                    <!-- [ navigation menu ] end -->
                    
                    <div class="pcoded-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h4 class="m-b-10">Change Password</h4>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?=$this->config->item('admin_url')?>">
                                                <i class="feather icon-home"></i>
                                            </a>
                                        </li>                                       
                                        <li class="breadcrumb-item">
                                            <a href="javascript:;">Change Password</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Change password</h5>
                                                        <span>change your account password</span>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="j-wrapper j-wrapper-640">
                                                            <form id="frm_1" action="<?=$this->config->item('admin_url')?>/profile/change_password_code" method="post" class="j-pro">
                                                                <div class="j-content">
                                                                  
                                                                    <div class="j-unit">
                                                                        <label class="j-label">Current Password</label>
                                                                        <div class="j-input">
                                                                            <label class="j-icon-right" for="password">
                                                                                <i class="icofont icofont-ui-lock"></i>
                                                                            </label>
                                                                            <input type="password" id="password" name="password">
                                                                             <span class="j-tooltip j-tooltip-right-top">Your current password</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="j-unit">
                                                                        <label class="j-label">New Password</label>
                                                                        <div class="j-input">
                                                                            <label class="j-icon-right" for="new_password">
                                                                                <i class="icofont icofont-ui-lock"></i>
                                                                            </label>
                                                                            <input type="password" id="new_password" name="new_password">
                                                                            <span class="j-tooltip j-tooltip-right-top">Your new password</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="j-unit">
                                                                        <label class="j-label">Re-type New Password</label>
                                                                        <div class="j-input">
                                                                            <label class="j-icon-right" for="c-password">
                                                                                <i class="icofont icofont-ui-lock"></i>
                                                                            </label>
                                                                            <input type="password" id="c-password" name="c-password">
                                                                            <span class="j-tooltip j-tooltip-right-top">Re-type your New Password</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                                <!-- end /.content -->
                                                                <div class="j-footer">
                                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                                </div>
                                                                <!-- end /.footer -->
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page body end -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Main-body end -->  
                    
                  
                </div>
            </div>
        </div>
    </div>
    <!-- Warning Section Starts -->
<?php $this->load->view('admin/includes/scripts'); ?>    
<script type="text/javascript">
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
						$.confirm({
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
						$.confirm({
							title: 'Success!',
							icon:  'fa fa-check',
							content: response.message,
							type: 'green',
							autoClose: 'ok',
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

</body>

</html>
