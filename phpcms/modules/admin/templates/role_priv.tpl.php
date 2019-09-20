<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('headerpage');
?>
<script type="text/javascript">
  window.focus();
  var pc_hash = '<?php echo $_SESSION['pc_hash'];?>';
  <?php if(!isset($show_pc_hash)) {?>
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
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>styleswitch.js"></script>
<link href="<?php echo CSS_PATH?>jquery.treeTable.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.treetable.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#dnd-example").treeTable({
    	indent: 20,
    });
  });
  function checknode(obj)
  {
      var chk = $("input[type='checkbox']");
      var count = chk.length;
      var num = chk.index(obj);
      var level_top = level_bottom =  chk.eq(num).attr('level')
      for (var i=num; i>=0; i--)
      {
              var le = chk.eq(i).attr('level');
              if(eval(le) < eval(level_top)) 
              {
                  chk.eq(i).attr("checked",'checked');
                  var level_top = level_top-1;
              }
      }
      for (var j=num+1; j<count; j++)
      {
              var le = chk.eq(j).attr('level');
              if(chk.eq(num).attr("checked")=='checked') {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",'checked');
                  else if(eval(le) == eval(level_bottom)) break;
              }
              else {
                  if(eval(le) > eval(level_bottom)) chk.eq(j).attr("checked",false);
                  else if(eval(le) == eval(level_bottom)) break;
              }
      }
  }
</script>
<?php if($siteid) {?>
<div class="table-list" id="load_priv">
<form name="myform" action="?m=admin&c=role&a=role_priv" method="post">
<input type="hidden" name="roleid" value="<?php echo $roleid?>"></input>
<input type="hidden" name="siteid" value="<?php echo $siteid?>"></input>
<table width="100%" cellspacing="0" id="dnd-example">
<tbody>
<?php echo $categorys;?>
</tbody>
</table>
    <div class="btn"><input type="submit"   class="dialog" name="dosubmit" id="dosubmit" value="<?php echo L('submit');?>" /></div>
</form>
</div>
<?php } else {?>
<style type="text/css">
.guery{background: url(<?php echo IMG_PATH?>msg_img/msg_bg.png) no-repeat 0px -560px;padding:10px 12px 10px 45px; font-size:14px; height:100px; line-height:96px}
.guery{background-position: left -460px;}
</style>
<center>
	<div class="guery" style="display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline;">
	<?php echo L('select_site');?>
	</div>
</center>
<?php }?>

</body>
</html>
