<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('headerpage', 'admin');?>
<link href="http://nos.netease.com/vod163/nep.min.css" rel="stylesheet">
<script src="http://nos.netease.com/vod163/nep.min.js"></script>
<style>
.my-video-dimensions {
    width: 100%;
}
.line-x {
    border-bottom: 0;
}
.content-menu {
    padding: 0;
}
</style>
</head>
<body width="100%" height="100%">
	
	<video id="my-video" class="video-js" x-webkit-airplay="allow" webkit-playsinline controls poster="poster.png" preload="auto" width="100%" height="90%" data-setup="{}">
	    <source src="<?php echo $video_url?>" type="video/mp4">
	</video>
	
	<script>
	/*注意： 使用data-setup时，initOptions将无效，因为播放器已经自动加载过了*/
	var myPlayer = neplayer("my-video",{"autoplay": true});
	</script>
	<script>
		$content = $(".my-video-dimensions");
	    $content.height($(window).height());
	    
	    $(window).resize(function () {
	        $content.height($(window).height());
	    });
	</script>
</body>
</html>