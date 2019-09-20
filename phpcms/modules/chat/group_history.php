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

class group_history extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	function init() {
	    $show_layer = true;
	    $tid = intval($_REQUEST['tid']);
	    
	    $group = \think\Db::name('group_history')
	    ->alias('his')
	    ->field('his.*,u.avatar,u.nickname,u.username')
	    ->join('user u','u.accid = his.from_account')
	    ->where('to',$tid)
	    ->order(['msg_timestamp'=>'DESC','id'=>'DESC'])
	    ->paginate(20,false,['query'=>$_GET]);
	    
	    $group->each(function($item){
	        $item['avatar'] = empty($item['avatar'])?pc_base::load_config('yunxin','user_icon'):API_PATH.$item['avatar'];
	        $item['attach'] = json_decode($item['attach'],true);
	        return $item;
	    });
	    
	    
	    $list = $group->items();
	    $pages = $group->render();
	    
	    include $this->admin_tpl('group_history','chat');
	}
	
	public function video_show(){
	    $video_url = $_REQUEST['url'];
	    
	    include $this->admin_tpl('video_show','chat');
	}
}
?>