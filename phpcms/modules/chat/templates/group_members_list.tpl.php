<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headersimple', 'admin');?>
<div class="table-list">
<table width="100%" class="table_form">
	<form name="myform" action="?m=chat&c=group_members&a=add_member" method="post" id="myform">
		<tr>
			<td width="150">添加群成员用户名：</td> 
			<td>
				<input type="text" name="username" id="username" value="" class="input-text" style="float: left;"> 
				<input type="submit" class="button" onclick="" value="添加" style="float: left;">
			</td>
		</tr>
		<tr><td></td></tr>
		<input type="hidden" name="tid" id="tid" value="<?php echo $tid;?>">
	</form>
</table>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left">用户名</th>
			<th align="left">姓名</th>
			<th align="left">群昵称</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr>
		<td align="left"><?php echo $v['username']?></td>
		<td align="left">
			<?php echo $v['is_own']?'<i class="fa fa-user" style="color:#FDC705;"></i>':''; ?>
			<?php echo $v['is_master']?'<i class="fa fa-user" style="color:#A3CC4A;"></i>':''; ?>
			<?php echo $v['nickname']?>
		</td>
		<td align="left">
    		<div class="groupnickname-warp" data-uid="<?php echo $v['userid']?>" data-tid="<?php echo $v['tid']?>">
    			<div class="groupnickname-show">
        			<span class="groupnickname-span"><?php echo $v['group_nickname']?></span>
        			<a href="javascript:;" class="edit-groupnickname" style="margin-left: 5px;"><i class="fa fa-edit"></i></a>
    			</div>
    			<div class="groupnickname-edit" style="display: none;">
    				<input type="text" name="group_nickname" id="group_nickname" class="groupnickname-input" value="<?php echo $v['group_nickname']?>" size="10"/>
    				<a href="javascript:;" class="save-groupnickname" style="margin-left: 5px;"><i class="fa fa-check" style="color:#19aa8d;"></i></a>
    				<a href="javascript:;" class="cancel-groupnickname" style="margin-left: 5px;"><i class="fa fa-close" style="color:#ff3300;"></i></a>
    			</div>
    		</div>
		</td>
		<td align="left">
			<?php if(!$v['is_own']){?>
    			<a href="?m=chat&c=group_members&a=change_owner&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定设为群主？')">设为群主</a>&nbsp;&nbsp;
    			<?php if($v['is_master']){ ?>
    				<a href="?m=chat&c=group_members&a=remove_manager&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定取消管理员？')">取消管理员</a>&nbsp;&nbsp;
    			<?php }else{?>
    				<a href="?m=chat&c=group_members&a=add_manager&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定设为管理员？')">设为管理员</a>&nbsp;&nbsp;
    			<?php }?>
    			<?php if($v['is_mute']){?>
    				<a href="?m=chat&c=group_members&a=unmute_member&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定取消禁言？')">取消禁言</a>&nbsp;&nbsp;
    			<?php }else{?>
    				<a href="?m=chat&c=group_members&a=mute_member&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定禁言？')">禁言</a>&nbsp;&nbsp;
    			<?php }?>
    			<?php if(!$v['is_master']){ ?>
        			<a href="?m=chat&c=group_members&a=remove_member&tid=<?php echo $v['tid'];?>&accid=<?php echo $v['accid']?>" onclick="return confirm('确定移出群？')">移出群</a>&nbsp;&nbsp;
    			<?php }?>
			<?php }?>
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
$(".edit-groupnickname").click(function(){
	var $item = $(this).parents(".groupnickname-warp");
	$item.find(".groupnickname-show").hide();
	$item.find(".groupnickname-edit").show();
});
$(".save-groupnickname").click(function(){
	var $item = $(this).parents(".groupnickname-warp");
	var nick = $item.find(".groupnickname-input").val();
	var uid = $item.data('uid');
	var tid = $item.data('tid');
	$.post("?m=chat&c=group_members&a=update_group_nickname&pc_hash="+pc_hash,{tid:tid,uid:uid,nick:nick},function(data){
		if(data.code == '200'){
			$item.find(".groupnickname-span").html(nick);
			$item.find(".groupnickname-show").show();
			$item.find(".groupnickname-edit").hide();
		}else{
			alert(data.msg);
		}
	});
});
$(".cancel-groupnickname").click(function(){
	var $item = $(this).parents(".groupnickname-warp");
	$item.find(".groupnickname-show").show();
	$item.find(".groupnickname-edit").hide();
});
</script>
</body>
</html>