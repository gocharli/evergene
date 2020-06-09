<nav class="pcoded-navbar">
        <div class="pcoded-inner-navbar main-menu">
            <div class="">
                <div class="main-menu-header">
                    <img class="img-menu-user img-radius" src="<?=base_url()?>assets/admin/assets/images/user-profile/contact-user.jpg" alt="Helpsquad">
                    <div class="user-details">
                        <p id="more-details"><?=$this->session_data->firstName?><i class="feather icon-chevron-down m-l-10"></i></p>
                    </div>
                </div>
                <div class="main-menu-content">
                    <ul>
                        <li class="more-details">
                            <a href="<?=$this->config->item('admin_url')?>/profile/change_password">
                            <i class="feather icon-lock"></i> Change Password
                        </a>
                         <a href="<?=$this->config->item('admin_url')?>/logout">
                            <i class="feather icon-log-out"></i>Logout
                        </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pcoded-navigation-label">Main</div>
            <ul class="pcoded-item pcoded-left-item">
                <li <?php if($this->router->fetch_class()=='home' ) { ?> class="active" <?php } ?>>
                    <a href="<?=$this->config->item('admin_url')?>" class="waves-effect waves-dark">
    				<span class="pcoded-micon">
    					<i class="feather icon-home"></i>
    				</span>
                    <span class="pcoded-mtext">Dashboard</span>
                	</a>
                </li>
				<li <?php if($this->router->fetch_class()=='orders' ) { ?> class="active" <?php } ?>>
					<a href="<?=$this->config->item('admin_url')?>/orders" class="waves-effect waves-dark">
    				<span class="pcoded-micon">
    					<i class="feather icofont icofont-cart-alt"></i>
    				</span>
						<span class="pcoded-mtext">Orders</span>
					</a>
				</li>
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='orders_items') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-cart"></i>
					</span>
						<span class="pcoded-mtext">Orders items</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='') || ($this->uri->segment(3)=='' && $this->uri->segment(4)=='')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index" class="waves-effect waves-dark">
								<span class="pcoded-mtext">All Items</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='new') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/new" class="waves-effect waves-dark">
								<span class="pcoded-mtext">New Items</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='inprogress') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/inprogress" class="waves-effect waves-dark">
								<span class="pcoded-mtext">InProgress Items</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='daft') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/draft" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Draft Items</span>
							</a>
						</li>
						<!-- <li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='recieved') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/recieved" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Result Recieved Items</span>
							</a>
						</li> -->
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='upcoming') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/upcoming" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Scheduled Items</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='completed') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/completed" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Completed Items</span>
							</a>
						</li>

						<li class="<?php if($this->router->fetch_class()=='orders_items' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='cancel') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/orders_items/index/cancel" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Cancelled Items</span>
							</a>
						</li>


					</ul>
				</li>
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='requests') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-doctor"></i>
					</span>
						<span class="pcoded-mtext">Requests</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='requests' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='') || ($this->uri->segment(3)=='' && $this->uri->segment(4)=='')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/requests/index" class="waves-effect waves-dark">
								<span class="pcoded-mtext">All requests</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='requests' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='new') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/requests/index/new" class="waves-effect waves-dark">
								<span class="pcoded-mtext">New</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='requests' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='nurse') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/requests/index/nurse" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Nurse</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='requests' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='doctor') ) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/requests/index/doctor" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Doctor</span>
							</a>
						</li>

					</ul>
				</li>
			 </ul>
            <div class="pcoded-navigation-label">Features</div>
            <ul class="pcoded-item pcoded-left-item">
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='tests') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-laboratory"></i>
					</span>
						<span class="pcoded-mtext">Tests</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='tests' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/tests/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add Test</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='tests' && ($this->uri->segment(3)=='index' && $this->uri->segment(4)=='') && ($this->uri->segment(3)=='' && $this->uri->segment(4)=='')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/tests" class="waves-effect waves-dark">
								<span class="pcoded-mtext">All Tests</span>
							</a>
						</li>
						<?php $cat=$this->db->query('select * from categories WHERE categoryType="Tests"')->result();
						foreach ($cat as $cat_row){
							?>
							<li class="<?php if($this->router->fetch_class()=='tests' && $this->uri->segment(3)=='index' && $this->uri->segment(4)==$cat_row->categoryId) { ?>active<?php } ?>">
								<a href="<?=$this->config->item('admin_url')?>/tests/index/<?=$cat_row->categoryId?>" class="waves-effect waves-dark">
									<span class="pcoded-mtext"><?=$cat_row->categoryName?> Tests</span>
								</a>
							</li>
						<?php } ?>

					</ul>
				</li>
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='mealprep') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-fast-food"></i>
					</span>
						<span class="pcoded-mtext">Meal Prep</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='mealprep' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/mealprep/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add Meal prep</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='mealprep' && ($this->uri->segment(3)=='index') && ($this->uri->segment(3)=='')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/mealprep" class="waves-effect waves-dark">
								<span class="pcoded-mtext">All Meal prep</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='items') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-food-basket"></i>
					</span>
						<span class="pcoded-mtext">General items</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='items' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/items/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add General item</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='items' && ($this->uri->segment(3)=='index') && ($this->uri->segment(3)=='')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/items" class="waves-effect waves-dark">
								<span class="pcoded-mtext">All General items</span>
							</a>
						</li>
					</ul>
				</li>

				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='members') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icon-users"></i>
					</span>
						<span class="pcoded-mtext">Members</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='members' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/members/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add Member</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='members' && ($this->uri->segment(3)=='' || $this->uri->segment(3)=='index')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/members" class="waves-effect waves-dark">
								<span class="pcoded-mtext">List Members</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='blogs') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-social-blogger"></i>
					</span>
						<span class="pcoded-mtext">Blogs</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='blogs' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/blogs/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add Blog</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='blogs' && ($this->uri->segment(3)=='' || $this->uri->segment(3)=='index')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/blogs" class="waves-effect waves-dark">
								<span class="pcoded-mtext">List Blogs</span>
							</a>
						</li>
					</ul>
				</li>





				<li class="pcoded-hasmenu <?php if($this->router->fetch_class()=='coupons') { ?>active pcoded-trigger<?php } ?>">
					<a href="javascript:void(0)" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-social-blogger"></i>
					</span>
						<span class="pcoded-mtext">coupons</span>
					</a>
					<ul class="pcoded-submenu">
						<li class="<?php if($this->router->fetch_class()=='coupons' && $this->uri->segment(3)=='add') { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/coupons/add" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Add discount code</span>
							</a>
						</li>
						<li class="<?php if($this->router->fetch_class()=='coupons' && ($this->uri->segment(3)=='' || $this->uri->segment(3)=='index')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/coupons" class="waves-effect waves-dark">
								<span class="pcoded-mtext">List coupons</span>
							</a>
						</li>

						<li class="<?php if($this->router->fetch_class()=='coupons' && ($this->uri->segment(3)=='used')) { ?>active<?php } ?>">
							<a href="<?=$this->config->item('admin_url')?>/coupons/used" class="waves-effect waves-dark">
								<span class="pcoded-mtext">Coupons used</span>
							</a>
						</li>

					</ul>
				</li>


				<li <?php if($this->router->fetch_class()=='settings') { ?> class="active" <?php } ?>>
					<a href="<?=$this->config->item('admin_url')?>/settings" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icon-aperture rotate-refresh"></i>
					</span>
						<span class="pcoded-mtext">Settings</span>
					</a>
				</li>

				<li <?php if($this->router->fetch_class()=='banner') { ?> class="active" <?php } ?>>
					<a href="<?=$this->config->item('admin_url')?>/banner" class="waves-effect waves-dark">
					<span class="pcoded-micon">
						<i class="feather icofont icofont-social-blogger"></i>
					</span>
						<span class="pcoded-mtext">Banner</span>
					</a>
				</li>
            

                    
            </ul>
            
            
        </div>
    </nav>
