<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
<script type="text/javascript">
$(function(){if ($.browser.msie && parseInt($.browser.version) < 7) $('#browserVersionAlert').show();}); 
</script>
<div class="explain-col mb10" style="display:none" id="browserVersionAlert"><?php echo L('ie8_tip')?></div>
<!--数据统计结束-->
<style>
.widthsquare{width:100%;}
.widthsquare ul{margin:20px;}
.widthsquare h1{width:100%;float:left;font-size:16px;line-height:16px;font-weight:bold;padding:15px;}
.widthsquare ul li{}
.widthsquare ul li{width:160px;float:left;text-align:center;margin-bottom:10px;}
.widthsquare ul li p{margin-top:10px;font-size:14px;text-align:center;}
</style>
<!--start-->
<div class='widthsquare'>
<h1>数据统计</h1>
<div class="bk10"></div>
<ul>

<li>
	<a href="?m=content&c=wenwen&a=init&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#2fbc63;'> <i class="fa fa-square fa-stack-2x"></i> <i class="fa  fa-question-circle fa-stack-1x fa-inverse"></i></span> </a>
	<p>问题：<?php echo $sys_cache['web_count_thread']?></p>
	<p>今日新增： <?php echo $sys_cache['new_count_thread']?> </p>
</li>
<li>
	<a href="?m=content&c=wenwen&a=managepost&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#3890d4;'> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-stethoscope fa-stack-1x fa-inverse"></i></span> </a>
	<p>解答： <?php echo $sys_cache['web_count_post']?> </p>
	<p>今日新增： <?php echo $sys_cache['new_count_post']?></p>
</li>


<li>
	<a href="?m=content&c=content&a=init&menuid=822&catid=109&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#2f4050;'> <i class="fa fa-square fa-stack-2x"></i> 
	<i class="fa fa-film fa-stack-1x fa-inverse"></i></span></a> 
	<p>课时：<?php echo $sys_cache['web_count_video']?></p>
	<p>今日新增：<?php echo $sys_cache['new_count_video']?>	</p>
</li>

<li>
	<a href="?m=content&c=content&a=init&menuid=822&catid=109&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#2f4050;'> <i class="fa fa-square fa-stack-2x"></i> 
	<i class="fa fa-film fa-stack-1x fa-inverse"></i></span></a> 
	<p>课时评论：<?php echo $sys_cache['web_count_video']?></p>
	<p>今日新增：<?php echo $sys_cache['new_count_video']?>	</p>
</li>

<li>
	<a href="?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash']?>">
	<span class=" fa-stack fa-4x" style='color:#ff6600;'> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-user fa-stack-1x fa-inverse"></i></span> </a>
	<p>用户： <?php echo $sys_cache['web_count_uid']?> </p>
	<p>今日新增： <?php echo $sys_cache['new_count_uid']?></p>
</li>
<li>
	<a href="?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#fe6b5f;'> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-user-md fa-stack-1x fa-inverse"></i></span></a>
	<p>专家：<?php echo $sys_cache['web_count_expert']?> </p>
	<p>待审核：<?php if($sys_cache['new_count_experapply']>0){
	 echo "<a href='?m=member&c=member_verify&a=manage&s=0&pc_hash=".$_SESSION['pc_hash']."'>".$sys_cache['new_count_experapply']."</a>  <img src='".IMG_PATH."new2.png' align='absmiddle'>";
	 }else{ echo '0';} ?></p>
</li>
</ul>
</div>

<div class="bk10"></div>
<div class='widthsquare'>
<h1>常用功能</h1>
<div class="bk10"></div>
<ul>

<li>
	<a href="?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash']?>"> <i class="fa fa-picture-o "></i> 发布课时</a>
</li>
</ul>
</div>


<div class="bk10"></div>
<div class='widthsquare'>
<h1>排行数据</h1>
<div class="bk10"></div>
<ul>

<li>
	<a href="?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash']?>"><span class="fa-stack fa-4x" style='color:#fe6b5f;'> <i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-user-md fa-stack-1x fa-inverse"></i></span></a>
	<p>专家：<?php echo $sys_cache['web_count_expert']?> </p>
	<p>待审核：<?php if($sys_cache['new_count_experapply']>0){
	 echo "<a href='?m=member&c=member_verify&a=manage&s=0&pc_hash=".$_SESSION['pc_hash']."'>".$sys_cache['new_count_experapply']."</a>  <img src='http://www.114nz.com/statics/icon/new2.png' align='absmiddle'>";
	 }else{ echo '0';} ?></p>
</li>
</ul>
</div>







<div class="bk10"></div>
<!--数据统计结束-->
<div class="col-2 lf mr10" style="margin-top:30px;width:80%">

	<h6><?php echo L('main_safety_tips')?></h6>
	<div class="content" >
<?php echo L('main_hello')?><?php echo $admin_username?><br />
	<div class="bk20 hr"><hr /></div>
	<?php echo L('main_role')?><?php echo $rolename?> <br />
	<div class="bk20 hr"><hr /></div>
	<?php echo L('main_last_logintime')?><?php echo date('Y-m-d H:i:s',$logintime)?><br />
	<div class="bk20 hr"><hr /></div>
	<?php echo L('main_last_loginip')?><?php echo $loginip?> <br />
<?php if(pc_base::load_config('system','debug')) {?>
<?php echo L('main_safety_debug')?><br />
<?php } ?>
<?php if(!pc_base::load_config('system','errorlog')) {?>
<?php echo L('main_safety_errlog')?><br />
<?php } ?>
	<div class="bk20 hr"><hr /></div>	
<?php if(pc_base::load_config('system','execution_sql')) {?>	
<?php echo L('main_safety_sql')?> <br />
<?php } ?>
<?php if($logsize_warning) {?>	
<?php echo L('main_safety_log',array('size'=>$common_cache['errorlog_size'].'MB'))?>

<?php } ?>
<?php 
$tpl_edit = pc_base::load_config('system','tpl_edit');
if($tpl_edit=='1') {?>
<?php echo L('main_safety_tpledit')?><br />
<?php } ?>
	</div>
</div>

<div class="bk10"></div>
</div>
</body></html>