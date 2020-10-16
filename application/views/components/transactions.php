<?php
foreach ($results as $row) {
?>
	<div class="panel panel-default" style="margin-bottom: 0px !important;">
		<div class="panel-heading" role="tab" id="headingOne" style="padding: 10px 0px !important;">
			<div class="col-lg-3 col-sm-3"><?= date('d F Y', strtotime($row->createdAt)) ?></div>
			<div class="col-lg-3 col-sm-3">#<?= $row->orderId ?></div>
			<div class="col-lg-3 col-sm-3">#<?= $row->trx_id ?></div>
			<div class="col-lg-3 col-sm-3" style="text-align: center">£<?= $row->paidAmount ?></div>
			<div class="clearfix"></div>
		</div>
	</div>
<?php
}
?>