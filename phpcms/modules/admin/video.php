<?php
use think\db\Where;

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
pc_base::load_sys_class('yunxin', '', 0);

class video extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	public function init() {

	    if(isset($_POST['dosubmit'])) {
	    	$catid = $_POST['info']['catid'];
	    	$page_db  = \think\Db::name('page');
	    	$info = $page_db->where('catid','=',$catid)->find();
	    	if(empty($_POST['title']) && empty($_POST['thumb']) && empty($_POST['video'])){
	            $data['updatetime'] = time();
		    	if($info){
		    		$data['catid'] = $catid;
		    		$data['title'] = '';
	    			$data['self1'] = '';
	    			$data['self2'] = '';
					$res = $page_db ->where('catid','=',$catid) ->data($data)->update();
		    	}
		        showmessage(L('operation_success'),HTTP_REFERER, '');exit;
	        }else{
	        	if(empty($_POST['title'])){
	            	showmessage('标题不能为空','goback', 1000);exit;
		        }
		        if(empty(htmlspecialchars($_POST['thumb']))){
		            showmessage('请上传缩略图','goback', 1000);exit;
		        }
		        if(empty($_POST['video'])){
		            showmessage('请上传视频','goback', 1000);exit;
		        }
		        $data['title'] = $_POST['title'];
		    	$data['self1'] = $_POST['video'];
		    	$data['self2'] = htmlspecialchars($_POST['thumb']);
		    	$data['updatetime'] = time();
		    	if(!$info){
		    		$data['catid'] = $catid;
		    		$res = $page_db->insert($data);
		    	}else{  		
		    		$res = $page_db ->where('catid','=',$catid) ->data($data)->update();
		    	}
	        	showmessage(L('operation_success'),HTTP_REFERER, '');
	        }
	    	
	    }
	    else{
	    	$catid = intval($_REQUEST['catid']);
	    	$info = \think\Db::name('page')
		    ->where('catid','=',$catid)
		    ->find();
	        include $this->admin_tpl('video','admin');
	    }
	    
	    
	    
	}
		
}
?>