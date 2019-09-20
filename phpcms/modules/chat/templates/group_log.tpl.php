<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style>
	body .table-list tbody td, body .table-list tbody tr,body .table-list thead th{text-align: left !important;}
</style>
<div class="page-header">
	<div class="pull-left">
		<h4>群日志管理</h4>      
	</div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=chat&c=group_log&a=add', title:'新建群日志', width:'800', height:'600', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em>新建群日志</em></a>　    <a href='javascript:;' class="on"><em>群日志列表</em></a>    </div>
</div>
<div class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="chat" name="m">
<input type="hidden" value="group_log" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="<?php echo $action;?>" name="action">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				创建时间：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
				标题：
				<input name="title" type="text" value="<?php if(isset($_GET['title'])) {echo $_GET['title'];}?>" class="input-text" />
				创建人：
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<div class="table-margin">
<form name="searchform" action="?m=chat&c=group_log&a=delete" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0" style="text-align: left !important;">
	<thead>
		<tr>
			<th align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			<th align="left" width="50">ID</th>
			<th align="left" width="400">标题</th>
			<th align="left">创建人</th>
			<th align="left">群聊日期</th>
			<th align="left">创建时间</th>
			<th align="left">关联群（群个数）</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr data-id="<?php echo $v['id']?>">
		<td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
		<td align="left"><?php echo $v['id']?></td>
		<td align="left"><?php echo $v['title'];?></td>
		<td align="left"><?php echo $v['creator'];?></td>
		<td align="left"><?php echo $v['date']?></td>
		<td align="left"><?php echo date('Y/m/d H:i:s',strtotime($v['create_time']));?></td>
		<td align="left"><?php echo $v['count']?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:show_group('<?php echo $v['id'];?>');"><img src="/statics/images/admin_img/detail.png"></a></td>
		<td align="left">
			<a href="javascript:edit('<?php echo $v['id'];?>','<?php echo $v['title'];?>');" >修改</a>&nbsp;&nbsp;
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
<input type="submit" class="button"  value="<?php echo L('delete')?>"  onclick="return confirm('<?php echo L('sure_delete')?>');">
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
function edit(id, title) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({
		title:'修改群日志《'+title+'》',
		id:'edit',
		iframe:'?m=chat&c=group_log&a=edit&id='+id,width:'800',height:'650'
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
function show_group(logid){
	window.top.art.dialog({id:'groups'}).close();
	window.top.art.dialog({
		title:'群列表',
		id:'members',
		iframe:'?m=chat&c=group_log&a=groups&id='+logid,width:'800',height:'500',
		cancel: function(){
			window.top.art.dialog({id:'groups'}).close()
		},
		cancelVal:"关闭"
	});
}
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>