<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/css/pages.css">
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
												<div class="j-wrapper j-wrapper-640">
													<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/faqs/edit_code" method="post" class="j-pro">
														<div class="j-content">
															<div class="j-unit">
																<label class="j-label" style="margin: 15px 0px; font-size: 18px;">Title</label>
																<div class="j-input">
																	<label class="j-icon-right" for="faqTitle">
																		<i class="icofont icofont-support-faq"></i>
																	</label>
																	<input type="text" id="faqTitle" name="faqTitle" value="<?= $row->faqTitle ?>">
																	<span class="j-tooltip j-tooltip-right-top">Enter faq title</span>
																</div>
																<div class="j-unit">
																	<label class="j-label" style="margin: 15px 0px; font-size: 18px;">Detail</label>
																	<div class="j-input">
																		<textarea spellcheck="false" id="faqDescription" name="faqDescription"><?= $row->faqDescription ?></textarea>
																	</div>
																</div>
															</div>
														</div>
														<!-- end /.content -->
														<div class="j-footer">
															<input type="hidden" name="faqId" value="<?= $row->faqId ?>">
															<button type="submit" class="btn btn-primary">Save</button>
														</div>
														<!-- end /.footer -->
													</form>
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


	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
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
											//location.reload();
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
	</script>

</body>

</html>