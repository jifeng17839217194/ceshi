<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headerpage','admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>formvalidatorregex.js" charset="UTF-8"></script>

<script type="text/javascript">
<!--
	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
	})
//-->
</script>
<style>
.txt_input{width:90%;}
</style>
<!--
<div class="page-header">
	<div class="pull-left">
		<h4>问题编辑</h4>      
	</div>
</div>
-->
<div class="pad_10">
<form action="?m=content&c=wenwen&a=edit&tid=<?php echo $tid; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="20%">问题描述：</th>
		<td>
		<textarea class="txt_input"  name="info[content]" id="content"  rows="6" cols="25"/><?php echo $content; ?></textarea>
		</td>
	</tr>
	<tr>
		<th width="20%">分类：</th>
		<td>
		<select name="info[fid]" id="fid">
		<?php
			foreach($forumtypes as $tkey=>$tf){
		?>
		<option value="<?php echo $tf['fid'];?>" <?php if($tf['fid']==$result['fid']){echo "selected";}?>><?php echo $tf['name'];?>
		</option>
      	<?php } ?>
		</select>
		</td>
	</tr>
	
	<?php if($pic_images){?>
	<tr>
		<th width="20%">图片：</th>
		<td>
		<div>
        <ul>		
		<?php
		foreach($pic_images as $key=>$value){
			if (preg_match('/(http:\/\/)|(https:\/\/)/i', $value))
			{
				$pic_urls_tiny=$value;
			}else{
				$pic_urls_tiny=API_PATH.$value;
			}
			echo "<li style='width:130px;float:left;margin:10px;'><a href='".$pic_urls_tiny."' target=_blank><img src=".$pic_urls_tiny." width=120 height=90></a><br><a  href='?m=content&c=wenwen&a=del_thread_pic&tid=".$tid."&aid=".$key."'><font class='redcolor'><i class='fa fa-trash'></i> </font></a></li>";
		}
		?>
        </ul></div>

	</td>
	</tr>
	<?php }?>
	<tr>
		<th width="20%">提问者：</th>
		<td><?php echo $username;?></td>
	</tr>
    <tr>
		<th width="20%">时间：</th>
		<td><?php echo date('Y-m-d H:i',$dateline);?></td>
	</tr>
	
	<tr>
		<th width="20%">状态：</th>
		<td><?php echo $status;?></td>
	</tr>
	
	
	<tr>
		<th width="20%" valign="top">专家：</th>
		<td>
		<?php
		foreach($types as $type_key=>$type){
		?>
		<?php if($type['userid']==$expertid){echo $type['nickname'];}?>
		<?php }?>
		 
	</td>
	</tr>
	<tr>
		<th></th>
		<td>
		<input name="info[tid]" id="tid" type="hidden" value="<?php echo $tid;?>">
		<input type="hidden" name="forward" value="?m=content&c=wenwen&a=edit">
		<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
		<!--class="dialog"--></td>
	</tr>
</table>
</form>
</div>
<?php
include $this->admin_tpl('footer', 'admin');
?>
</body>
</html>