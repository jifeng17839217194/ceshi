<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headersimple', 'admin');?>
<div class="table-list">
<table width="100%" class="table_form">
	<tr>
		<td width="150">输入要关联的群号：</td> 
		<td>
			<input type="text" name="tid" id="tid" value="" class="input-text" style="float: left;"> 
			<input type="button" class="button" onclick="link()" value="添加" style="float: left;">
		</td>
	</tr>
	<tr><td></td></tr>
</table>
<table width="100%" cellspacing="0" style="text-align: left !important;">
	<thead>
		<tr>
			<th align="left">群号</th>
			<th align="left">群名</th>
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
		<td align="left"><?php echo $v['tname']?></td>
		<td align="left">
			<a href="javascript:log_link(this,'<?php echo $v['tid'];?>',0);" >取消关联</a>&nbsp;&nbsp;
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
function link(){
	var tid = $("#tid").val();
	var logid = "<?php echo $logid;?>";
	$.get("?m=chat&c=group_log&a=link&pc_hash="+pc_hash,{logid:logid,tid:tid,type:1},function(data){
		window.location.reload();
	});
}
function log_link(obj,tid,type){
	$this = $(obj);
	var logid = "<?php echo $logid?>";
	$.get("?m=chat&c=group_log&a=link&pc_hash="+pc_hash,{tid:tid,logid:logid,type:type},function(data){
		window.location.reload();
	});
}
</script>
</body>
</html>