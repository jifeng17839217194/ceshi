<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('headerpage', 'admin');
?>
<div class="table-list" style='margin:80px auto;width:80%;'>
	<form method="post" action="<?php echo API_PATH?>uploadatavar?from=pc&uid=<?php echo $userid;?>" enctype="multipart/form-data">
		<input type="file" name="avatar" style="width:160px;" />
		<!--<input type="submit" name="Submit" value="上传头像" class="button"/>-->
		 <input name="dosubmit" id="dosubmit" type="submit" value="上传头像" class="dialog">
	</form>
</div>