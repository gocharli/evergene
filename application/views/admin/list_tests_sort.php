<?php $this->load->view('admin/includes/head'); ?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">


<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<style>
	#sortable {
		list-style-type: none;
		margin: 0;
		padding: 0;
		width: 60%;
	}

	#sortable li {
		padding: 0.4em;
		padding-left: 1.5em;
		font-size: 1.4em;
	}

	#sortable li span {
		position: absolute;
		margin-left: -1.3em;
	}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(function() {
		$("#sortable").sortable();
		$("#sortable").disableSelection();
	});
</script>


</head>

<body>
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-bar"></div>
	</div>
	<!-- [ Pre-loader ] end -->
	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">
			<!-- [ Header ] start -->
			<?php $this->load->view('admin/includes/menu'); ?>
			<!-- [ Header ] end -->
			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
					<!-- [ navigation menu ] start -->
					<?php $this->load->view('admin/includes/sidebar'); ?>
					<!-- [ navigation menu ] end -->
					<div class="pcoded-content">
						<!-- [ breadcrumb ] start -->
						<div class="page-header">
							<div class="page-block">
								<div class="row align-items-center">
									<div class="col-md-8">
										<div class="page-header-title">
											<h4 class="m-b-10"><?= $page_title ?></h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item"><a href="javascript:;"><?= $page_title ?></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- [ breadcrumb ] end -->
						<div class="pcoded-inner-content">
							<div class="main-body">
								<div class="page-wrapper">
									<div class="page-body">
										<!-- Server Side Processing table start -->
										<div class="card">
											<div class="card-header">
												<h5><?= $page_title ?></h5>
												<span><?= $page_title ?> Management</span>
											</div>
											<div class="card-block">
												<div class="dt-responsive table-responsive">


													<ul id="sortable">

														<?php foreach ($tests as $t) { ?>

															<li class="<?php echo $t->sort; ?> ui-state-default" id="item_<?php echo $t->testId;  ?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $t->testName . '    (' . $t->categoryName . ')'; ?> </li>

														<?php } ?>
													</ul>


												</div>
											</div>
										</div>
										<!-- Server Side Processing table end -->
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>



	<script>
		$(function() {



			$(".ui-sortable").sortable({
				connectWith: ".connected-sortable",
				stack: '.connected-sortable ul',

				stop: function(event, ui) {
					//console.log(ui); 
					//var target_class = $(ui.item).parent().attr('id');
					var target_class = $(ui.item).attr('id');

					//alert(target_class); return;

					var movement = ui.position.top - ui.originalPosition.top > 0 ? "down" : "up";
					//alert(movement); return;	
					var moved = ui.item;
					replaced = ui.item.prev();
					// if replaced.length === 0 then the item has been pushed to the top of the list
					// in this case we need the .next() sibling
					if (replaced.length === 0) {
						//alert("")
						replaced = ui.item.next();
						//moved = ui.item.prev();					
					} else {
						if (movement == "up") {
							replaced = ui.item.next();
						}
					}

					var fsid = moved.attr("class");
					var ssid = replaced.attr("class");

					var f = fsid.split(" ");
					var second_id;

					if (ssid) { // if second list is not empty
						//alert("list"); 
						var s = ssid.split(" ");
						ssid = s[0];
						second_id = replaced.attr("id"); //alert(first_id); return;
						var si = second_id.split("_");
						second_id = si[1];
					} else { // second list is empty, there is no item in drop list
						//alert("list"); 
						second_id = 0;
						ssid = 0;
					}


					fsid = f[0];
					//alert("1st_sid = "+fsid);	//alert("2nd_sid = "+ssid);
					var first_id = moved.attr("id");
					var fi = first_id.split("_");
					first_id = fi[1];


					$.ajax({

						type: "POST",
						url: "<?php echo base_url(); ?>admin/tests/update_order",
						data: {
							first_id: first_id,
							second_id: second_id,
							fsid: fsid,
							ssid: ssid
						},
						success: function(data) {

							var dec_ids = JSON.parse(data);
							if (movement == 'up') {

								$.each(dec_ids, function(id, sid) {

									//alert("id = "+id+" sid = "+sid);
									$("#item_" + id).attr("class", "");

									$("#item_" + id).attr("class", sid);
									$("#item_" + id).addClass('ui-state-default');
									$("#item_" + id).addClass('ui-sortable-handle');
									//$("#item_"+id).addClass('kanban-entry');

								});

								$("#item_" + first_id).removeClass(fsid);
								$("#item_" + first_id).removeClass('ui-state-default');
								$("#item_" + first_id).removeClass('ui-sortable-handle');
								//$("#item_"+first_id).removeClass('kanban-entry');

								$("#item_" + first_id).addClass(ssid);
								$("#item_" + first_id).addClass('ui-state-default');
								$("#item_" + first_id).addClass('ui-sortable-handle');
								//$("#item_"+first_id).addClass('kanban-entry');

							} else {

								$.each(dec_ids, function(id, sid) {

									//alert(id+"  "+sid);
									$("#item_" + id).attr("class", "");

									$("#item_" + id).attr("class", sid);
									$("#item_" + id).addClass('ui-state-default');
									$("#item_" + id).addClass('ui-sortable-handle');
									//$("#item_"+id).addClass('kanban-entry');
								});

								$("#item_" + first_id).removeClass(fsid);
								$("#item_" + first_id).removeClass('ui-state-default');
								$("#item_" + first_id).removeClass('ui-sortable-handle');
								//$("#item_"+first_id).removeClass('kanban-entry');

								$("#item_" + first_id).addClass(ssid);
								$("#item_" + first_id).addClass('ui-state-default');
								$("#item_" + first_id).addClass('ui-sortable-handle');
								//$("#item_"+first_id).addClass('kanban-entry');	  				  
							}
						}
					});

					//alert("1st_id = "+first_id);	alert("2nd_id = "+second_id); 
					return;

				}

			}).disableSelection();


		});
	</script>


	<script>
		// function draggableInit() {

		// 			var sourceId;
		// 			$('[draggable=true]').bind('dragstart', function (event) {
		// 				sourceId = $(this).parent().attr('id');
		// 				//alert(sourceId); return;
		// 				event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
		// 			});

		// 			$('.panel-body').bind('dragover', function (event) {
		// 				event.preventDefault();
		// 			});

		// 			$('.panel-body').bind('drop', function (event) {
		// 				var children = $(this).children();
		// 				var targetId = children.attr('id');

		// 				//alert(targetId);

		// 				var stagetype = targetId.split("_");
		// 				var stage_type_id = stagetype[2];

		// 				//alert(stage_type_id);
		// 				//alert(sourceId);
		// 				var source_stage_id = 1;
		// 				switch (sourceId) {
		// 					case 'sortable_discovery':
		// 						source_stage_id = 1;
		// 						break;
		// 					case 'sortable_contract_made':
		// 						source_stage_id = 2;
		// 						break;
		// 					case 'sortable_proposal_sent':
		// 						source_stage_id = 3;
		// 						break;
		// 					case 'sortable_proposal_signed':
		// 						source_stage_id = 4;
		// 						break;
		// 					case 'sortable_paid':
		// 						source_stage_id = 5;
		// 						break;

		// 					default:
		// 						source_stage_id = 1;
		// 				}

		// 				//alert(stage_type_id);

		// 				//if (sourceId != targetId) {
		// 				if (source_stage_id != stage_type_id) {
		// 					var elementId = event.originalEvent.dataTransfer.getData("text/plain");
		// 					$('#processing-modal').modal('toggle'); //before post

		// 					var item = elementId.split("_");
		// 					var item_id = item[1];


		// 					// Post data 
		// 					setTimeout(function () {
		// 						var element = document.getElementById(elementId);
		// 						children.prepend(element);
		// 						$('#processing-modal').modal('toggle'); // after post
		// 					}, 1000);

		// 					$.ajax({
		// 						type: "POST",
		// 						dataType: 'json',
		// 						url: "<?php echo base_url(); ?>deals/change_status",
		// 						async: false,
		// 						data: {stage_type_id: stage_type_id, item_id: item_id},
		// 						success: function (resp)
		// 						{
		// 							var prev_cnt = $("#"+resp.prev_stage).text();
		// 							var next_cnt = $("#"+resp.new_stage).text();

		// 							$("#"+resp.prev_stage).text(parseInt(prev_cnt)-1);
		// 							$("#"+resp.new_stage).text(parseInt(next_cnt)+1);

		// 						}
		// 					});

		// 				}else{
		// 					//sorting at same stage

		// 					//end sorting at same stage 
		// 				}

		// 				event.preventDefault();
		// 			});
		// }
	</script>

</body>

</html>