<?php include $this->admin_tpl('admin_mainmenu','admin');?>
<div class="down-main">
	<div class="left-main left-full"
		style="background: rgba(30, 41, 51, 1);">
		<!-- <div class="sidebar-fold"><span class="glyphicon glyphicon-menu-hamburger"></span></div> -->
		<div class="subNavBox">
		
			<?php foreach ($this->menuList[$this->menuTopId]['children'] as $key=>$val){?>
			<div class="sBox">
				<div class="subNav sublist-up">
					<span class="title-icon glyphicon <?php if( $this->menuCurrent['parentid'] == $val['id']){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span>
					<span class="sublist-title"><?php echo $val['name']?></span>
				</div>
				<ul class="navContent" 
                    <?php if($this->menuCurrent['parentid'] == $val['id']){echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
					<?php foreach ($val['children'] as $k=>$v){?>
					<li <?php if($this->menuCurrent['id'] == $v['id']){echo 'class="active"';}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" /><?php echo $v['name']?>
						</div>
						<a href="<?php echo $v['path'];?>&pc_hash=<?php echo $_SESSION['pc_hash']?>">
    						<span class="sublist-icon glyphicon glyphicon-question-sign"></span>
    						<span class="sub-title"><?php echo $v['name']?></span></a>
					</li>
					<?php }?>
				</ul>
			</div>
			<?php }?>

		</div>
	</div>
	<div class="right-product view-product right-full">
		<div class="container-fluid">
			<div class="message-manage info-center">
<style type="text/css">
html {
	_overflow-y: scroll
}
</style>