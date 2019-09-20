<?php include $this->admin_tpl('admin_mainmenu','admin');?>
<div class="down-main">
	<div class="left-main left-full"
		style="background: rgba(30, 41, 51, 1);">
		<!-- <div class="sidebar-fold"><span class="glyphicon glyphicon-menu-hamburger"></span></div> -->
		<div class="subNavBox">
			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==100){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">问答</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==100){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if( ROUTE_C =='wenwen' && ROUTE_A =='init'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />问题管理
						</div> <a
						href="index.php?m=content&c=wenwen&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=100"><span
							class="sublist-icon glyphicon glyphicon-question-sign"></span><span
							class="sub-title">问题管理</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='wenwen' && ROUTE_A =='managepost'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />解答管理
						</div> <a
						href="index.php?m=content&c=wenwen&a=managepost&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=100"><span
							class="sublist-icon glyphicon glyphicon-volume-up"></span><span
							class="sub-title">解答管理</span></a>
					</li>

				</ul>
			</div>
			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==200){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">资讯</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==200){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if( ROUTE_C =='position' && ROUTE_A =='public_item' && $_GET['posid']==18){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />热点资讯
						</div> <a
						href="index.php?m=admin&c=position&a=public_item&posid=18&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">热点资讯</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==102){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />各地蜂情
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=102&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">各地蜂情</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==103){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />政策法规
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=103&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">政策法规</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==104){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />行业动态
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=104&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">行业动态</span></a>
					</li>

					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==105){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />国际蜂情
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=105&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">国际蜂情</span></a>
					</li>

					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==106){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />技术发展
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=106&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">技术发展</span></a>
					</li>

					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==107){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />协会服务
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=107&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">协会服务</span></a>
					</li>

					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==108){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />行业会议
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=108&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-menu-hamburger"></span><span
							class="sub-title">行业会议</span></a>
					</li>




					<li
						<?php if( ROUTE_C =='linkage' && ROUTE_A =='public_manage_submenu' && $_GET['keyid']==1){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />省份设置
						</div> <a
						href="index.php?m=admin&c=linkage&a=public_manage_submenu&keyid=1&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=200"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">省份设置</span></a>
					</li>
				</ul>
			</div>


			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==300){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">课程</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==300){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='init' && $_GET['catid']==109){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />课时管理
						</div> <a
						href="index.php?m=content&c=content&a=init&catid=109&from=train&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=300"><span
							class="sublist-icon glyphicon glyphicon-facetime-video"></span><span
							class="sub-title">课时管理</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='linkage' && ROUTE_A =='public_manage_submenu' && $_GET['keyid']==3364){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />目录管理
						</div> <a
						href="index.php?m=admin&c=linkage&a=public_manage_submenu&keyid=3364&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=300"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">目录管理</span></a>
					</li>
					<li <?php if( ROUTE_M =='comment'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />课时评论
						</div> <a
						href="index.php?m=comment&c=comment_admin&a=listinfo&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=300"><span
							class="sublist-icon glyphicon glyphicon-check"></span><span
							class="sub-title">课时评论</span></a>
					</li>
				</ul>
			</div>

			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==400){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">用户</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==400){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if((ROUTE_C =='member' && ROUTE_A =='manage') ||(ROUTE_C =='member' && ROUTE_A =='search')){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />用户管理
						</div> <a
						href="index.php?m=member&c=member&a=manage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=400"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">用户管理</span></a>
					</li>
					<li
						<?php if(( ROUTE_C =='member' && ROUTE_A =='expertmanage')||(ROUTE_C =='member' && ROUTE_A =='expsearch')){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />专家库
						</div> <a
						href="index.php?m=member&c=member&a=expertmanage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=400"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">专家库</span></a>
					</li>
					<li <?php if( ROUTE_C =='member_verify'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />审核专家申请
						</div> <a
						href="index.php?m=member&c=member_verify&a=manage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=400"><span
							class="sublist-icon glyphicon glyphicon-time"></span><span
							class="sub-title">审核专家申请</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='member_group' && ROUTE_A =='manage'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />管理用户组
						</div> <a
						href="index.php?m=member&c=member_group&a=manage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=400"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">管理用户组</span></a>
					</li>

					<li
						<?php if( ROUTE_C =='member_wenwenmodule' && ROUTE_A =='manage'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />用户擅长选项

						</div> <a
						href="index.php?m=member&c=member_wenwenmodule&a=manage&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=400"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">用户擅长选项 </span></a>
					</li>
				</ul>
			</div>

			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==600){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">消息</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==600){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if( (ROUTE_C =='group' && ROUTE_A =='init') || (ROUTE_C =='group_log' && ROUTE_A =='lists')){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />群管理
						</div> <a
						href="index.php?m=chat&c=group&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=600"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">群管理</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='group_log' && ROUTE_A =='init'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />群日志管理
						</div> <a
						href="index.php?m=chat&c=group_log&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=600"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">群日志管理</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='group_check' && ROUTE_A =='init'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />审核群
						</div> <a
						href="index.php?m=chat&c=group_check&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=600"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">审核群</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='group_setting' && ROUTE_A =='init'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />群设置
						</div> <a
						href="index.php?m=chat&c=group_setting&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=600"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">群设置</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='group_support' && ROUTE_A =='init'){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />蜂博士团队管理
						</div> <a
						href="index.php?m=chat&c=group_support&a=init&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=600"><span
							class="sublist-icon glyphicon glyphicon-user"></span><span
							class="sub-title">蜂博士团队管理</span></a>
					</li>
				</ul>
			</div>


			<div class="sBox">
				<div class="subNav sublist-up">
					<span
						class="title-icon glyphicon <?php if( $_GET['snav'] ==500){echo "glyphicon-chevron-down";}else{echo "glyphicon-chevron-up";}?>"></span><span
						class="sublist-title">APP设置</span>
				</div>
				<ul class="navContent"
					<?php if( $_GET['snav'] ==500){echo "display:block";}else{echo 'style="display:none"';}?>>
					<li
						<?php if( ROUTE_C =='position' && ROUTE_A =='public_item' && $_GET['posid']==19){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" /><?php echo L('menu_app');?></div>
						<a
						href="index.php?m=admin&c=position&a=public_item&posid=19&menuid=32&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=500"><span
							class="sublist-icon glyphicon glyphicon-globe"></span><span
							class="sub-title"><?php echo L('menu_app');?></span></a>
					</li>

					<li
						<?php if( ROUTE_C =='content' && $_GET['catid'] ==2){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />用户协议
						</div> <a
						href="index.php?m=content&c=content&a=add&catid=2&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=500"><span
							class="sublist-icon glyphicon glyphicon-pencil"></span><span
							class="sub-title">用户协议</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='content' && $_GET['catid'] ==3){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />关于蜂博士
						</div> <a
						href="index.php?m=content&c=content&a=add&catid=3&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=500"><span
							class="sublist-icon glyphicon glyphicon-cog"></span><span
							class="sub-title">关于蜂博士</span></a>
					</li>
					<li
						<?php if( ROUTE_C =='content' && ROUTE_A =='video' ){echo "class='active'";}?>>
						<div class="showtitle" style="width: 100px;">
							<img src="<?php echo CSS_PATH;?>aliyun/img/leftimg.png" />视频广告
						</div> <a
						href="index.php?m=admin&c=video&a=init&catid=124&pc_hash=<?php echo $_SESSION['pc_hash'];?>&snav=500"><span
							class="sublist-icon glyphicon glyphicon-globe"></span><span
							class="sub-title">视频广告</span></a>
					</li>

				</ul>
			</div>



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