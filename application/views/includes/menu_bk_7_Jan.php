<header class="theme-menu-wrapper <?php if($this->router->fetch_class()=='home') { echo 'menu-style-two';} ?>">
	<div class="header-wrapper">
		<div class="container">
			<!-- Logo -->
			<div class="logo float-left tran4s">
				<a href="<?=base_url()?>"><img src="<?=base_url('assets/front/')?>images/logo/<?php if($this->router->fetch_class()=='home') { echo 'logo2.png';}else{ echo 'logo.png';} ?>" alt="Logo"></a>
			</div>
			<!-- ============================ Theme Menu ========================= -->
			<nav class="theme-main-menu float-right navbar" id="mega-menu-wrapper">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="navbar-collapse-1">
					<ul class="nav">
						<li class="dropdown-holder menu-list <?php if($this->router->fetch_class()=='home'){ ?>active<?php } ?>"><a href="<?=base_url()?>" class="tran3s">Home</a>
						</li>
						<li class="dropdown-holder menu-list <?php if($this->router->fetch_class()=='tests'){ ?>active<?php } ?>"><a href="<?=base_url('tests')?>" class="tran3s">Tests</a>
							<ul class="sub-menu">
								<li><a href="<?=base_url('tests')?>">All Tests</a></li>
								<?php $cat=$this->db->query('select * from categories WHERE categoryType="Tests"')->result();
								foreach ($cat as $cat_row){
								?>
									<li><a href="<?=base_url('tests/index/'.$cat_row->catSlug)?>"><?=$cat_row->categoryName?></a></li>

								<?php } ?>
								<li><a href="<?=base_url('tests/index/mealprep')?>">Meal Prep</a></li>
								<li><a href="<?=base_url('tests/index/items')?>">General Items</a></li>
							</ul>
						</li>
						<li class="menu-list <?php if($this->router->fetch_class()=='memberships'){ ?>active<?php } ?>"><a href="<?=base_url('memberships')?>" class="tran3s">Memberships</a></li>
						<li class="menu-list">
							<a href="<?=base_url('cart')?>" class="tran3s"><i class="fa fa-cart-plus"></i> Cart <span class="label label-success" id="cart_label">
                            <?php 
                            
	                            $count_new_cart=array();
	                            foreach($this->cart->contents() as $row) {
	                               if(!isset($count_new_cart[$row['options']['ref']])) {                
	                                    $new=array();
	                                    $new['id']=$row['id'];                                   
	                                    $count_new_cart[$row['options']['ref']]=$new;    
	                               }       
	                            }                            
                            ?>                            
                            
                            <?=count($count_new_cart)?>
                            </span></a>
						</li>

						<?php
							if(isset($this->session_data->userId)) {
						?>
								<li class="menu-list">
									<a href="<?=base_url('hub')?>" class="tran3s">
									<?=$this->session_data->userFirstName?> Hub
									</a>
								</li>
						<?php
							}
							else {
						?>
								<li class="login-button">
									<a href="javascript:;"  class="tran3s loginBtn" >login</a>
								</li>
						<?php
							}
						?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav> <!-- /.theme-main-menu -->
		</div> <!-- /.clearfix -->
	</div>
</header> <!-- /.theme-menu-wrapper -->
