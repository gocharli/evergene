<?php
	foreach ($results as $row) {
?>
		<div class="panel panel-default" style="margin-bottom: 0px !important;">
			<div class="panel-heading" role="tab" id="headingOne" style="padding: 10px 0px !important;">			
					<div class="col-lg-4 col-sm-4"><?=date('F d,Y',strtotime($row->createdAt))?></div>
					<div class="col-lg-4 col-sm-4">#<?=$row->orderId?></div>			
					<div class="col-lg-4 col-sm-4">£<?=$row->paidAmount?></div>					
			<div class="clearfix"></div>
			</div>	
		</div>
<?php 
	}
?>
