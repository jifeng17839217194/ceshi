<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="page-header">
	<div class="pull-left">
		<h4><?php if($_GET['catid']==109){echo '课时管理';}else{echo '资讯管理';}?></h4>      
	</div>
</div>

<div class="table-margin">
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="javascript:;" onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=&catid=<?php echo $catid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>','')><em>新增课时</em></a>　
</div>
<div id="searchid" class="table-margin">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menu_id']?>" name="menu_id">
<input type="hidden" value="<?php echo $catid;?>" name="catid">
<input type="hidden" value="train" name="from">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				
				<script type="text/javascript" src="<?php echo JS_PATH;?>linkage/js/jquery.ld.js"></script>
				级别：<input type="hidden" name="beetype"  id="beetype" value="">
				<select class="pc-select-beetype" name="beetype-1" id="beetype-1" width="100"><option value="">选择级别</option></select>
				课程：<select class="pc-select-beetype" name="beetype-2" id="beetype-2" width="100"><option value="">选择课程</option></select>
				目录：<select class="pc-select-beetype" name="beetype-3" id="beetype-3" width="100"><option value="">选择目录</option></select>
				<script type="text/javascript">
					jQuery.noConflict();
					(function($){
					var $ld4 = $(".pc-select-beetype");					  
					$ld4.ld({ajaxOptions : {"url" : "<?php echo APP_PATH;?>api.php?op=get_linkage&act=ajax_select&keyid=3364"},defaultParentId : 0,style : {"width" : 120}})	 
					var ld4_api = $ld4.ld("api");
					ld4_api.selected();
					$ld4.bind("change",onchange);
					function onchange(e){
							var $target = $(e.target);
							var index = $ld4.index($target);
							$("#beetype-4").remove();
							$("#beetype").val($ld4.eq(index).show().val());
							index ++;
							$ld4.eq(index).show();
						}
					})(jQuery);
				</script>
				 <?php echo L('addtime');?>：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<select name="searchtype">
					<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>>按<?php echo L('title');?></option>
				</select>
				
				
			
			
			
				<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" onsubmit="checktid();return false;">
<div class="table-margin">
    <table width="100%" class="table table-bordered table-header">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="50"><?php echo L('listorder');?></th>
            <th width="50">ID</th>
			<th><?php echo L('title');?></th>
			<th width="80" style="text-align:center"><?php echo L('zan');?></th>
			<th width="80" style="text-align:center"><?php echo '收藏';?></th>
			<th width="80" style="text-align:center"><?php echo '评论';?></th>
            <th width="80" style="text-align:center"><?php echo L('hits');?></th>
            <th width="100" style="text-align:center"><?php echo L('publish_user');?></th>
            <th width="150"style="text-align:center"><?php echo L('updatetime');?></th>
			<th width="90" style="text-align:center"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		$this->fav_db = pc_base::load_model('favorite_model');
		$this->cmtdb = pc_base::load_model('comment_data_model');
		$this->db = pc_base::load_model('content_model');
		$this->model = getcache('model', 'commons');
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
			
			$this->db->table_name = $this->db->db_tablepre.$this->model[$modelid]['tablename'];
			$this->db->table_name = $this->db->table_name.'_data';
			$r2 = $this->db->get_one(array('id'=>$r['id']));
			$infofavwhere=array('catid'=>$r['catid'],'infoid'=>$r['id'],'status'=>1,'module'=>'video');
			$fav=$this->fav_db->count($infofavwhere);//收藏
		//查询评论表
		$this->cmtdb->table_name('1');
		$infocmtwhere=array('commentid'=>'content_'.$r['catid'].'-'.$r['id'].'-1');
		$ping=$this->cmtdb->count($infocmtwhere);//课程评论
			
	?>
        <tr>
		<td align="center" height='35'><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
        <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td>
		<?php
		if($status==99) {
			if($r['islink']) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} elseif(strpos($r['url'],'http://')!==false) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} else {
				echo '<a href="'.$release_siteurl.$r['url'].'" target="_blank">';
			}
		} else {
			echo '<a href="javascript:;" onclick=\'window.open("?m=content&c=content&a=public_preview&steps='.$steps.'&catid='.$catid.'&id='.$r['id'].'","manage")\'>';
		}?><span<?php echo title_style($r['style'])?>><?php echo $r['title'];?></span></a> <?php if($r['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif" title="'.L('thumb').'">'; } if($r['posids']) {echo '<img src="'.IMG_PATH.'icon/small_elite.gif" title="'.L('elite').'">';} if($r['islink']) {echo ' <img src="'.IMG_PATH.'icon/link.png" title="'.L('islink_url').'">';}?></td>
		
		<td align='center' ><?php echo $r2['votenums'];?></td>
		<td align='center' ><?php echo $fav;?></td>
		
		<td align='center' ><?php echo $ping;?></td>
		
		<td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yesterdayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."&pc_hash=".$_SESSION['pc_hash']."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><?php echo format::date($r['updatetime'],0);?></td>
		<td align='center'><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a>
		<!--课程模型开启评论
		<?php if($modelid==16){?>
		 | <a href="javascript:view_comment('<?php echo id_encode('content_'.$catid,$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')"><?php echo L('comment');?></a>
		<?php }?>
		-->
		</td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
    	<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('listorder');?>" onclick="myform.action='?m=content&c=content&a=listorder&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php if($category['content_ishtml']) {?>
		<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('createhtml');?>" onclick="myform.action='?m=content&c=create_html&a=batch_show&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }
		if($status!=99) {?>
		<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('passed_checked');?>" onclick="myform.action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }?>
		<input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('delete');?>" onclick="myform.action='?m=content&c=content&a=delete&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
		
		<!-- <input type="button" class="btn btn-mystyle btn-sm" value="<?php echo L('remove');?>" onclick="myform.action='?m=content&c=content&a=remove&catid=<?php echo $catid;?>';myform.submit();"/> -->
		<?php echo runhook('admin_content_init')?>
	</div>
    <div class="pull-right">
		<nav>
			<ul class="pagination"><?php echo $pages?></ul>
	    </nav>
    </div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>

<script type="text/javascript"> 
<!--
function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
		return false;
	}
	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'<?php echo L('push');?>：',id:'push',iframe:'?m=content&c=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function checktid() {
	var ids='';
	$("input[name='ids[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
		return false;
	} else {
		myform.submit();
	}
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function reject_check(type) {
	if(type==1) {
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') {
				str = 1;
			}
		});
		if(str==0) {
			window.top.art.dialog({content:'　　<?php echo L('you_do_not_check');?>　　',lock:true,width:'300',height:'150'},function(){});
		return false;
		}
		document.getElementById('myform').action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1';
		document.getElementById('myform').submit();
	} else {
		$('#reject_content').css('display','');
		return false;
	}	
}
setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
//-->
</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>