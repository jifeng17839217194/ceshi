<?php
return array(
//网站路径
'web_path' => '/bee/',
//Session配置
'session_storage' => 'mysql',
'session_ttl' => 1800,
'session_savepath' => CACHE_PATH.'sessions/',
'session_n' => 0,
//Cookie配置
'cookie_domain' => '', //Cookie 作用域
'cookie_path' => '', //Cookie 作用路径
'cookie_pre' => 'CMPkO_', //Cookie 前缀
'cookie_ttl' => 0, //Cookie 生命周期，0 表示随浏览器进程
//模板相关配置
'tpl_root' => 'templates/', //模板保存物理路径
'tpl_name' => 'default', //当前模板方案目录
'tpl_css' => 'default', //当前样式目录
'tpl_referesh' => 1,
'tpl_edit'=> 0,//是否允许在线编辑模板

//附件相关配置
'upload_path' => PHPCMS_PATH.'uploadfile/',
'upload_url' => 'http://bee.nightlan.top/uploadfile/', //附件路径
'attachment_stat' => '1',//是否记录附件使用状态 0 统计 1 统计， 注意: 本功能会加重服务器负担

'js_path' => 'http://bee.nightlan.top/statics/js/', //CDN JS
'css_path' => 'http://bee.nightlan.top/statics/css/', //CDN CSS
'img_path' => 'http://bee.nightlan.top/statics/images/', //CDN img
'app_path' => 'http://bee.nightlan.top/',//动态域名配置地址
'api_path' => 'http://beeapi.nightlan.top/',//API地址
'charset' => 'utf-8', //网站字符集
'timezone' => 'Etc/GMT-8', //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8
'debug' => 0, //是否显示调试信息
'admin_log' => 1, //是否记录后台操作日志
'errorlog' => 1, //1、保存错误日志到 cache/error_log.php | 0、在页面直接显示
'gzip' => 1, //是否Gzip压缩后输出
'auth_key' => '7SLahrT8anWkl7LfOBhW', //密钥
'lang' => 'zh-cn',  //网站语言包
'lock_ex' => '1',  //写入缓存时是否建立文件互斥锁定（如果使用nfs建议关闭）

'admin_founders' => '1', //网站创始人ID，多个ID逗号分隔
'execution_sql' => 0, //EXECUTION_SQL

//保利视频参数
'ployv_id' => '2967e594f6',
'ployv_secretkey' => 'eL1PuSWZrQ',


'html_root' => '/html',//生成静态文件路径
'safe_card'=>'1',//是否启用口令卡

'admin_url' => '127.0.0.1',	//允许访问后台的域名
'app_key' => '7400b300725399cdcec2993745496334',
);
?>
