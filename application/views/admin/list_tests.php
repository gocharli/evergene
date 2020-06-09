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
										<div class="card-header row">
											<div class="col-md-6">
												<h5><?=$page_title?></h5>
												<span><?=$page_title?> Management</span>
											</div>

											<div class="col-md-6" >
												<a style="float: right" href="<?php echo base_url(); ?>admin/tests/sort" class="btn waves-effect waves-light btn-primary btn-sm" >Sort Tests</a>
											</div>

														
																	

										</div>
										<div class="card-block">
											<div class="dt-responsive table-responsive">
												<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
													<thead>
													<tr>
														<th> ID</th>
														<th> Name</th>
                                                        <th> Code</th>
														<th> category</th>
														<th> Price</th>														
														<th style="width: 100px;"> Status</th>
														<th style="width: 100px;"> Action </th>
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

	// Server side processing Data-table
	$('#dt-server-processing').DataTable({
		"processing": true,
		"serverSide": true,
		"order": [[ 0, "desc" ]],
		"ajax":{
			"url": admin_url+"tests/list_data/<?=$categoryId?>",
			"dataType": "json",
			"type": "POST",
			"data":{ }
		},
		"columns": [
			{ "data": "id" },
			{ "data": "name" },
            { "data": "code" },
			{ "data": "category" },
			{ "data": "price" },			
			{ "data": "status" },
			{ "data": "action" }
		]
	});




	function popular(id){

		var popular = 0;
		var cur_pop = $("#pop_"+id).val();
		if(cur_pop == 0){
			popular = 1;
		}
		
		$.ajax({
			url: admin_url+"tests/change_popular",
			dataType: 'json',
			data:{id:id,popular:popular},
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
					autoClose: 'close|10000',
					typeAnimated: true,
					buttons: {
						close: function () {
						}
					}
				});
			}
			else if(response.code==2){

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

			}else{
				
				$("#pop_"+id).val(popular); // new popular status
				if(popular == 1){
					$("#popular_"+id).addClass('btn-success').removeClass('btn-inverse');
				}else{
					$("#popular_"+id).addClass('btn-inverse').removeClass('btn-success');
				}

				$.confirm({
					title: 'Success!',
					content: response.message,
					type: 'green',
					autoClose: 'ok|5000',
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




	function status(did)
	{
		var vstatus=$('#status_'+did).text();

		if(vstatus=='Pending')
		{
			$.confirm({
				title: 'Status!',
				content: 'Are you want to change ?',
				type: 'blue',
				typeAnimated: true,
				buttons: {
					Active: {
						text: 'Active',
						btnClass: 'btn-green',
						action: function(){

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function () {
									var self = this;
									return $.ajax({
										url: admin_url+"tests/change_status",
										dataType: 'json',
										data:{id:did,type:'Active'},
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function()
														{
															$('#status_'+did).html(response.status_code);
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




						}
					},
					Block: {
						text: 'Block',
						btnClass: 'btn-red',
						action: function(){

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function () {
									var self = this;
									return $.ajax({
										url: admin_url+"tests/change_status",
										dataType: 'json',
										data:{id:did,type:'Block'},
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function()
														{
															$('#status_'+did).html(response.status_code);
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




						}
					},
					No: function () {
					}
				}
			});

		}
		else if(vstatus=='Block')
		{
			$.confirm({
				title: 'Status!',
				content: 'Are you want to change ?',
				type: 'blue',
				typeAnimated: true,
				buttons: {
					Active: {
						text: 'Active',
						btnClass: 'btn-green',
						action: function(){

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function () {
									var self = this;
									return $.ajax({
										url: admin_url+"tests/change_status",
										dataType: 'json',
										data:{id:did,type:'Active'},
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function()
														{
															$('#status_'+did).html(response.status_code);
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
						}
					},
					No: function () {
					}
				}
			});

		}
		else
		{
			$.confirm({
				title: 'Status!',
				content: 'Are you want to change ?',
				type: 'blue',
				typeAnimated: true,
				buttons: {
					Block: {
						text: 'Block',
						btnClass: 'btn-red',
						action: function(){

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function () {
									var self = this;
									return $.ajax({
										url: admin_url+"tests/change_status",
										dataType: 'json',
										data:{id:did,type:'Block'},
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
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function()
														{
															$('#status_'+did).html(response.status_code);
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


						}
					},
					No: function () {
					}
				}
			});
		}



	}

</script>

</body>

</html>
