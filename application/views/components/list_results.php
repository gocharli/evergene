<?php
	foreach ($results as $row) {  
?>
		<div class="product-list mb-2">
			<div class="row">
				<a href="<?=base_url('results/view/'.$row->detailId)?>" class="order-again">View Detail</a>
				<div class="col-lg-3 col-sm-3 text-center">
					<div class="symbol-icon">
						<img class="img-responsive" src="<?=base_url('uploads/tests/logo/').$row->testLogo?>" alt=""/>
					</div>
				</div><!-- /.col- -->
				<div class="col-lg-9 col-sm-9">
					<div class="results-info-list">
						<ul class="clearfix">
							<li>
								<span class="heading">Name:</span>
								<span class="detail"><?=$row->testName?></span>
								<div class="clearfix"></div>
							</li>
							<li>
								<span class="heading">Date Test Ordered:</span>
								<span class="detail"><?=date('d F Y',strtotime($row->createdAt))?></span>
								<div class="clearfix"></div>
							</li>
							<li>
								<span class="heading">Date Results Received:</span>
								<span class="detail"><?=date('d F Y',strtotime($row->resultReceivedDate))?></span>
								<div class="clearfix"></div>
							</li>
							<li>

<?php

$detailId = $row->detailId; //echo '<pre>'; print_r($row);
$all_orders=$this->db->query('select @acount:=@acount+1 sub_id, order_details.detailId from (SELECT @acount:= 0) AS acount, order_details WHERE orderId='.$row->orderId)->result(); // all order items of the order
$sub_id = 1;
foreach($all_orders as $o){
	// echo $o->sub_id.'  '.$detailId; exit;
	if($o->detailId == $detailId){
		$sub_id = $o->sub_id;
	}
}
// $this->data['sub_id']=$sub_id;

?>

								<span class="heading">Order No:</span>
								<span class="detail"><?=$row->orderId.'-'.$sub_id?></span>
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
