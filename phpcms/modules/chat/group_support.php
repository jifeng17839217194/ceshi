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
pc_base::load_sys_class('yunxin', '', 0);

class group_support extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	function init() {
        
	    $groupCountSql = \think\Db::name('group_members')->field('count(0)')->where("accid = u.accid")->where('is_master',1)->buildSql();
	    
	    $userQuery = \think\Db::name('user')
	    ->alias('u')
	    ->field("*,$groupCountSql as group_count")
	    ->where('is_supporter',1)
	    ->where('status',99)
	    ->order(['support_time'=>'DESC'])
	    ->paginate(20,false,['query'=>$_GET]);
	    
	    
	    $list = $userQuery->items();
	    $pages = $userQuery->render();
	    
	    include $this->admin_tpl('group_support','chat');
	    
	}
	
	public function groups(){
	    
	    $userid = intval($_REQUEST['userid']);
	    $accid = \think\Db::name('user')->where('userid',$userid)->value('accid');
	    
	    $group = \think\Db::name('group_members')
	    ->field('g.tname,g.tid,gm.accid')
	    ->alias('gm')
	    ->join('group g','g.tid = gm.tid','LEFT')
	    ->where('gm.accid',$accid)
        ->where('gm.is_master',1)
	    ->where('g.status','1')
	    ->order('g.create_time','DESC')
	    ->paginate(20,false,['query'=>$_GET]);
	    
	    $list = $group->items();
	    $pages = $group->render();
	    
	    include $this->admin_tpl('group_support_groups','chat');
	}
	
	public function add(){
	    header("Content-Type: application/json; charset=utf-8");
	    
        $username = htmlspecialchars($_POST['username']);
        $userinfo = \think\Db::name('user')->where(['username'=>$username,'status'=>99])->find();
        if(empty($userinfo)){
            exit(json_encode(['code'=>500,'msg'=>'用户名不存在！','data'=>'']));
        }
        
        \think\Db::name('user')->where(['username'=>$username])->update(['is_supporter'=>1,'support_time'=>date('Y-m-d H:i:s')]);
        
        exit(json_encode(['code'=>1,'msg'=>'操作成功','data'=>'']));        
	}
	
	public function delete(){
	    $userid = $_REQUEST['userid'];
	    if(is_array($userid)){
    	    //$accid = \think\Db::name('user')->where('userid',$userid)->value('accid');
    	    \think\Db::name('user')->where('userid','in',$userid)->setField('is_supporter',0);
	    }
	    else{
	        $userid = intval($_REQUEST['userid']);
	        \think\Db::name('user')->where('userid',$userid)->setField('is_supporter',0);
	    }
	    
	    showmessage(L('operation_success'),HTTP_REFERER);
	}
}
?>