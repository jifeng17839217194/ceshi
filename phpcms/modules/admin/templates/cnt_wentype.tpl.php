<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('headerpage', 'admin');
?>
<div class="table-list" style='margin:50px auto;width:90%;'>
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="center">提问数    </th>
			<th align="center">解答数</th>
			<th align="center">关注数</th>
			<th align="center">粉丝数</th>
			<th align="center">解答被赞数</th>
		</tr>
	</thead>
<tbody>
<td align="center"><?php echo $temp['ask'];?></td>
<td align="center"><?php echo $temp['answer'];?></td>
<td align="center"><?php echo $temp['attention'];?></td>
<td align="center"><?php echo $temp['fans'];?></td>
<td align="center"><?php echo $temp['votes'];?></td>

</tbody>
</table>
</div>