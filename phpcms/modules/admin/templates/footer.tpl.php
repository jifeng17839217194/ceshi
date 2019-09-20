</div>
</div>
</div>
</div>
<!--<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.cookie.js"></script>-->
<script type="text/javascript">

$(function(){
/*换肤*/
/*
$(".dropdown .changecolor li").click(function(){
	var style = $(this).attr("id");
    $("link[title!='']").attr("disabled","disabled"); 
	$("link[title='"+style+"']").removeAttr("disabled"); 

	$.cookie('mystyle', style, { expires: 7 }); // 存储一个带7天期限的 cookie 
})
var cookie_style = $.cookie("mystyle"); 
if(cookie_style!=null){ 
    $("link[title!='']").attr("disabled","disabled"); 
	$("link[title='"+cookie_style+"']").removeAttr("disabled"); 
} 
*/
/*左侧导航栏显示隐藏功能*/
$(".subNav").click(function(){				
			/*显示*/
			if($(this).find("span:first-child").attr('class')=="title-icon glyphicon glyphicon-chevron-down")
			{
				$(this).find("span:first-child").removeClass("glyphicon-chevron-down");
			    $(this).find("span:first-child").addClass("glyphicon-chevron-up");
			    $(this).removeClass("sublist-down");
				$(this).addClass("sublist-up");
			}
			/*隐藏*/
			else
			{
				$(this).find("span:first-child").removeClass("glyphicon-chevron-up");
				$(this).find("span:first-child").addClass("glyphicon-chevron-down");
				$(this).removeClass("sublist-up");
				$(this).addClass("sublist-down");
			}	
		// 修改数字控制速度， slideUp(500)控制卷起速度
	    $(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(300);
	})
/*左侧导航栏缩进功能*/
$(".left-main .sidebar-fold").click(function(){

	if($(this).parent().attr('class')=="left-main left-full")
	{
		$(this).parent().removeClass("left-full");
		$(this).parent().addClass("left-off");
		
		$(this).parent().parent().find(".right-product").removeClass("right-full");
		$(this).parent().parent().find(".right-product").addClass("right-off");
		
		}
	else
	{
		$(this).parent().removeClass("left-off");
		$(this).parent().addClass("left-full");
		
		$(this).parent().parent().find(".right-product").removeClass("right-off");
		$(this).parent().parent().find(".right-product").addClass("right-full");
		
		}
	})	
 
  /*左侧鼠标移入提示功能*/
		$(".sBox ul li").mouseenter(function(){
			if($(this).find("span:last-child").css("display")=="none")
			{$(this).find("div").show();}
			}).mouseleave(function(){$(this).find("div").hide();})	
})
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>admin_end.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>require.js"></script>
<script type="text/javascript">
require.config({
	baseUrl: "statics/js",
	paths: {
        jquery: '<?php echo CSS_PATH?>aliyun/script/jquery-1.11.1.min',
		"layer": "layer/layer",
		"autocomplete":"autocompleter/jquery.autocomplete.min",
		"nestable":"nestable/jquery.nestable.min",
		"sortable":"sortable/html5sortable.min",
		"artDialog":"dialog",
		"ajaxForm":"ajaxForm"
	},
    shim:{
    　　  	"ajaxForm" : {
            deps: ['jquery'],
        },
        'nestable':{
            deps: ['css!nestable'],
        }
    },
	map: {
        '*': {
            css: 'css.min'
        }
    }
});
</script>