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

class group_members extends admin {
	
	private $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('group_model');
		
	}
	
	public function init() {
	    $tid = intval($_REQUEST['tid']);
	    
	    yunxin::updateGroupMembers($tid);
	    
	    $group = \think\Db::name('group_members')
	    ->alias('m')
	    ->join("user u","u.accid = m.accid")
	    ->where('m.tid',$tid)
	    ->order(['m.is_own'=>'desc','m.is_master'=>'desc','m.id'=>'asc']);
	    
	    $group = $group->paginate(10,false,['query'=>$_GET]);
	    $list = $group->items();
	    $pages = $group->render();
		
		include $this->admin_tpl('group_members_list','chat');
	}
	
	public function update_group_nickname(){
	    header("Content-Type: application/json; charset=utf-8");
	    $uid = intval($_REQUEST['uid']);
	    $tid = intval($_REQUEST['tid']);
	    $nick = htmlspecialchars($_REQUEST['nick']);
	    
	    $accid = \think\Db::name('user')->where(['userid'=>$uid])->value('accid');
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    $return = yunxin::updateTeamNick($tid, $owner, $accid,$nick);
	    
	    if($return['code']!=200){
	       exit(json_encode(['code'=>500,'msg'=>$return['desc'],'data'=>'']));
        }
        
        \think\Db::name('group_members')->where('accid',$accid)->where('tid',$tid)->update(['group_nickname'=>$nick]);
	    
	    exit(json_encode(['code'=>200,'msg'=>'操作成功','data'=>'']));
	}
	
	public function remove_manager(){
	    $tid = intval($_REQUEST['tid']);
	    $accid = htmlspecialchars($_REQUEST['accid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $return = yunxin::managerRemove($tid, $owner, [$accid]);
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function add_manager(){
	    $tid = intval($_REQUEST['tid']);
	    $accid = htmlspecialchars($_REQUEST['accid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $return = yunxin::managerAdd($tid, $owner, [$accid]);
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function add_member(){
	    $tid = intval($_REQUEST['tid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $username = htmlspecialchars($_POST['username']);
	    $userinfo = \think\Db::name('user')->where(['username'=>$username,'status'=>99])->find();
	    if(empty($userinfo)){
	        showmessage("输入的用户名不存在！",'goback');
	    }
	    
	    $return = yunxin::addMember($tid, $owner, [$userinfo['accid']]);
	    
	    if($return['code']!=200){
	        if($return['code']==801){
	            showmessage("群人数达到上限",'goback');
	        }
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function remove_member(){
	    $tid = intval($_REQUEST['tid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $accid = $_REQUEST['accid'];
	    if(is_array($accid)){
	        $return = yunxin::removeMember($tid, $owner, $accid);
	    }
	    else{
    	    $return = yunxin::removeOneMember($tid, $owner, $accid);
	    }
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function change_owner(){
	    $tid = intval($_REQUEST['tid']);
	    $newowner = htmlspecialchars($_REQUEST['accid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $return = yunxin::changeOwner($tid, $owner, $newowner);
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function mute_member(){
	    $tid = intval($_REQUEST['tid']);
	    $accid = htmlspecialchars($_REQUEST['accid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $return = yunxin::muteMember($tid, $owner, $accid);
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
	public function unmute_member(){
	    $tid = intval($_REQUEST['tid']);
	    $accid = htmlspecialchars($_REQUEST['accid']);
	    $owner = \think\Db::name('group')->where(['tid'=>$tid])->value('accid');
	    
	    $return = yunxin::unmuteMember($tid, $owner, $accid);
	    if($return['code']!=200){
	        showmessage("云信：".$return['desc'],'goback');
	    }
	    showmessage("操作成功",'goback');
	}
	
}
?>