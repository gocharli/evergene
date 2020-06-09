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
										<h6 class="print-design"><img src="<?=base_url(); ?>uploads/tests/logo/<?php echo $order_details->testLogo; ?>" alt="" style="width:10%"/>
										   <span style="margin-left:1rem;padding:1% 0%"><?=$order_details->testName?> <small style="line-height:56px">(Date : <?=date('d F Y',strtotime($order_details->resultReceivedDate))?>)</small></span> 
										</h6>
										
										<div class="row">
										    <br><br>
											<div class="col-lg-12">
												<table class="table table-borderless table-sm">
												  	<thead>
												  	    <tr>
												    		<td scope="col">
												      			<strong>Patient ID: <?php echo $order_details->userId; ?></strong>
												      		
												      		</td>
												      		<td scope="col">
												      			<strong>First Name: <?php echo $order_details->userFirstName; ?></strong>
												      		
												      		</td>
												      		<td scope="col">
												      			<strong>Last Name: <?php echo $order_details->userLastName; ?></strong>
												      			
												      		</td>
												    	</tr>
												    	<tr>
												      		<td scope="col">
												      			<strong>DoB: <?php echo date('d F Y',strtotime($order_details->dob)); ?></strong>
												      		
												      		</td>
												      		<td scope="col" colspan="2">
												      			<strong>Gender: <?php echo $order_details->gender; ?></strong>
												      		
												      		</td>
												    	</tr>
												    	<tr>
												      		<td scope="col">
												      			<strong>Sample Taken: <?=date('d F Y',strtotime($results[0]->sample_taken_on))?></strong>
												      			
												      		</td>
												      		<td scope="col">
												      			<strong>Result Recieved: <?=date('d F Y',strtotime($results[0]->result_processed_on))?></strong>
												      			
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
                                        <div style="margin-top:20px;">
                                            <h5 class="mb-15">Description</h5>
										    <p class="mb-15"> <?php echo $results[0]->testDescription; ?></p>
                                        </div>
									   <!--  Commented by David  -->
                                        
										
										
											<?php

											$lbls="['";

											$i=0;
											$p=0;
												// $results=$this->db->query('SELECT * FROM `results` WHERE detailId='.$order_details->detailId)->result();
												foreach ($results as $res){
													
													//echo '<pre>'; print_r($res);
													$m_title = $markers[$p]->tm_title;
													if(empty($markers[$p]->tm_title)){

														$m_title = $res->marker_title;
														if(empty($res->marker_title)) { 
															$m_title = explode(",", $res->testMarkers)[$p]; 
														} 
													}

													//$lbls.= $m_title."','";
													$lbls.= $m_title." (" .$res_unit[$i].") ','";

												    $i++;

													?>
											
										    	<div class="row col-md-12 col-xs-12 mix technical investment" style="">
													 <!-- <h5 class="marker-heading">Marker Type 1</h5><br> -->
													 <div>
													<h5 class="marker-heading mb-15"><?php echo $m_title; ?></h5>

												    <div class="single-service" style="margin-bottom: 30px;border: 1px solid rgba(0,0,0,0.07);padding: 20px;border-radius: 5px;background: #FFF;">
												   
												  	<!-- <p> <?php echo $results[0]->testDescription; ?></p>   -->
													  <p class="mb-15"> <?php echo $res->topText; ?></p>
												<br />
												<div class="clearfix"></div>
													<div class="row">
    												
    												    <div class=" result-value res_div mb-0">Normal Range : <?php echo $res->lower_value; ?> - <?php echo $res->upper_value; ?> <?php echo ' '.$res->resultUnit; ?></div>
    											    
    											    </div>
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
												<div class="row">
								
												<div class=" result-value res_div" >Result = <?=$res->resultValue?> <?=$res->resultUnit?> 
											
												</div>
												<!-- <span style="color:red"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> High</span>  -->
												 <div style="float:left;margin-left:2rem">
													<?php if($res->resultValue < $res->lower_value){  ?>
														<span style="color:red;line-height: 48px;font-weight:600"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> Low </span>
													<?php }else if($res->resultValue > $res->upper_value) { ?>
														<span style="color:red;line-height: 48px;font-weight:600"><i class="fa fa-exclamation-circle" id="info-icon" aria-hidden="true" ></i> High </span>
													<?php }else{ ?>
														<span style="color:#008000;line-height: 48px;font-weight:600"><i class="fa fa-check" id="info-icon" aria-hidden="true" ></i> Normal </span>
													<?php } ?>
                                                </div>
												</div>

												<div class="clearfix"></div>
												<p class="mb-15" style="margin-top:15px;"><?php echo $res->bottomText; ?></p>

												<div class="clearfix"></div>
											</div></div> <!-- /.single-service -->
                                            </div>  
											<?php  $p++; } 
											
											$lbls = substr($lbls, 0, -3)."']";
											
											//echo $lbls;
											?>
										
											<?php //if($order_details->resultHistory=='Yes'){

												//track//
												$kkk = array();
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

													

													for($g=1; $g<=$results[0]->no_of_markers; $g++){
														$new['x'.$g]=0;
													}
													// $new['x1']=0;
													// $new['x2']=0;
													// $new['x3']=0;
													// $new['x4']=0;
													$result_analytics[]=$new;
												}
												//$result_track_graph=$this->db->query('select * from results WHERE  DATE(createdAt)>="'.$last_year.'" and  userId='.$this->session_data->userId.' and testId='.$order_details->testId.' and resType="OBX" GROUP BY YEAR(createdAt), MONTH(createdAt)')->result();
												$result_track_graph=$this->db->query('select * from results WHERE  DATE(createdAt)>="'.$last_year.'" and  userId='.$this->session_data->userId.' and testId='.$order_details->testId.' and resType="OBX" ')->result();

												//echo '<pre>'; print_r($result_track_graph);

												foreach ($result_track_graph as $r)
												{
													foreach ($result_analytics as $key=>$row)
													{
														if(count($previous_results) > 1){
														if(date('Y-m',strtotime($row['y']))==date('Y-m',strtotime($r->sample_taken_on)))
														{
															$result_analytics[$key]['y'] = date('Y-m-d', strtotime($r->sample_taken_on)); // added on 20 may
															$result_analytics[$key]['x']=$r->resultValue;
															if(count($previous_results) <= 1){
																$result_analytics[$key]['x'] = 0;
															}
															

															$mrkrs = $this->db->query("select * from results where detailId = '".$r->detailId."'  ")->result();
															$p=1;
															foreach($mrkrs as $mm){
																$result_analytics[$key]['x'.$p]=$mm->resultValue;
																if(count($previous_results) <= 1){
																	$result_analytics[$key]['x'.$p] = 0;
																}
																$p++;
															}

															$kkk[$key] = $result_analytics[$key];

														}else{
														  //  unset($result_analytics[$key]['y']);
														  //  unset($result_analytics[$key]['x']);
														  //  unset($result_analytics[$key]['x1']);
														  //  unset($result_analytics[$key]['x2']);
														  //  unset($result_analytics[$key]['x3']);
														  //  unset($result_analytics[$key]['x4']);
														}
														}else{

														 	$kkk[$key] = $result_analytics[$key];

														}
													}

												}
//echo '<pre>'; print_r($daily_analytics);

												?>


												
												
													<?php if(count($previous_results) > 1){ ?>
													
														<select id="m_report" name="m_report" class="form-control d-print-none" style="width: 20%; margin: 10px; margin-left: 80%;" onchange="get_report(this.value, '<?php echo $order_details->testId; ?>')">
															
															<option value="">Result Value</option>

															<?php $ii=0; $m=1; foreach($results as $r){ ?>

																<option class="<?php echo $res_unit[$ii]; ?>" value="<?php echo $r->marker_title; ?>"> <?php echo $r->marker_title; ?></option>

															<?php $m++; $ii++; } ?>

														</select> 
													
													<?php } ?>

												<div class="single-service">

												<?php if(count($previous_results) > 1){ ?>

														<div id="graph" ></div>
														<?php } else{ ?>
														<div id="graph" class="d-print-none"></div>
														<!-- <img src="<?php echo base_url(); ?>assets/img/graph.jpg" /> -->
														<div class="d-print-none"><h4 style="text-align: center; color: green; font-size: inherit;">Only one result available</h4></div>
														<?php } ?>
													<div class="boxstyle text-left margin-bottom text-center">
													    
													</div>
													



<script>

function get_report(marker_title, testId){

	var m_unit = $('select[name="m_report"] :selected').attr('class');
	//alert(m_unit);
        
		$.ajax({
			url: '<?=base_url('results/filter_chart')?>',
			dataType: 'json',
			data:{'marker_title':marker_title, 'testId': testId},
			method: 'post'
		}).done(function (response) {
			
		  
			
			$("#graph").empty();

			if(marker_title == ""){
				Morris.Line({
					element: 'graph',
					data:response, //[{"y":"2019-04-18","x":10,"x1":20},{"y":"2019-05-18","x":20,"x1":33},{"y":"2020-03-18","x":37,"x1":42}],  //response,

					xkey: 'y',

					<?php 
			
					$ykeys = "['x'";
					//$labels = "['Result Vlaue'";

					for($i=1; $i < $results[0]->no_of_markers; $i++){

						$ykeys.=", 'x".$i."'";
						//$labels.=", 'Result Vlaue'";
						//array_push($ykeys,'x'.$i);
						//array_push($labels,'Result Vlaue');

					}
					
					$ykeys.="]";
					//$labels.="]";
					
					?>

					ykeys : <?php echo $ykeys; ?>,
					labels: <?php echo $lbls; ?>,

					padding: 100,

					xLabelFormat: function (x) {
						// var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
						// var month = IndexToMonth[ x.getMonth() ];
						// var year = x.getFullYear();
						// return date('Y-d-m', x); //year + ' ' + month;
						return formatDate(x);
					},
					dateFormat: function (x) {
						// var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
						// var month = IndexToMonth[ new Date(x).getMonth() ];
						// var year = new Date(x).getFullYear();
						// var dt = new Date(x);
						// return dt; //year + ' ' + month;
						return formatDate(x);
					},
					resize: true

				});
			}else{

				<?php //$res_unit = " (" .$results[0]->resultUnit.") "; ?>

				Morris.Line({
					element: 'graph',
					data:response, //[{"y":"2019-04-18","x":10,"x1":20},{"y":"2019-05-18","x":20,"x1":33},{"y":"2020-03-18","x":37,"x1":42}],  //response,

					xkey: 'y',
					ykeys : ['x'],
					labels: [marker_title+' ('+m_unit+')'], //['Result Vlaue'] ,

					padding: 100,
		
					xLabelFormat: function (x) {
						//var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
						//var month = IndexToMonth[ x.getMonth() ];
						//var year = x.getFullYear();
						return formatDate(x);
						//return x; //year + ' ' + month;
					},
					dateFormat: function (x) {
						//var IndexToMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
						//var month = IndexToMonth[ new Date(x).getMonth() ];
						//var year = new Date(x).getFullYear();

						return formatDate(x);
						//return x; //year + ' ' + month;
					},
					resize: true

				});
			}
		
			
		
		}).fail(function(){
			
		});

}


function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [day, month, year].join('/');
}

</script>





														<div class="clearfix"></div>
													</div>
												</div>
												<div class="d-print-none">
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
											</div>

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
	<?php //$this->load->view('includes/footer'); ?>
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
    <?php
	
	$IndexToMonth = '[';
	foreach($kkk as $month) {
		$m = date('M', strtotime($month['y']));
		$IndexToMonth.='"'.$m.'",';
	}
	$IndexToMonth = substr($IndexToMonth, 0, -1).']';
	//echo $IndexToMonth;
    // $result_analytics1 = [];
    // foreach($result_analytics as $idx => $row) {
    //     if ($row['x'] != 0) {
    //         $result_analytics1[] = $row;
    //     }
    // }
    
    //echo 'vvvvvvvv'; echo '<pre>'; print_r($result_analytics1); //if($order_details->resultHistory=='Yes'){ ?>
		// Use Morris.Bar
		Morris.Line({
			element: 'graph',
			data:[
				<?php
				foreach($kkk as $month) {
					echo json_encode($month).',';
				}?>],
			xkey: 'y',
			//xmax: <?php echo $results[0]->no_of_markers; ?>, // set this value according to your liking

			//ykeys: ['x'],
			//labels: ['Result Value'] ,

			<?php 
			
			$ykeys = "['x'";


			// $labels="['";
			// $mrkrs = $this->db->query("select tm_title from test_markers_value where tm_test_id where tm_test_idssss")->result();
			// foreach($mrkrs as $t){
			// 	$labels.=$t->tm_title."','";
			// }

			// $labels = substr($labels, 0,-2);
			// $labels .= "']"; 

			// echo $labels; exit;
			
			//$labels = "['Result Vlaue'";

			for($i=1; $i < $results[0]->no_of_markers; $i++){

				$ykeys.=", 'x".$i."'";
				$labels.=", 'Result Vlaue'";
				//array_push($ykeys,'x'.$i);
				//array_push($labels,'Result Vlaue');

			}
			
			$ykeys.="]";
			$labels.="]";
			
			?>

			ykeys : <?php echo $ykeys; ?>,
			labels: <?php echo $lbls; ?>,

			padding: 100,

			//xLabelMargin: 10,
			//pointFillColors:['#green'],
			// pointStrokeColors: ['black'],
			// lineColors:['gray','red'],
			//gridTextColor:['#green'],
			//xLabelAngle: 45,
			//xLabelMargin: 500,
			//behaveLikeLine: true,

			xLabelFormat: function (x) {
				// var IndexToMonth = <?php //echo $IndexToMonth; ?> [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
				// var month = IndexToMonth[ x.getMonth() ];
				// var year = x.getFullYear();
				// return year + ' ' + month;
				return formatDate(new Date(x));
			},
			dateFormat: function (x) {
				// var IndexToMonth = <?php //echo $IndexToMonth; ?> [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
				// var month = IndexToMonth[ new Date(x).getMonth() ];
				// var year = new Date(x).getFullYear();
				// return year + ' ' + month;
				return formatDate(new Date(x));
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


<?php $this->load->view('includes/footer'); ?>
