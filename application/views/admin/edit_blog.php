<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<!-- Style.css -->
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />



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
											<h4 class="m-b-10">Edit Blog</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/blogs">
													Blogs
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">Edit Blog</a>
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
									<!-- Page body start -->
									<div class="page-body">
										<div class="row">
											<div class="col-sm-12">
												<div class="card">
													<div class="card-header">
														<h5>Edit Blog</h5>
														<span>Edit Blog information</span>
													</div>
													<div class="card-block">
														<div class="j-wrapper j-wrapper-640">
															<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/blogs/edit_process/<?= $row->blogId ?>" method="post" class="j-pro">
																<div class="j-content">

																	<div class="j-unit">
																		<label class="j-label">Title</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<!-- <i class="icofont icofont-ui-user"></i> -->
																			</label>
																			<input type="text" id="blogTitle" value="<?= $row->blogTitle ?>" onfocusout="update_slug(this.value)" name="blogTitle">
																			<span class="j-tooltip j-tooltip-right-top">Enter title</span>
																		</div>
																	</div>


																	<div class="j-unit">
																		<label class="j-label">Page Slug</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<!-- <i class="icofont icofont-ui-user"></i> -->
																			</label>
																			<input type="text" id="blogSlug" onfocusout="update_pageURL(this.value)" value="<?= $row->blogSlug ?>" name="blogSlug">
																			<span class="j-tooltip j-tooltip-right-top">Enter Page Slug</span>
																		</div>
																	</div>

																	<script>
																		function update_slug(title) {

																			var slug = "";
																			$.ajax({
																				url: "<?php echo base_url(); ?>admin/blogs/get_slug",
																				type: "POST",
																				data: {
																					"title": title
																				},
																				success: function(slug) {
																					$("#blogSlug").val(slug);
																					var pageURL = '<?php echo base_url(); ?>blog/view/' + slug;
																					$("#pageURL").val(pageURL);
																				}
																			});
																		}

																		function update_pageURL(slug) {

																			var pageURL = '<?php echo base_url(); ?>blog/view/' + slug;
																			$("#pageURL").val(pageURL);

																		}
																	</script>


																	<div class="j-unit">
																		<label class="j-label">Page URL</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<!-- <i class="icofont icofont-ui-user"></i> -->
																			</label>
																			<input id="pageURL" disabled type="text" value="<?php echo base_url(); ?>blog/view/<?= $row->blogSlug ?>">

																		</div>
																	</div>


																	<div class="j-unit">
																		<label class="j-label">Page Description</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<!-- <i class="icofont icofont-ui-user"></i> -->
																			</label>
																			<!-- <input type="text" id="pageDescription" name="pageDescription" value="<?= $row->pageDescription ?>"> -->
																			<textarea id="pageDescription" name="pageDescription" value="<?= $row->pageDescription ?>"><?= $row->pageDescription ?></textarea>
																			<span class="j-tooltip j-tooltip-right-top">Enter Page Description</span>
																		</div>
																	</div>

																	<div class="j-unit">
																		<label class="j-label">Picture Alt Text</label>
																		<div class="j-input">
																			<label class="j-icon-right" for="userFirstName">
																				<!-- <i class="icofont icofont-ui-user"></i> -->
																			</label>
																			<input type="text" id="PicAltText" name="PicAltText" value="<?= $row->PicAltText ?>">
																			<span class="j-tooltip j-tooltip-right-top">Picture alt text</span>
																		</div>
																	</div>



																	<div class="j-unit">
																		<label class="j-label">Description</label>
																		<div class="j-input">
																			<textarea spellcheck="false" id="blogDescription" name="blogDescription"><?= $row->blogDescription ?></textarea>
																		</div>
																	</div>
																	<div class="card">
																		<div class="card-header">
																			<h5>Image</h5>
																		</div>
																		<div class="card-block">
																			<input type="file" name="blogImage" id="blogImage">
																			<div class="row">
																				<div class="col-lg-4 col-sm-6">
																					<div class="thumbnail">
																						<div class="thumb text-center">
																							<img src="<?= base_url() . '/uploads/blog/' . $row->blogImage ?>" alt="" class="img-fluid img-thumbnail" style="max-height: 100px">
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>

																</div>
																<!-- end /.content -->
																<div class="j-footer">
																	<button type="submit" class="btn btn-primary">Update</button>
																</div>
																<!-- end /.footer -->
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Page body end -->
								</div>
							</div>
						</div>
					</div>
					<!-- Main-body end -->
				</div>
			</div>
		</div>
	</div>
	<!-- Warning Section Starts -->
	<?php $this->load->view('admin/includes/scripts'); ?>
	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/pages/j-pro/js/jquery.j-pro.js"></script>
	<!-- jquery file upload js -->
	<script src="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
	<!-- data-table js -->
	<script type="text/javascript">
		$('#blogImage').filer({
			extensions: ['jpg', 'jpeg', 'png', 'gif'],
			limit: 1,
			maxSize: 1,
			changeInput: true,
			showThumbs: true,
			addMore: false
		});
		CKEDITOR.replace('blogDescription', {
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
			var blogDescription = CKEDITOR.instances.blogDescription.getData();
			formData.set('blogDescription', blogDescription);
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
	</script>
</body>

</html>