<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="page-header">
	<div class="pull-left">
	<h4><?php echo L('comment_check')?> (<?php echo L('for_audit_several')?>：<span id="wait" style="color:red"><?php echo $total?></span>)</h4>      
	</div>
</div>

									 
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='?m=comment&c=comment_admin&a=listinfo&menu_id=<?php echo $_GET['menu_id']?>' class="on"><em>评论管理</em></a><span>|</span><a href='?m=comment&c=check&a=checks&menu_id=<?php echo $_GET['menu_id']?>' ><em>评论审核</em></a>    </div>
</div>									 
									 
<div class="table-margin">
<div class="comment">
<?php if(is_array($comment_check_data)) foreach($comment_check_data as $v) :
$this->comment_data_db->table_name($v['tableid']);
$data = $this->comment_data_db->get_one(array('id'=>$v['comment_data_id'], 'siteid'=>$this->get_siteid()));
?>
<div  id="tbody_<?php echo $data['id']?>">
<h5 class="title fn" ><span class="rt"><input type="button" value="<?php echo L('pass')?>" class="btn btn-mystyle btn-sm" onclick="check(<?php echo $data['id']?>, 1, '<?php echo $data['commentid']?>')" /> <input  class="btn btn-mystyle btn-sm"  type="button" value="<?php echo L('delete')?>" onclick="check(<?php echo $data['id']?>, -1, '<?php echo new_html_special_chars($data['commentid'])?>')" />
</span><?php echo $data['username']?> <?php echo L('chez')?> <?php echo format::date($data['creat_at'], 1)?> <?php echo L('release')?> </h5>
    <div class="content">
    	<?php echo $data['content']?>
    </div>
    <div class="bk20 hr mb8"></div>
</div>
<?php endforeach;?>
</div>
</div>
<script type="text/javascript">
window.top.$('#display_center_id').css('display','none');
function check(id, type, commentid) {
	if(type == -1 && !confirm('<?php echo L('are_you_sure_you_want_to_delete')?>')) {
		return false;
	}
	$.get('?m=comment&c=check&a=ajax_checks&id='+id+'&type='+type+'&commentid='+commentid+'&pc_hash='+pc_hash+'&'+Math.random(), function(data){if(data!=1){if(data==0){alert('<?php echo L('illegal_parameters')?>')}else{alert(data)}}else{$('#tbody_'+id).remove();

	$.getJSON('?m=comment&c=check&a=public_get_one'+'&pc_hash='+pc_hash+Math.random(), function(data){
		if (data) {
			$('#wait').html(data.total);
			val = data.data;
			if (val.content) {
			html = '<div id="tbody_'+val.id+'"><h5 class="title fn" ><span class="rt"><input type="button" value="<?php echo L('pass')?>" class="button" onclick="check('+val.id+', 1, \''+val.commentid+'\')" /> <input  class="button"  type="button" value="<?php echo L('delete')?>" onclick="check('+val.id+', -1, \''+val.commentid+'\')" /></span>'+val.username+' ('+val.ip+') <?php echo L('chez')?> '+val.creat_at+' <?php echo L('release')?> </h5><div class="content"><pre>'+val.content+'</pre></div><div class="bk20 hr mb8"></div></div>';
			$('.comment').append(html);
			}
		}
		});

	}});
	
}
</script>
<?php include $this->admin_tpl('footer','admin');?>
</body>
</html>