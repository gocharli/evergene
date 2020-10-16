<?php $this->load->view('admin/includes/head'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/admin/assets/pages/j-pro/css/j-pro-modern.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/bower_components/select2/css/select2.min.css" />

<!-- jquery file upload Frame work -->
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

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
											<h4 class="m-b-10">Edit Meal prep</h4>
										</div>
										<ul class="breadcrumb">
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>">
													<i class="feather icon-home"></i>
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="<?= $this->config->item('admin_url') ?>/mealprep">
													Meal preps
												</a>
											</li>
											<li class="breadcrumb-item">
												<a href="javascript:;">Edit Meal prep</a>
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
														<h5>Edit Meal prep</h5>
														<span>Edit <?= $row->testName ?> information</span>
													</div>
													<div class="card-block">
														<div class="j-wrapper j-wrapper-640">
															<form id="frm_1" action="<?= $this->config->item('admin_url') ?>/mealprep/edit_process/<?= $row->testId ?>" method="post" class="j-pro j-multistep" novalidate>
																<div class="j-content">
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 1/3 - Basic information</span>
																		</div>
																		<div class="j-unit">
																			<label class="j-label"> Name</label>
																			<div class="j-input">
																				<label class="j-icon-right" for="testName">
																					<i class="icofont icofont-blood-test"></i>
																				</label>
																				<input type="text" id="testName" name="testName" value="<?= $row->testName ?>">
																				<span class="j-tooltip j-tooltip-right-top">Enter name</span>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Original Price</label>
																			<div class="j-input">
																				<label class="j-icon-right" for="originalPrice">
																					<i class="icofont icofont-cur-pound"></i>
																				</label>
																				<input type="email" id="originalPrice" name="originalPrice" value="<?= $row->originalPrice ?>">
																				<span class="j-tooltip j-tooltip-right-top">Enter original price</span>
																			</div>
																		</div>
																		<div class="j-row">

																			<div class="j-span6 j-unit">
																				<label class="j-label">Discount Price</label>
																				<div class="j-input">
																					<label class="j-icon-right" for="discountPrice">
																						<i class="icofont icofont-sale-discount"></i>
																					</label>
																					<input type="email" id="discountPrice" name="discountPrice" value="<?= $row->discountPrice ?>">
																					<span class="j-tooltip j-tooltip-right-top">Enter discount price</span>
																				</div>
																			</div>
																			<div class="j-span6 j-unit">
																				<label class="j-label">Percentage</label>
																				<div class="j-input form-radio" style="margin-top: 15px;">
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" name="discountPercentage" value="Yes" <?php if ($row->discountPercentage == 'Yes') {
																																							echo 'checked=""';
																																						} ?>>
																							<i class="helper"></i>Yes
																						</label>
																					</div>
																					<div class="radio radio-inline">
																						<label>
																							<input type="radio" name="discountPercentage" value="No" <?php if ($row->discountPercentage == 'No') {
																																							echo 'checked=""';
																																						} ?>>
																							<i class="helper"></i>No
																						</label>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Description</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="testDescription" name="testDescription"><?= $row->testDescription ?></textarea>
																			</div>
																		</div>
																	</fieldset>
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 2/3 - Tabs information</span>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Test Details</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="testDetails" name="testDetails"><?= $row->testDetails ?></textarea>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">Menu</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="menu" name="menu"><?= $row->menu ?></textarea>
																			</div>
																		</div>
																		<div class="j-unit">
																			<label class="j-label">How Its Work</label>
																			<div class="j-input">
																				<textarea spellcheck="false" id="howItsWork" name="howItsWork"><?= $row->howItsWork ?></textarea>
																			</div>
																		</div>
																	</fieldset>
																	<fieldset>
																		<div class="j-divider-text j-gap-top-20 j-gap-bottom-45">
																			<span>Step 3/3 - Images</span>
																		</div>
																		<div class="card">
																			<div class="card-header">
																				<h5>Test Logo</h5>
																			</div>
																			<div class="card-block">
																				<input type="file" name="testLogo" id="testLogo">
																				<div class="row">
																					<div class="col-lg-4 col-sm-6">
																						<div class="thumbnail">
																							<div class="thumb text-center">
																								<img src="<?= base_url() . '/uploads/tests/logo/' . $row->testLogo ?>" alt="" class="img-fluid img-thumbnail" style="max-height: 100px">
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="card">
																			<div class="card-header">
																				<h5>Other Images</h5>
																			</div>
																			<div class="card-block">
																				<input type="file" name="moreImages[]" id="moreImages" multiple="multiple">

																				<div class="row">
																					<?php $imoreImages = $this->db->query('select * from test_images WHERE testId=' . $row->testId)->result();
																					if ($imoreImages) {
																						foreach ($imoreImages as $image) { ?>
																							<div class="col-lg-4 col-sm-6" id="img_<?= $image->imageId ?>">
																								<div class="thumbnail">
																									<div class="thumb text-center">
																										<img src="<?= base_url() . '/uploads/tests/products/' . $image->imageName ?>" alt="" class="img-fluid img-thumbnail" style="height: 100px">
																									</div>
																									<button type="button" onclick="delete_img(<?= $image->imageId ?>)" class="btn btn-out waves-effect waves-light btn-danger btn-square w-100"><i class="icofont icofont-ui-delete"></i></button>

																								</div>
																							</div>
																						<?php
																						}
																					} else { ?>
																						<p class="text-center">No image Listed</p>
																					<?php }
																					?>
																				</div>


																			</div>
																		</div>

																	</fieldset>
																	<div class="j-response"></div>
																</div>
																<!-- end /.content -->
																<div class="j-footer">
																	<button type="submit" class="btn btn-primary">Update</button>
																	<button type="button" class="btn btn-primary j-multi-next-btn">Next</button>
																	<button type="button" class="btn btn-default m-r-20 j-multi-prev-btn">Back</button>
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
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/bower_components/select2/js/select2.full.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/admin/assets/pages/j-pro/js/jquery.j-pro.js"></script>
	<!-- jquery file upload js -->
	<script src="<?= base_url() ?>assets/admin/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
	<script src="<?= base_url() ?>assets/admin/assets/pages/filer/custom-filer.js" type="text/javascript"></script>


	<script type="text/javascript">
		$('#testLogo').filer({
			extensions: ['jpg', 'jpeg', 'png', 'gif'],
			limit: 1,
			maxSize: 1,
			changeInput: true,
			showThumbs: true,
			addMore: false
		});
		//Example 2
		$('#moreImages').filer({
			limit: 10,
			maxSize: 10,
			extensions: ['jpg', 'jpeg', 'png', 'gif'],
			changeInput: true,
			showThumbs: true,
			addMore: true
		});
		/*document ckeditor*/
		CKEDITOR.replace('testDetails', {
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
		CKEDITOR.replace('menu', {
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
		CKEDITOR.replace('howItsWork', {
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
	</script>
	<!-- data-table js -->
	<script type="text/javascript">
		$("#frm_1").justFormsPro({
			rules: {
				testName: {
					required: true
				},
				originalPrice: {
					required: true,
					number: true
				},
				discountPrice: {
					required: true,
					number: true
				},
				testDescription: {
					required: true
				}
			},
			messages: {
				testName: {
					required: "Enter name"
				},
				originalPrice: {
					required: "Enter original price",
					number: "Field only numbers allowed"
				},
				discountPrice: {
					required: "Enter Discount Price",
					number: "Field only numbers allowed"
				},
				testDescription: {
					required: "Enter Description"
				}
			},
			formType: {
				multistep: true
			},
			submit: false,
			afterSubmitHandler: function(result) {
				//$('#');
				return true;
			}
		});
		$('#frm_1').submit(function(evt) {
			var frm = $(this);
			var formData = new FormData($('form#frm_1').get(0));
			var testDetails = CKEDITOR.instances.testDetails.getData();
			var menu = CKEDITOR.instances.menu.getData();
			var howItsWork = CKEDITOR.instances.howItsWork.getData();
			formData.set('testDetails', testDetails);
			formData.set('menu', menu);
			formData.set('howItsWork', howItsWork);
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

		function delete_img(id) {
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
										url: "<?php echo base_url(); ?>admin/mealprep/delete_img",
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
															$('#img_' + id).remove();
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