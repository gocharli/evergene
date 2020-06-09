<?php $this->load->view('includes/head');   ?>



<?php if($order_details->testResultType=='Result 3' || $order_details->testResultType=='Result 2'){ ?>
	<link rel="stylesheet" href="<?=base_url('assets/plugins/morris')?>/morris.css">
	
	

<?php } ?>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


</head>

<body>
<div class="main-page-wrapper">
	<!--
    =============================================
        Theme Header
    ==============================================
    -->
	<?php $this->load->view('includes/menu');   ?>

	<!--
    =============================================
        Theme Inner Banner
    ==============================================
    -->
	<div class="inner-page-banner">
		<div class="opacity header-product-detail">

		</div> <!-- /.opacity -->
	</div> <!-- /inner-page-banner -->

	<div class="shop-page hub-page">
		<div class="row">
			<div class="container">
				<div class="title-head">
					<h5 class="pull-left" style="padding: 15px 0; ">Results</h5>
                   
					<a href="<?=base_url('results')?>" class="tran3s custom-btn small-btn pull-right">Back</a>
					
					<?php if(count($previous_results) > 0){ ?>
						<select class="form-control pull-right" style="width: 200px; height: 53px;" onchange="go_get_result(this.value)">
							<option value="0">Previous Results</option>
							<?php foreach($previous_results as $p){ ?>
							
								<option value="<?php echo $p->detailId; ?>"><?php echo date('d F Y',strtotime($p->resultReceivedDate)); ?></option>

							<?php } ?>
						</select>

					<?php }else{ ?>

						<h6 class="pull-right" style="padding: 15px 0;">No Result History</h6>
						
					<?php } ?>
					 <a href="<?=base_url()?>tests/<?php echo str_replace(" ","-",$order_details->testName); ?>" class="tran3s custom-btn small-btn pull-right" style="margin-right:10px">Reorder</a>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div> <br /><br />
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">

						<div class="row">
							<div class="col-lg-12 col-xs-12">

								<div class="single-product shop-sidebar">
								    <div id="html-2-pdfwrapper">
									<div class="product-header">
										<h6><img src="<?=base_url(); ?>uploads/tests/logo/<?php echo $order_details->testLogo; ?>" alt=""/>
										    <?=$order_details->testName?> <small>(Date : <?=date('d F Y',strtotime($order_details->resultReceivedDate))?>)</small>
										</h6>
										
										<div class="row">
										    <br><br>
											<div class="col-lg-12">
												<table class="table table-borderless table-sm">
												  	<thead>
												  	    <tr>
												    		<td scope="col">
												      			<strong>Patient ID:</strong>
												      			<?php echo $order_details->userId; ?>
												      		</td>
												      		<td scope="col">
												      			<strong>First Name:</strong>
												      			<?php echo $order_details->userFirstName; ?>
												      		</td>
												      		<td scope="col">
												      			<strong>Last Name:</strong>
												      			<?php echo $order_details->userLastName; ?>
												      		</td>
												    	</tr>
												    	<tr>
												      		<td scope="col">
												      			<strong>DoB:</strong>
												      			<?php echo date('d F Y',strtotime($order_details->dob)); ?>
												      		</td>
												      		<td scope="col" colspan="2">
												      			<strong>Gender:</strong>
												      			<?php echo $order_details->gender; ?>
												      		</td>
												    	</tr>
												    	<tr>
												      		<td scope="col">
												      			<strong>Sample Taken:</strong>
												      			<?=date('d F Y',strtotime($results[0]->sample_taken_on))?>
												      		</td>
												      		<td scope="col">
												      			<strong>Result Recieved:</strong>
												      			<?=date('d F Y',strtotime($results[0]->result_processed_on))?>
												      		</td>
												      		<td scope="col"></td>
												    	</tr>
												    	
												    	
												  	</thead>
												</table>
											</div>
										</div>
										<div class="shorting-option clearfix">
											<!--<ul class="clearfix">
												<li class="float-right">
													<select class="selectpicker">
														<option>Select Results</option>
														<option>Results 1</option>
														<option>Results 2</option>
														<option>Results 3</option>
													</select>
												</li>
											</ul>-->
										</div> <!-- /.shorting-option -->
										<div class="clearfix"></div>
									</div><!--product header-->

									<div class="row" >   <!--  Commented by David  -->

										<div class="col-md-12 col-xs-12 mix technical investment" style="">
										<h5>Description</h5>
										<p> <?php echo $results[0]->testDescription; ?></p>
											<?php
											$i=0;
												// $results=$this->db->query('SELECT * FROM `results` WHERE detailId='.$order_details->detailId)->result();
												foreach ($results as $res){
												    
												    $i++;

													?>
												<div class="single-service">
												    
												<br />
												<div class="clearfix"></div>
												<div class="res_div mb-0">Normal Range : <?php echo $res->lower_value; ?> - <?php echo $res->upper_value; ?> <?php echo ' '.$res->resultUnit; ?></div>
											
												<div class="price-ranger col-lg-12">

													<div class="row">
														<!--<div class="col-md-1"></div>-->
														<div class="col-md-12">
															<?php
													          //$width =10.0;
													          //$total =  (int) $res->resultValue * $width;
													       	?>
															<!--<div style="background-color: yellow;height: 120px;z-index: 999;left: <?php echo $total; ?>px;width: 4px;position: absolute;"></div>-->
  															<div id = "<?php echo 'container'.$i; ?>" style = "width: 100%; height: 100px; margin: 0 auto">
  															</div>
														 </div>
													</div>
													
												</div> <!-- /price-ranger -->
												<div class="clearfix"></div>
												<div class="res_div">Result = <?=$res->resultValue?> <?=$res->resultUnit?> 
												
												<!-- <span style="color:red"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> High</span>  -->
												
													<?php if($res->resultValue < $res->lower_value){  ?>
														<span style="color:red"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> Low </span>
													<?php }else if($res->resultValue > $res->upper_value) { ?>
														<span style="color:red"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> High </span>
													<?php }else{ ?>
														<span > Normal </span>
													<?php } ?>

												</div>

												<div class="clearfix"></div>
												<p><?php //echo $res->bottomText; ?></p>

												<div class="clearfix"></div>
											</div> <!-- /.single-service -->
                                                    
											<?php  } ?>
											</div>
											<?php //if($order_details->resultHistory=='Yes'){

												//track//
												$result_analytics=array();
												$last_year=date("Y-m-d",strtotime("-1 year"));
												$date=$last_year;
												for($i=1;$i<13;$i++)
												{
													if($i!=0)
													{
														$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($date)) . ' +1 month'));
													}
													$new=array();
													$new['y']=date('Y-m-d',strtotime($date));
													$new['x']=0;
													$new['x1']=0;
													$new['x2']=0;
													$new['x3']=0;
													$new['x4']=0;
													$result_analytics[]=$new;
												}
												$result_track_graph=$this->db->query('select * from results WHERE  DATE(createdAt)>="'.$last_year.'" and  userId='.$this->session_data->userId.' and testId='.$order_details->testId.' and resType="OBX" GROUP BY YEAR(createdAt), MONTH(createdAt)')->result();
												
												//echo '<pre>'; print_r($result_track_graph);

												foreach ($result_track_graph as $r)
												{
													foreach ($result_analytics as $key=>$row)
													{
														if(count($previous_results) > 1){
														if(date('Y-m',strtotime($row['y']))==date('Y-m',strtotime($r->createdAt)))
														{
															//$r_val = $r->resultValue.' ('.$r->lower_value.'-'.$r->upper_value.')';
															$result_analytics[$key]['x']=$r->resultValue;
															$result_analytics[$key]['x1']=$r->min_value;
															$result_analytics[$key]['x2']=$r->max_value;
															$result_analytics[$key]['x3']=$r->upper_value;
															$result_analytics[$key]['x4']=$r->lower_value;
															//$daily_analytics[$key]['x4']= $r->resultValue;
														}
														}
													}

												}
//echo '<pre>'; print_r($daily_analytics);

												?>


												</div>

												<d iv class="single-service">
												    
												    <?php if(count($previous_results) > 1){ ?>

														<select id="m_report" class="form-control" style="width: 20%; float: right" onchange="get_report(this.value, '<?php echo $order_details->testId; ?>')">
															
															<!--<option value="">Result Value</option>-->

															<?php $m=1; foreach($results as $r){ ?>

																<option value="<?php echo $r->marker_title; ?>"> <?php echo $r->marker_title; ?></option>

															<?php $m++; } ?>

															<!-- <option value="min_value">Min Value</option>
															<option value="max_value">Max Value</option>
															<option value="lower_value">Lower Value</option>
															<option value="upper_value">upper_value</option> -->
														</select> 

														<!-- <select id="m_report" class="form-control" style="width: 20%" onchange="get_report(this.value, '<?php echo $order_details->testId; ?>')">
															<option value="result_value">Result Value</option>
															<option value="min_value">Min Value</option>
															<option value="max_value">Max Value</option>
															<option value="lower_value">Lower Value</option>
															<option value="upper_value">upper_value</option>
														</select>  -->

														<div id="graph"></div>
													<?php } else{ ?>
														<div id="graph"></div>
														<div><h4>Only one result available</h4></div>
													<?php } ?>
													
													
													<div class="boxstyle text-left margin-bottom text-center">
													<?php //echo '<pre>'; print_r($results); ?>
													

														<script>
											
															// load_chart();
															// function load_chart(){// Use Morris.Bar
															// 	Morris.Line({
															// 		element: 'graph1',
															// 		data:[
															// 			<?php
															// 			foreach($res_bmi as $month) {
															// 				echo json_encode($month).',';
															// 			}?>
															// 		],
															// 		xkey: 'y',
															// 		ykeys: ['x','x1', 'x2', 'x3', 'x4'],
															// 		labels: ['Min Value', 'Max Value', 'Upper Value', 'Lower Value', 'Result Value'] ,
															// 		xLabelFormat: function (x) {
															// 			var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
															// 			var month = IndexToMonth[ x.getMonth() ];
															// 			var year = x.getFullYear();
															// 			return year + ' ' + month;
															// 		},
															// 		dateFormat: function (x) {
															// 			var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
															// 			var month = IndexToMonth[ new Date(x).getMonth() ];
															// 			var year = new Date(x).getFullYear();
															// 			return year + ' ' + month;
															// 		},
															// 		resize: true
															// 	});
															// }

															</script>


<script>

function get_report(marker_title, testId){
        
		$.ajax({
			url: '<?=base_url('results/filter_chart')?>',
			dataType: 'json',
			data:{'marker_title':marker_title, 'testId': testId},
			method: 'post'
		}).done(function (response) {
			
		  
			
$("#graph").empty();

	// if(type == 'result_value'){
	// 	load_chart();
	// 	return;
	// }    
			
 Morris.Line({
	element: 'graph',
	data:response,

	xkey: 'y',
	ykeys: ['x'],
	labels: ['Result Vlaue'] ,

	xLabelFormat: function (x) {
		var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
		var month = IndexToMonth[ x.getMonth() ];
		var year = x.getFullYear();
		return year + ' ' + month;
	},
	dateFormat: function (x) {
		var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
		var month = IndexToMonth[ new Date(x).getMonth() ];
		var year = new Date(x).getFullYear();
		return year + ' ' + month;
	},
	resize: true

});
		
		}).fail(function(){
			
		});

}

</script>





														<div class="clearfix"></div>
													</div>
												</div>
												
											<?php //} ?>
											
											<a href="javascript:;" onclick="generate()" class="tran3s custom-btn pull-left">Download Results</a>
											<a href="javascript:;" onclick="generate()" class="tran3s custom-btn pull-left">Copy the Graph</a>
											
											<?php
											$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'call_nurse'));
											if($setting_qry)
											{
												if($setting_qry->settingValue==1)
												{
											?>   	<a href="javascript:;" onclick="call_request('nurse')" class="tran3s custom-btn request-btn pull-right">
														Request Call From Nurse
														<span><?=$order_details->callNurseType?></span>
													</a>
											<?php }
											}
											$setting_qry=$this->general_model->select_where('settings',array('settingOption'=>'call_doctor'));
											if($setting_qry) {
												if ($setting_qry->settingValue == 1) {
													$call_doctor_price=$this->general_model->select_where('settings',array('settingOption'=>'call_doctor_price'));
													if($call_doctor_price){
														if($call_doctor_price->settingValue>0){
													?>
													<a href="javascript:;" onclick="call_request('doctor')" class="tran3s custom-btn request-btn pull-right">
														Request Call From Doctor
														<span>£<?=$call_doctor_price->settingValue?></span>
													</a>
												<?php }
													}
												}
											}?>

										</div> <!-- /.col-md-12 -->

										<div class="clearfix"></div>
									</div><!-- /.row -->

									<div class="clearfix"></div>
								</div> <!-- /.single-product -->


							</div> <!-- /.col- -->
						</div> <!-- /.row -->

					</div> <!-- /.shop-product-wrapper -->
				</div>

			</div> <!-- /.container -->
		</div> <!-- /.row -->
	</div> <!-- /.shop-page -->
    <form id="frm_request_call">
		<input type="hidden" id="request_type" name="type" value="">
		<input type="hidden" id="request_type" name="orderId" value="<?=$order_details->detailId?>">
	</form>
	<?php $this->load->view('includes/footer'); ?>
	<script type="text/javascript" src="<?=base_url('assets/front/')?>vendor/jquery.ripples-master/dist/jquery.ripples-min.js"></script>
    <script src="<?=base_url('assets/plugins/morris')?>/raphael-min.js"></script>
	<script src="<?=base_url('assets/plugins/morris')?>/morris.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<?php $this->load->view('includes/scripts'); ?>

	
	
	<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js">
      </script>
      <script type = "text/javascript">
         google.charts.load('current', {packages: ['corechart']});     
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	  

	<script>
  
    
  function drawChart() {


<?php
	$i=0;
	foreach ($results as $res){
		$i++;
		?>

		<?php
			$themin= $res->min_value;
			$themax= $res->max_value;
			$theupper= $res->upper_value;
			$thelower= $res->lower_value;
			$thevalue= $res->resultValue;
		?>
		// Define the chart to be drawn.
		var data = google.visualization.arrayToDataTable([
		['Year', 'Asia', 'Europe', 'Pk' , 'value'],
			['Result',  <?php echo $thelower?>, <?php echo $theupper - $thelower?>,<?php echo $themax - $theupper?> , <?php echo $thevalue?> ],
		]);
			var options = {
				isStacked:'absolute',
				allowHtml:true,
				legend:'none',
				displayAnnotations: true,
				'is3D':true,
				colors: ['red', 'green', 'red'],
				'tooltip' : {
				trigger: 'none'
				},
				hAxis: { 
					viewWindow: { 
						min:<?php echo $themin?>, 
						max:<?php echo  $themax ?>
					},
					gridlines: {
						count: Math.ceil(120 * 1.1 /10),
					}
					
				},
				orientation: 'vertical',
					series: {
						3: {
						color: 'yellow',
						type: 'line',
						lineWidth: 5,
						showR2: true,
						
						}
					},
					seriesType: 'bars',
			};  
		// Instantiate and draw the chart.
		var chart = new google.visualization.BarChart(document.getElementById('<?php echo 'container'.$i; ?>'));
		chart.draw(data, options);

		<?php
			}
		?> 
	}
	google.charts.setOnLoadCallback(drawChart);
		
    
</script>


	<script type="text/javascript">
    <?php //if($order_details->resultHistory=='Yes'){ ?>
		// Use Morris.Bar
		Morris.Line({
			element: 'graph',
			data:[
				<?php
				foreach($result_analytics as $month) {
					echo json_encode($month).',';
				}?>],
			xkey: 'y',
			ykeys: ['x'],
			labels: ['Result Value'] ,
			xLabelFormat: function (x) {
				var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
				var month = IndexToMonth[ x.getMonth() ];
				var year = x.getFullYear();
				return year + ' ' + month;
			},
			dateFormat: function (x) {
				var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
				var month = IndexToMonth[ new Date(x).getMonth() ];
				var year = new Date(x).getFullYear();
				return year + ' ' + month;
			},
			resize: true
		});
        
      <?php //} ?>  

		function generate()
		{
			var divToPrint=document.getElementById('html-2-pdfwrapper');

			var newWin=window.open('','Print-Window');

			newWin.document.open();

			newWin.document.write("<html><head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' ><link rel='stylesheet' type='text/css' href='<?=base_url('assets/front/')?>css/style.css'><style type='text/css'>.ruler_active {background: #86c44c !important;height: 34px !important;border-left: 0px !important;width: 11% !important; -webkit-print-color-adjust: exact; }</style></head><body onload='window.print()'><h2 style='text-align:center'>Results <?=$order_details->testName?></h2>"+divToPrint.innerHTML+"</body></html>");

			newWin.document.close();

			setTimeout(function(){newWin.close();},10);
		}
		function  call_request(type='nurse') {
			$.ajax({
				url: '<?=base_url('results/call')?>',
				dataType: 'json',
				data:{'type':type,'orderId':<?=$order_details->detailId?>},
				method: 'post'
			}).done(function (response) {
				if(response.code==0)
				{
					error_box(response.message,10000);
				}
				else
				{
					if(response.price>0)
					{
						$('#request_type').val(response.type);
						var total_g=response.price;
						var title='Request Charges';
						var total=total_g*100;
						handler.open({
							name: title,
							description: 'Charges( £'+total_g+' )',
							currency : 'GBP',
							amount: total
						});
					}
					else
					{
						$.ajax({
							url: '<?=base_url('results/call_payment')?>',
							dataType: 'json',
							data:{'type':response.type,'orderId':<?=$order_details->detailId?>},
							method: 'post'
						}).done(function (res) {
							if(res.code==0)
							{
								error_box(res.message,10000);
							}
							else
							{
								$.confirm({
									title: 'Success!',
									icon:  'fa fa-check',
									content: res.message,
									type: 'green',
									typeAnimated: true,
									buttons: {
										ok: {
											text: 'Ok',
											btnClass: 'btn-green',
											action: function(){
												location.reload();
											}
										}
									}
								});
							}
						}).fail(function(){
							error_box();
						});

					}
				}
			}).fail(function(){
				error_box();
			});
		}
		var handler = StripeCheckout.configure
		({
			key: '<?=getenv('stripe_api_key')?>',
			image: '<?php echo base_url(); ?>assets/stripelogo.png',
			token: function(token)
			{
				$('#frm_request_call').append("<input type='hidden' name='stripeToken' value='" + token.id + "' />");
				var frm=$('#frm_request_call');
				$.confirm({
					icon: 'fa fa-spinner fa-spin',
					title: 'Working!',
					content: function () {
						var self = this;
						return $.ajax({
							url: '<?=base_url('results/call_payment')?>',
							dataType: 'json',
							data:frm.serialize(),
							method: 'post'
						}).done(function (response) {
							self.close();
							if(response.code==0)
							{
								error_box(response.message,10000);
							}
							else
							{
								$.confirm({
									title: 'Success!',
									icon:  'fa fa-check',
									content: response.message,
									type: 'green',
									typeAnimated: true,
									buttons: {
										ok: {
											text: 'Ok',
											btnClass: 'btn-green',
											action: function(){
												location.reload();
											}
										}
									}
								});
							}
						}).fail(function(){
							self.close();
							error_box();
						});
					},
					buttons: {
						close: function () { }
					}
				});


			}
		});

		window.addEventListener('popstate', function() {
			handler.close();
		});
	</script>




	<script>

		function go_get_result(detailId){
			if(detailId > 0){
				top.location.href="<?php echo base_url(); ?>results/view/"+detailId;
			}
		}

	</script>

</div> <!-- /.main-page-wrapper -->
</body>
</html>
