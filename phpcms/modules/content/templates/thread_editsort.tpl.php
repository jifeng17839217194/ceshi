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
<form action="?m=content&c=wenwen&a=editsort&fid=<?php echo $fid; ?>&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="20%">分类：</th>
		<td>
		<select name="info[fid]" id="fid">
		<?php
		  foreach($forumtypes as $tkey=>$tf){
		?>
		<option value="<?php echo $tf['fid'];?>" <?php if($tf['fid']==$fid){ echo "selected"; }?>><?php echo $tf['name'];?></option>
		<?php } ?>
		</select>
		</td>
	</tr>	
	<tr>
		<th></th>
		<td>
		<input name="info[tid]" id="tid" type="hidden" value="<?php echo $id;?>">
		<input type="hidden" name="forward" value="?m=content&c=wenwen&a=editsort">
		<input type="submit" name="dosubmit" id="dosubmit"  value=" <?php echo L('submit')?>" class='dialog' >
		</td>
	</tr>
</table>
</form>
</div>
</body>
</html>