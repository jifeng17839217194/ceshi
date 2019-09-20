<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<style>
.dept_select{
	border: 1px solid #A7A6AA;
    margin: 0 5px 0 0;
    padding: 2px 0 2px 5px;
    border: 1px solid #d0d0d0;
    background: #FFF url(../images/admin_img/input.png) repeat-x;
    font-family: Verdana, Geneva, sans-serif,"宋体";
    font-size: 12px;
	width: 660px;
}
.chosen-container .chosen-results {
    height: 384px;
}
.line-x {
    border-bottom: 0;
}
.content-menu {
    padding: 0;
}
</style>
<link rel="stylesheet" href="<?php echo CSS_PATH?>chosen.css">
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script language="javascript" src="<?php echo JS_PATH?>chosen.jquery.js"></script>
<div class="common-form">
<form name="myform" action="?m=chat&c=group_log&a=<?php echo ROUTE_A ?>" method="post" id="myform">
<fieldset>
    <table width="100%" cellspacing="0" class="table_form">
    	<tbody>	
    		<tr>
    			<th width="80">标题</th> 
    			<td colspan="3">
    				<input type="text" name="title" class="input-text" id="title" value="<?php echo $info['title']?>" size="41"/>
    			</td>
    		</tr>
    		<tr>
    			<th>略缩图</th> 
    			<td colspan="3">
    				<?php if(!empty($info["thumb"])){?><img src="<?php echo $info['thumb'];?>" width="60" height="60" border=0><?php }?>
    				<?php echo form::images("thumb", 'thumb', $info["thumb"], 'chat','',41)?>
    				尺寸建议：750px*420px
    			</td>
    		</tr>
    		<?php if(ROUTE_A == 'edit'){?>
    		<tr>
    			<th>创建人</th> 
    			<td colspan="3">
    				<?php echo $info['creator']?>
    			</td>
    		</tr>
    		<?php }?>
    		<tr>
    			<th>群聊日期</th>
    			<td colspan="3">
    				<?php echo form::date('date', $info['date'],0,0)?>
    			</td>
    		</tr>
    		<tr>
    			<th>视频</th> 
    			<td colspan="3">
    				<?php echo getchatlogvideolist('video',$info['video'])?>
    			</td>
    		</tr>
    		<tr>
    			<th>内容</th> 
    			<td colspan="3">
    				<textarea id="info" name="info"><?php echo $info['info'];?></textarea>
    				<?php echo form::editor('info','full','chat');?>
    			</td>
    		</tr>
    		<input type="hidden" name="id" id="id" value="<?php echo $info['id']?>"/>
    		<input type="hidden" name="tid" id="tid" value="<?php echo $tid?>"/>
        </tbody>
    </table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
<script>
$(function(){
    $('.dept_select').chosen({
        
    });
});
function refersh_window() {
	setcookie('refersh_time', 1);
}
</script>
</body>
</html>