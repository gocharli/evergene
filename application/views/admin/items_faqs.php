<?php $this->load->view('admin/includes/head'); ?>
<!-- Data Table Css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/data-table/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/component.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/bower_components/select2/css/select2.min.css" />
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">
<style type="text/css">
	.j-pro input[type="search"] {
		height: 30px;
	}

	span.select2-container {
		z-index: 10050;
	}
</style>
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
												<h5><?= $row->testName ?> <?= $page_title ?></h5>
												<span><?= $row->testName ?> <?= $page_title ?> Management</span>
											</div>
											<div class="card-block">
												<div class="row">
													<div class="col-md-12">
														<div class="animation-model">
															<button type="button" class="btn btn-primary btn-outline-primary waves-effect md-trigger" data-modal="modal-8">Add New</button>
															<button type="button" class="btn btn-primary btn-outline-primary waves-effect md-trigger" data-modal="modal-9">Use Multi Faqs</button>

														</div>
													</div>
												</div>
												<div class="dt-responsive table-responsive">
													<table id="dt-server-processing" class="table table-striped table-bordered nowrap">
														<thead>
															<tr>
																<th> FAQs</th>
																<th style="width: 100px;"> Action</th>
															</tr>
														</thead>
													</table>
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
	<div class="md-modal md-effect-8" id="modal-8">
		<div class="md-content">
			<h3>ADD FAQ</h3>
			<div>
				<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/items/edit_faq_code" method="post" class="j-pro">
					<div class="j-content">
						<div class="j-unit">
							<label class="j-label" style="margin: 15px 0px; font-size: 18px;">Title</label>
							<div class="j-input">
								<label class="j-icon-right" for="faqTitle">
									<i class="icofont icofont-support-faq"></i>
								</label>
								<input type="text" id="faqTitle" name="faqTitle">
								<span class="j-tooltip j-tooltip-right-top">Enter faq title</span>
							</div>
							<div class="j-unit">
								<label class="j-label" style="margin: 15px 0px; font-size: 18px;">Detail</label>
								<div class="j-input">
									<textarea spellcheck="false" id="faqDescription" name="faqDescription"></textarea>
								</div>
							</div>
						</div>
					</div>
					<!-- end /.content -->
					<div class="j-footer">
						<input type="hidden" name="testId" value="<?= $row->testId ?>">
						<button type="button" class="btn btn-primary waves-effect md-close">Close</button>
						<button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save</button>
					</div>
					<!-- end /.footer -->
				</form>
			</div>
		</div>
	</div>
	<div class="md-modal md-effect-8" id="modal-9" tabindex="-1">
		<div class="md-content">
			<h3>FAQs</h3>
			<div>
				<form id="frm_2" action="<?= $this->config->item('admin_url') ?>/items/rel_faq_code" method="post" class="j-pro">
					<div class="j-content">
						<div class="j-unit">
							<label class="j-label" style="margin: 15px 0px; font-size: 18px;">Title</label>
							<div class="j-input j-select">
								<select class="js-example-basic-single" id="rfaqId" name="rfaqId[]" multiple="multiple" style="width: 100% !important; height:30px!important">

									<?php
									$found = array();
									$f = $this->db->query("SELECT * FROM faq_relations WHERE faq_relations.testId=" . $row->testId . " group by faq_relations.faqId")->result();
									foreach ($f as $rf) {
										$found[] = $rf->faqId;
									}
									if (count($found) > 0) {
										$im = implode(',', $found);
										$faqs = $this->db->query("SELECT * FROM faqs WHERE faqs.faqId NOT IN (" . $im . ") ")->result();
									} else {
										$faqs = $this->db->query("SELECT * FROM faqs")->result();
									}
									foreach ($faqs as $faq) { ?>
										<option value="<?= $faq->faqId ?>"><?= $faq->faqTitle ?></option>
									<?php  } ?>
								</select>
							</div>
						</div>
					</div>
					<!-- end /.content -->
					<div class="j-footer">
						<input type="hidden" name="testId" value="<?= $row->testId ?>">
						<button type="button" class="btn btn-primary waves-effect md-close">Close</button>
						<button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save</button>
					</div>
					<!-- end /.footer -->
				</form>
			</div>
		</div>
	</div>
	<div class="md-overlay"></div>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>

	<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/select2/js/select2.full.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script><!-- Custom js -->
	<script src="<?= base_url() ?>assets/admin/assets/js/classie.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/js/modalEffects.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>


	<script type="text/javascript">
		$('#rfaqId').select2({});

		// Server side processing Data-table
		$('#dt-server-processing').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				"url": admin_url + "items/list_faqs_data/<?= $row->testId ?>",
				"dataType": "json",
				"type": "POST",
				"data": {}
			},
			"columns": [{
					"data": "faq"
				},
				{
					"data": "action"
				}
			]
		});
		CKEDITOR.replace('faqDescription', {
			toolbar: [{
				name: 'document',
				items: ['Print']
			}, {
				name: 'clipboard',
				items: ['Undo', 'Redo']
			}, {
				name: 'styles',
				items: ['Format', 'Font', 'FontSize']
			}, {
				name: 'basicstyles',
				items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
			}, {
				name: 'colors',
				items: ['TextColor', 'BGColor']
			}, {
				name: 'align',
				items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
			}, {
				name: 'links',
				items: ['Link', 'Unlink']
			}, {
				name: 'paragraph',
				items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
			}, {
				name: 'insert',
				items: ['Table']
			}, {
				name: 'tools',
				items: ['Maximize']
			}, {
				name: 'editing',
				items: ['Scayt']
			}],
			customConfig: '',
			height: 200,
			contentsCss: ['assets/pages/ckeditor/contents.css', 'assets/pages/ckeditor/document.css'],
			bodyClass: 'document-editor',
			format_tags: 'p;h1;h2;h3;pre',
			removeDialogTabs: 'image:advanced;link:advanced',
			stylesSet: [
				/* Inline Styles */
				{
					name: 'Marker',
					element: 'span',
					attributes: {
						'class': 'marker'
					}
				}, {
					name: 'Cited Work',
					element: 'cite'
				}, {
					name: 'Inline Quotation',
					element: 'q'
				},
				/* Object Styles */
				{
					name: 'Special Container',
					element: 'div',
					styles: {
						padding: '5px 10px',
						background: '#eee',
						border: '1px solid #ccc'
					}
				}, {
					name: 'Compact table',
					element: 'table',
					attributes: {
						cellpadding: '5',
						cellspacing: '0',
						border: '1',
						bordercolor: '#ccc'
					},
					styles: {
						'border-collapse': 'collapse'
					}
				}, {
					name: 'Borderless Table',
					element: 'table',
					styles: {
						'border-style': 'hidden',
						'background-color': '#E6E6FA'
					}
				}, {
					name: 'Square Bulleted List',
					element: 'ul',
					styles: {
						'list-style-type': 'square'
					}
				}
			]
		});
		$('#frm_2').submit(function(evt) {
			var frm = $(this);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data: frm.serialize(),
						method: 'post',
						cache: false,
					}).done(function(response) {
						self.close();
						if (response.code == 0) {
							$.confirm({
								title: 'Error!',
								icon: 'fa fa-warning',
								closeIcon: true,
								content: response.message,
								type: 'red',
								autoClose: 'close|10000',
								typeAnimated: true,
								buttons: {
									close: function() {}
								}
							});
						} else {
							$.confirm({
								title: 'Success!',
								icon: 'fa fa-check',
								content: response.message,
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function() {
											$('#rfaqId').val(null).trigger('change');
											location.reload();
										}

									}
								}
							});
						}
					}).fail(function() {
						self.close();
						$.confirm({
							title: 'Encountered an error!',
							content: 'Something went wrong.',
							type: 'red',
							typeAnimated: true,
							buttons: {
								close: function() {}
							}
						});
					});
				},
				buttons: {
					close: function() {}
				}
			});
			return false;
		});
		$('#frm_1').submit(function(evt) {
			var frm = $(this);
			var formData = new FormData($('form#frm_1').get(0));
			var faqDescription = CKEDITOR.instances.faqDescription.getData();
			formData.set('faqDescription', faqDescription);
			$.confirm({
				icon: 'fa fa-spinner fa-spin',
				title: 'Working!',
				content: function() {
					var self = this;
					return $.ajax({
						url: frm.attr('action'),
						dataType: 'json',
						data: formData,
						processData: false,
						contentType: false,
						method: 'post',
						cache: false,
					}).done(function(response) {
						self.close();
						if (response.code == 0) {
							$.confirm({
								title: 'Error!',
								icon: 'fa fa-warning',
								closeIcon: true,
								content: response.message,
								type: 'red',
								autoClose: 'close|10000',
								typeAnimated: true,
								buttons: {
									close: function() {}
								}
							});
						} else {
							$.confirm({
								title: 'Success!',
								icon: 'fa fa-check',
								content: response.message,
								type: 'green',
								typeAnimated: true,
								buttons: {
									ok: {
										text: 'Ok',
										btnClass: 'btn-green',
										action: function() {
											location.reload();
										}

									}
								}
							});
						}
					}).fail(function() {
						self.close();
						$.confirm({
							title: 'Encountered an error!',
							content: 'Something went wrong.',
							type: 'red',
							typeAnimated: true,
							buttons: {
								close: function() {}
							}
						});
					});
				},
				buttons: {
					close: function() {}
				}
			});
			return false;
		});

		function del(e, id) {
			$.confirm({
				title: 'Status!',
				content: 'Are you want to delete ?',
				type: 'red',
				typeAnimated: true,
				buttons: {
					Yes: {
						text: 'Yes',
						btnClass: 'btn-red',
						action: function() {

							$.confirm({
								icon: 'fa fa-spinner fa-spin',
								title: 'Working!',
								content: function() {
									var self = this;
									return $.ajax({
										url: "<?php echo base_url(); ?>admin/faqs/delete_faq",
										dataType: 'json',
										data: {
											id: id
										},
										method: 'post'
									}).done(function(response) {
										self.close();

										if (response.code == 0) {
											$.confirm({
												title: 'Error!',
												icon: 'fa fa-warning',
												closeIcon: true,
												content: response.message,
												type: 'red',
												autoClose: 'close|5000',
												typeAnimated: true,
												buttons: {
													close: function() {}
												}
											});
										} else {
											$.confirm({
												title: 'Success!',
												icon: 'fa fa-check',
												content: response.message,
												type: 'green',
												autoClose: 'ok|5000',
												typeAnimated: true,
												buttons: {
													ok: {
														text: 'Ok',
														btnClass: 'btn-green',
														action: function() {
															$(e).closest("tr").remove();
														}

													}
												}
											});

										}

									}).fail(function() {
										self.close();
										$.confirm({
											title: 'Encountered an error!',
											content: 'Something went wrong.',
											type: 'red',
											typeAnimated: true,
											buttons: {
												close: function() {}
											}
										});

									});
								},
								buttons: {
									close: function() {}
								}
							});

						}
					},
					No: function() {}
				}
			});

		}
	</script>

</body>

</html>