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
			<th align="center" >ID    </th>
			<th align="left">标题</th>
			<th align="center">收藏数</th>
			
		</tr>
	</thead>
<tbody>
<?php foreach($temp as $val){?>
<tr>
<td ><?php echo $val['infoid'];?></td>
<td ><?php echo $val['title'];?></td>
<td align="center"><?php echo $val['numbers'];?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>