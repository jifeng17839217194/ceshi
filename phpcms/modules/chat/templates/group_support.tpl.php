<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="page-header">
	<div class="pull-left">
		<h4>蜂博士管理团队</h4>      
	</div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a class="add fb add-member" href="javascript:;"><em>添加蜂博士管理成员</em></a>　    <a href='javascript:;' class="on"><em>管理员列表</em></a>    </div>
</div>
<div class="table-margin">
<form name="searchform" action="?m=chat&c=group_support&a=delete" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left" width="50">ID</th>
			<th align="left">用户名及姓名</th>
			<th align="left">管理群（数量）</th>
			<th align="left">添加管理员时间</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['userid']?></td>
		<td align="left"><?php echo $v['username'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['nickname']?></td>
		<td align="left"><?php echo $v['group_count'];?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:show_group('<?php echo $v['userid'];?>');"><img src="/statics/images/admin_img/detail.png"></a></td>
		<td align="left"><?php echo date('Y/m/d H:i:s',strtotime($v['support_time']));?></td>
		<td align="left">
			<a href="?m=chat&c=group_support&a=delete&userid=<?php echo $v['userid']?>" onclick="return confirm('将从本列表删除，但仍在各群聊中担任管理员，如有需要，请在群管理中手动移除管理权限，是否确认操作？')">删除</a>&nbsp;&nbsp;
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
<!--
<input type="submit" class="button" name="dosubmit" value="<?php echo L('verify_pass')?>" onclick="document.myform.action='?m=member&c=member_verify&a=pass'"/>
<input type="submit" class="button" name="dosubmit" value="<?php echo L('reject')?>" onclick="document.myform.action='?m=member&c=member_verify&a=reject'"/>
<input type="submit" class="button" name="dosubmit" value="<?php echo L('ignore')?>" onclick="document.myform.action='?m=member&c=member_verify&a=ignore'"/>
<input type="checkbox" value=1 name="sendsms"/> <?php echo L('sendsms')?>
-->
<input type="submit" class="button"  value="<?php echo L('delete')?>"  onclick="return confirm('将从本列表删除，但仍在各群聊中担任管理员，如有需要，请在群管理中手动移除管理权限，是否确认操作？');">
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
$(".add-member").click(function(){
	window.top.art.dialog({
		id:'add',
		content:'<input type="text" name="username" class="input-text" id="username" value="" size="30"/>', 
		title:'输入蜂博士管理成员用户名', 
		width:'400', 
		height:'120', 
		lock:true
	}, function(){
		var username = $("#username").val();
		$.post("?m=chat&c=group_support&a=add&pc_hash="+pc_hash,{username:username},function(data){
			console.log(data);
			if(data.code == 1){
				window.location.reload();
			}
			else{
				alert(data.msg);
				$("#username").val("");
			}
		});
		return false;
	}, function(){
		window.top.art.dialog({id:'add'}).close()
	});
})
function show_group(userid){
	window.top.art.dialog({id:'groups'}).close();
	window.top.art.dialog({
		title:'管理群列表',
		id:'members',
		iframe:'?m=chat&c=group_support&a=groups&userid='+userid,width:'800',height:'500',
		cancel: function(){
			window.top.art.dialog({id:'members'}).close()
		},
		cancelVal:"关闭"
	});
}
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>