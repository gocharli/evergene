<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/widget.css">
 <!-- Style.css -->
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin/assets/css/style.css"> 
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
                                            <h4 class="m-b-10">Dashboard</h4>
                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="<?=$this->config->item('admin_url')?>">
                                                    <i class="feather icon-home"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="#!">Dashboard</a>
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
                                        <!-- [ page content ] start -->
										<div class="row">

											<div class="col-lg-12 col-md-12">
												<div class="row">
													<div class="col-md-12 clearfix">

													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/orders_items/index/new')?>" target="_blank">
															<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-lite-green"><?=$total_new?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-cart-alt f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-lite-green">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">New Orders</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/orders_items/index/inprogress')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_inprogress?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-cart-alt f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">InProgress</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/orders_items/index/recieved')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_result_recieved?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-cart-alt f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">Result Recieved</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/orders_items/index/completed')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-green"><?=$total_completed?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-cart-alt f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-green">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">Completed</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/orders_items/index/upcoming')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_upcoming?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-cart-alt f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">Upcoming</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>

													<div class="col-md-12 clearfix">

														<div class="card table-card review-card">
															<div class="card-header borderless ">
																<h5>New Request (Nurse/Doctor)</h5>
															</div>
														</div>

													</div>

													<div class="col-md-4">
														<a href="<?=base_url('admin/requests/index/nurse')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_nurse?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-nurse f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">Nurse Requests</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/requests/index/doctor')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_doctor?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-doctor f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">Doctor Requests</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>

													<div class="col-md-12 clearfix">
														<div class="card table-card review-card">
															<div class="card-header borderless ">
																<h5>Items</h5>
															</div>
														</div>

													</div>

													<div class="col-md-4">
														<a href="<?=base_url('admin/tests')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-yellow"><?=$total_test?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-laboratory f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-yellow">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">All Tests</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/mealprep')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-green"><?=$total_mealprep?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-fast-food f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-green">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">All Meal Prep</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
													<div class="col-md-4">
														<a href="<?=base_url('admin/items')?>" target="_blank">
														<div class="card">
															<div class="card-block">
																<div class="row align-items-center">
																	<div class="col-8">
																		<h4 class="text-c-blue"><?=$total_items?></h4>
																	</div>
																	<div class="col-4 text-right">
																		<i class="feather icofont icofont-food-basket f-28"></i>
																	</div>
																</div>
															</div>
															<div class="card-footer bg-c-blue">
																<div class="row align-items-center">
																	<div class="col-9">
																		<h5 class="text-white m-b-0">All Items</h5>
																	</div>

																</div>
															</div>
														</div>
														</a>
													</div>
												</div>


											</div>
											<!-- site Analytics card end -->
										</div>
										<!-- [ page content ] end -->
                                        <!-- [ page content ] end -->
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
	<!-- amchart js -->
	<script src="<?=base_url()?>assets/admin/assets/pages/widget/amchart/amcharts.js"></script>
	<script src="<?=base_url()?>assets/admin/assets/pages/widget/amchart/serial.js"></script>
	<script src="<?=base_url()?>assets/admin/assets/pages/widget/amchart/light.js"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			// seo ecommerce start
			$(function() {
				var chart = AmCharts.makeChart("seo-ecommerce-barchart", {
					"type": "serial",
					"theme": "light",
					"marginTop": 0,
					"marginRight": 0,
					"dataProvider": [{
						"year": "1950",
						"value": -0.307
					}, {
						"year": "1951",
						"value": -0.168
					}, {
						"year": "1952",
						"value": -0.073
					}, {
						"year": "1953",
						"value": -0.027
					}, {
						"year": "1954",
						"value": -0.251
					}, {
						"year": "1955",
						"value": -0.281
					}, {
						"year": "1956",
						"value": -0.348
					}, {
						"year": "1957",
						"value": -0.074
					}, {
						"year": "1958",
						"value": -0.011
					}, {
						"year": "1959",
						"value": -0.074
					}, {
						"year": "1960",
						"value": -0.124
					}, {
						"year": "1961",
						"value": -0.024
					}, {
						"year": "1962",
						"value": -0.022
					}, {
						"year": "1963",
						"value": 0
					}, {
						"year": "1964",
						"value": -0.296
					}, {
						"year": "1965",
						"value": -0.217
					}, {
						"year": "1966",
						"value": -0.147
					}, {
						"year": "1967",
						"value": -0.15
					}, {
						"year": "1968",
						"value": -0.16
					}, {
						"year": "1969",
						"value": -0.011
					}, {
						"year": "1970",
						"value": -0.068
					}, {
						"year": "1971",
						"value": -0.19
					}, {
						"year": "1972",
						"value": -0.056
					}, {
						"year": "1973",
						"value": 0.077
					}, {
						"year": "1974",
						"value": -0.213
					}, {
						"year": "1975",
						"value": -0.17
					}, {
						"year": "1976",
						"value": -0.254
					}, {
						"year": "1977",
						"value": 0.019
					}, {
						"year": "1978",
						"value": -0.063
					}, {
						"year": "1979",
						"value": 0.05
					}, {
						"year": "1980",
						"value": 0.077
					}, {
						"year": "1981",
						"value": 0.12
					}, {
						"year": "1982",
						"value": 0.011
					}, {
						"year": "1983",
						"value": 0.177
					}, {
						"year": "1984",
						"value": -0.021
					}, {
						"year": "1985",
						"value": -0.037
					}, {
						"year": "1986",
						"value": 0.03
					}, {
						"year": "1987",
						"value": 0.179
					}, {
						"year": "1988",
						"value": 0.18
					}, {
						"year": "1989",
						"value": 0.104
					}, {
						"year": "1990",
						"value": 0.255
					}, {
						"year": "1991",
						"value": 0.21
					}, {
						"year": "1992",
						"value": 0.065
					}, {
						"year": "1993",
						"value": 0.11
					}, {
						"year": "1994",
						"value": 0.172
					}, {
						"year": "1995",
						"value": 0.269
					}, {
						"year": "1996",
						"value": 0.141
					}, {
						"year": "1997",
						"value": 0.353
					}, {
						"year": "1998",
						"value": 0.548
					}, {
						"year": "1999",
						"value": 0.298
					}, {
						"year": "2000",
						"value": 0.267
					}, {
						"year": "2001",
						"value": 0.411
					}, {
						"year": "2002",
						"value": 0.462
					}, {
						"year": "2003",
						"value": 0.47
					}, {
						"year": "2004",
						"value": 0.445
					}, {
						"year": "2005",
						"value": 0.47
					}],
					"valueAxes": [{
						"axisAlpha": 0,
						// "gridAlpha": 0,
						"dashLength": 6,
						"position": "left"
					}],
					"graphs": [{
						"id": "g1",
						"balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>",
						"bullet": "round",
						"bulletSize": 8,
						// "fillAlphas": 0.1,
						"lineColor": "#448aff",
						"lineThickness": 2,
						"negativeLineColor": "#ff5252",
						"type": "smoothedLine",
						"valueField": "value"
					}],
					"chartScrollbar": {
						"graph": "g1",
						"gridAlpha": 0,
						"color": "#888888",
						"scrollbarHeight": 55,
						"backgroundAlpha": 0,
						"selectedBackgroundAlpha": 0.1,
						"selectedBackgroundColor": "#888888",
						"graphFillAlpha": 0,
						"autoGridCount": true,
						"selectedGraphFillAlpha": 0,
						"graphLineAlpha": 0.2,
						"graphLineColor": "#c2c2c2",
						"selectedGraphLineColor": "#888888",
						"selectedGraphLineAlpha": 1
					},
					"chartCursor": {
						"categoryBalloonDateFormat": "YYYY",
						"cursorAlpha": 0,
						"valueLineEnabled": true,
						"valueLineBalloonEnabled": true,
						"valueLineAlpha": 0.5,
						"fullWidth": true
					},
					"dataDateFormat": "YYYY",
					"categoryField": "year",
					"categoryAxis": {
						"minPeriod": "YYYY",
						"gridAlpha": 0,
						"parseDates": true,
					},
				});
				chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.3), Math.round(chart.dataProvider.length * 0.55));
			});
			// seo ecommerce end
		});
	</script>
</body>

</html>
