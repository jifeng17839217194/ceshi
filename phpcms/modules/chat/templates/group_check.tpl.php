<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style>
	body .table-list tbody td, body .table-list tbody tr,body .table-list thead th{text-align: left !important;}
</style>
<div class="page-header">
	<div class="pull-left">
		<h4>审核群</h4>      
	</div>
</div>
<div class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="chat" name="m">
<input type="hidden" value="group_check" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="<?php echo $action;?>" name="action">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				申请日期：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
				群名/申请用户名/申请用户姓名：
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				类型：
				<select name="status" id="status">
					<option value="" selected>全部
					<option value="0" <?php echo $status==='0'?'selected':''; ?>>未审核
					<option value="1" <?php echo $status==1?'selected':''; ?>>已通过
					<option value="2" <?php echo $status==2?'selected':''; ?>>已拒绝
				</select>
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<div class="table-margin">
<div class="table-list">
<table width="100%" cellspacing="0" style="text-align: left !important;">
	<thead>
		<tr>
			<th align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left" width="60">ID</th>
			<th align="left" width="80">群头像</th>
			<th align="left">群名称</th>
			<th align="left">申请人名字及用户名</th>
			<th align="left">申请时间</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr data-id="<?php echo $v['id']?>">
		<td align="left"><input type="checkbox" value="<?php echo $v['mobile']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['id']?></td>
		<td align="left"><a href="javascript:top.imagePreviewDialog('<?php echo $v['icon'];?>');"><img src="<?php echo $v['icon']; ?>" height="18" width="18" align="absmiddle"></a></td>
		<td align="left"><?php echo $v['tname'];?></td>
		<td align="left"><?php echo $v['nickname'].'&nbsp;&nbsp;&nbsp;'.$v['username']?></td>
		<td align="left"><?php echo date('Y/m/d H:i:s',strtotime($v['create_time']));?></td>
		<td align="left">
			<?php if($v['status']==0){?>
			<div class="btn-group">
			  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
			   操作 <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu" style="width:80px;">
				<li><a href='javascript:;' style='color:green' title="点击通过审核" class="apply-agree" data-tname="<?php echo $v['tname'];?>">
					<span class="glyphicon glyphicon-ok-circle">通过</span></a></li>
				<li class="divider"></li>
				<li><a href='javascript:;' style='color:red' title="点击拒绝审核" class="apply-refuse">
					<span class="glyphicon glyphicon-remove-circle">拒绝</a></li>
			  </ul>
			</div>
			<?php }else if($v['status']==1){?>
				<span class="glyphicon glyphicon-ok-circle" style="color:green">已通过</span>
			<?php }else if($v['status']==2){?>
				<span class="glyphicon glyphicon-remove-circle" style="color:red">已拒绝</span>
			<?php }?>
		</td>
    </tr>
	<tr>
		<th align="left" colspan="2" style="border-bottom:#eee 1px solid;">群介绍：</th>	
		<td align="left" colspan='4'><?php echo  $v['intro'];?></td>
		<td align="left"></td>	
	</tr>
	<tr>
		<th align="left" colspan="2" style="border-bottom:#eee 1px solid;">群规则：</th>	
		<td align="left" colspan='4'><?php echo  $v['rule'];?></td>
		<td align="left"></td>	
	</tr>
	<?php if($v['status']==2){?>
	<tr>
		<th align="left" colspan="2" style="border-bottom:#eee 1px solid;">拒绝理由：</th>	
		<td align="left" colspan='4'><?php echo  $v['refuse_reason'];?></td>
		<td align="left"></td>	
	</tr>
	<?php }?>
<?php
	}
}
?>
</tbody>
</table>
<!-- <div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
<input type="submit" class="button"  value="<?php echo L('delete')?>"  onclick="return confirm('<?php echo L('sure_delete')?>');">
</div>  -->
<div class="pull-right">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>
</div>
</div>
<script type="text/javascript">
$(".table-list").on("click",".apply-agree",function(){
	var obj = $(this);
	var id = obj.parents('tr').attr("data-id");

	var tname = obj.data('tname'); 
	$.post("?m=chat&c=group_check&a=apply_agree_confirm&pc_hash="+pc_hash,{tname:tname},function(data){
		if(data.code == '200'){
			var content = '<div style="width:400px;">';
			<?php foreach ($masterList as $master){?>
			content += '<input type="checkbox" name="members[]" value="<?php echo $master['accid']?>" class="members'+id+'"/><?php echo $master['nickname']?>(<?php echo $master['group_count']?>)&nbsp;';
		    <?php }?>
		    content += '</div>';
		    
			window.top.art.dialog({
				id:'agree',
				content:content, 
				title:'请添加蜂博士团队管理员', 
				width:'400', 
				height:'120', 
				lock:true,
				ok: function(){
					var members = new Array();
					$(".members"+id+":checked").each(function(){
						members.push($(this).val());
				    });
					$.post("?m=chat&c=group_check&a=apply_agree&pc_hash="+pc_hash,{id:id,members:members},function(data2){
						if(data2.code == '200'){
    						obj.parents('td').html('<span class="glyphicon glyphicon-ok-circle" style="color:green">已通过</span>');
						}else{
							alert(data2.msg);
						}
					});
				},
				okVal:"审核通过",
				cancel: function(){
					window.top.art.dialog({id:'agree'}).close();
				}
			});
		}else{
			alert(data.msg);
		}
	});
	
})
$(".table-list").on("click",".apply-refuse",function(){
	var obj = $(this);
	var id = obj.parents('tr').attr("data-id");
	
	window.top.art.dialog({
		id:'refuse',
		content:'<textarea type="text" name="refuse_reason" class="input-text" id="refuse_reason'+id+'" value="" style="width:300px;height:100px;"></textarea>', 
		title:'请填写拒绝理由', 
		width:'500', 
		height:'200', 
		lock:true,
		ok: function(){
			var refuse_reason = $("#refuse_reason"+id).val();
			$.post("?m=chat&c=group_check&a=apply_refuse&pc_hash="+pc_hash,{id:id,refuse_reason:refuse_reason},function(data){
				obj.parents('td').html('<span class="glyphicon glyphicon-remove-circle" style="color:red">已拒绝</span>');
			});
		},
		okVal:"确认拒绝",
		cancel: function(){
			window.top.art.dialog({id:'refuse'}).close();
		}
	});
})
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>