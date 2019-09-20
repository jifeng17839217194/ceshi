<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="page-header">
	<div class="pull-left">
		<h4>用户擅长选项</h4>      
	</div>
</div>

<!-- <div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=member&c=member_wenwenmodule&a=add', title:'添加', width:'500', height:'300', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em>添加</em></a>　    <a href='javascript:;' class="on"><em>用户擅长选项</em></a>    </div>
</div> -->

<form name="myform" id="myform" action="?m=member&c=member_wenwenmodule&a=delete" method="post" onsubmit="check();return false;">
<div class="table-margin">
<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="30px"><input type="checkbox" value="" id="check_box" onclick="selectall('fid[]');"></th>
			<th align="left" width="50px">ID</th>
			<th width="80px"><?php echo L('sort')?></th>
			<th>名称</th>
			<th><?php echo L('issystem')?></th>
			
			<th><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	foreach($member_group_list as $k=>$v) {
?>
    <tr>
		<td align="left"><?php if(!$v['issystem']) {?><input type="checkbox" value="<?php echo $v['fid']?>" name="fid[]"><?php }?></td>
		<td align="left"><?php echo $v['fid']?></td>
		<td align="center"><input type="text" name="sort[<?php echo $v['fid']?>]" class="input-text" size="1" value="<?php echo $v['sort']?>"></th>
		<td align="center" title="<?php echo $v['description']?>"><?php echo $v['name']?></td>
		<td align="center"><?php echo $v['issystem'] ? L('icon_unlock') : L('icon_locked')?></td>
		<td align="center"><a href="javascript:edit(<?php echo $v['fid']?>, '<?php echo $v['name']?>')">[<?php echo L('edit')?>]</a></td>
    </tr>
<?php
	}
?>
</tbody>
 </table>

<div class="table-margin"> <!-- <input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/> -->
<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=member&c=member_wenwenmodule&a=sort'" value="<?php echo L('sort')?>"/>
</div> 
<div id="pages"><?php echo $pages?></div>
</div>
</div>
</form>
<div id="PC__contentHeight" style="display:none">160</div>
<script language="JavaScript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member_group')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member_wenwenmodule&a=edit&fid='+id,width:'500',height:'300'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function check() {
	if(myform.action == '?m=member&c=member_wenwenmodule&a=delete') {
		var ids='';
		$("input[name='fid[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			window.top.art.dialog({content:'<?php echo L('plsease_select').L('member_wenwenmodule')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
			return false;
		}
	}
	myform.submit();
}
//-->
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>