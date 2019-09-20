<div class="container-fluid">
	<div class="page-header">
	   	<div class="pull-right">
	   		<div class="btn-group">
    			<button class="button-success save-menu" style="margin-top: 13px;">保存</button>
			</div>
		</div>
	</div>
	<form method="post" class="js-ajax-forms menu-form" data-success="success_callback" action="?m=admin&c=menu_setting&a=add">
		<div class="form-group">
			<label class="control-label"><span class="form-required">*</span>菜单名称</label>
			<div class="">
				<input class="form-control" type="text" name="name" value="<?php echo $data['name']?>-copy" required="true">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">模块</label>
			<div class="">
				<input class="form-control" type="text" name="module" value="<?php echo $data['m']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">控制器</label>
			<div class="">
				<input class="form-control" type="text" name="controller" value="<?php echo $data['c']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">方法</label>
			<div class="">
				<input class="form-control" type="text" name="action" value="<?php echo $data['a']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">参数</label>
			<div class="">
				<input class="form-control" type="text" name="data" value="<?php echo $data['data']?>">
			</div>
		</div>
		<!-- 
		<div class="form-group">
			<label class="control-label">图标</label>
			<div class="">
				<input class="form-control" type="text" name="icon" value="<?php echo $data['icon']?>">
				<p class="help-block">
					<a href="http://www.thinkcmf.com/font/icons" target="_blank">选择图标</a> 不带前缀fa-，如fa-user => user
				</p>
			</div>
		</div>
		 -->
		<div class="form-group">
			<label class="control-label">左侧菜单显示</label>
			<div class="">
				<select name="type" id="type" class="form-control">
					<option value="1">显示</option>
					<option value="2" <?php echo $data['type']==2?'selected':'';?>>仅超级管理员显示</option>
					<option value="0" <?php echo $data['type']==0?'selected':'';?>>不显示</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label">状态</label>
			<div class="">
				<select name="status" id="status" class="form-control">
					<option value="1">启用</option>
					<option value="0" <?php echo $data['status']==0?'selected':'';?>>禁用</option>
				</select>
			</div>
		</div>
		<input type="hidden" name="before_id" value="<?php echo $_GET['before_id']?>" />
		<input type="hidden" name="after_id" value="<?php echo $_GET['after_id']?>" />
		<input type="hidden" name="parentid" value="<?php echo $parentid?>" />
		<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash']?>" />
	</form>
</div>
<script>
$(".save-menu").click(function(){
	require(['ajaxForm'],function(){
		$.fn.sortMenu = function() {
			var that = $(this);
			var id = that.data('id');
			var pid = that.parents("li.dd-item:first").data('id');
			var sort_arr = new Array();
			if(typeof(pid)=='undefined'){
				pid = that.parents("div.dd:first").data('id');
				that.parents("div.dd:first").children(".dd-list").children(".dd-item").each(function(){
					sort_arr.push($(this).data('id'));
				})
			}
			else{
				that.parents("li.dd-item:first").children(".dd-list").children(".dd-item").each(function(){
					sort_arr.push($(this).data('id'));
				})
			}
			$.post("?m=admin&c=menu_setting&a=sort&pc_hash="+pc_hash,{id:id,pid:pid,sort_arr:sort_arr},function(data){
				
			});
		};
    	var $form  = $(".menu-form");
    	$form.ajaxSubmit({
			url : $form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
			dataType : 'json',
			beforeSubmit : function(arr, $form, options) {
				formloading = true;
			},
			success : function(data, statusText, xhr, $form) {
				formloading = false;
				if (data.code==200) {
					var item = data.data;
					if(typeof(item.after_id)!='undefind' && item.after_id!=0){
						$(".menu-"+item.after_id).after(item.html);
					}
					else if(typeof(item.before_id)!='undefind' && item.before_id!=0){
						$(".menu-"+item.before_id).before(item.html);
					}
					else{
						if($(".menu-"+item.pid).children(".dd-list").length>0){
							$(".menu-"+item.pid).children(".dd-list").append(item.html);
						}
						else{
							$(".menu-"+item.pid).append('<ol class="dd-list">' + item.html + "</ol>");
						}
					}
					$(".dd-content").removeClass('active');
					$(".menu-"+item.id).children(".dd-content").addClass('active');
					$(".menu-"+item.id).sortMenu();
					$.get(item.url,{},function(data2){
						$("#menu-edit-form").html(data2);
					});
				} else {
					artdialogAlert(data.msg,'error');
				}
			}
		});
	});
});
</script>