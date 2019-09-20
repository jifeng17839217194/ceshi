<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="page-header">
	<div class="pull-left">
		<h4>群管理</h4>      
	</div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=chat&c=group&a=add', title:'新建群', width:'700', height:'500', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em>新建群</em></a>　    <a href='javascript:;' class="on"><em>群管理列表</em></a>    </div>
</div>

<div class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="chat" name="m">
<input type="hidden" value="group" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="<?php echo $action;?>" name="action">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
				<?php echo L('group_keywords')?>：
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left">群号</th>
			<th align="left">群头像</th>
			<th align="left">群名称</th>
			<th align="left">群主名字及用户名</th>
			<th align="left">群成员（人数）</th>
			<th align="left">群日志</th>
			<th align="left">创建时间</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr>
		<td align="left"><?php echo $v['tid']?></td>
		<td align="left"><a href="javascript:top.imagePreviewDialog('<?php echo $v['icon'];?>');"><img src="<?php echo $v['icon']; ?>" height="18" width="18" align="absmiddle"></a></td>
		<td align="left"><?php echo new_html_special_chars($v['tname'])?></td>
		<td align="left"><?php echo $v['nickname'].'&nbsp;&nbsp;&nbsp;'.$v['username']?></td>
		<td align="left"><?php echo $v['members_num']?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:members('<?php echo $v['tid']?>','<?php echo $v['tname']?>');"><img src="/statics/images/admin_img/detail.png"></a></td>
		<td align="left"><?php echo $v['logs_count']?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?m=chat&c=group_log&a=lists&tid=<?php echo $v['tid']?>&menu_id=<?php echo $_GET['menu_id']?>"><img src="/statics/images/admin_img/detail.png"></a></td>
		<td align="left"><?php echo date('Y/m/d H:i:s',strtotime($v['create_time']));?></td>
		<td align="left">
			<a href="javascript:edit('<?php echo $v['tid']?>','<?php echo $v['tname']?>')" >设置</a>&nbsp;&nbsp;
			<a href="?m=chat&c=group&a=delete&tid=<?php echo $v['tid']?>" onclick="return confirm('操作不可撤销，是否确定解散该群？')">解散</a>&nbsp;&nbsp;
			<a href="javascript:history('<?php echo $v['tid']?>','<?php echo $v['tname']?>');">聊天记录</a>&nbsp;&nbsp;
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="pull-right">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>
</div>
</div>
<script type="text/javascript">
function edit(tid, tname) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({
		title:'群设置《'+tname+'》',
		id:'edit',
		iframe:'?m=chat&c=group&a=edit&tid='+tid,width:'700',height:'500'
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
function members(tid, tname) {
	window.top.art.dialog({id:'members'}).close();
	window.top.art.dialog({
		title:'群成员管理《'+tname+'》',
		id:'members',
		iframe:'?m=chat&c=group_members&a=init&tid='+tid,width:'800',height:'500',
		cancel: function(){
			window.top.art.dialog({id:'members'}).close()
		},
		cancelVal:"关闭"
	});
}
function history(tid, tname) {
	window.top.art.dialog({id:'history'}).close();
	window.top.art.dialog({
		title:'群聊天记录《'+tname+'》',
		fixed:true,
		padding:0,
		id:'members',
		iframe:'?m=chat&c=group_history&a=init&tid='+tid,width:'800',height:'600',
		cancel: function(){
			window.top.art.dialog({id:'history'}).close()
		},
		cancelVal:"关闭"
	});
}
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>