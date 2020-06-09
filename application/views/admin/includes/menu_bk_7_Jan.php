<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
            <i class="feather icon-toggle-right"></i>
        </a>
            <a href="<?=$this->config->item('admin_url')?>">
            <!--<img class="img-fluid" src="<?=base_url()?>assets/admin/assets/logo.png" alt="Helpsquad" />-->
            <h4 style="margin: 0px;">EverGreen</h4>
        </a>
            <a class="mobile-options waves-effect waves-light">
            <i class="feather icon-more-horizontal"></i>
        </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">                
                <li>
                    <a href="javascript:;" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                    <i class="full-screen feather icon-maximize"></i>
                </a>
                </li>                
            </ul>
            <ul class="nav-right">
				<li class="header-notification">
					<div class="dropdown-primary dropdown">
						<div class="dropdown-toggle" data-toggle="dropdown">
							<i class="feather icon-bell"></i>
							<span class="badge bg-c-red" id="not_cnt">0</span>
						</div>
						<ul id='notificationMenu' class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style='overflow-y: scroll; height: 450px;'>

						</ul>
					</div>
				</li>
                
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=base_url()?>assets/admin/assets/images/user-profile/contact-user.jpg" class="img-radius" alt="User-Profile-Image">
                            <span><?=$this->session_data->firstName?></span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <a href="<?=$this->config->item('admin_url')?>/profile/change_password">
                                <i class="feather icon-lock"></i> Change Password
                            </a>
                            </li>
                            <li>
                                <a href="<?=$this->config->item('admin_url')?>/logout">
                                <i class="feather icon-log-out"></i> Logout
                            </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Header ] end -->
