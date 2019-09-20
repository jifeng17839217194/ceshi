<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
<title><?php echo L('webtitle');?></title>
<link href="<?php echo CSS_PATH?>aliyun/bootstrap-3.3.5-dist/css/bootstrap.min.css" title="" rel="stylesheet" />
<link title="" href="<?php echo CSS_PATH?>aliyun/css/style.css" rel="stylesheet" type="text/css"  />
<link href="<?php echo CSS_PATH?>muntime/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
<link title="blue" href="<?php echo CSS_PATH?>aliyun/css/dermadefault.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS_PATH?>aliyun/css/templatecss.css" rel="stylesheet" title="" type="text/css" />
<script src="<?php echo CSS_PATH?>aliyun/script/jquery-1.11.1.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<link rel="shortcut icon" href="<?php echo APP_PATH;?>favicon.ico"/>

<script src="<?php echo CSS_PATH?>aliyun/bootstrap-3.3.5-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>muntime/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo JS_PATH?>layer/theme/default/layer.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script type="text/javascript">
var pc_hash = '<?php echo $_SESSION['pc_hash']?>'
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<?php if(isset($show_validator)) { ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<?php } ?>

<script type="text/javascript">
	window.focus();
	var pc_hash = '<?php echo $_SESSION['pc_hash'];?>';
	<?php if(!isset($show_pc_hash)) {?>
		window.onload = function(){
		var html_a = document.getElementsByTagName('a');
		var num = html_a.length;
		for(var i=0;i<num;i++) {
			var href = html_a[i].href;
			if(href && href.indexOf('javascript:') == -1 && href.indexOf('#') == -1) {
				if(href.indexOf('?') != -1) {
					html_a[i].href = href+'&pc_hash='+pc_hash;
				} else {
					html_a[i].href = href+'?pc_hash='+pc_hash;
				}
			}
		}

		var html_form = document.forms;
		var num = html_form.length;
		for(var i=0;i<num;i++) {
			var newNode = document.createElement("input");
			newNode.name = 'pc_hash';
			newNode.type = 'hidden';
			newNode.value = pc_hash;
			html_form[i].appendChild(newNode);
		}
	}
<?php } ?>
</script>
<style>
  .user-nav{background:rgba(30,41,51,1);height: 25px;line-height: 25px;width: 100%;z-index: 9999999;padding-left: 15px;position:fixed;left: 0;top: 0}
  .user-nav>li>a{
        padding-top: 0;
        padding-bottom: 0;
        color: #fff;
        line-height: 25px;
  }
  .user-nav>li>a:hover,.nav .open>a, .nav .open>a:focus, .nav .open>a:hover,
  .user-nav .open>a:focus, .user-nav .open>a:hover
  {
    background-color: #19aa8d;
    color: #FFF;
  }
  @media (min-width: 768px){
    .navbar-nav>li>a {
      padding-top: 0;
      padding-bottom: 0;
    }
}
.dropdown-menu{
  z-index: 99999;
}

</style>
<ul class="nav navbar-nav user-nav">
       <!--
     <li class="dropdown li-border">
          <a href="#" class="dropdown-toggle mystyle-color" data-toggle="dropdown">
            <span class="glyphicon glyphicon-bell"></span>
            <span class="topbar-num">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="caret"></span>
           </a>
       <ul class="dropdown-menu">
      <li><a href="?m=member&c=member_verify&a=manage&s=0&pc_hash=<?php echo $_SESSION['pc_hash'];?>">专家申请</a></li>
      
        </ul>
      
     
      </li>
      <li class="li-border dropdown"><a href="#" class="mystyle-color" data-toggle="dropdown">
      <span class="glyphicon glyphicon-search"></span> 搜索</a>
         <div class="dropdown-menu search-dropdown">
            <div class="input-group">
                <input type="text" class="form-control">
                 <span class="input-group-btn">
                   <button type="button" class="btn btn-default">搜索</button>
                </span>
            </div>
         </div>
      </li>
    -->
      <li class="dropdown li-border"><a class="dropdown-toggle mystyle-color" data-toggle="dropdown">操作手册<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="http://www.hibeeok.com/uploadfile/public/bee_doctor_manage.pdf" target="_blank">操作文档</a></li>
          <li class="divider"></li>
      <li><a href="http://my.polyv.net/secure/uploadvideo_v2/" target="_blank">视频上传</a></li>
        
        </ul>
      </li>
      <li class="dropdown "><a class="dropdown-toggle mystyle-color" data-toggle="dropdown"><?php echo L('hello'),param::get_cookie('admin_username');?><span class="caret"></span></a>
        <ul class="dropdown-menu">
           <li><a href='?m=admin&c=admin_manage&a=public_edit_info&snav=1400'>修改个人信息</a></li>
        <li class="divider"></li>
       <li><a href='?m=admin&c=admin_manage&a=public_edit_pwd&snav=1400'>修改密码</a></li>
        <li class="divider"></li>
      <li><a href="?m=admin&c=index&a=public_logout">退出</a></li>
        </ul>
      </li>
    </ul>
<nav class="nav navbar-default navbar-mystyle navbar-fixed-top index-nav">
  <div class="navbar-header">
    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
     <span class="icon-bar"></span> 
     <span class="icon-bar"></span> 
     <span class="icon-bar"></span> 
    </button>
   <a class="navbar-brand mystyle-brand"  href="?m=admin&c=index&pc_hash=<?php echo $_SESSION['pc_hash'];?>"><span class="glyphicon "></span></a></div>
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav">
	  <li><img src="<?php echo IMG_PATH.'logo.png';?>" style="margin-top:15px;margin-right:10px;" width='45' height='45'></li>
      <li style='margin-right:50px;'> <a  href="?m=admin&c=index&pc_hash=<?php echo $_SESSION['pc_hash'];?>" style='color:white;font-size: 18px;font-weight: bold;'><?php echo L('webtitle')?></a> </li>
      <?php foreach ($this->menuList as $key=>$val){?>
	  	<li class="li-border" style="border:none;"><a class="mystyle-color" href="<?php echo $val['path'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>"><?php echo $val['name'];?></a></li>
      <?php }?>
    </ul>
  </div>
</nav>