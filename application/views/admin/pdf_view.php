<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/test.css">
</head>

<body>

	<h1>Test Results </h1>
	<label>Test Name:</label>
	<strong><?= $results[0]->testName ?> </strong>
	<br>
	<label>Date Sample Taken:</label>
	<strong><?= $results[0]->sample_taken_on ?></strong>
	<br>
	<label>Date Result Processed:</label>
	<strong><?= $results[0]->result_processed_on ?></strong>

	<div class="view-info">
		<div id="html-2-pdfwrapper">
			<?php
			foreach ($results as $res) {

				$first_range = 0;
				$second_range = 1000;
				$range = $res->resultRange;
				$pos = strpos($range, '-');

				if ($pos != false) {

					$range = explode('-', $range);

					if (isset($range[1])) {

						$first_range = preg_replace('/\s+/', '', $range[0]);
						$second_range = preg_replace('/\s+/', '', $range[1]);
					}
				}

				@$pos = strpos($range, '>');

				if ($pos != false) {

					$range = explode('>', $range);

					if (isset($range[1])) {

						$first_range = preg_replace('/\s+/', '', $range[0]);
						$second_range = preg_replace('/\s+/', '', $range[1]);
					}
				}

				@$pos = strpos($range, '<');

				if ($pos != false) {

					$range = explode('<', $range);
					if (isset($range[1])) {

						$first_range = preg_replace('/\s+/', '', $range[0]);
						$second_range = preg_replace('/\s+/', '', $range[1]);
					}
				}

				if ($first_range == '') {

					$first_range = 0;
				}

				if ($second_range == '') {

					$second_range = 1000;
				}

				$resulValue = $res->resultValue;
				$max = max($first_range, $second_range, $resulValue);
				$min = min($first_range, $second_range, $resulValue);
				$interval = ($max - $min) / 8;
				$start = $min - $interval;
				$end = $max + $interval;
			?>

				<h3><?php echo $res->marker_title; ?></h3>
				<p><?php echo $res->topText ?></p>

				<div class="single-service">
					<div class="price-ranger col-lg-12">

						<div class='ruler' id="ruler_<?= $res->resultId ?>">
							<?php
							for ($i = 0; $i <= 9; $i++) {
								$val = ($start + ($i * $interval));
								$next = ($val + $interval);
								$int = ($next - $val) / 10;
							?>
								<style type="text/css">
									#ruler_<?= $res->resultId ?>.cm:nth-of-type(<?= $i + 1 ?>)::after {
										content: "<?= $val ?>" !important;
									}
								</style>
								<div class='cm'>
									<?php
									for ($k = 0; $k < 10; $k++) {
										$cvalue = ($val + ($k * $int));
										$nvalue = ($cvalue + $int);
									?>
										<div class='mm <?php if ($resulValue >= $cvalue && $resulValue < $nvalue) {
															echo 'result';
														} ?> <?php if ($first_range <= $cvalue &&  $second_range >= $cvalue) {
																																		echo 'ruler_active';
																																	} ?>'>
										</div>
									<?php
									}
									?>
								</div>
							<?php
							}
							?>
						</div>

					</div>
					<div class="res_div">Result = <?php echo $res->resultValue ?> <?php echo $res->resultUnit ?></div>
				</div>

				<p><?php echo $res->bottomText ?></p>

			<?php
			}
			?>
		</div>
	</div>

</body>

</html>