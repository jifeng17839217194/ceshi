<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('groupname')?>",onfocus:"<?php echo L('groupname').L('between_2_to_8')?>"}).inputValidator({min:2,max:15,onerror:"<?php echo L('groupname').L('between_2_to_8')?>"}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"<?php echo L('groupname').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member_group&a=public_checkname_ajax",
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
<form name="myform" action="?m=member&c=member_group&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('member_group_name')?></td> 
			<td><input type="text" name="info[name]"  class="input-text" id="name"></td>
		</tr>
		
	</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
	<legend><?php echo L('more_configuration')?></legend>
	<table width="100%" class="table_form">
		
		<tr>
			<td width="80"><?php echo L('member_group_username_color')?></td> 
			<td><input type="text" name="info[usernamecolor]" class="input-text" id="usernamecolor" size="8" value="#000000"></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_icon')?></td> 
			<td><input type="text" name="info[icon]" class="input-text" id="icon" value="images/group/vip.jpg" size="40"></td>
		</tr>
		<tr>
			<td width="80"><?php echo L('member_group_description')?></td> 
			<td><input type="text" name="info[description]" class="input-text" size="60"></td>
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