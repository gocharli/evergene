<?php $this->load->view('admin/includes/head'); ?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
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
										<h4 class="m-b-10">Activity Log</h4>
									</div>
									<ul class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=$this->config->item('admin_url')?>">
												<i class="feather icon-home"></i>
											</a>
										</li>
										<li class="breadcrumb-item"><a href="javascript:;">Activities</a>
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
								<div class="page-body">
									<!-- Server Side Processing table start -->
									<div class="card">
										<div class="card-header">

											<div class="row col-md-12">

												<div class="col-md-3">
													<h5>Activities</h5>
													
												</div>

												<div class="col-md-6">
												
												</div>
												
											</div>
										</div>
										<div class="card-block">
											<div class="dt-responsive table-responsive">
												<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
													<thead>
													<tr>
														<th> SNo</th>
														<th> Description </th>
														<th> createdAt</th>
														<th> Action</th>
													</tr>
													</thead>


													<tbody>

													<?php $i=1; foreach($activities as $act){ ?>
													<tr>
														<td><?php echo $i; ?></td>
														<td> <?php echo $act->description; ?> </td>
														<td> <?php echo date('d F Y H:i:s', strtotime($act->createdAt)); ?></td>
														<td> 
														<?php if($act->tid > 0){ ?>
																<a class="btn waves-effect waves-light btn-primary btn-sm" href="<?php echo base_url(); ?>admin/tests/view/<?php echo $act->tid; ?>"><i class="icofont icofont-eye-alt icofont-2x"></i></a>
														<?php }else if($act->oid > 0){ ?>
																<a class="btn waves-effect waves-light btn-primary btn-sm" href="<?php echo base_url(); ?>admin/orders_items/view/<?php echo $act->oid; ?>"><i class="icofont icofont-eye-alt icofont-2x"></i></a>
														<?php $i++; } ?> 
														
														</td>
													</tr>
													<?php } ?>

													</tbody>


												</table>
											</div>
										</div>
									</div>
									<!-- Server Side Processing table end -->
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- Warning Section Starts -->
<?php $this->load->view('admin/includes/scripts'); ?>

<script src="<?=base_url()?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/admin/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/admin/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script><!-- Custom js -->
<script type="text/javascript">

	// Server side processing Data-table
	$('#dt-server-processing').DataTable({
		
	});
	

</script>

</body>

</html>
