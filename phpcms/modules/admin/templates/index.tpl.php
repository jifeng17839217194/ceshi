<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<!--
<div class="info-title">
<div class="pull-left">
<h4><strong><?php echo L('main_hello')?><?php echo $admin_username?></strong></h4>
<p>欢迎登录<?php echo L('webtitle')?>！</a></p>
</div>

<div class="clearfix"></div>
</div>
-->
<!----数据统计---->
<?php 
$countCheck1 = check_rule('content','wenwen','init');
$countCheck2 = check_rule('content','wenwen','managepost');
$countCheck3 = check_rule('content','content','init','catid=109');
$countCheck4 = check_rule('content','comment_admin','listinfo');
$countCheck5 = check_rule('member','member','manage');
$countCheck6 = check_rule('member','member','expertmanage');
$totalCheck = $countCheck1 || $countCheck2 || $countCheck3 || $countCheck4 || $countCheck5 || $countCheck6;
?>
<?php if($totalCheck){?>
<div class="page-header">
<div class="pull-left">
<h4>统计信息（每10分钟更新数据）</h4>      
</div>
</div>			   
<div class="content-list">
<div class="row">
<?php if($countCheck1){?>
 <div class="col-md-2">
	<div class="content">
	  
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		   <h3 class="number"><a href="?m=content&c=wenwen&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=301"><?php echo $sys_cache['web_count_thread']?></a></h3>
		   <p>问题</p>
		   <p>今日新增：<span style="color:gray;"><?php echo $sys_cache['new_count_thread']?></span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($countCheck2){?>
  <div class="col-md-2">
	<div class="content">
	   
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		 
		   <h3 class="number"> <a href="?m=content&c=wenwen&a=managepost&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=302"><?php echo $sys_cache['web_count_post']?></a></h3>
		     <p>解答</p>
		   <p>今日新增：<span style="color:gray;"><?php echo $sys_cache['new_count_post']?></span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($countCheck3){?>
  <div class="col-md-2">
	<div class="content">
	  
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		   
		   <h3 class="number"><a href="?m=content&c=content&a=init&catid=109&from=train&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=312"><?php echo $sys_cache['web_count_video']?></a></h3>
		   <p>课时</p>
		   <p>今日新增：<span style="color:gray;"><?php echo $sys_cache['new_count_video']?></span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($countCheck4){?>
  <div class="col-md-2">
	<div class="content">
	  
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		   
		   <h3 class="number"><a href="?m=comment&c=comment_admin&a=listinfo&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=314"><?php echo $sys_cache['web_count_comment']?></a></h3>
		   <p>课时评论</p>
		   <p>今日新增：<span style="color:gray;"><?php echo $sys_cache['web_new_comment']?></span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($countCheck5){?>
 <div class="col-md-2">
	<div class="content">
	   
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		  
		   <h3 class="number"> <a href="?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=315"><?php echo $sys_cache['web_count_uid']?></a></h3>
		    <p>用户</p>
		   <p>今日新增：<span style="color:gray;"><?php echo $sys_cache['new_count_uid']?></span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($countCheck6){?>
 <div class="col-md-2">
	<div class="content">
	  
	   <div class="w70 right-title pull-right">
	   <div class="title-content">
		   
		   <h3 class="number"><a href="?m=member&c=member&a=expertmanage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=316"><?php echo $sys_cache['web_count_expert']?></a></h3>
		   <p>专家</p>
		   <p>待审核：<span style="color:gray;"><?php if($sys_cache['new_count_experapply']>0 && check_rule('member','member_verify','manage')){
echo "<a href='?m=member&c=member_verify&a=manage&s=0&pc_hash=".$_SESSION['pc_hash']."'>".$sys_cache['new_count_experapply']." <img src='".IMG_PATH."new2.png' align='absmiddle'>";
}else{ echo '0';} ?></a> </span></p>
	   </div>
	   </div>
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php }?>
 
</div>
<!-- 常用功能 -->
</div>
<div class="page-header">
<div class="pull-left">
<h4>常用功能</h4>      
</div>
</div>
<div class="content-list index-list">
	<div class="row">
		<?php if(check_rule('content','content','add','catid=109')){?>
		<div>
		<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=109&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="publish-class-icon img-icon"></span> 发布课时</a>
		</div>
		<?php }?>
		<?php if(check_rule('admin','linkage','public_manage_submenu','keyid=3364')){?>
		<div>
		<a class="btn btn-graystyle btn-lg" href="?m=admin&c=linkage&a=public_manage_submenu&keyid=3364&menu_id=313&pc_hash=<?php echo $_SESSION['pc_hash'];?>"   role="button" style='width:240px;height:90px'><span class="outline-class-icon img-icon"></span> <?php echo L('menu_train');?></a>
		</div>
		<?php }?>
		<?php if(check_rule('admin','position','public_item','posid=19')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=admin&c=position&a=public_item&posid=19&menu_id=325&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  role="button" style='width:240px;height:90px'><span class="app-icon img-icon"></span><?php echo L('menu_app');?></a>
		</div>
		<?php }?>
		<?php if(check_rule('member','member_verify','manage')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=member&c=member_verify&a=manage&menu_id=317&pc_hash=<?php echo $_SESSION['pc_hash'];?>"   role="button" style='width:240px;height:90px'><span class="expert-cion img-icon"></span> 审核专家申请</a>
		</div>
		<?php }?>
		<?php if(check_rule('admin','cache_all','init')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="javascript:cacheall()"  role="button" style='width:240px;height:90px'><span class="cache-icon img-icon"></span> 更新系统缓存</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=102')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=102&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="bee-icon img-icon"></span>  发布各地蜂情</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=103')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=103&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="rules-icon img-icon"></span>  发布政策法规</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=104')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=104&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="info-icon img-icon"></span>  发布行业动态</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=105')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=105&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="internationalBee-info-icon img-icon"></span>  发布国际蜂情</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=106')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=106&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="skill-icon img-icon"></span>  发布技术发展</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=107')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=107&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="serve-icon img-icon"></span>  发布协会服务</a>
		</div>
		<?php }?>
		<?php if(check_rule('content','content','add','catid=108')){?>
		<div>
			<a class="btn btn-graystyle btn-lg" href="?m=content&c=content&a=add&catid=108&pc_hash=<?php echo $_SESSION['pc_hash'];?>"  target="_blank" role="button" style='width:240px;height:90px'><span class="deal-icon img-icon"></span>  发布行业会议</a>
		</div>
		<?php }?>
	</div>
</div>
 




<?php 
$rankCheck1 = check_rule('admin','index','cnt_wentype');
$rankCheck2 = check_rule('admin','index','cnt_expertanswer');
$rankCheck3 = check_rule('admin','index','cnt_info');
$rankCheck4 = check_rule('admin','index','cnt_train');
$totalRankCheck = $rankCheck1 || $rankCheck2 || $rankCheck3 || $rankCheck4;
?>
<?php if($totalRankCheck){?>
<div class="page-header">
<div class="pull-left">
<h4>排行数据</h4>      
</div>
</div>

<div class="content-list rank-data">
<div class="row">

<?php if($rankCheck1){?>
 <div class="co">
	<div class="content">
	   <div class="w70 pull-left text-center">
		  <a href="javascript:getwentype()" role="button" class="btn btn-mystyle btn-lg" style="font-size: 40px;color:white;">
<span class="glyphicon glyphicon-th-list"></span>
</a>
<p>问题类型数据量</p>
</div>
	 <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($rankCheck2){?>
 
 <div class="co">
	<div class="content">
	   <div class="w70 pull-left text-center">
		  <a href="javascript:getexpertrank()" role="button" class="btn btn-mystyle btn-lg" style="font-size: 40px;color:white;">
<span class="glyphicon glyphicon-user"></span>
</a>
<p >专家回复排行榜（TOP20）</p>

	   </div>
	  
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($rankCheck3){?>
 
  <div class="co">
	<div class="content">
	   <div class="w70 pull-left text-center">
		  <a href="javascript:getnewsrank()" role="button" class="btn btn-mystyle btn-lg" style="font-size: 40px;color:white;">
<span class="glyphicon glyphicon-thumbs-up"></span>
</a>
<p >资讯点赞（TOP100）</p>

	   </div>
	  
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php if($rankCheck4){?>
 
  <div class="co">
	<div class="content">
	   <div class="w70 pull-left text-center">
		  <a href="javascript:getfavoriterank()" role="button" class="btn btn-mystyle btn-lg" style="font-size: 40px;color:white;">
<span class="glyphicon glyphicon-star"></span>
</a>
<p >收藏最多课时（TOP20）</p>

	   </div>
	  
	   <div class="clearfix"></div>
	</div>
 </div>
<?php }?>
<?php }?>
  
</div>
</div>

</div>			
</div>
</div>
</div>

<script type="text/javascript">
<!--
function getwentype() {
	window.top.art.dialog({id:'getwentype'}).close();
	window.top.art.dialog({title:'问题类型数据量',id:'getwentype',iframe:'?m=admin&c=index&a=cnt_wentype',width:'700',height:'400'}, function(){var d = window.top.art.dialog({id:'getwentype'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'getwentype'}).close()});
}

function getexpertrank() {
	window.top.art.dialog({id:'getexpertrank'}).close();
	window.top.art.dialog({title:'专家回复排行榜（TOP20）',id:'getexpertrank',iframe:'?m=admin&c=index&a=cnt_expertanswer',width:'600',height:'200'}, function(){var d = window.top.art.dialog({id:'getexpertrank'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'getexpertrank'}).close()});
}

function getnewsrank() {
	window.top.art.dialog({id:'getnewsrank'}).close();
	window.top.art.dialog({title:'资讯点赞（TOP100）',id:'getnewsrank',iframe:'?m=admin&c=index&a=cnt_info',width:'600',height:'200'}, function(){var d = window.top.art.dialog({id:'getnewsrank'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'getnewsrank'}).close()});
}

function getfavoriterank() {
	window.top.art.dialog({id:'getfavoriterank'}).close();
	window.top.art.dialog({title:'收藏最多课时（TOP20）',id:'getfavoriterank',iframe:'?m=admin&c=index&a=cnt_train',width:'600',height:'200'}, function(){var d = window.top.art.dialog({id:'getfavoriterank'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'getfavoriterank'}).close()});
}

function cacheall() {
	window.top.art.dialog({id:'cacheall'}).close();
	window.top.art.dialog({title:'收藏最多课时（TOP20）',id:'cacheall',iframe:'?m=admin&c=cache_all&a=init',width:'600',height:'400'}, function(){var d = window.top.art.dialog({id:'cacheall'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'cacheall'}).close()});
}
//-->
</script>

<?php
include $this->admin_tpl('footer');?>
</body>
</html>
