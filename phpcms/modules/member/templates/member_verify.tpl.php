<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script src="<?php echo JS_PATH;?>artDialog-master/dist/dialog.js"></script>
<style>
	#cancel{display: none;}
</style>
<script language="JavaScript">
function refuseapply(mpid,name){
	var optips = dialog({
	id: 'Tips',  
	title: '拒绝专家申请',  
	cancel: true,  
	fixed: true,  
	lock: true,  
	opacity: 0.5,
	width: 460,
	background: '#f0ff00',
	skin: 'min-dialog tips',
	align: 'right',
	content: '<font size="4em">是否拒绝'+name+'的专家申请？</font>',
	okValue: '确定',
	ok: function () {
		$.post("<?php echo ADMIN_PATH;?>index.php?m=member&c=member_verify&a=rejectsingle&mpid="+mpid+"&pc_hash="+pc_hash,function(datas){
				if(datas=="1"){
						var waiting = dialog({
						id: 'Tips',  
						title: false,
						cancel: false,  
						fixed: true,  
						lock: true,  
						opacity: 0.5,
						width: 460,
						background: '#f0ff00',
						skin: 'min-dialog tips',
						align: 'right',
						content: '<font size="4em">操作成功</font>',
						});
						waiting.showModal();
						setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 2000);
					}else if(datas=="2"){
						var waiting = dialog({
						id: 'Tips',  
						title: '提示', 
						cancel: false,  
						fixed: true,  
						lock: true,  
						opacity: 0.5,
						width: 460,
						background: '#f0ff00',
						skin: 'min-dialog tips',
						align: 'right',
						content: '<font size="4em">此用户已是专家，请直接忽略专家申请</font>',
						okValue: '知道了',
						ok: function () {}
						});	
						waiting.showModal();
						return false;
					}else{
						var waiting = dialog({
						id: 'Tips',  
						title: false,  
						cancel: false,  
						fixed: true,  
						lock: true,  
						opacity: 0.5,
						width: 460,
						background: '#f0ff00',
						skin: 'min-dialog tips',
						align: 'right',
						content: '<font size="4em">数据异常</font>',
						});
						waiting.showModal();
						setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 2000);
					}
					
					
			});
	},
	cancelValue: '取消',
});
optips.showModal();
}
</script>
<script language="JavaScript">
function hulueapply(mpid,name){
	var optips = dialog({
	id: 'Tips',  
	title: '填写忽略'+name+'的专家申请备注？',  
	cancel: true,  
	fixed: true,  
	lock: true,  
	opacity: 0.5,
	width: 460,
	background: '#f0ff00',
	skin: 'min-dialog tips',
	align: 'right',
	content: '<textarea autofocus name="message" id="message" style="width:100%;height:90px;"/>',
	okValue: '确定',
	ok: function () {
		var theLabel=document.getElementById("message").value; 
		$.post("<?php echo ADMIN_PATH;?>index.php?m=member&c=member_verify&a=ignore&mpid="+mpid+"&message="+theLabel+"&pc_hash="+pc_hash,function(datas){
				if(datas=="1"){
						var waiting = dialog({
						id: 'Tips',  
						title: false,
						cancel: false,  
						fixed: true,  
						lock: true,  
						opacity: 0.5,
						width: 460,
						background: '#f0ff00',
						skin: 'min-dialog tips',
						align: 'right',
						content: '<font size="4em">操作成功</font>',
						});
						waiting.showModal();
						setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 2000);
					}else{
						var waiting = dialog({
						id: 'Tips',  
						title: false,  
						cancel: false,  
						fixed: true,  
						lock: true,  
						opacity: 0.5,
						width: 460,
						background: '#f0ff00',
						skin: 'min-dialog tips',
						align: 'right',
						content: '<font size="4em">数据异常</font>',
						});
						waiting.showModal();
						setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 2000);
					}
					
					
			});
	},
	cancelValue: '取消',
});
optips.showModal();
}
</script>
<script language="JavaScript">
function checkapply(mpid,name){
	var optips = dialog({
	id: 'Tips',  
	title: '通过专家申请',  
	cancel: true,  
	fixed: true,  
	lock: true,  
	opacity: 0.5,
	width: 460,
	background: '#f0ff00',
	skin: 'min-dialog tips',
	align: 'right',
	content: '<font size="4em">是否通过'+name+'的专家申请？</font>',
	okValue: '确定',
	ok: function () {
		$.post("<?php echo ADMIN_PATH;?>index.php?m=member&c=member_verify&a=passsingle&mpid="+mpid+"&pc_hash="+pc_hash,function(datas){
		if(datas=="1"){
				var waiting = dialog({
				id: 'Tips',  
				title: false,  
				cancel: false,  
				fixed: true,  
				lock: true,  
				opacity: 0.5,
				width: 460,
				background: '#f0ff00',
				skin: 'min-dialog tips',
				align: 'right',
				content: '<font size="4em">操作成功</font>',
				});
				waiting.showModal();
				setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 1000);
		   }else if(datas=="2"){
				var waiting = dialog({
				id: 'Tips',  
				title: '提示', 
				cancel: false,  
				fixed: true,  
				lock: true,  
				opacity: 0.5,
				width: 460,
				background: '#f0ff00',
				skin: 'min-dialog tips',
				align: 'right',
				content: '<font size="4em">此用户已是专家，请直接忽略专家申请</font>',
				okValue: '知道了',
				ok: function () {}
				});
				waiting.showModal();
				return false;
			}else if(datas=="6"){
				var waiting = dialog({
				id: 'Tips',  
				title: '提示', 
				cancel: false,  
				fixed: true,  
				lock: true,  
				opacity: 0.5,
				width: 460,
				background: '#f0ff00',
				skin: 'min-dialog tips',
				align: 'right',
				content: '<font size="4em">'+name+'之前已存在简介，请前往检验专家信息</font>',
				okValue: '知道了',
				ok: function () {
					window.location.reload();//关闭子页面后要进行的操作
				}
				});
				
				waiting.showModal();
				
				return false;
			}else{
				var waiting = dialog({
				id: 'Tips',  
				title: false,  
				cancel: false,  
				fixed: true,  
				lock: true,  
				opacity: 0.5,
				width: 460,
				background: '#f0ff00',
				skin: 'min-dialog tips',
				align: 'right',
				content: '<font size="4em">数据异常</font>',
				});
			}
			waiting.showModal();
			setTimeout(function () {window.location.href='?m=member&c=member_verify&a=manage&s=0&menu_id=<?php echo $_GET['menu_id']?>&pc_hash='+pc_hash}, 1000);
		});
	},
	cancelValue: '取消'
});
	optips.showModal();
}
</script>
<div class="page-header">
	<div class="pull-left">
		<h4>审核专家申请</h4>      
	</div>
</div>
<!--
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='?m=member&c=member_verify&a=manage' class="on"><em>未审核</em></a><span>|</span><a href='?m=member&c=member_verify&a=manage&s=2&menu_id=<?php echo $_GET['menu_id']?>' ><em>已忽略</em></a><span>|</span><a href='?m=member&c=member_verify&a=manage&s=1&menu_id=<?php echo $_GET['menu_id']?>' ><em>已通过</em></a><span>|</span><a href='?m=member&c=member_verify&a=manage&s=4&menu_id=<?php echo $_GET['menu_id']?>' ><em>已拒绝</em></a><span>   </div>
</div>
-->

<div class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member_verify" name="c">
<input type="hidden" value="search" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<style>
	body .table-list tbody td, body .table-list tbody tr,body .table-list thead th{text-align: left !important;}
</style>
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<select name="type">
					<option value='1' <?php if(isset($_GET['type']) && $_GET['type']==1){?>selected<?php }?>><?php echo L('username')?></option>
					<option value='2' <?php if(isset($_GET['type']) && $_GET['type']==2){?>selected<?php }?>><?php echo L('nickname')?></option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				
				申请日期：
				<?php echo form::date('start_time', $start_time)?>-
				<?php echo form::date('end_time', $end_time)?>
							
				<select name="status">
					<option value='99' <?php if(isset($_GET['status']) && $_GET['status']=='99'){?>selected<?php }?>>全部</option>
					<option value='0' <?php if(isset($_GET['status']) && $_GET['status']==0){?>selected<?php }?>>未审核</option>
					<option value='1' <?php if(isset($_GET['status']) && $_GET['status']==1){?>selected<?php }?>>已通过</option>
					<option value='2' <?php if(isset($_GET['status']) && $_GET['status']==2){?>selected<?php }?>>已忽略</option>
					<option value='4' <?php if(isset($_GET['status']) && $_GET['status']==4){?>selected<?php }?>>已拒绝</option>
				</select>
				
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>


<form name="myform" action="?m=member&c=member_verify&a=delete" method="post" onsubmit="checkuid();return false;">
<div class="table-margin">
<div class="table-list">
<table width="100%" cellspacing="0">
        <thead>
            <tr>
			<th align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left" width="50">ID</th>
			<th align="left" width="350"><?php echo L('username')?></th>
			<th align="left" width="120"><?php echo L('nickname')?></th>
			<th align="left" width="120"><?php echo L('sex')?></th>
			<th align="left" ><?php echo L('idcard')?></th>
			<th align="left" width="180"><?php echo L('birthday')?></th>
			<th align="center" width="150">状态</th>
            </tr>
        </thead>
    <tbody>
<?php
	foreach($memberlist as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['mobile']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['id']?></td>
		<td align="left"><?php if($v['avatar']){?>
		<a href="<?php echo API_PATH.$v['avatar']?>" target="_blank">
		<img height="18" width="18" align="absmiddle" src="<?php echo API_PATH.$v['avatar']?>">
		<?php }else{ ?>
		<img height=18 width=18 align=absmiddle src="<?php echo IMG_PATH?>member/nophoto.gif">
		<?php } 
		?><?php echo $v['mobile']?></td>
		<td align="center"><?php echo $v['nickname']?></td>
		<td align="center"><?php echo $v['sex']?></td>
		<td align="left"><?php echo $v['idcard']?></td>
		<td align="center" ><?php if($v['birthday']){ echo format::date($v['birthday'], '','');}?></td>
		<td align="center">
			<?php 
				$verify_status = array('5'=>'<font class="redcolor">'.L('nerver_pass').'</font>', '4'=>'<span class="glyphicon glyphicon-remove-circle" style="color:red">已拒绝</span>', '3'=>L('delete'), '2'=>'<span class="glyphicon glyphicon-ban-circle" style="color:white">已忽略</span>', '0'=>'<font class="whitecolor">未审核</font>', '1'=>'<span class="glyphicon glyphicon-ok-circle" style="color:orange">已通过</span>'); 
			?>
			
			
			<?php if($v['status']==0 || $v['status']==2){?>
			
			<!-- operate button -->
			<div class="btn-group">
			  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
			   <?php echo $verify_status[$v['status']];?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu" style="width:80px;">
				<li ><a href='#' style='color:green' title="点击通过审核" onClick="checkapply(<?php echo $v['id']?>,'<?php echo new_html_special_chars($v['nickname'])?>')"><span class="glyphicon glyphicon-ok-circle">通过</span></a></li>
				<li class="divider"></li>
				<li><a href='#' style='color:red' title="点击拒绝审核" onClick="refuseapply(<?php echo $v['id']?>,'<?php echo new_html_special_chars($v['nickname'])?>')"><span class="glyphicon glyphicon-remove-circle">拒绝</a></li>
				<li class="divider"></li>
				<li><a href='#' title="点击忽略审核" onClick="hulueapply(<?php echo $v['id']?>,'<?php echo new_html_special_chars($v['nickname'])?>')"><span class="glyphicon glyphicon-ban-circle">忽略</a></li>
			  </ul>
			</div>
			<!-- operate button -->
			<?php }else{ echo $verify_status[$v['status']];}?>
		</td>
	</tr>
	<tr >
		<td align="left"></td>	
		<td align="left"></td>	
		<td align="left" colspan='5'>地区：<?php echo  $v['province']. $v['city'].$v['county'].$v['street'].$v['address']?></td>
		<td align="left"></td>	
	</tr>
	<tr> 
		<td align="left"></td>
		<td align="left"></td>	
		<td align="left">公司：<?php echo $v['company']?></td>
		<td align="left">职务：<?php echo $v['duty']?></td>
		<td align="left" colspan='2'>擅长：<?php echo $v['skill']?></td>
		<td align="left" >申请类型：<font color='red'><?php echo $grouparray[$v['usertype']];?></font></td>
		<td align="left"></td>	
	</tr>
	<tr >
		<td align="left"></td>	
		<td align="left"></td>	
		<td align="left" colspan='5'>简介： <?php echo $v['introduction']?></td>
		<td align="left"></td>	
	</tr>
	<tr>
		<td align="left"></td>
		<td align="left"></td>	
		<td align="left"><?php echo L('applydate')?>：<?php echo format::date($v['regdate'], 1);?></td>
		<td align="left" colspan='4'><?php echo L('verify_message')?>：<?php echo $v['message']?></td>
		<td align="left"></td>	
	</tr>
<?php
	}
?>
 </tbody>
</table>
<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label>
<!--
<input type="submit" class="button" name="dosubmit" value="<?php echo L('verify_pass')?>" onclick="document.myform.action='?m=member&c=member_verify&a=pass'"/>
<input type="submit" class="button" name="dosubmit" value="<?php echo L('reject')?>" onclick="document.myform.action='?m=member&c=member_verify&a=reject'"/>
<input type="submit" class="button" name="dosubmit" value="<?php echo L('ignore')?>" onclick="document.myform.action='?m=member&c=member_verify&a=ignore'"/>
<input type="checkbox" value=1 name="sendsms"/> <?php echo L('sendsms')?>
-->
<input type="submit" class="button"  value="<?php echo L('delete')?>"  onclick="return confirm('<?php echo L('sure_delete')?>');">
</div> 
<div class="pull-right">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>
</div>
</div>
</form>
<script type="text/javascript">
<!--
function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
		
	} else {
		myform.submit();
	}
}
//-->
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>