;(function () {
	
	$("body").on("click",".ajax-get",function(e){
        e.preventDefault();
		var that = this;
		require(['artDialog'], function (){
            var $_this = that,
                $this  = $($_this),
                href   = $this.data('href')?$this.data('href'):$this.attr('href'),
                msg    = $this.data('msg'),
                funStr = $this.data('callback');
            
            href	= href ? href : $this.attr('href');
			
			if(funStr != null){
				var callback = function(e){
					window[funStr](e);
				}
			}
			$.getJSON(href).done(function (data) {
                if (data.code == '200') {
                	if(typeof(callback) == 'function'){
						callback($this);
					}
					else{
						art.dialog({
    						title:'提示信息',
                            content: data.msg,
                            path:'/statics/js/artDialog',
                            icon: 'succeed',
                            ok: function () {
                                return true;
                            },
                            okValue: "确定"
                        });
					}
                } else if (data.code == '500') {
                	art.dialog({
						title:'提示信息',
                        content: data.msg,
                        path:'/statics/js/artDialog',
                        icon: 'warning',
                        ok: function () {
                            return true;
                        },
                        okValue: "确定"
                    });
                }
            });
		});
	});
	
	
	$("body").on("submit",".js-ajax-form",function(e){
        e.preventDefault();
		var that = this;
	    require(['ajaxForm'],function(){
	    	var $this  = $(that),
            successFun = $this.data('success'),
            errorFun = $this.data('error');
	    	
	    	if(successFun != null){
	    		var successCallback = function(e,d){
	    			window[successFun](e,d);
	    		}
			}
	    	if(errorFun != null){
	    		var errorCallback = function(e,d){
	    			window[errorFun](e,d);
	    		}
			}
	    	
	    	$this.ajaxSubmit({
				url : $this.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
				dataType : 'json',
				beforeSubmit : function(arr, $form, options) {
					formloading = true;
				},
				success : function(data, statusText, xhr, $form) {
					formloading = false;
					if (data.code==200) {
						if(typeof(successCallback) == 'function'){
							successCallback($this,data);
						}
						else{
							artdialogAlert(data.msg,'succeed');
						}
					} else {
						if(typeof(errorCallback) == 'function'){
							errorCallback($this,data);
						}
						else{
							artdialogAlert(data.msg,'error');
						}
					}
				}
			});
		});
	});
	
	
})();