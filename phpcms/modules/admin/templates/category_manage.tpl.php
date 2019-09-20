<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headersetting');?>

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href='javascript:;' class="on"><em>管理栏目</em></a><span>|</span><a href='?m=admin&c=category&a=add&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' ><em>添加栏目</em></a><span>|</span><a href='?m=admin&c=category&a=add&s=1&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' ><em>添加单网页</em></a><span>|</span><a href='?m=admin&c=category&a=public_cache&module=admin&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' ><em>更新栏目缓存</em></a><span>|</span><a href='?m=admin&c=category&a=count_items&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' ><em>重新统计栏目数据</em></a><span>|</span><a href='?m=admin&c=category&a=batch_edit&&pc_hash=<?php echo $_SESSION['pc_hash'];?>&menu_id=<?php echo $_GET['menu_id']?>' ><em>批量编辑</em></a>    </div>
</div>


<form name="myform" action="?m=admin&c=category&a=listorder" method="post">
<div class="pad_10">
<div class="explain-col">
<?php echo L('category_cache_tips');?>，<a href="?m=admin&c=category&a=public_cache&menuid=43&module=admin"><?php echo L('update_cache');?></a>
</div>
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="38"><?php echo L('listorder');?></th>
            <th width="60">栏目ID</th>
            <th ><?php echo L('catname');?></th>
            <th align='left' width='70'><?php echo L('category_type');?></th>
            <th align='left' width="70"><?php echo L('modelname');?></th>
            <th align='center' width="60"><?php echo L('items');?></th>
            <th align='center' width="50"><?php echo L('vistor');?></th>
            <th align='center' width="100"><?php echo L('domain_help');?></th>
			<th ><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $categorys;?>
    </tbody>
    </table>

    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
<?php
include $this->admin_tpl('footer','admin');?>
</body>
</html>
