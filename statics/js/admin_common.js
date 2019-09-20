function confirmurl(url, message) {
	url = url + '&pc_hash=' + pc_hash;
	if (confirm(message)) redirect(url);
}

function redirect(url) {
	location.href = url;
}
//滚动条
$(function () {
	$(":text").addClass('input-text');
})

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	// if ($("#check_box").attr("checked")=='checked') {
	// $("input[name='"+name+"']").each(function() {
	// $(this).attr("checked","checked");

	// });
	// } else {
	// $("input[name='"+name+"']").each(function() {
	// $(this).removeAttr("checked");
	// });
	// }


	if ($("#check_box").attr("checked") == false) {
		$("input[name='" + name + "']").each(function () {
			this.checked = false;
		});
	} else {
		$("input[name='" + name + "']").each(function () {
			this.checked = true;
		});
	}
}

function openwinx(url, name, w, h) {
	if (!w) w = screen.width - 4;
	if (!h) h = screen.height - 95;
	url = url + '&pc_hash=' + pc_hash;
	//获得窗口的垂直位置 
    var iTop = (window.screen.availHeight - 30 - h) / 2; 
    //获得窗口的水平位置 
    var iLeft = (window.screen.availWidth - 10 - w) / 2; 
	window.open(url, name, "width=" + w + ",height=" + h + ",left:"+iLeft+",top:"+iTop+",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}
//弹出对话框
function omnipotent(id, linkurl, title, close_type, w, h) {
	if (!w) w = 700;
	if (!h) h = 500;
	art.dialog({
			id: id,
			iframe: linkurl,
			title: title,
			width: w,
			height: h,
			lock: true
		},
		function () {
			if (close_type == 1) {
				art.dialog({
					id: id
				}).close()
			} else {
				var d = art.dialog({
					id: id
				}).data.iframe;
				var form = d.document.getElementById('dosubmit');
				form.click();
			}
			return false;
		},
		function () {
			art.dialog({
				id: id
			}).close()
		});
	void(0);
}

function imagePreviewDialog(img){
	require(['layer'], function (){
		layer.photos({
            photos: {
                "title": "", //相册标题
                "id": 'image_preview', //相册id
                "start": 0, //初始显示的图片序号，默认0
                "data": [   //相册包含的图片，数组格式
                    {
                        "alt": "",
                        "pid": 666, //图片id
                        "src": img, //原图地址
                        "thumb": img //缩略图地址
                    }
                ]
            } //格式见API文档手册页
            , anim: 5, //0-6的选择，指定弹出图片动画类型，默认随机
            shadeClose: true,
            // skin: 'layui-layer-nobg',
            shade: [0.5, '#000000'],
            shadeClose: true,
        });
	});
}


function artdialogAlert(msg,icon){
	art.dialog({
		title:'提示信息',
        content: msg,
        path:'/statics/js/artDialog',
        icon: icon,
        ok: function () {
            return true;
        },
        okValue: "确定"
    });
};
