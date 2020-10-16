<script type="text/javascript">
	var admin_url = "<?= base_url() ?>admin/";
	var base_url = "<?= base_url() ?>";
</script>
<!-- Required Jquery -->
<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- waves js -->
<script src="<?= base_url() ?>assets/admin/assets/pages/waves/js/waves.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>assets/admin/assets/js/pcoded.min.js"></script>
<script src="<?= base_url() ?>assets/admin/assets/js/vertical/vertical-layout.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/js/script.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jquery-confirm/jquery-confirm.min.js" type="text/javascript"></script>
<script type="text/javascript">
	// notification //
	<?php if (isset($this->session_data->adminID)) { ?>

		function notifications(notificationId) {
			if (notificationId == '') {
				return false;
			}
			$.ajax({

				type: "post",
				dataType: "json",
				url: admin_url + 'notifications/read',
				data: {
					'notificationId': notificationId
				},
				success: function(data) {
					if (data.code == 1) {
						$('#notification_' + notificationId).removeClass('bg-warning');
						window.open(admin_url + data.link, '_blank');
					}
				}
			});
		}

		function allnotify() {
			$.ajax({
				type: "post",
				dataType: "json",
				url: admin_url + 'notifications/top',
				success: function(data) {
					$("#notificationMenu").html(data.result);
					$("#not_cnt").html(data.total);

				}

			});
		}


		allnotify();
		setInterval(function() {
			allnotify()
		}, 5000);
	<?php } ?>
</script>