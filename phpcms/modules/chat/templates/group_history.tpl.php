<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headersimple', 'admin');?>
<link rel="stylesheet" href="<?php echo JS_PATH;?>chataudio/css/jquery.audio5js.css" />
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>emoji.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>chataudio/js/audio5.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>chataudio/js/jquery.audio5js.js"></script>
<style>
.line-x {
    border-bottom: 0;
}
.content-menu {
    padding: 0;
}
.emoji{
	width: 18px;
	height: 18px;
}
.picture img{
	max-width: 200px;
	max-height: 200px;
}
.video {
	position: relative;
    min-height: 20px;
    line-height: 20px;
    /* overflow: hidden; */
    white-space: normal;
    word-wrap: break-word;
    word-break: break-all;
    font-size: 14px;
}
.aui_main {
    padding: 0px 10px;
}
body .table-list tbody td, body .table-list tbody tr, body .table-list .btn {
    text-align: left !important;
}
.item td {
	padding-top: 0px !important;
    padding-bottom: 0px !important;
    border-bottom: 0 !important;
}
.pagination {
    margin: 5px 0 !important;
}

</style>
<div class="table-list" style="margin-bottom: 60px;">
<!-- 
<table width="100%" class="table_form">
	<tr>
		<td width="150">聊天内容：</td> 
		<td>
			<input type="text" name="keywords" id="keywords" value="" class="input-text" style="float: left;"> 
			<input type="submit" class="button" onclick="link()" value="搜索" style="float: left;">
		</td>
	</tr>
	<tr><td></td></tr>
</table>
 -->
<table width="100%" cellspacing="0" class="table-list table-hover " style="text-align: left !important;">
<tbody>
<?php
	if(is_array($list)){
	    foreach($list as $k=>$v){
?>
    <tr>
		<td>
			<table class="item">
				<tr>
					<td rowspan="2"><a href="<?php echo $v['avatar']; ?>" target="_blank"><img src="<?php echo $v['avatar']; ?>" height="50" width="50" align="absmiddle"></a></td>
					<td><?php echo $v['nickname']?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['username']?>
						<?php echo date('Y-m-d H:i:s',$v['msg_timestamp']/1000)?></td>
				</tr>
				<tr>
					<td>
						<?php if($v['msg_type'] == 'TEXT'){ ?>
            				<div class="text"><?php echo $v['body'];?></div>
            			<?php }else if($v['msg_type'] == 'PICTURE'){?>
            				<div class="picture"><a href="javascript:top.imagePreviewDialog('<?php echo $v['attach']['url'];?>');"><img alt="" src="<?php echo $v['attach']['url'];?>" /></a></div>
            			<?php }else if($v['msg_type'] == 'AUDIO'){?>
            				<div class="audio" data-src="<?php echo $v['attach']['url'];?>"></div>
            			<?php }else if($v['msg_type'] == 'VIDEO'){?>
            				<div class="video"><!-- controlslist="nodownload" -->
            					<video src="<?php echo $v['attach']['url'];?>" controls="true"  preload="metadata" style="width:300px;">您的浏览器不支持 video 标签。</video>
            					<font color="red">*</font>注：下载后请手动在文件名后加.mp4后缀
            				</div>
            			<?php }else if($v['msg_type'] == 'LOCATION'){?>
            				<i class="fa fa-map-marker" style="color: red;"></i>&nbsp;<?php echo $v['attach']['title'];?>
            			<?php }else if($v['msg_type'] == 'CUSTOM'){?>
            				<?php if($v['attach']['type'] == 1){?>
            				    <?php 
            				    if($v['attach']['data']['value'] == 1){echo "【石头】";}
            				    if($v['attach']['data']['value'] == 2){echo "【剪刀】";}
            				    if($v['attach']['data']['value'] == 3){echo "【布】";}
            				    ?>
            				<?php }?>
            				<?php if($v['attach']['type'] == 3){?>
            				    <img alt="" src="<?php echo IMG_PATH.'im/'.$v['attach']['data']['catalog'].'/'.$v['attach']['data']['chartlet'].'.png'?>" width="100"/>
            				<?php }?>
            			<?php }?>&nbsp;
					</td>
				</tr>
			</table>
			
		</td>
	</tr>
<?php
	}
}
?>
</tbody>
</table>


</div>

<div class="pull-right" style="position: fixed;right: 0;bottom: 0;">
<nav>
<ul class="pagination"><?php echo $pages?></ul>
</nav>
</div>

</div>
<script type="text/javascript">
$(".text").each(function(){
	var value = $(this).html();
	$(this).html(buildEmoji(value));
})
$(".audio").each(function(){
	var url = $(this).data('src');
	$(this).audio5js({
		url : url,
		type:'chat'
	});
})
</script>
</body>
</html>