<?php $this->load->view('includes/head');   ?>
<?php if($order_details->testResultType=='Result 3' || $order_details->testResultType=='Result 2'){ ?>
	<link rel="stylesheet" href="<?=base_url('assets/plugins/morris')?>/morris.css">
	
	

<?php } ?>

<style>
	#zoom-in-button{
		display: none;
	}
	</style>

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
					<div class="col-md-12 row m-0 test-result-mb">
                        <div class="col-md-3 p-0">
					       <h5 class="pull-left" style="padding: 15px 0; ">Results</h5>
                         </div>
                        <div class="col-md-9 p-0">
                            <a href="<?=base_url('results')?>" class="tran3s custom-btn small-btn pull-right  ml-0">Back</a>
                            <a href="<?=base_url()?>tests/<?php echo str_replace(" ","-",$order_details->testName); ?>" class="tran3s custom-btn small-btn pull-right" >Reorder</a>

                            <?php if(count($previous_results) > 0){ ?>
                                <select class="form-control pull-right test-result-select" style="width: 200px; height: 53px;" onchange="go_get_result(this.value)">
                                    <option value="0">Previous Results</option>
                                    <?php foreach($previous_results as $p){ ?>

                                        <option value="<?php echo $p->detailId; ?>"><?php echo date('d F Y',strtotime($p->resultReceivedDate)); ?></option>

                                    <?php } ?>
                                </select>

                            <?php }else{ ?>

                                <h6 class="pull-right" style="padding: 15px 0;">No Result History</h6>

                            <?php } ?>
                        </div>
					<div class="clearfix"></div>
				</div>

				<div class="clearfix"></div>
				<div class="col-lg-12 col-md-12 col-xs-12 float-right p-0">
					<div class="shop-product-wrapper service-version-one">

						<div class="row">
							<div class="col-lg-12 col-xs-12">

								<div id="html-2-pdfwrapper" class="single-product shop-sidebar result-type">
								    <div >
									<div class="product-header">
										<h6 class="print-design"><img src="<?=base_url(); ?>uploads/tests/logo/<?php echo $order_details->testLogo; ?>" alt="" style="width:10%"/>
                                            <span style="padding:1% 0%"> <?=$order_details->testName?> <small style="line-height:56px">(Date : <?=date('d F Y',strtotime($order_details->resultReceivedDate))?>)</small></span>
										</h6>
										
										<div class="row">
										    <br><br>
											<div class="col-lg-12">
												<table class="table table-borderless table-sm result-table">
												  	<thead>
												  	    <tr>
												    		<td scope="col">
												      			<strong>Patient ID: <?php echo $order_details->userId; ?></strong>
												      			
												      		</td>
												      		<td scope="col">
												      			<strong>First Name: <?php echo $order_details->userFirstName; ?></strong>
												      			
												      		</td>
												      		<td scope="col">
												      			<strong>Last Name: 	<?php echo $order_details->userLastName; ?></strong>
												      		
												      		</td>
												    	</tr>
												    	<tr>
												      		<td scope="col">
												      			<strong>DoB: 	<?php echo date('d F Y',strtotime($order_details->dob)); ?></strong>
												      		
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

									<div class="row">
                                                <div class="col-md-12 col-xs-12 mix technical investment m-0">


												<h5 class="mb-15">Description</h5>
												<p class="mb-15"> <?php echo $results[0]->testDescription; ?></p>


												<?php $var=explode(',',$results[0]->result4File);
												
												$c=1; if(!empty($results[0]->result4File)){ foreach($var as $f){ ?>


													

													
													<!-- <a target="_blank" href="<?php echo base_url().'uploads/results/'.$f; ?>"><?php echo $f; ?></a> -->
														<?php if (strpos($f, 'pdf') !== false) { ?>
									        	        	<div class="single-service" >
																<embed src="<?php echo base_url().'uploads/results/'.$f; ?>#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&view=FitH&zoom=0&pagemode=none" type="application/pdf" width="100%" height="600px" />
															
																<!-- <object data="<?php echo base_url().'uploads/results/'.$f; ?>" type="pdf/html" width="100%" height="600px">
																
																</object> -->
															
															
															</div>
														<?php }else if(stripos($f, 'JPEG') !== false || stripos($f, 'PNG') !== false || stripos($f, 'GIF') !== false || stripos($f, 'TIFF') !== false || stripos($f, 'jpg') !== false) { ?> 
															<div class="single-service">
																<img src="<?php echo base_url().'uploads/results/'.$f; ?>" width="100%">
															</div>
														<?php }else{ ?>
															<div class="single-service" style="min-height: 20px;">
																<a target="_blank" href="<?php echo base_url().'uploads/results/'.$f; ?>"><?php echo $f; ?></a>
															</div>
															
														<?php } ?>
														
														

														<div class="d-print-none">
															<a target="_blank" href="<?php echo base_url().'uploads/results/'.$f; ?>" class="tran3s custom-btn pull-left">Download Results</a>
															<!-- <a href="javascript:;" onclick="generate()" class="tran3s custom-btn pull-left">Download Results</a> -->
															<br>
															<br>
															<br>
														</div>

													
														

												<?php } } ?>



									        	    <!-- <div class="single-service">
									        	        <embed src="<?=base_url('assets/dummy.pdf')?>" type="application/pdf" width="100%" height="600px" />
									        	    </div>
									        	    <div class="single-service">
									        	        <img src="<?=base_url('assets/testResult.png')?>" width="100%">
									        	    </div> -->
												
									     
											
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

	
	<?php $this->load->view('includes/footer'); ?>

	<script>

		function generate()
		{
			var divToPrint=document.getElementById('html-2-pdfwrapper');

			var newWin=window.open('','Print-Window');

			newWin.document.open();

			newWin.document.write("<html><head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' ><link rel='stylesheet' type='text/css' href='<?=base_url('assets/front/')?>css/style.css'><style type='text/css'>.ruler_active {background: #86c44c !important;height: 34px !important;border-left: 0px !important;width: 11% !important; -webkit-print-color-adjust: exact; }</style></head><body onload='window.print()'><h2 style='text-align:center'>Results <?=$order_details->testName?></h2>"+divToPrint.innerHTML+"</body></html>");

			newWin.document.close();

			setTimeout(function(){newWin.close();},10);
		}

	</script>