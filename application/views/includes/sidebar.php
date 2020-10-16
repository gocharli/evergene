<style type="text/css">

</style>
<div class="shop-sidebar">
	<div class="sidebar-categories">
		<ul>
			<li class="clearfix">
				<a href="<?= base_url('hub') ?>" class="tran3s <?php if ($this->router->fetch_class() == 'hub') { ?>active<?php } ?>">Evergene Hub</a>
			</li>
			<li class="clearfix <?php if ($newResults->count > 0) {
									echo 'quadrat';
								} ?>">
				<a href="<?= base_url('results') ?>" class="tran3s <?php if ($this->router->fetch_class() == 'results') { ?>active<?php } ?>">Your Test Results <?php if ($newResults->count > 0) { ?> <i class="fa fa-exclamation-circle" style="color: red" aria-hidden="true"></i> <?php } ?> </a>
			</li>
			<li class="clearfix">
				<a href="<?= base_url('orders') ?>" class="tran3s <?php if ($this->router->fetch_class() == 'orders' && $this->router->fetch_method() == 'index') { ?>active<?php } ?>">Your Order History</a>
			</li>
			<li class="clearfix">
				<a href="<?= base_url('orders/upcoming') ?>" class="tran3s <?php if ($this->router->fetch_class() == 'orders' && $this->router->fetch_method() == 'upcoming') { ?>active<?php } ?>">Scheduled Orders
					<!--Your Upcoming Orders--></a>
			</li>
			<li class="clearfix">
				<a href="<?= base_url('tests') ?>" class="tran3s">See all Products</a>
			</li>
			<li class="clearfix">
				<a href="<?= base_url() ?>account" class="tran3s <?php if ($this->router->fetch_class() == 'account' && $this->router->fetch_method() == 'index') { ?>active<?php } ?>">Account Settings</a>
			</li>
			<li class="clearfix">
				<a href="<?= base_url() ?>logout" class="tran3s">Logout</a>
			</li>
		</ul>
	</div> <!-- /.sidebar-categories -->
</div> <!-- /.shop-sidebar -->