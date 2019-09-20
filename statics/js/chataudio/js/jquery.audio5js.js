/*!
 * Jquery Audio5js: 基于Audio5js的Jquery简单封装
 * wangguanqun
 * 2016-08-26
 */
/**
	使用方式：
	$("#chatAudioPlayer").audio5js({
		url : "voice/demo.mp3",
		type:"chat"
	});
	$("#miniAudioPlayer").audio5js({
		url : "voice/demo.mp3",
		type:"mini"
	});

 	销毁播放器：
 	$(".miniAudioPlayer").audio5js('destroyAudio');
 */
!function ($) {
	var Audio = function (element, options) {
		this.$element = $(element);
		this.options = $.extend({}, $.fn.audio5js.defaults, options);
		this.canPlay = false;
		this.volume = 1;
		this.init();
	};
	Audio.prototype = {
		constructor : Audio,

		// 初始化播放器
		init : function(){
			var setting = this.options;
			var ele = this.$element;
			var audio = this;

			// 添加顶级样式，防止别的样式干扰
			ele.addClass("audio5js");

			switch(setting.type)
			{
				case 'mini':
					// 添加播放器主体结构
					var playerBody = '<div class="mini">' +
											'<div class="play-pause">' +
												'<p class="play"></p>' +
												'<p class="pause"></p>' +
												'<p class="loading"></p>' +
												'<p class="error"></p>' +
											'</div>' +
											'<div class="scrubber">' +
												'<div class="progress"></div>' +
												'<div class="loaded"></div>' +
											'</div>' +
											'<div class="time">' +
												'<em class="played">00:00</em>/<strong class="duration">00:00</strong>' +
											'</div>' +
											'<div class="volume">' +
												'<div class="play-volume">' +
													'<div class="play-volume-button">' +
														'<a href="javascript:;">&nbsp;</a>' +
													'</div>' +
													'<div class="play-volume-adjust">' +
														'<div class="curVolume"></div>' +
														'<div class="maxVolume"></div>' +
													'</div>' +
												'</div>' +
											'</div>' +
											'<div class="error-message"></div>' +
										'</div>';
					ele.append(playerBody);
					ele.find('.play').attr("title", setting.playTitle);
					ele.find('.pause').attr("title", setting.pauseTitle);
					break;
				case "chat":
				default :
					// 添加播放器主体结构
					var playerBody = '<div class="chat">' +
										'<i class="loading"></i>' +
										'<span class="play"></span>' +
										'</div>';
					ele.append(playerBody);

					// 初始化标题
					ele.find('.play').attr("title", setting.playTitle);
					break;
			}

			// 初始化audio5js
			setting.audio5js = new Audio5js({
				swf_path: './audio5/audio5js.swf',
				// 配置不抛出错误，由回调函数处理
				throw_errors: false,
				format_time: false,
			  	ready: function(){
					// 加载音频
					this.load(setting.url);

					// 根据不同类型的播放器，绑定不同事件
					switch (setting.type)
					{
						case 'mini':
							var playBtn = ele.find('.play');
							var pauseBtn = ele.find('.pause');
							var errorBtn = ele.find('.error');
							var errorMsg = ele.find('.error-message');
							var progressBar = ele.find('.progress');
							var loadedBar = ele.find('.loaded');
							var playedTime = ele.find('.played');
							var durationTime = ele.find('.duration');
							var playVolumeBar = ele.find('.volume');
							var playVolumeBtn = ele.find('.play-volume-button a');
							var playVolumeAdjust = ele.find('.play-volume-adjust');
							var maxVolume = ele.find('.maxVolume');
							var curVolume = ele.find('.curVolume');

							playBtn.click(function(){
								audio.play();
							})

							pauseBtn.click(function(){
								audio.pause();
							});

							progressBar.click(function(){
								var w = event.offsetX;
								audio.seek(w);
							});

							loadedBar.click(function(){
								var w = event.offsetX;
								audio.seek(w);
							});

							playVolumeBar.hover(
								function()
								{
									playVolumeAdjust.show();
								},
								function()
								{
									playVolumeAdjust.hide();
								}
							);

							playVolumeBtn.click(function(){
								audio.volumeMute($(this));
							});

							maxVolume.click(function(){
								var h = event.offsetY;
								audio.setVolume(100-h);
							});

							curVolume.click(function(){
								var h = event.offsetY;
								var curH = $(this).height();
								audio.setVolume(curH-h);
							});

							// 音量最大
							this.volume(1);

							// 可以播放时，加载按钮隐藏
							this.one('canplay', function () {
								audio.canPlay = true;
								playBtn.show().siblings().hide();
							}, this);

							this.on('progress', function (load_percent) {
								loadedBar.width(280 * load_percent);
								durationTime.text(audio.formatTime(this.duration));
							}, this);

							this.on('timeupdate', function (position, duration) {
								progressBar.width(Math.ceil((position/duration) * 280));
								playedTime.text(audio.formatTime(position));
							}, this);

							this.on('play', function () {
								pauseBtn.show().siblings().hide();
							}, this);

							this.on('pause', function () {
								playBtn.show().siblings().hide();
							}, this);

							this.on('ended', function () {
								playBtn.show().siblings().hide();
							}, this);

							this.on('error', function (error) {
								errorBtn.show().siblings().hide();
								errorMsg.show(error.message);
							}, this);

							break;
						case 'chat':
						default :
							var audioPlayer = ele.find('.play');
							var audioDuration = ele.find('i');

							// 播放和暂停按钮事件
							audioPlayer.click(function(){
								audio.playPause();
							});

							// 音频加载后，设为可播放
							this.one('canplay', function () {
								audio.canPlay = true;
							}, this);

							// 设置音频时长
							this.on('progress', function (load_percent) {
								audioDuration.removeClass('loading').text(Math.ceil(this.duration) + " ''");
							}, this);

							this.on('play', function () {
								if (audio.canPlay)
								{
									audioPlayer.removeClass(setting.playClass);
									audioPlayer.addClass(setting.playingClass);
								}
							}, this);

							this.on('pause', function () {
								audioPlayer.removeClass(setting.playingClass);
								audioPlayer.addClass(setting.playClass);
							}, this);

							this.on('ended', function () {
								audioPlayer.removeClass(setting.playingClass);
								audioPlayer.addClass(setting.playClass);
							}, this);

							this.on('error', function (error) {
								audioDuration.removeClass('loading').addClass('error').text('');
							}, this);
							break;
					}
			  	}
			});
		},
		playPause : function () {
			// chat方式专有播放，播放/暂停一体
			var audio5js = this.options.audio5js;
			if (audio5js.playing) {
				audio5js.pause();
				audio5js.volume(0);
			} else {
				// 回到最开始的位置
				audio5js.seek(0);
				audio5js.play();
				audio5js.volume(1);
			}
	  	},
		play : function(){
			var audio5js = this.options.audio5js;
			if (!audio5js.playing) {
				audio5js.play();
			}
		},
	  	pause : function(){
			var audio5js = this.options.audio5js;
			if (audio5js.playing)
			{
				audio5js.pause();
			}
	  	},
		seek : function(w){
			var ele = this.$element;
			var progressBar = ele.find('.progress');
			var loadedBar = ele.find('.loaded');
			var audio5js = this.options.audio5js;
			var loadProcess = loadedBar.width;

			// 拉动的进度超过已下载的长度，用下载长度
			if (w>=loadProcess)
			{
				progressBar.width(loadProcess);
				audio5js.seek((loadProcess/280)*audio5js.duration);
			}
			else
			{
				progressBar.width(w);
				audio5js.seek((w/280)*audio5js.duration);
			}
		},
		setVolume : function(h){
			var ele = this.$element;
			var curVolume = ele.find('.curVolume');
			var audio5js = this.options.audio5js;
			var vol = (h/100).toFixed(1);
			curVolume.height(h);
			audio5js.volume(vol);
			this.volume = vol;
		},
		volumeMute : function(obj){
			var ele = this.$element;
			var curVolume = ele.find('.curVolume');
			var audio5js = this.options.audio5js;

			// 当前是静音，恢复成上次的音量
			if(obj.hasClass('mute'))
			{
				obj.removeClass('mute');
				curVolume.height(Math.ceil(this.volume * 100));
				audio5js.volume(this.volume);
			}
			else
			{
				// 当前是正常音量，点击后静音
				curVolume.height(0);
				audio5js.volume(0);
				obj.addClass('mute');
			}
		},
		destroyAudio:function()
		{
			var ele = this.$element;
			var audio5js = this.options.audio5js;
			audio5js.destroy();
			ele.data('audio', null);
			ele.empty();
			ele.removeClass('audio5js');
		},
		getAudio5js : function(){
	  		return this.options.audio5js;
	  	},
		formatTime: function (seconds) {
			var hours = parseInt(seconds / 3600, 10) % 24;
			var minutes = parseInt(seconds / 60, 10) % 60;
			var secs = parseInt(seconds % 60, 10);
			var result, fragment = (minutes < 10 ? "0" + minutes : minutes) + ":" + (secs  < 10 ? "0" + secs : secs);
			if (hours > 0) {
				result = (hours < 10 ? "0" + hours : hours) + ":" + fragment;
			} else {
				result = fragment;
			}
			return result;
		}
	};

	$.fn.audio5js = function (option, value) {
		var methodReturn;
		var $set = this.each(function () {
			var $this = $(this);
			var data = $this.data('audio');
			var options = typeof option === 'object' && option;
			if (!data) {
				$this.data('audio', (data = new Audio(this, options)));
			}
			if (typeof option === 'string') {
				methodReturn = data[option](value);
			}
		});
		return (methodReturn === undefined) ? $set : methodReturn;
	};

	$.fn.audio5js.defaults = {
		url : "", 				// 音频文件地址
		type : "chat",			// 播放器类型，chat聊天气泡；mini精简模式
		playTitle : "点击播放",	// 播放按钮的提示词
		playClass : "play", 		// 正常样式class
		loadingClass : "loading", 	// 加载样式class
		playingClass : "playing", 	// 播放时样式class
		errorClass : "error", 		// 错误时的样式
		pauseTitle : "点击暂停",	// 暂停按钮的提示词
		pauseClass : "pause", 	// 暂停样式class
		audio5js : {}
	};

	$.fn.audio5js.Constructor = Audio;
}(window.jQuery);