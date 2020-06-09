<?php
	foreach ($results as $row) {  
?>
		<div class="product-list mb-2">
			<div class="row">
				<a href="<?=base_url('results/view/'.$row->detailId)?>" class="order-again">View Detail</a>
				<div class="col-lg-3 text-center">
					<div class="symbol-icon">
						<img src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" style="height: 150px" alt=""/>
					</div>
				</div><!-- /.col- -->
				<div class="col-lg-9">
					<div class="results-info-list">
						<ul class="clearfix">
							<li>
								<span class="heading">Name:</span>
								<span class="detail"><?=$row->testName?></span>
								<div class="clearfix"></div>
							</li>
							<li>
								<span class="heading">Date Test Ordered:</span>
								<span class="detail"><?=date('F d,Y',strtotime($row->createdAt))?></span>
								<div class="clearfix"></div>
							</li>
							<li>
								<span class="heading">Date Results Received:</span>
								<span class="detail"><?=date('F d,Y',strtotime($row->resultReceivedDate))?></span>
								<div class="clearfix"></div>
							</li>
							<li>
								<span class="heading">Order No:</span>
								<span class="detail"><?=$row->orderId?></span>
								<div class="clearfix"></div>
							</li>
						</ul>
					</div> <!-- /.results list -->
				</div><!-- /.col- -->
				<div class="clearfix"></div>
			</div>
		</div>
<?php 
	}
?>
