<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headersimple', 'admin');?>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left">群号</th>
			<th align="left">群名</th>
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
</script>
</body>
</html>