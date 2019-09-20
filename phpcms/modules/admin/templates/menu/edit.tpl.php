<div class="container-fluid">
	<div class="page-header">
	   	<div class="pull-left">
			<h4 class="menu-title"><?php echo $data['name']?></h4>      
		</div>
	   	<div class="pull-right">
	   		<div class="btn-group">
			  <button type="button" class="button-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	添加菜单 <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu dropdown-menu-right">
			    <li><a href="javascript:;" data-href="?m=admin&c=menu_setting&a=add&parentid=<?php echo $data['parentid']?>&before_id=<?php echo $data['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" class="add-menu">在当前菜单之前</a></li>
			    <li><a href="javascript:;" data-href="?m=admin&c=menu_setting&a=add&parentid=<?php echo $data['parentid']?>&after_id=<?php echo $data['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" class="add-menu">在当前菜单之后</a></li>
			    <li><a href="javascript:;" data-href="?m=admin&c=menu_setting&a=add&parentid=<?php echo $data['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" class="add-menu">当前菜单的子菜单</a></li>
			  </ul>
			</div>
			<button class="button-success copy-menu" data-href="?m=admin&c=menu_setting&a=copy&cpid=<?php echo $data['id']?>&after_id=<?php echo $data['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>">复制</button>
			<button class="button-danger delete-menu">删除</button>
		</div>
	</div>
	<form method="post" class="menu-form" action="?m=admin&c=menu_setting&a=edit">
		<div class="form-group">
			<label class="control-label"><span class="form-required">*</span>菜单名称</label>
			<div class="">
				<input class="form-control" type="text" name="name" value="<?php echo $data['name']?>" required="true">
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
		<input type="hidden" name="id" value="<?php echo $data['id']?>" />
		<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash']?>" />
	</form>
</div>
<script>
$(".add-menu").click(function(){
	var url = $(this).data('href');
	$.get(url,{},function(data){
		$("#menu-edit-form").html(data);
	});
});
$(".copy-menu").click(function(){
	var url = $(this).data('href');
	$.get(url,{},function(data){
		$("#menu-edit-form").html(data);
	});
})
$(".menu-form").find("input").change(function(){
    require(['ajaxForm'],function(){
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
					$(".menu-title").html($("input[name='name']").val());
					$(".menu-title-"+data.id).html($("input[name='name']").val() + "&nbsp;" + data.path);
				} else {
					artdialogAlert(data.msg,'error');
				}
			}
		});
	});
});
$(".menu-form").find("select").change(function(){
	require(['ajaxForm'],function(){
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
					$(".menu-title").html($("input[name='name']").val());
					$(".menu-title-"+data.id).html($("input[name='name']").val() + "&nbsp;" + data.path);
				} else {
					artdialogAlert(data.msg,'error');
				}
			}
		});
	});
});
$(".delete-menu").click(function(){
    var that = this;
    require(['artDialog'],function(){
        art.dialog({
            title: false,
            content: "将删除所有下级子菜单，是否确认？",
            path:'/statics/js/artDialog',
            icon:"question",
            follow: that,
            close: function () {
            	that.focus(); //关闭时让触发弹窗的元素获取焦点
                return true;
            },
            okValue: "确定",
            ok: function () {
                $.getJSON("?m=admin&c=menu_setting&a=delete&id=<?php echo $data['id']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>").done(function (data) {
                    if (data.code == '200') {
                    	$(".menu-"+"<?php echo $data['id']?>").remove();
                    	$("#menu-edit-form").html("");
                    	
                    } else{
                    	artdialogAlert(data.msg,'warning');
                    }
                });
                return true;
            },
            cancelValue: '取消',
            cancel: true
        });
    });
})
</script>