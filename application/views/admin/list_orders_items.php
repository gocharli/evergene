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
										<h4 class="m-b-10"><?=$page_title?></h4>
									</div>
									<ul class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?=$this->config->item('admin_url')?>">
												<i class="feather icon-home"></i>
											</a>
										</li>
										<li class="breadcrumb-item"><a href="javascript:;"><?=$page_title?></a>
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
											<h5><?=$page_title?></h5>
											<span><?=$page_title?> Management</span>
										</div>
										<div class="card-block">
											<div class="dt-responsive table-responsive">
												<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
													<thead>
													<tr>
														<th style="width: 20px;"> ID</th>
														<th> Order ID</th>
														<th> Member</th>
														<th> Item</th>
														<th> Amount</th>
														<th> Scheduled</th>
														<th> Status</th>
														<th> Payment</th>
														<th style="width: 50px;"> Action</th>
													</tr>
													</thead>
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
	$( document ).ready(function() {
	// Server side processing Data-table
	$('#dt-server-processing').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [[ 7, "desc" ]],
		"ajax":{
			"url": admin_url+"orders_items/list_data/<?=$type?>",
			"dataType": "json",
			"type": "POST",
			"data":{ }
		},
		"columns": [
			{ "data": "id" },
			{ "data": "orderId" },
			{ "data": "name" },
			{ "data": "item" },
			{ "data": "amount" },
			{ "data": "date" },
			{ "data": "status" },
			{ "data": "payment" },
			{ "data": "action" }
		]
	});
	});




	function cancel_order_status(detailId, st){

			if(st == 0){
				st = 1;
			}else{
				st = 0;
			}
			
			if(confirm("Are you sure ?")){

				$.ajax({
				url: admin_url+"orders_items/cancel_order_status",
				dataType: 'json',
				data:{detailId:detailId,st:st},
				method: 'post'
				}).done(function (response) {
					self.close();

					if(response.code==1)
					{
						$.confirm({
							title: 'Success!',
							content: response.message,
							type: 'green',
							autoClose: 'ok|5000',
							typeAnimated: true,
							buttons: {
								close: function () {
									location.reload();
								}
							}
						});
					}
					else{
						
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

			}

			

	}

</script>

</body>

</html>
