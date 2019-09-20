<?php
/**
 * 管理员后台会员操作类
 */
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_app_func('util', 'content');
pc_base::load_sys_class('thinkorm', '', 0);

class group_setting extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	function init() {

	    $list = \think\Db::name('category')
	    ->where('parentid','=','117')
	    ->select();
	    $catid = intval($_REQUEST['catid']);
	    if(empty($catid)){
	    	$catid = $list[0]['catid'];
	    }
	    $info = \think\Db::name('page')
	    ->where('catid','=',$catid)
	    ->find();
		include $this->admin_tpl('group_setting','chat');
	}
		
	function edit() {
	    if(isset($_POST['dosubmit'])) {
	    	$catid = $_POST['info']['catid'];
	    	$page_db  = \think\Db::name('page');
	    	$info = $page_db->where('catid','=',$catid)->find();
	    	$data['content'] = $_POST['info']['content'];
	    	$data['updatetime'] = time();
	    	if(!$info){
	    		$data['catid'] = $catid;
	    		$data['title'] = \think\Db::name('category')->where('catid','=',$catid)->value('catname');
	    		$res = $page_db->where('catid','=',$catid)->insert($data);
	    	}else{  		
	    		$res = $page_db ->where('catid','=',$catid) ->data($data)->update();
	    	}
	        showmessage(L('operation_success'),HTTP_REFERER);
	    }
	    else{
	        include $this->admin_tpl('group_setting','chat');
	    }
	    
	}
	
}
?>