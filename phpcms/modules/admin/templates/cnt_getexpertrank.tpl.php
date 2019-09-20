<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('headerpage', 'admin');
?>
<div class="table-list" style='margin:10px auto;width:90%;'>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left">ID    </th>
			<th align="left">用户名</th>
			<th align="left">名字</th>
			<th align="center">回复数</th>
			
		</tr>
	</thead>
<tbody>
<?php foreach($temp as $val){?>
<tr>
<td ><?php echo $val['userid'];?></td>
<td ><?php echo $val['username'];?></td>
<td ><?php echo $val['nickname'];?></td>
<td align="center"><?php echo $val['replies'];?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>