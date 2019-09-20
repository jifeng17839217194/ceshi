<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headersetting');?>

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='javascript:;' class="on"><em>角色管理</em></a><span>|</span><a href='?m=admin&c=role&a=add&menu_id=<?php echo $_GET['menu_id']?>' ><em>添加角色</em></a>    </div>
</div>


<div class="table-list pad-lr-10">
<form name="myform" action="?m=admin&c=role&a=listorder" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%"><?php echo L('listorder');?></th>
		<th width="10%">ID</th>
		<th width="15%"  align="left" ><?php echo L('role_name');?></th>
		<th width="265"  align="left" ><?php echo L('role_desc');?></th>
		<th width="5%"  align="left" ><?php echo L('role_status');?></th>
		<th class="text-c"><?php echo L('role_operation');?></th>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td width="10%" align="center"><input name='listorders[<?php echo $info['roleid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
<td width="10%" align="center"><?php echo $info['roleid']?></td>
<td width="15%"  ><?php echo $info['rolename']?></td>
<td width="265" ><?php echo $info['description']?></td>
<td width="5%"><a href="?m=admin&c=role&a=change_status&roleid=<?php echo $info['roleid']?>&disabled=<?php echo ($info['disabled']==1 ? 0 : 1)?>"><?php echo $info['disabled']? L('icon_locked'):L('icon_unlock')?></a></td>
<td  class="text-c">
<?php if($info['roleid'] > 1) {?>
<a href="javascript:setting_role(<?php echo $info['roleid']?>, '<?php echo new_addslashes($info['rolename'])?>')"><?php echo L('role_setting');?></a> |
<!-- <a href="javascript:void(0)" onclick="setting_cat_priv(<?php echo $info['roleid']?>, '<?php echo new_addslashes($info['rolename'])?>')"><?php echo L('usersandmenus')?></a> | -->
<?php } else {?>
<font color="#cccccc"><font color="#cccccc"><?php echo L('usersandmenus')?></font> |
<?php }?>
<a href="?m=admin&c=role&a=member_manage&roleid=<?php echo $info['roleid']?>&menu_id=<?php echo $_GET['menu_id']?>"><?php echo L('role_member_manage');?></a> | 
<?php if($info['roleid'] > 1) {?><a href="?m=admin&c=role&a=edit&roleid=<?php echo $info['roleid']?>&menu_id=<?php echo $_GET['menu_id']?>"><?php echo L('edit')?></a> | 
<a href="javascript:confirmurl('?m=admin&c=role&a=delete&roleid=<?php echo $info['roleid']?>', '<?php echo L('posid_del_cofirm')?>')"><?php echo L('delete')?></a>
<?php } else {?>
<font color="#cccccc"><?php echo L('edit')?></font> | <font color="#cccccc"><?php echo L('delete')?></font>
<?php }?>
</td>
</tr>
<?php 
	}
}
?>
</tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>
</form>
</div>
</body>
<script type="text/javascript">
function setting_role(id, name) {

	window.top.art.dialog({
		title:'<?php echo L('sys_setting')?>《'+name+'》',
		id:'edit',
		iframe:'?m=admin&c=role&a=role_priv&roleid='+id,
		width:'700',
		height:'500'
	}, 
	function(){
		var d = window.top.art.dialog({id:'edit'}).data.iframe;
		d.document.getElementById('dosubmit').click();
		return false;
	}, 
	function(){
		window.top.art.dialog({id:'edit'}).close()
	});
}
function setting_cat_priv(id, name) {

	window.top.art.dialog({title:'<?php echo L('usersandmenus')?>《'+name+'》',id:'edit',iframe:'?m=admin&c=role&a=setting_cat_priv&roleid='+id,width:'700',height:'500'});
}
</script>
<?php
include $this->admin_tpl('footer','admin');?>
</html>
