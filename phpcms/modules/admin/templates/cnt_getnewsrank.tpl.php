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
			<th >ID    </th>
			<th >栏目</th>
			<th align="left">标题</th>
			<th align="center">点赞数</th>
			
		</tr>
	</thead>
<tbody>
<?php foreach($temp as $val){?>
<tr>
<td ><?php echo $val['newsid'];?></td>
<td ><?php echo $val['catname'];?></td>
<td ><?php echo $val['title'];?></td>
<td align="center"><?php echo $val['votenums'];?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>