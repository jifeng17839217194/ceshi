<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="page-header">
	<div class="pull-left">
		<h4>问题管理</h4>      
	</div>
</div>

<div class="pad-lr-10">
<div class="table-margin">
<form name="myform2" id="myform2" action="" method="get">
<input type="hidden" value="content" name="m">
<input type="hidden" value="wenwen" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
			<td><div class="explain-col">             
             提问者: <input name="author" type="text" value="<?php if(isset($_GET['author'])) {echo $_GET['author'];}?>" class="input-text" size="12"/>                      
             关键字: <input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" size="12"/>
			 分类: 
			 
			 <select name="zuowu">
			 <option value="">全部分类</option>
			<?php
			foreach($datazuo as $key=>$v){?>			
				<option value="<?php echo $v['fid'];?>"  <?php if($v['fid']==$_GET['zuowu']) {echo "selected";}?>><?php echo $v['letter'];?> <?php echo $v['name'];?></option>
			<?php
				}
			?>
			 </select>
			 状态: 
			  <select name="status">
			  <option value="99" <?php if($_GET['status']==99) {echo "selected";}?>>全部</option>
			  <option value="999" <?php if($_GET['status']==999) {echo "selected";}?>>正常</option>
			  <option value="25" <?php if($_GET['status']==25) {echo "selected";}?>>待解答</option>
			  <option value="2" <?php if($_GET['status']==2) {echo "selected";}?>>已关闭</option>
			  <!--
			  <option value="9" <?php if($_GET['status']==9) {echo "selected";}?>>待审核</option>
			  <option value="15" <?php if($_GET['status']==15) {echo "selected";}?>>已回复</option>
			  <option value="3" <?php if($_GET['status']==3) {echo "selected";}?>>精华帖</option>
			  <option value="4" <?php if($_GET['status']==4) {echo "selected";}?>>置顶帖</option>
			  -->
			  </select>
             
             <?php echo L('times_t')?>  <?php echo form::date('search[start_time]', '', 1)?> <?php echo L('to')?> <?php echo form::date('search[end_time]', '', 1)?>
             <input type="submit" value=" 搜索 " class="btn btn-mystyle btn-sm" name="dosubmit"></div></td>
		</tr>
    </tbody>
</table>
</form>
</div>

	
<div class="clearfix"></div>
<div class="table-margin">
<form name="myform" id="myform" action="?m=content&c=wenwen&a=wenoperateall&status=1&pc_hash=<?php echo $_SESSION['pc_hash']?>" method="post" onsubmit="checktid();return false;">
    
      <table width="100%" class="table table-bordered table-header">
        <thead>
          <tr>
            <td width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('tid[]');"></td>
            <td align="center">ID</td>
			<td align="center">问题标题</td>
			<td width='9%' align="center">分类</td>
			<td width='10%' align="center">回复/浏览</td>
            <td width="11%" align="center">提问者</td>
			<td width="12%" align="center">时间</td>
			<td width="10%" align="center"><?php echo L('status')?></td>
            <td width="8%" align="center">邀请专家</td>
			<td width="5%" align="center">编辑</td>
		 </tr>
        </thead>
        <tbody>
          <?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	  <tr>
		<td align="center" width="40"><input type="checkbox" name="tid[]" value="<?php echo $info['tid']?>"></td>
		<td align="center" ><?php echo $info['tid']?></td>
		<td style="font-size:14px;" height='35'>
			<?php if($info['attachment']>0){ echo "<span class='glyphicon glyphicon-picture' style='color:green'></span> "; }?><?php echo str_cut($info['content'],'80','...');?>
		</td>
		<td>
			<a href="javascript:void(0);" onclick="editsort('<?php echo $info['tid']?>', '<?php echo $info['fid']?>')">	<?php
			$this->forum_forum = pc_base::load_model('wenwen_module_model');
			$fcmp = $this->forum_forum->get_one(array('fid'=>$info['fid']));
			echo " <span class='glyphicon glyphicon-cog' style='color:green'></span> ".$fcmp['name'];
			?>
			</a>
		</td>
			
		<td align="center"><?php echo $info['replies']?>/<?php echo $info['views']?></td>
		<td align="center"><a href="javascript:member_infomation(<?php echo $info['userid']?>)"><span class='glyphicon glyphicon-zoom-in'></span> <?php echo $info['username']?></a></td>
		<td align="center"><?php echo date('Y/m/d H:i',$info['dateline'])?></td>
		<td align="center"><?php echo $info['wenstatus'];?></td>
		
		<td align="center">
			<?php
			 echo $info['expertid'];
			?>	
			</td>
			<td align="center"> <a href="javascript:void(0);" onclick="editwen('<?php echo $info['tid']?>')"><span class='glyphicon glyphicon-edit'></span> </a>
		</td>	
        </tr>
        <?php
	}
}
?>
        </tbody>
      </table>
  
    <div class="btn">
	<!--&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=0'" value="<?php echo "批量通过";?>"/>
    &nbsp;&nbsp;-->

	 
	<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="return confirm('<?php echo L('sure_delete')?>');" value="<?php echo L('delete')?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=2'" value="<?php echo "关闭问题";?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=2&act=cancel'" value="<?php echo "打开问题";?>"/>
	<!--&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=3&act=cancel'" value="<?php echo "取消精华";?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=3'" value="<?php echo "设为精华";?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=4&act=cancel'" value="<?php echo "取消置顶";?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=wenoperateall&status=4'" value="<?php echo "置顶";?>"/>-->
	</div>
<div class="pull-right">
<nav>
<ul class="pagination">
<?php echo $pages?></ul>
</nav>
</div>
  </form>
</div>
</div>
<script type="text/javascript">
function editsort(id,fid) {
	window.top.art.dialog({id:'editsort'}).close();
	window.top.art.dialog({title:'<?php echo "编辑分类";?>',id:'editsort',iframe:'?m=content&c=wenwen&a=editsort&fid='+fid+'&id='+id,width:'300',height:'120'}, function(){var d = window.top.art.dialog({id:'editsort'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editsort'}).close()});
}

function editwen(id) {
	window.top.art.dialog({id:'editwen'}).close();
	window.top.art.dialog({title:'<?php echo "问题编辑";?>',id:'editwen',iframe:'?m=content&c=wenwen&a=edit&id='+id,width:'500',height:'300'}, function(){var d = window.top.art.dialog({id:'editwen'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editwen'}).close()});
}
</script>
<script type="text/javascript">
<!--

function checktid() {
	var ids='';
	$("input[name='tid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
		return false;
	} else {
		myform.submit();
	}
}
function member_infomation(userid, modelid, name) {
	window.top.art.dialog({id:'modelinfo'}).close();
	window.top.art.dialog({title:'<?php echo L('memberinfo')?>',id:'modelinfo',iframe:'?m=member&c=member&a=memberinfo&userid='+userid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

//-->
</script>
<?php
include $this->admin_tpl('footer', 'admin');
?>
</body></html>