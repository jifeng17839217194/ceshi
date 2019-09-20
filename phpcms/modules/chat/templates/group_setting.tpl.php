<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-header">
    <div class="pull-left">
        <h4>群设置</h4>      
    </div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <?php
    if(is_array($list)){
        foreach($list as $k=>$v){
?>
        <a href='index.php?m=chat&c=group_setting&a=init&catid=<?php echo $v['catid']?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' class="on"><em><?php echo $v['catname']?></em></a><span>|</span>
        <?php
    }
}
?>
    </div>
</div>
<div class="pad_10">
<form name="myform" action="?m=chat&c=group_setting&a=edit&catid=<?php echo $catid?>" method="post" enctype="multipart/form-data">
<div class="pad_10">
<div style='overflow-y:auto;overflow-x:hidden' class='scrolltable'>
<table width="100%" cellspacing="0" class="table_form contentWrap">
<tr>
     <th width="80"></th>
     <td> <?php echo $info['title']?></td>
<tr>
 <th width="80"> <?php echo L('content');?>   </th>
<td>
<?php if($catid == '120'){?>
<textarea name="info[content]" id="content" style='width:700px;height:200px;' placeholder="最多可输入600字"><?php echo $info['content']?></textarea>
<span class="wordwrap"><span class="word" max_number="600">0</span>/600</span>
<?php }else{?>
  <textarea name="info[content]" id="content" style='width:700px;height:200px;' ><?php echo $info['content']?></textarea>
<?php }?>

</td>
</tr>

</table>
</div>
<div class="bk10"></div>
<div class="btn">
<input type="hidden" name="info[catid]" value="<?php echo $catid;?>" /> 
<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit');?>" />
</div> 
  </div>

</form>
</div>
<script language="JavaScript">

  // textarea 字数调用函数
function statInputNum(textArea, numItem) {
  var max = numItem.attr('max_number'),
    curLength;
  var number_init = textArea.val().length;
  numItem.text(number_init);
  textArea[0].setAttribute("maxlength", max);
  curLength = textArea.val().length;
  textArea.on('input propertychange', function () {
    var _value = $(this).val().replace(/\n/gi, "");
    numItem.text(_value.length);
  });
}
statInputNum($("#content"), $(".word"));
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>
