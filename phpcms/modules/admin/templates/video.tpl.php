<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
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
</style>
<link rel="stylesheet" href="<?php echo CSS_PATH?>chosen.css">
<script language="javascript" src="<?php echo JS_PATH?>chosen.jquery.js"></script>
<div class="page-header">
    <div class="pull-left">
        <h4>视频广告设置</h4>      
    </div>
</div>
<div class="common-form">
<form name="myform" action="?m=admin&c=video&a=init&catid=<?php echo $catid;?>" method="post" enctype="multipart/form-data">
<table width="100%" cellspacing="0" class="table_form contentWrap">
<tr>
     <th width="80">标题</th>
     <td><input type="text" name="title" class="input-text" id="title" value="<?php echo $info['title']?>" size="41"/></td>
<tr>
<tr>
    <th>略缩图</th> 
    <td colspan="3">
       
        <?php echo form::images("thumb", 'thumb', $info["self2"], 'admin','',41)?> 尺寸建议：750px*420px
         <?php if(!empty($info["self2"])){?><img src="<?php echo $info['self2'];?>" width="60" height="60" border=0><?php }?>
       
    </td>
    </tr>
 <th width="80"> 视频</th>
<td>
<?php echo getadvideolist('video',$info['self1'])?>

</td>
</tr>

</table>
<div class="bk10"></div>
<div class="btn">
<input type="hidden" name="info[catid]" value="124" /> 
<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit');?>" />
</div> 
</form>
</div>
<script>
$(function(){
    $('.dept_select').chosen({
        
    });
});
</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>

