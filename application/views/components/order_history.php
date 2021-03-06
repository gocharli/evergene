<?php
foreach ($orders as $row) {

	$detail = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details LEFT JOIN tests ON order_details.testId=tests.testId WHERE order_details.orderId=' . $row->orderId)->result();

	$dsss = 1;
	foreach ($detail as $d) {
		if ($d->detailStatus != 'Completed') {
			$dsss = 0;
		}
	}
?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#order<?= $row->orderGroupId ?>" aria-expanded="true" aria-controls="collapseOne" style="width: 100%;" onclick="odr_status();">
					<div class="table-row">

						<div class="col-lg-3 col-sm-3 col-xs-3 p-0-mb">
							<?= date('d F Y', strtotime($row->createdAt)) ?>
						</div>

						<div class="col-lg-3 col-sm-3 col-xs-3 ">
							#<?= $row->orderId ?>
						</div>

						<div class="col-lg-3 col-sm-3 col-xs-3">
							£<?= number_format($row->orderAmount) . ".00" ?>
						</div>

						<div class="col-lg-3 col-sm-3 col-xs-3">

							<?php
							if ($dsss == 1) {

							?>
								<img id="order_up<?= $row->orderGroupId ?>" src="<?php echo base_url() . 'assets/admin/icon-img-up.png'; ?>">
							<?php
							}
							?>
						</div>
						<i class="icon-down fa fa-angle-down"></i>
					</div>
				</a>
			</h4>
		</div>

		<div id="order<?= $row->orderGroupId ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
				<?php
				$detail = $this->db->query('select order_details.*,tests.testName,tests.testLogo from order_details LEFT JOIN tests ON order_details.testId=tests.testId WHERE order_details.orderId=' . $row->orderId)->result();

				foreach ($detail as $d) {
				?>
					<div class="table-row" style="margin-top:10px">
						<div class="col-lg-2"><img class="img-responsive" src="<?= base_url('uploads/tests/logo/') . $d->testLogo ?>" alt="" /></div>
						<div class="col-lg-1"></div>
						<div class="col-lg-3"><?= $d->testName ?><br /> (<?= date('d F Y', strtotime($d->scheduleDate)) ?>)</div>
						<div class="col-lg-3">£<?= number_format($d->detailPrice) . ".00" ?></div>
						<div class="col-lg-3"> <strong class="status-mb">Status:</strong> <?php if ($d->order_cancel_status == 1) {
																								echo '<span style="color: red">Cancelled</span>';
																							} else {
																								if ($d->detailStatus == 'Pending' && strtotime($d->scheduleDate) != strtotime(date('Y-m-d'))) echo 'Scheduled';
																								else echo $d->detailStatus;
																							} //echo $d->detailStatus; 
																							?></div>

						<?php
						if ($d->paymentStatus == 'Yes') {
							echo 'Paid';
						} else {
							echo 'Not Paid';
						}
						?>
					</div>
					<div class="clearfix"></div>
				<?php
				}
				?>

				<hr />
				<div class="table-row" style="margin-top:10px">
					<div class="col-lg-6">

						<b>Order Summary</b> <br><br>

						<b>Units Ordered :</b> <?= $detail[0]->detailQty ?><br>
						<b>Total :</b> £ <?= $row->orderAmount ?><br>

					</div>
					<div class="col-lg-6"><b>Shipping Information</b>
						<br> Free Shipping <br>
						<b><?= $row->orderShipName ?></b> <br>
						<?= $row->orderShipAddress ?> <br>
						<?= $row->orderCity ?> <?= $row->orderState ?>, <?= $row->orderPostalCode ?> <br>
					</div>

					<?php
					if ($row->subscriptionCancel == 'No' && $row->directDebit == 'Yes') {
					?>
						<div class="col-md-12">
							<button class="tran3s cart-button btn-pay hvr-trim-two" href="javascript:;" onclick="cancel_subscription(<?= $row->orderGroupId ?>)">Cancel Subscription</button>
						</div>
					<?php
					}
					?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
<?php
}
?>