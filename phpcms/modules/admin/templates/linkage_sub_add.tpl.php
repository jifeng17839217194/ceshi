<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headerpage');?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('linkage_name').L('linkage_name_desc')?>",onfocus:"<?php echo L('linkage_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('linkage_name').L('not_empty')?>"});
  })
</script>
<script language="JavaScript">
		function DispayPrice() {
			//location.href='index.php?m=admin&c=linkage&a=publish&catid='+catid;
			 var nSel = document.getElementById("parentid");  
			var index = nSel.selectedIndex; // 选中索引  
			var text = nSel.options[index].text; // 选中文本  
			var value= nSel.options[index].value;  
			// document.getElementById("cityse").innerHTML=text+"----"+value;
			//alert(value);
			$.ajax({
				url:"?m=admin&c=linkage&a=getReturnDegree",
				type:"post",
				dataType:"json",
				data:"linkageid="+value,
				timeout:5000,
				/*function(XMLHttpRequest, textStatus, errorThrown,msg) {
					alert(XMLHttpRequest.status);
					alert(XMLHttpRequest.readyState);
					alert(textStatus);
					alert(errorThrown);
					alert(msg);
				}
				success: function() {
					alert(1);
				},
				
				error: 
				
				error:function(){
					alert(1);
				},
				success:function(){
					alert('suc');
				}
				*/
			})
		}

</script>
<div class="pad_10">
<div class="common-form">
<form name="myform" action="?m=admin&c=linkage&a=public_sub_add" method="post" id="myform">
<table width="100%" class="table_form contentWrap">
<tr>
<td><?php echo L('level_menu')?></td>
<td>
<?php echo $list?>
</td>
</tr>

<tr>
<td><?php echo L('linkage_name')?></td>
<td>
<textarea name="info[name]" rows="2" cols="20" id="name" class="inputtext" style="height:90px;width:150px;"><?php echo $name?></textarea>
</td>
</tr>

<tr>
<td><?php echo L('menu_description')?></td>
<td>
<textarea name="info[description]" rows="2" cols="20" id="description" class="inputtext" style="height:45px;width:300px;"><?php echo $description?></textarea>
</td>
</tr>

<tr>
       <td>图片：</td>
        <td><?php echo form::images('info[image]', 'image', $image, 'content');?></td>
      </tr>
	  <tr>
		<td></td>
		<td>图片尺寸建议：750*420px</td>
	</tr>
</table>

    <div class="bk15"></div>
    <input type="hidden" name="keyid" value="<?php echo $keyid?>">
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
</form>
</div>
</div>
</body>
</html>
