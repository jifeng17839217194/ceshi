<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('usermodule')?>",onfocus:"<?php echo L('usermodule').L('between_2_to_8')?>"}).inputValidator({min:2,max:15,onerror:"<?php echo L('usermodule').L('between_2_to_8')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('usermodule').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member_wenwenmodule&a=public_checkname_ajax",
		datatype : "html",
		async:'false',
		success : function(data){	
            if( data == "1" ) {
                return true;
			} else {
                return false;
			}
		},
		buttons: $("#dosubmit"),
		onerror : "<?php echo L('groupname_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	

});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member_wenwenmodule&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120">名称</td> 
			<td><input type="text" name="info[name]"  class="input-text" id="name"></td>
		</tr>
		
		<tr>
			<td>图片</td> 
			<td><input type="text" name="info[thumb]" class="input-text" id="thumb" value="images/wewen/vip.jpg" size="40"></td>
		</tr>
		<tr>
			<td>是否系统</td> 
			<td><span class="ik lf">
					<input type="checkbox" name="info[issystem]" id="issystem">
					是（为系统字段，该选项不可删除）
				</span></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_description')?></td> 
			<td><input type="text" name="info[description]" class="input-text" size="40"></td>
		</tr>
	</table>
</fieldset>
    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
</html>