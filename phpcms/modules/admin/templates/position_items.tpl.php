<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<div class="page-header">
	<div class="pull-left">
		<h4><?php if($_GET['posid']==18){ echo '热点资讯';}else{ echo L('menu_app');}?></h4>      
	</div>
</div>
<?php if($_GET['posid']==19){?>
<div class="indentify-class padding-lr">
<p class="margin-big-tb text-sub text-default">
	 请在资讯处推送或设置推荐位为“app banner“；banner图尺寸建议：750*300px
</p>
</div>
<?php }?>
<form name="myform" id="myform" action="" method="post" onsubmit="checktid();return false;">
<input type="hidden" value="<?php echo $posid?>" name="posid">
<div class="table-margin">
    <table width="100%" class="table table-bordered table-header">
        <thead>
            <tr align="center">
            <th width="30"  align="left"><input type="checkbox" value="" id="check_box" onclick="selectall('items[]');"></th>
            <th width="80"  style="text-align:center"><?php echo L('listorder');?></th>
            <th width="60"  style="text-align:center">ID</th>
			
            <th width=""  align="left"><?php echo L('title');?></th>
			<?php if($_GET['posid']==18){?><th width="80" style="text-align:center">点赞量</th><?php }?>
			<th width="80" style="text-align:center">点击量</th>
            <th width="100" style="text-align:center">来源栏目</th>
            <th width="150" style="text-align:center">推送时间</th>
			<?php if($_GET['posid']==19){?><th width="50">状态</th><?php }?>
            <th width="200" style="text-align:center"><?php echo L('posid_operation');?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	$this->hits_db = pc_base::load_model('hits_model');
	$this->db = pc_base::load_model('content_model');
	$this->model = getcache('model', 'commons');
	foreach($infos as $info){
		$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$info['modelid'].'-'.$info['id']));
		$this->db->table_name = $this->db->db_tablepre.$this->model[$info['modelid']]['tablename'];
		$this->db->table_name = $this->db->table_name.'_data';
		$r2 = $this->db->get_one(array('id'=>$info['id']));
	?>   
	<tr>
	<td>
	<input type="checkbox" name="items[]" value="<?php echo $info['id'],'-',$info['modelid']?>" id="items" boxid="items">
	</td>	
	<td >
	<input name='listorders[<?php echo $info['catid'],'-',$info['id']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c">
	</td>	
	<td  align="left"><?php echo $info['id']?></td>
	<td  align="left"><?php if($_GET['posid']==19 && trim($info['imgurl'])!='') {?><a href='<?php echo $info['imgurl'];?>' target='_blank'><img src="<?php echo $info['imgurl'];?>" width="300" height="120"> </a><?php }?>
	<p><a href='?m=content&c=index&a=show&catid=<?php echo $info['catid'];?>&id=<?php echo $info['id'];?>' target='_blank'><?php echo $info['title']?></a></p></td>
	
	<?php if($_GET['posid']==18){?><td  align="center"><?php echo $r2['votenums'];?></td><?php }?>
	
	<td  align="center"><?php echo $hits_r['views'];?></td>
	<td  align="center"><?php echo $info['catname'];?></td>
	<td align="center"><?php echo date('Y-m-d',$info['inputtime']);?></td>
	
	<?php if($_GET['posid']==19){?>
	<td  align="center"><?php if($info['status']==1) {echo '<span class="glyphicon glyphicon-ok-circle btn-lg" style="color:green;"></span>';}else{ echo '<span class="glyphicon glyphicon-ban-circle btn-lg" style="color:red"></span>';}?></td>
	<?php }?>
	
	
	<?php if($_GET['posid']==19){?>
	<td align="center"><a onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $info['catid']?>&id=<?php echo $info['id']?>','')" href="javascript:;"><?php echo L('posid_item_edit');?></a> | <a href="javascript:item_manage(<?php echo $info['id']?>,<?php echo $info['posid']?>, <?php echo $info['modelid']?>,'<?php echo $info['title']?>')">上传banner图</a>
	</td><?php }else{?>
	<td align="center">
	
		<a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $info['catid']?>&id=<?php echo $info['id']?>','')">修改</a>
	</td>
	
	<?php }?>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
  
    <div class="btn">
	
	<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> 
	
	<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('listorder')?>" onclick="myform.action='?m=admin&c=position&a=public_item_listorder';myform.submit();"/> 
	
	<!--<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" value="删除" onclick="return confirm('<?php echo L('sure_delete')?>');"/> 
	
	?m=admin&c=position&a=public_item&posid=<?php echo $_GET['posid'];?>&pc_hash=<?php echo $_SESSION['pc_hash']?>
	
	-->
	<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('delete');?>" onclick="myform.action='?m=admin&c=position&a=public_item&dosubmit=1&posid=<?php echo $_GET['posid'];?>&pc_hash=<?php echo $_SESSION['pc_hash']?>';return confirm_delete()"/>
	<?php if($_GET['posid']==19){?>
	<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" value="启用" onclick="document.myform.action='?m=admin&c=position&a=public_item_start&status=1';"/> 
	
	<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" value="停用" onclick="document.myform.action='?m=admin&c=position&a=public_item_start&status=0';"/> 
	
	<?php }?>
	</div>


 <div id="pages"> <?php echo $pages?></div>
</div>
</form>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script type="text/javascript">

	function checktid() {
		var ids='';
		$("input[name='items[]']:checked").each(function(i, n){
			ids += $(n).val() + ',';
		});
		if(ids=='') {
			window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
			return false;
		} else {
			myform.submit();
		}
	}
	function confirm_delete(){
		if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
	}
	function item_manage(id,posid, modelid, name){
		window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=position&a=public_item_manage&id='+id+'&posid='+posid+'&modelid='+modelid ,width:'550px',height:'430px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();setTimeout(function(){window.top.art.dialog({id:'edit'}).close()},2000);return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
	}

</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>