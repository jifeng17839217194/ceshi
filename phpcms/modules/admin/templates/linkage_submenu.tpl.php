<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="page-header">
	<div class="pull-left">
		<h4><?php if($_GET['keyid']==1){echo '省份设置';}else{echo '目录管理';}?></h4>      
	</div>
</div>

<div class="subnav">
 
<div class="content-menu ib-a blue line-x">
	<?php if($_GET['keyid']=='3364'){ ?>
	<a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=admin&c=linkage&a=public_sub_add&keyid=<?php echo $_GET['keyid'];?>', title:'添加菜单', width:'600', height:'430', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);">添加目录</a>
<?php } ?>
　<a class="on" href="?m=admin&c=linkage&a=public_cache&linkageid=<?php echo $_GET['keyid'];?>"><em>更新缓存</em></a>&nbsp;&nbsp;

<a href="javascript:void(0);" onclick="editpl(<?php echo $_GET['keyid'];?>,'更新显示样式')"><em>更新显示样式</em></a>
</div></div>


 
<div class="pad_10">
<form name="myform" action="?m=admin&c=linkage&a=public_listorder" method="post">
<input type="hidden" name="keyid" value="<?php echo $keyid?>">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="100"><?php echo L('listorder')?></th>
		<th width="100">ID</th>
		<th width="360" align="left" ><?php echo L('linkage_name')?></th>
		<th ><?php echo L('linkage_desc')?></th>
		<th width="200"><?php echo L('operations_manage')?></th>
		</tr>
        </thead>
        <tbody>
		<?php echo $submenu?>
		</tbody>
	</table>
	<div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
<script type="text/javascript">
<!--
function add(id, name,linkageid) {
	window.top.art.dialog({id:'add'}).close();
	window.top.art.dialog({title:name,id:'add',iframe:'?m=admin&c=linkage&a=public_sub_add&keyid='+id+'&linkageid='+linkageid,width:'600',height:'320'}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});
}

function edit(id, name,parentid) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:name,id:'edit',iframe:'?m=admin&c=linkage&a=edit&linkageid='+id+'&parentid='+parentid,width:'600',height:'300'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function editpl(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:name,id:'edit',iframe:'?m=admin&c=linkage&a=edit&linkageid='+id,width:'500',height:'200'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
//-->

</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>