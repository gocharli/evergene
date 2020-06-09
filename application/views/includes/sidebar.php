
<style type="text/css">
		/*.quadrat {
		  /*width: 50px;
		  height: 50px;*/
		  /*-webkit-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Safari 4+ */
		 /* -moz-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Fx 5+ */
		 /* -o-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Opera 12+ */
		 /* animation: NAME-YOUR-ANIMATION 1s infinite;  /* IE 10+, Fx 29+ */
		/*}/*

		@-webkit-keyframes NAME-YOUR-ANIMATION {
		  0%, 49% {
		    background-color: rgb(117, 209, 63);
		    border: 3px solid #e50000;
		  }
		  50%, 100% {
		    background-color: #e50000;
		    border: 3px solid rgb(117, 209, 63);
		  }
		}*/
		
</style>
<div class="shop-sidebar">
	<div class="sidebar-categories">
		<ul>
			<li class="clearfix">
				<a href="<?=base_url('hub')?>" class="tran3s <?php if($this->router->fetch_class()=='hub'){ ?>active<?php } ?>">Evergene Hub</a>
			</li>
			<li class="clearfix <?php if($newResults->count>0){echo 'quadrat';} ?>">
				<a href="<?=base_url('results')?>" class="tran3s <?php if($this->router->fetch_class()=='results'){ ?>active<?php } ?>">Your Test Results <?php if($newResults->count>0){ ?> <i class="fa fa-exclamation-circle" style="color: red" aria-hidden="true"></i> <?php } ?> </a>
			</li>
			<li class="clearfix">
				<a href="<?=base_url('orders')?>" class="tran3s <?php if($this->router->fetch_class()=='orders' && $this->router->fetch_method()=='index' ){ ?>active<?php } ?>">Your Order History</a>
			</li>
			<li class="clearfix">
				<a href="<?=base_url('orders/upcoming')?>" class="tran3s <?php if($this->router->fetch_class()=='orders' && $this->router->fetch_method()=='upcoming' ){ ?>active<?php } ?>">Scheduled Orders <!--Your Upcoming Orders--></a>
			</li>
			<!-- <li class="clearfix">
				<a href="<?=base_url('orders/cancel')?>" class="tran3s <?php if($this->router->fetch_class()=='orders' && $this->router->fetch_method()=='cancel' ){ ?>active<?php } ?>">Cancelled Orders </a>
			</li> -->
			<!-- <li class="clearfix">
				<a href="<?=base_url('transactions')?>" class="tran3s <?php if($this->router->fetch_class()=='transactions'){ ?>active<?php } ?>">Transactions</a>
			</li> -->
            <li class="clearfix">
            	<a href="<?=base_url('tests')?>" class="tran3s">See all Products</a>
            </li>
			<li class="clearfix">
				<a href="<?=base_url()?>account" class="tran3s <?php if($this->router->fetch_class()=='account' && $this->router->fetch_method()=='index' ){ ?>active<?php } ?>">Account Settings</a>
			</li>
			<li class="clearfix">
				<a href="<?=base_url()?>logout" class="tran3s">Logout</a>
			</li>
		</ul>
	</div> <!-- /.sidebar-categories -->
</div> <!-- /.shop-sidebar -->
