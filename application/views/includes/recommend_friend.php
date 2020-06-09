<a href="javascript:;" data-toggle="modal" data-target="#FriendModal" class="tran3s custom-btn pull-right">Recommend a Friend</a>
<div id="FriendModal" class="modal fade loginModal theme-modal-box" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<h3>Recommend Friends</h3>
				<ul class="clearfix">
					<li class="float-left"><a onclick="window.open( 'http://www.facebook.com/sharer.php?u=<?=base_url()?>?ref=EG<?=$this->session_data->userId?>', 'sharer', 'toolbar=0, status=0, width=626, height=436');return false;" title="Share on Facebook" href="javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i> facebook</a></li>
					<li class="float-left"><a onclick="window.open( 'https://plus.google.com/share?url=<?=base_url()?>?ref=EG<?=$this->session_data->userId?>', 'sharer', 'toolbar=0, status=0, width=626, height=436');return false;" title="Share on Google+" href="javascript:void(0)"><i class="fa fa-google-plus" aria-hidden="true"></i> Google</a></li>
					<li class="float-left"><a onclick="window.open( 'http://www.twitter.com/share?url=<?=base_url()?>?ref=EG<?=$this->session_data->userId?>', 'sharer', 'toolbar=0, status=0, width=626, height=436');return false;" title="Share on Twitter" href="javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a></li>
					<li class="float-left"><a onclick="window.open( 'https://www.linkedin.com/share?url=<?=base_url()?>?ref=EG<?=$this->session_data->userId?>', 'sharer', 'toolbar=0, status=0, width=626, height=436');return false;" title="Share on Linkedin" href="javascript:void(0)"><i class="fa fa-linkedin" aria-hidden="true"></i> Linkedin</a></li>
				</ul>
				<form  action="" method="post">
					<h6><span>or</span></h6>
					<div class="wrapper">
						<input type="text" id="ref_url_inp" value="<?=base_url()?>?ref=EG<?=$this->session_data->userId?>" readonly>
						<button type="button"  onclick="copy()"  class="hvr-trim-two" style="background: #000000b3;margin-top: 10px;">Copy</button>
					</div>
				</form>

			</div> <!-- /.modal-body -->
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.signUpModal -->
<script type="text/javascript">
function copy() {
	var copyText = document.getElementById("ref_url_inp");
	copyText.select();
	document.execCommand("copy");
}
</script>
