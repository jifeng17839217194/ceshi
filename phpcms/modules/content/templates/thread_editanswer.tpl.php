<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headerpage','admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>

<style>
.txt_input{width:90%;}
</style>
<div class="pad_10">
<form action="?m=content&c=wenwen&a=editanswer&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
	
		<td>
		<textarea class="txt_input" name="info[content]" id="content" rows="6" cols="25"><?php echo $rowname['message'];?></textarea>
		
		</td>
	</tr>	
	<tr>
	
		<td>
		<input name="info[tid]" id="tid" type="hidden" value="<?php echo $id;?>">
		<input type="hidden" name="forward" value="?m=content&c=wenwen&a=editanswer">
		<input type="submit" name="dosubmit" id="dosubmit"  value=" <?php echo L('submit')?>" class='dialog' >
		</td>
	</tr>
</table>
</form>
</div>
</body>
</html>