<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});

	$("#username").formValidator({onshow:"<?php echo L('input').L('username')?>",onfocus:"<?php echo L('username').L('between_2_to_20')?>"}).inputValidator({min:2,max:20,onerror:"<?php echo L('username').L('between_2_to_20')?>"}).regexValidator({regexp:"mobile",datatype:"enum",onerror:"<?php echo L('username').L('format_incorrect')?>"}).ajaxValidator({
	    type : "get",
		url : "",
		data :"m=member&c=member&a=public_checkname_ajax",
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
		onerror : "<?php echo L('deny_register').L('or').L('user_already_exist')?>",
		onwait : "<?php echo L('connecting_please_wait')?>"
	});
	$("#password").formValidator({onshow:"<?php echo L('input').L('password')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({onshow:"<?php echo L('input').L('cofirmpwd')?>",onfocus:"<?php echo L('input').L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('input').L('passwords_not_match')?>"});
});
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=add" method="post" id="myform">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('username')?></td> 
			<td colspan="3"><input type="text" name="info[username]"  class="input-text" id="username"></input></td>
		</tr>
		<tr>
			<td><?php echo L('password')?></td> 
			<td colspan="3"><input type="password" name="info[password]" class="input-text" id="password" value=""></input></td>
		</tr>
		<tr>
			<td><?php echo L('cofirmpwd')?></td> 
			<td colspan="3"><input type="password" name="info[pwdconfirm]" class="input-text" id="pwdconfirm" value=""></input></td>
		</tr>
		<tr>
			<td><?php echo L('nickname')?></td> 
			<td><input type="text" name="info[nickname]" id="nickname" value="" class="input-text"></input></td>
		
			<!--<td><?php echo L('email')?></td>
			<td>
			<input type="text" name="info[email]" value="" class="input-text" id="email" size="30"></input>
			</td>-->
		</tr>
		<tr>
			<td><?php echo L('mp')?></td>
			<td  colspan="3">
			<input type="text" name="info[mobile]" value="<?php echo $memberinfo['mobile']?>" class="input-text" id="mobile" size="15"></input>
			</td>
		</tr>
		
		<tr>
			<td>性别</td> 
			<td><?php echo form::select($usersex, '1', 'name="info[sex]"', '');?></td>
		
			<td>生日</td> 
			<td><?php echo form::date('info[birthday]', '', '')?></td>
		</tr>
		
		<tr>
			<td>身份证</td> 
			<td><input type="text" name="info[idcard]" id="idcard" value="" class="input-text" size="30"></input></td>
			<td>养蜂等级</td> 
			<td><?php echo form::select($userdegee, '1', 'name="info[grade]"', '');?></td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td>
			<td colspan="3">
			<?php 
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
				$str= "<input type='radio' name='info[usertype]' id='_".$_key."' value='".$_key."'";
				if($_key==1){
					$str.='onclick="$(\'#istopsetting\').hide()" checked';
				}else{
					$str.='onclick="$(\'#istopsetting\').show()"';
				}
				$str.= '> '.$_value[name].'&nbsp;';
				echo $str;
			}
			?>
			</td>
		</tr>
		<tr >
			<td colspan="4">
				<table id="istopsetting" style="display:none;" style="border:0px;padding-left:-30px;">
					<tr >
						<td width="80">公司</td> 
						<td colspan="3"><input type="text" name="info[company]" id="company" value="" class="input-text" size="40"></input></td>
					</tr>

					<tr>
						<td>职务</td> 
						<td><input type="text" name="info[duty]" id="duty" value="" class="input-text"></input></td>
					</tr>
					
					<tr>
						<td>擅长</td> 
						<td><?php echo form::checkbox($wenmodulelist, '', 'name="info[skill][]"', '');?></td>
					</tr>
				</table>
			</td>
		</tr>	
		<tr>
			<td>地区</td> 
			<td colspan="3">
			 <script type="text/javascript" src="<?php echo JS_PATH;?>linkage/js/jquery.ld.js"></script>
			<input type="hidden" name="areaid"  id="areaid" value="">
			<select class="pc-select-areaid form-control" name="areaid-1" id="areaid-1" width="100"><option value="">请选择地区</option></select>
			<select class="pc-select-areaid form-control" name="areaid-2" id="areaid-2" width="100"><option value="">请选择地区</option></select>
			<select class="pc-select-areaid form-control" name="areaid-3" id="areaid-3" width="100"><option value="">请选择地区</option></select>
			<select class="pc-select-areaid form-control" name="areaid-4" id="areaid-4" width="100"><option value="">请选择地区</option></select>
			<script type="text/javascript">
				$(function(){
				var $ld5 = $(".pc-select-areaid");					  
				$ld5.ld({ajaxOptions : {"url" : "<?php echo APP_PATH;?>api.php?op=get_linkage&act=ajax_select&keyid=1"},defaultParentId : 0,style : {"width" : 120}})	 
				var ld5_api = $ld5.ld("api");
				ld5_api.selected();
				$ld5.bind("change",onchange);
				function onchange(e){
						var $target = $(e.target);
						var index = $ld5.index($target);
						$("#areaid-5").remove();
						$("#areaid").val($ld5.eq(index).show().val());
						index ++;
						$ld5.eq(index).show();
					}
				})
			</script>
			

			
			
			
			</td>
		</tr>
		<tr>
			<td>地址</td>
			<td colspan="3"><input type="text" name="info[address]" id="address" value="" class="input-text" size="40"></input></td>
		</tr>
		
		<tr>
			<td>简介</td> 
			<td colspan="3"><textarea  name="info[introduction]" id="introduction" value="" class="input-text" style="width:300px;height:60px"></textarea></td>
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