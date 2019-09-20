<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#password").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('password').L('between_6_to_20')?>"}).inputValidator({min:6,max:20,onerror:"<?php echo L('password').L('between_6_to_20')?>"});
	$("#pwdconfirm").formValidator({empty:true,onshow:"<?php echo L('not_change_the_password_please_leave_a_blank')?>",onfocus:"<?php echo L('passwords_not_match')?>",oncorrect:"<?php echo L('passwords_match')?>"}).compareValidator({desid:"password",operateor:"=",onerror:"<?php echo L('passwords_not_match')?>"});
	

	
  });
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=member&c=member&a=edit" method="post" id="myform">
	<input type="hidden" name="info[userid]" id="userid" value="<?php echo $memberinfo['userid']?>"></input>
	<input type="hidden" name="info[username]" value="<?php echo $memberinfo['username']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="80"><?php echo L('username')?></td> 
			<td  colspan="3"><?php echo $memberinfo['username']?><?php if($memberinfo['islock']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?><?php if($memberinfo['vip']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/vip.gif"><?php }?></td>
		</tr>
		<tr>
			<td><?php echo L('avatar')?></td> 
			<td  colspan="3"><img src="<?php echo API_PATH.$memberinfo['avatar']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=38 width=38><input type="checkbox" name="delavatar" id="delavatar" class="input-text" value="1" ><label for="delavatar"><?php echo L('delete').L('avatar')?></label></td>
		</tr>
		<tr>
			<td><?php echo L('password')?></td> 
			<td colspan="3"><input type="password" name="info[password]" id="password" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('cofirmpwd')?></td> 
			<td colspan="3"><input type="password" name="info[pwdconfirm]" id="pwdconfirm" class="input-text"></input></td>
		</tr>
		<tr>
			<td><?php echo L('nickname')?></td> 
			<td colspan="3"><input type="text" name="info[nickname]" id="nickname" value="<?php echo $memberinfo['nickname']?>" class="input-text"></input></td>
		</tr>
		<!--
		<tr>
			<td><?php echo L('email')?></td>
			<td colspan="3">
			<input type="text" name="info[email]" value="<?php echo $memberinfo['email']?>" class="input-text" id="email" size="30"></input>
			</td>
		</tr>
		-->
		<tr>
			<td><?php echo L('mp')?></td>
			<td colspan="3">
			<input type="text" name="info[mobile]" value="<?php echo $memberinfo['mobile']?>" class="input-text" id="mobile" size="15"></input>
			</td>
		</tr>
		
		
		
		<tr>
			<td>性别</td> 
			<td><?php echo form::select($usersex, $memberinfo['sex'], 'name="info[sex]"', '');?></td>
		
			<td>生日</td> 
			<td><?php echo form::date('info[birthday]',date('Y-m-d',$memberinfo['birthday']),'')?></td>
		</tr>
		
		<tr>
			<td>身份证</td> 
			<td><input type="text" name="info[idcard]" id="idcard" value="<?php echo $memberinfo['idcard']?>" class="input-text" size="30"></input></td>
			<td>养蜂等级</td> 
			<td><?php echo form::select($userdegee, $memberinfo['grade'], 'name="info[grade]"', '');?></td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td>
			<td colspan="3">
			<?php 
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
				// echo $_key;
				if($_key == $memberinfo['usertype']){$checked="checked";}else{$checked='';};
				$str= "<input type='radio' name='info[usertype]' id='usertype' value='".$_key."'";
				if($_key==1){
					$str.='onclick="$(\'#istopsetting\').hide()"';
				}else{
					$str.='onclick="$(\'#istopsetting\').show()"';
				}
				$str.=$checked;
				$str.= '> '.$_value[name].'&nbsp;';
				echo $str;
			}
			?>
			</td>
		</tr>
		<tr >
			<td colspan="4">
				<table id="istopsetting" <?php if($memberinfo['usertype']==1) {?>style="display:none;"<?php }?> style="border:0px;padding-left:-30px;">
					<tr >
						<td width="80">公司</td> 
						<td colspan="3"><input type="text" name="info[company]" id="company" value="<?php echo $memberinfo['company']?>" class="input-text" size="40"></input></td>
					</tr>

					<tr>
						<td>职务</td> 
						<td><input type="text" name="info[duty]" id="duty" value="<?php echo $memberinfo['duty']?>" class="input-text"></input></td>
					</tr>
					
					<tr>
						<td>擅长</td> 
						<td><?php echo form::checkbox($wenmodulelist,$memberinfo['skill'], 'name="info[skill][]"', '');?></td>
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
			<td></td>
			<td colspan="3"><font color='orange'>默认不更改地区，如需更改，请重新选择地区</font></td>
		</tr>
		<tr>
			<td>地址</td>
			<td colspan="3"><input type="text" name="info[address]" id="address" value="<?php echo $memberinfo['address']?>" class="input-text" size="40"></input></td>
		</tr>
		
		<tr>
			<td>简介</td> 
			<td colspan="3"><textarea  name="info[introduction]" id="introduction"  class="input-text" style="width:300px;height:60px"><?php echo $memberinfo['introduction']?></textarea></td>
		</tr>
	</table>
</fieldset>


    <div class="bk15"></div>
    <input name="dosubmit" id="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
</body>
<script language="JavaScript">
<!--
	function changemodel(modelid) {
		redirect('?m=member&c=member&a=edit&userid=<?php echo $memberinfo[userid]?>&modelid='+modelid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>');
	}
//-->
</script>
</html>