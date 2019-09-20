<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>

<style>
.page-content{
	
}

.page-left{
	width: 220px;
	position:absolute;
	margin:0;
	padding-top: 15px;
	min-height: calc(100vh - 220px);
	border-right: 1px solid #e4eaec;
}

.page-right{
	margin-left: 220px;
}

.page-left .list-group .list-group-item {
    padding-top: 6px;
    padding-bottom: 6px;
    line-height: 32px;
    cursor: pointer;
}

.page-left .list-group-item {
    padding: 13px 20px;
    margin-bottom: 1px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    border: none;
    border-radius: 0;
}

.page-left .list-group-item.placeholder {
    border: 1px dashed #e4eaec;
}

.page-left .list-group.bottom-line:after {
	position: relative;
    display: block;
    margin: 15px;
    content: "";
    border-bottom: 1px solid #e4eaec;
}

.page-left .list-group-item>a {
	display:block;
	height: 32px;
	color: #76838f;
}

.page-left .list-group-item i {
    width: 20px;
	margin-right:5px;
	text-align: center;
}

.page-left .list-group-item:focus, .page-left .list-group-item:hover {
    color: #62a8ea;
    background-color: #f3f7f9;
    border: none;
}

.page-left .list-group .list-group-item .item-actions {
    position: absolute;
    top: 6px;
    right: 20px;
	display: none;
}

.page-left .list-group-item:focus .item-actions, .page-left .list-group-item:hover .item-actions{
    display: block;
}

.page-left .list-group .list-group-item .item-actions>a {
    color: #76838f;
}

.page-left .list-group .list-group-item .item-actions>a:hover {
    color: #62a8ea;
}
</style>


<div class="page-header">
   	<div class="pull-left">
		<h4>菜单设置</h4>      
	</div>
</div>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='javascript:;' class="on"><em>菜单设置</em></a>&nbsp;&nbsp;&nbsp;
        <a class="add fb ajax-get" href="?m=admin&c=menu_setting&a=update_cache"><em>更新菜单缓存</em></a>
    </div>
</div>
<div class="page-content">
	<div class="page-left">
		<div class="list-group bottom-line top-menu-list">
			<?php foreach ($category as $key=>$val){?>
				<div class="list-group-item" data-id="<?php echo $val['id']?>">
					<a href="#category-id-<?php echo $val['id']?>" data-toggle="tab" onmouseover="this.click()" id="top-menu-<?php echo $val['id']?>">
					    <i class="fa fa-<?php echo empty($val['icon'])?"list":$val['icon'];?>"></i>
					    <?php echo $val['name']?>
					</a>
					<?php if($val['id']!=1){?>
					<!-- <div class="item-actions">
                         <a href="javascript:openIframeLayer('{:url('edit',['display'=>'simple','id'=>$val['id']])}','编辑顶级菜单',{'height':''});"><i class="fa fa-edit"></i></a>
                         <a class="js-ajax-delete" data-callback="removeItem" href="javascript:;" data-href="{:url('delete',['id'=>$val['id']])}"><i class="fa fa-close"></i></a>
                    </div> -->
                    <?php }?>
				</div>
			<?php }?>
		</div>
		<!-- <div class="list-group">
			<div class="list-group-item">
				<a href="javascript:openIframeLayer('{:url('add',['display'=>'simple'])}','添加顶级菜单',{'height':''});">
				    <i class="fa fa-plus"></i>
				    	添加新菜单
				</a>
			</div>
		</div> -->
	</div>
	<div class="page-right">
		<div class="row">
			<div class="col-sm-6">
				<div class="tabbable">
					<div class="tab-content data-content">
						<?php 
						    $i = 1;
						    foreach ($category as $key=>$val){?>
							<div class="tab-pane <?php echo $i==1?"active":""; ?>" id="category-id-<?php echo $val['id'];?>" style="overflow-x:visible;overflow-y:auto;height:  calc(100vh - 250px);">
								<div class="dd" data-id="<?php echo $val['id'];?>">
									<?php echo $val['category'];?>
								</div>
							</div>
						<?php $i++;}?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div id="menu-edit-form"></div>
			</div>
		</div>
	</div>
</div>
<script>
	(function( $ ){
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
	})( jQuery );
	
	$(".data-content").on("click",".dd-content",function(){
		var url = $(this).data('href');
		$.get(url,{},function(data){
			$("#menu-edit-form").html(data);
		});
		$(".dd-content").removeClass('active');
		$(this).addClass('active');
	});
	$(document).ready(function() {
		require(['nestable'],function(){
			$(".data-content").find('.dd').nestable({
				callback : function(l, e, p) {
					// l is the main container
					// e is the element that was moved
					e.sortMenu();
				}
			});
		});
		require(['sortable'],function(){
			sortable('.top-menu-list', {
				placeholder: '<div class="list-group-item placeholder"><a href="javascript:;"></a></div>'
			});
			sortable('.top-menu-list')[0].addEventListener('sortupdate', function(e) {
				var that = e.detail.item;
			    var id = $(that).data('id');
				var sort_arr = new Array();
				$(e.detail.origin.items).each(function(){
					sort_arr.push($(this).data('id'));
				})
				$.post("?m=admin&c=menu_setting&a=sort&pc_hash="+pc_hash,{id:id,pid:0,sort_arr:sort_arr},function(data){
					
				});
			});
		});
		$(".dd-content:first").click();
	});
	function removeItem(obj){
		obj.parents(".list-group-item")[0].remove();
	}
</script>

<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>