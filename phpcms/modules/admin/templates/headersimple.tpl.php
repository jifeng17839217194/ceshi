<?php defined('IN_ADMIN') or exit('No permission resources.'); ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo L('website_manage');?></title>

<link href="<?php echo CSS_PATH?>aliyun/bootstrap-3.3.5-dist/css/bootstrap.min.css" title="" rel="stylesheet" />
<link href="<?php echo CSS_PATH?>muntime/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>muntime/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
<!--<link href="<?php echo CSS_PATH?>muntime/font-awesome/css/fontawesome-all.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH?>muntime/styles1.css" title="styles1" media="screen" />
<link rel="alternate stylesheet" type="text/css" href="<?php echo CSS_PATH?>muntime/styles2.css" title="styles2" media="screen" />
<link href="<?php echo CSS_PATH?>dialog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>table_form.css" rel="stylesheet" type="text/css" />
<?php
if(!$this->get_siteid()) showmessage(L('admin_login'),'?m=admin&c=index&a=nzmanage');
if(isset($show_dialog)) {
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>dialog.js"></script>
<?php } ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<?php if(isset($show_validator)) { ?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<?php } ?>
<script type="text/javascript">
	window.focus();
	var pc_hash = '<?php echo $_SESSION['pc_hash'];?>';
	<?php if(!isset($show_pc_hash)) { ?>
		window.onload = function(){
		var html_a = document.getElementsByTagName('a');
		var num = html_a.length;
		for(var i=0;i<num;i++) {
			var href = html_a[i].href;
			if(href && href.indexOf('javascript:') == -1) {
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
</head>
<body>
<style type="text/css">
	html{_overflow-y:scroll}
</style>