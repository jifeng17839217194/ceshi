<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=chat&c=group&a=add" method="post" id="myform">
<fieldset>
	<legend>新建群</legend>
	<table width="100%" class="table_form">
		<tr>
			<td><font color="red">*</font>群名称</td> 
			<td colspan="3">
				<input type="text" name="tname" class="input-text" id="tname" value="" size="41"/>
				<span class="wordwrap"><span class="word" max_number="15">0</span>/15</span>
			</td>
		</tr>
		<tr>
			<td width="120"><font color="red">*</font>群头像</td> 
			<td colspan="3">
				<?php echo form::images("icon", 'icon', '', 'chat','',41)?>建议图片宽高比1:1
			</td>
		</tr>
		<tr>
			<td><font color="red">*</font>群介绍</td> 
			<td colspan="3">
				<textarea  name="intro" id="intro" value="" class="input-text" style="width:300px;height:60px"></textarea>
				<span class="wordwrap"><span class="word" max_number="200">0</span>/200</span>
			</td>
		</tr>
		<tr>
			<td>群规则</td> 
			<td colspan="3">
				<textarea  name="rule" id="rule" value="" class="input-text" style="width:300px;height:60px"></textarea>
				<span class="wordwrap"><span class="word" max_number="600">0</span>/600</span>
				<br>*注：不填写默认使用基础群规
			</td>
		</tr>
		<tr>
			<td>输入群主<br>(群主用户名)</td> 
			<td colspan="3">
				<input type="text" name="username" class="input-text" id="username" value="" size="41"/>
			</td>
		</tr>
		<tr>
			<td>选择蜂博士管理团队</td> 
			<td colspan="3">
				<?php foreach ($masterList as $master){?>
    				<input type="checkbox" name="members[]" value="<?php echo $master['accid']?>"/><?php echo $master['nickname']?>(<?php echo $master['group_count']?>)&nbsp;
				<?php }?>
			</td>
		</tr>
	</table>
</fieldset>

    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="dialog">
</form>
</div>
</div>
<script>
function statInputNum(textArea, numItem) {
    var max = numItem.attr('max_number'),curLength;
    var number_init = textArea.val().length;
    numItem.text(number_init);
    textArea[0].setAttribute("maxlength", max);
    curLength = textArea.val().length;
    textArea.on('input propertychange', function () {
        var _value = $(this).val();
        numItem.text(_value.length);
    });
}
statInputNum($("#intro"), $("#intro").next().find(".word"));
statInputNum($("#rule"), $("#rule").next().find(".word"));
statInputNum($("#tname"), $("#tname").next().find(".word"));
</script>
</body>
</html>