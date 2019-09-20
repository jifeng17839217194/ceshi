<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="page-header">
	<div class="pull-left">
		<h4><?php if(ROUTE_A=='manage'){echo '用户管理';}else{echo '专家管理';}?></h4>      
	</div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a class="add fb" href="javascript:window.top.art.dialog({id:'add',iframe:'?m=member&c=member&a=add', title:'添加用户', width:'700', height:'500', lock:true}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});void(0);"><em>添加用户</em></a>　    <a href='javascript:;' class="on"><em>用户管理</em></a>    </div>
</div>

<div class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="expsearch" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="expertmanage" name="action">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<?php echo L('regtime')?>：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
							
				<select name="status">
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>><?php echo L('status')?></option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>><?php echo L('lock')?></option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>><?php echo L('normal')?></option>
				</select>
				<?php echo form::select($grouplist, $groupid, 'name="groupid"', '选择用户组')?>
				
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('uid')?></option>
					<option value='5' <?php if(isset($_GET['type']) && $_GET['type']==5){?>selected<?php }?>><?php echo L('nickname')?></option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?m=member&c=member&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left">ID</th>
			
			<th align="left"><?php echo L('username')?></th>
			<th align="left">名字</th>
			<th align="left">所在地</th>
			<th align="left"><?php echo L('member_group')?></th>
			<?php if(ROUTE_A=='expertmanage' || ROUTE_A=='expsearch'){
				

			?>
			<th align="left">擅长领域</th>
			<th align="left">工作单位</th>
			<th align="left">专家通过时间</th>
			<?php }else{ ?>
			<th align="left">注册时间</th>
			<th align="left"><?php echo L('lastlogintime')?></th>
			<?php } ?>
			
			
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($memberlist)){
		$this->userdb=pc_base::load_model('member_data_model');
	foreach($memberlist as $k=>$v){
	$rs=$this->userdb->get_one(array('userid'=>$v['userid']));
?>
    <tr>
		<td align="left" height='35'><input type="checkbox" value="<?php echo $v['userid']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['userid']?><?php if($v['islock']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?></td>
		
		<td align="left"><a href="javascript:top.imagePreviewDialog('<?php if($v['avatar']){echo API_PATH.$v['avatar'];}else{ echo IMG_PATH.'member/nophoto.gif';} ?>');"><img src="<?php if($v['avatar']){echo API_PATH.$v['avatar'];}else{ echo IMG_PATH.'member/nophoto.gif';} ?>" height="18" width="18" align="absmiddle"></a><?php echo $v['username']?><a href="javascript:member_infomation(<?php echo $v['userid']?>, '<?php echo $v['modelid']?>', '')"><?php echo $member_model[$v['modelid']]['name']?><img src="<?php echo IMG_PATH?>admin_img/detail.png"></a></td>
		<td align="left"><?php echo new_html_special_chars($v['nickname'])?></td>
		<td align="left"><?php echo $rs['province'].$rs['city'].$rs['county']?></td>
		<td align="left"><?php if(in_array($v['usertype'],array(9,10,11))){ echo "<font color='red'>"; }?><?php echo $grouplist[$v['usertype']]?></font></td>
		
		
		<?php if(ROUTE_A=='expertmanage' || ROUTE_A=='expsearch'){
			?>
			<td align="left"><?php 
			$skillarray=explode(',', $rs['skill']);
			foreach ($skillarray as $key => $value) {
					echo $wenmodulelist[$value].'&nbsp;';
				}
			?></td>
			<td align="left"><?php echo $rs['company'];?></td>
			<td align="left"><?php echo date('Y/m/d',$v['expbegintime']);?></td>
			<?php }else{?>
			<td align="left"><?php echo date('Y/m/d',$v['regdate']);?></td>
			<td align="left"><?php echo format::date($v['lastlogindate'],0);?></td>
		<?php } ?>
		
		<td align="left">
			<a href="javascript:edit(<?php echo $v['userid']?>, '<?php echo $v['username']?>')"><span class='glyphicon glyphicon-edit' style='color:#00cc33'></span></a>&nbsp;&nbsp;
			
			<a href="javascript:avatar(<?php echo $v['userid']?>, '<?php echo $v['nickname']?>')"><span class='glyphicon glyphicon-cloud-upload' style='color:#ff6600'></span></a>&nbsp;&nbsp;
			
			<a href="javascript:webcount(<?php echo $v['userid']?>, '<?php echo $v['nickname']?>')"><span class='glyphicon glyphicon-signal' style='color:#ff3300'></span></a>&nbsp;&nbsp;
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>
<!--onclick="operatedelete();return false;"-->
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')" />
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=lock'" value="<?php echo L('lock')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=unlock'" value="<?php echo L('unlock')?>"/>
<input type="button" class="button" name="dosubmit" onclick="move();return false;" value="<?php echo L('move')?>"/>
</div>

<div class="pull-right">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member&a=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function avatar(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>《'+name+'》头像',id:'edit',iframe:'?m=member&c=member&a=avatar&userid='+id,width:'400',height:'200'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function webcount(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'查看<?php echo L('member')?>《'+name+'》数据统计',id:'edit',iframe:'?m=member&c=member&a=webcount&userid='+id,width:'600',height:'200'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150',time:2.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?m=member&c=member&a=move&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function operatedelete() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150',time:2.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'operatedelete'}).close();
	// window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?m=member&c=member&a=delete&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'userid'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'userid'}).close()});
	window.top.art.dialog({content:'<?php echo L('sure_delete');?>', fixed:true,width:'300',height:'150',yesText:'', style:'confirm'}, function(){var d = window.top.art.dialog({id:'operatedelete'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){});
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
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
	window.top.art.dialog({title:'<?php echo L('memberinfo')?>',id:'modelinfo',iframe:'?m=member&c=member&a=memberinfo&userid='+userid+'&modelid='+modelid,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'modelinfo'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'modelinfo'}).close()});
}

//-->
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>