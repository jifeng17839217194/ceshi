<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='?m=comment&c=comment_admin&a=listinfo&menu_id=<?php echo $_GET['menu_id']?>' class="on"><em>课时评论</em></a><!--<span>|</span><a href='?m=comment&c=check&a=checks&menu_id=<?php echo $_GET['menu_id']?>' ><em>评论审核</em></a>-->    </div>
</div>

<div class="pad_10">
<div id="searchid">
<form name="searchform" action="" method="get" >
<input type="hidden" value="comment" name="m">
<input type="hidden" value="comment_admin" name="c">
<input type="hidden" value="listinfo" name="a">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="<?php echo $_SESSION['pc_hash']?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">	
			<?php if($max_table > 1) {?>
			<?php echo L('choose_database')?>：<select name="tableid" onchange="show_tbl(this)"><?php for($i=1;$i<=$max_table;$i++) {?><option value="<?php echo $i?>" <?php if($i==$tableid){?>selected<?php }?>><?php echo $this->comment_data_db->db_tablepre?>comment_data_<?php echo $i?></option><?php }?></select>
			<?php }?>
			<select name="searchtype">
				<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>><?php echo L('original').L('title');?></option>
				<option value='1' <?php if($_GET['searchtype']==1) echo 'selected';?>><?php echo L('original');?>ID</option>
				<option value='2' <?php if($_GET['searchtype']==2) echo 'selected';?>><?php echo L('username');?></option>
			</select>
			<input name="keyword" type="text" value="<?php if(isset($keywords)) echo $keywords;?>" class="input-text" />
			<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
</div>
<div class="pad-lr-10">
<form name="myform" id="myform" action="" method="get" >
<input type="hidden" value="comment" name="m">
<input type="hidden" value="comment_admin" name="c">
<input type="hidden" value="del" name="a">
<input type="hidden" value="<?php echo $tableid?>" name="tableid">
<input type="hidden" value="1" name="dosubmit">
<div class="table-list comment">
    <table width="100%" class="table table-bordered table-header">
        <thead>
            <tr>
			 <th width="25"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
			<th width="130"><?php echo L('author')?></th>
			<th><?php echo L('comment')?></th>
			<th width="200">发表时间</th>
			<th width="280"><?php echo L('original').L('title');?></th>
			<th width="100"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
		<tbody class="add_comment">
    <?php
	if(is_array($data)) {
		foreach($data as $v) {
			$comment_info = $this->comment_db->get_one(array('commentid'=>$v['commentid']));
			if (strpos($v['content'], '<div class="content">') !==false) {
				$pos = strrpos($v['content'], '</div>');
				$v['content'] = substr($v['content'], $pos+6);
			}
	?>
     <tr id="tbody_<?php echo $v['id']?>">
		<td align="center" width="16"><input class="inputcheckbox " name="ids[]" value="<?php echo $v['id'];?>" type="checkbox"></td> 
		<td width="130"><?php echo $v['username']?><br /><?php echo $v['ip']?></td>
		<td style="text-align: left;"><?php echo $v['content']?></td>
		
		<td> <?php echo format::date($v['creat_at'], 1)?></td>
		<td><a href="?m=comment&c=comment_admin&a=listinfo&search=1&searchtype=0&keyword=<?php echo urlencode($comment_info['title'])?>&pc_hash=<?php echo $_SESSION['pc_hash']?>&tableid=<?php echo $tableid?>"><?php echo str_cut($comment_info['title'],60,'...')?></td>
		<td align='center'><a href="?m=comment&c=comment_admin&a=del&ids=<?php echo $v['id']?>&tableid=<?php echo $tableid?>&dosubmit=1" onclick="return check(<?php echo $v['id']?>, -1, '<?php echo new_html_special_chars($v['commentid']);?>')"><span class='glyphicon glyphicon-trash' style='color:red'></span></a> </td>
	</tr>
     <?php }
	}
	?>
	</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
		<input type="submit" class="button" onclick="return confirm('<?php echo L('sure_delete')?>');" value="<?php echo L('delete');?>" />
	</div>
    <div class="pull-right">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>
</div>
</form>
</div>
<script type="text/javascript">
window.top.$('#display_center_id').css('display','none');
function check(id, type, commentid) {
	if(type == -1 && !confirm('<?php echo L('are_you_sure_you_want_to_delete')?>')) {
		return false;
	}
	return true;
}
function show_tbl(obj) {
	var pdoname = $(obj).val();
	location.href='?m=comment&c=comment_admin&a=listinfo&tableid='+pdoname+'&pc_hash=<?php echo $_SESSION['pc_hash']?>';
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>