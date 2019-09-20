<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>

<div class="pad-lr-10">
<div class="table-list">
<div class="common-form">
	<input type="hidden" name="info[userid]" value="<?php echo $memberinfo['userid']?>"></input>
	<input type="hidden" name="info[username]" value="<?php echo $memberinfo['username']?>"></input>
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('username')?></td> 
			<td><img src="<?php echo API_PATH.$memberinfo['avatar']?>" onerror="this.src='<?php echo IMG_PATH?>member/nophoto.gif'" height=20 width=20 align='absmiddle'> <?php echo $memberinfo['username']?><?php if($memberinfo['islock']) {?><img title="<?php echo L('lock')?>" src="<?php echo IMG_PATH?>icon/icon_padlock.gif"><?php }?><?php if($memberinfo['vip']) {?><img title="<?php echo L('vip')?>" src="<?php echo IMG_PATH?>icon/vip.gif"><?php }?></td>
		</tr>
		
		<?php if($memberinfo['nickname']){?>
		<tr>
			<td><?php echo L('nickname')?></td> 
			<td><?php echo $memberinfo['nickname']?></td>
		</tr>
		<?php }?>
		<?php if($memberinfo['email']){?>
		<tr>
			<td><?php echo L('email')?></td>
			<td>
			<?php echo $memberinfo['email']?>
			</td>
		</tr>
		<?php }?>
		<?php if($memberinfo['mobile']){?>
		<tr>
			<td><?php echo L('mp')?></td>
			<td>
			<?php echo $memberinfo['mobile'];?>
			</td>
		</tr>
		<?php }?>
		
		<tr>
			<td>性别</td>
			<td>
			<?php echo $usersex[$memberinfo['sex']];?>
			</td>
		</tr>
		<?php if($memberinfo['birthday']){?>
		<tr>
			<td>生日</td>
			<td>
			<?php echo date('Y-m-d',$memberinfo['birthday']);?>
			</td>
		</tr>
		<?php }?>
		<?php if($memberinfo['idcard']){?>
		<tr>
			<td>身份证</td>
			<td>
			<?php echo $memberinfo['idcard'];?>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>养蜂等级</td>
			<td>
			<?php echo $userdegee[$memberinfo['grade']];?>
			</td>
		</tr>
		<tr>
			<td><?php echo L('member_group')?></td>
			<td>
			<?php echo $grouplist[$memberinfo['usertype']];?>
			</td>
		</tr>
		<?php if($memberinfo['usertype']!=1) {?>
		<tr>
			<td>公司</td>
			<td>
			<?php echo $memberinfo['company'];?>
			</td>
		</tr>
		
		<tr>
			<td>职务</td>
			<td>
			<?php echo $memberinfo['duty'];?>
			</td>
		</tr>
		<tr>
			<td>擅长</td>
			<td>
			<?php echo $memberinfo['skill'];?>
			</td>
		</tr>
		<?php }?> 
		
		<tr>
			<td>地区</td>
			<td>
			<?php echo $memberinfo['province'].$memberinfo['city'].$memberinfo['county'];?>
			</td>
		</tr>
		<?php if($memberinfo['address']){?>
		<tr>
			<td>地址</td>
			<td>
			<?php echo $memberinfo['address'];?>
			</td>
		</tr>
		<?php }?>
		<?php if($memberinfo['introduction']){?>
		<tr>
			<td>简介</td>
			<td>
			<?php echo $memberinfo['introduction'];?>
			</td>
		</tr>
		<?php }?>
	</table>
</fieldset>
</div>
<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
</div>
</div>
</body>
</html>