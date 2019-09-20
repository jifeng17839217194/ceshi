<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = $show_header = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="page-header">
	<div class="pull-left">
		<h4>解答管理</h4>      
	</div>
</div>
<div class="table-margin">
<form name="myform2" id="myform2" action="" method="get">
<input type="hidden" value="content" name="m">
<input type="hidden" value="wenwen" name="c">
<input type="hidden" value="managepost" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
			<td><div class="explain-col">
				<select name="searchtype">
					<!--<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>>选择类型</option>-->
					<option value='1' <?php if($_GET['searchtype']==1) echo 'selected';?>>问题标题</option>
					<option value='2' <?php if($_GET['searchtype']==2) echo 'selected';?>>用户名</option>
					<option value='3' <?php if($_GET['searchtype']==3) echo 'selected';?>>解答关键词</option>
				</select>            
                                   
             <input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" size="15"/>
			 分类：
			 
			 <select name="zuowu" id="zuowu">
			 <option value="">全部分类</option>
			<?php
			foreach($datazuo as $key=>$v){?>			
				<option value="<?php echo $v['fid'];?>"  <?php if($v['fid']==$_GET['zuowu']) {echo "selected";}?>><?php echo $v['letter'];?> <?php echo $v['name'];?></option>
			<?php
				}
			?>
			 </select>
             <?php echo L('times_t')?>  <?php echo form::date('search[start_time]',$start_time)?> <?php echo L('to')?> <?php echo form::date('search[end_time]',$end_time)?>
             <input type="submit" value=" 搜索 " class="btn btn-mystyle btn-sm" name="dosubmit"></div></td>
		</tr>
    </tbody>
</table>
</form>
	</div>
  <div class="table-margin">
<form name="myform" id="myform" action="?m=content&c=wenwen&a=delanswer&pc_hash=<?php echo $_SESSION['pc_hash']?>" method="post" onsubmit="checkpid();return false;">
    <div class="table-list">
      <table width="100%"  class="table table-bordered table-header">
        <thead>
          <tr>
            <th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('pid[]');"></th>
            <th width="50" align="center">ID</th>
			<th align="center">解答内容</th>
			<th width='60' align="center">点赞量</th> 
			<th width='200' align="center">用户</th> 
			<th width='150' align="center">时间</th>
			<th width="60" align="center">操作</th>
		  </tr>
        </thead>
        <tbody>
		
          <?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
         <tr>
            <td align="center" height="40"><input type="checkbox" name="pid[]" value="<?php echo $info['pid']?>"></td>
            <td align="center"><?php echo $info['pid'];?></td>
			<td style="text-align: left;">
			<?php if($info['elite']==1){ echo "<span class='glyphicon glyphicon-thumbs-up' style='color:red'></span> ";}?><?php echo $info['message'];?>
			</td>
			<td align="left"><?php echo $info['votenums'];?></td>
			<td align="center"> <a href="javascript:member_infomation(<?php echo $info['userid']?>)"><span class='glyphicon glyphicon-zoom-in'></span> <?php echo $info['nickname'];?>(<?php echo $info['mobile'];?>)</a>
			</td>
            <td align="center"><?php echo date('Y/m/d H:i',$info['dateline'])?></td>
			<td align="center"><a href="javascript:void(0);" onclick="editpl('<?php echo $info['pid']?>')"><span class='glyphicon glyphicon-edit'></span></a>
			</td>
			
          </tr>
          <tr>
            <td align="center"></td>
			<td align="center"></td>
            <td height="30" colspan='5' style='background:#f3f3f3;text-align: left;'>问题：<?php echo $info['content'];?></td>
          </tr>
		  <tr><td colspan='7' style='height:2px;'></td></tr>
          <?php
	}
}
?>
        </tbody>
      </table>
    </div>
    <div class="btn">
	
    &nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="return confirm('<?php echo L('sure_delete')?>');" value="<?php echo L('delete')?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=setelitepost&status=0'" value="<?php echo "取消推荐";?>"/>
	&nbsp;&nbsp;<input type="submit" class="btn btn-mystyle btn-sm" name="dosubmit" onclick="document.myform.action='?m=content&c=wenwen&a=setelitepost&status=1'" value="<?php echo "设为推荐";?>"/>
	</div>
    <div class="pull-right">
<nav>
                                      <ul class="pagination"><?php echo $pages?>
									  </ul>
                                    </nav></div>
  </form>
</div>





<script type="text/javascript">
function editpl(id) {
	window.top.art.dialog({id:'editanswer'}).close();
	window.top.art.dialog({title:'<?php echo "编辑回复";?>',id:'editanswer',iframe:'?m=content&c=wenwen&a=editanswer&id='+id,width:'500',height:'300'}, function(){var d = window.top.art.dialog({id:'editanswer'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'editanswer'}).close()});
}
</script>

<script type="text/javascript">
<!--
function checkpid() {
	var ids='';
	$("input[name='pid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150',time:2.5},function(){});
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