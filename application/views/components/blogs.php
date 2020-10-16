<?php foreach ($blogs as $row) { ?>
	<div class="col-lg-4 col-md-4 col-xs-6">
		<div class="single-blog">
			<div class="image"><img src="<?= base_url('uploads/blog/' . $row->blogImage) ?>" style="height: 200px" alt=""></div>
			<div class="text" style="padding: 0px 0 0 0;">
				<h5><a href="<?= base_url('blog/view/' . $row->blogSlug) ?>" class="tran3s"><?= short_text($row->blogTitle, 55) ?></a></h5>
				<p><?= short_text($row->blogDescription, 200) ?></p>
				<a href="<?= base_url('blog/view/' . $row->blogSlug) ?>" class="tran3s"><i class="flaticon-arrows" aria-hidden="true"></i></a>
			</div>
		</div> <!-- /.single-blog -->
	</div>
<?php } ?>