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

class group extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('group_model');
		
	}
	
	function init() {
	    
	    $logsSql = \think\Db::name('group_log_link')->field('count(*)')->where('tid = g.tid')->buildSql();
	    $group = \think\Db::name('group')
	    ->field("*,$logsSql as logs_count")
	    ->alias('g')
	    ->join("user u","u.accid = g.accid")
	    ->where('g.status','1');
	    
	    $start_time = $_GET['start_time'];
	    $end_time = $_GET['end_time'];
	    if(!empty($start_time) || !empty($end_time)){
	        $where['g.create_time'] = ['betwe'];
	        $group = $group->whereTime('g.create_time', 'BETWEEN',[$start_time.' 00:00:00',$end_time.' 23:59:59'],'and');
	    }
	    $keyword = trim($_GET['keyword']);
	    if(!empty($keyword)){
	        $group = $group->where(function ($query) use ($keyword){
	            $query->whereLike('g.tname', "%$keyword%")
	            ->whereOr('g.tid', $keyword)
	            ->whereOr('u.username', $keyword)
	            ->whereLike('u.nickname', "$keyword%",'OR');
	        });
	    }
	    
	    $group = $group->order('g.create_time','DESC')->paginate(20,false,['query'=>$_GET]);
	    $list = $group->items();
	    $pages = $group->render();
		
		include $this->admin_tpl('group_list','chat');
	}

	function add() {
	    if(isset($_POST['dosubmit'])) {
	        
	        try {
	            \think\Db::startTrans();
	            $data = [];
	            $username = $_POST['username'];
	            $userinfo = \think\Db::name('user')->where(['username'=>$username,'status'=>99])->find();
	            $data['uid'] = $userinfo['userid'];
	            $data['accid'] = $userinfo['accid'];
	            $data['tname'] = htmlspecialchars($_POST['tname']);
	            $data['icon'] = htmlspecialchars($_POST['icon']);
	            $data['intro'] = htmlspecialchars($_POST['intro']);
	            $data['rule'] = htmlspecialchars($_POST['rule']);
	            $data['status'] = 1;
	            $data['maxusers'] = 200;
	            $data['create_time'] = date('Y-m-d H:i:s');
	            if(empty($data['uid'])){
	                showmessage('用户名不存在','goback', 1000);
	            }
	            if(empty($data['tname'])){
	                showmessage('群名称为空','goback', 1000);
	            }
	            $saved = \think\Db::name('group')->where(['tname'=>$data['tname'],'status'=>1])->count();
	            if($saved > 0){
	                showmessage('群名称重复','goback', 1000);
	            }
	            if(empty($data['intro'])){
	                showmessage('群介绍为空','goback', 1000);
	            }
	            if(empty($data['rule'])){
	                $data['rule'] = \think\Db::name('page')->where('catid','=',120)->value('content');
	            }
	            if(empty($data['icon'])){
	                showmessage('群头像为空','goback', 1000);
	            }
	            $data['icon'] = empty($data['icon'])?pc_base::load_config('yunxin','group_icon'):$data['icon'];//群头像
	            $id = \think\Db::name('group')->insertGetId($data);
	            
	            $members = $_POST['members'];
	            $return = yunxin::groupCreate($data['accid'], $data['tname'], $members,$data['intro'],$data['icon']);
	            if($return['code']!=200){
	                showmessage("云信：".$return['desc'],'goback');
	            }
	            \think\Db::name('group')->where(['id'=>$id])->update(['status'=>1,'tid'=>$return['tid']]);
	            
	            $return2 = yunxin::managerAdd($return['tid'], $userinfo['accid'], $members);
	            if($return2['code']!=200){
	                showmessage("云信：".$return2['desc'],'goback');
	            }
	            
	            yunxin::updateGroupMembers($return['tid']);
	            
	            \think\Db::commit();
	            
	        } catch (Exception $e) {
	            showmessage($e->getMessage(),'goback', 1000);
	        }
	        
	        showmessage(L('operation_success'),'?m=member&c=member&a=add', 1000, 'add');
	    }
	    else{
	        
	        $groupCountSql = \think\Db::name('group_members')->field('count(0)')->where("accid = u.accid")->where('is_master',1)->buildSql();
	        $masterList = \think\Db::name('user')
	        ->alias('u')
	        ->field("*,$groupCountSql as group_count")
	        ->where('is_supporter',1)
	        ->where('status',99)
	        ->order(['group_count'=>'DESC'])
	        ->select();
	        
    	    include $this->admin_tpl('group_add');
	    }
	}
	
	function edit() {
	    if(isset($_POST['dosubmit'])) {
	        
	        try {
	            $data = [];
	            $data['id'] = intval($_POST['id']);
	            $data['tname'] = htmlspecialchars($_POST['tname']);
	            $data['icon'] = htmlspecialchars($_POST['icon']);
	            $data['intro'] = htmlspecialchars($_POST['intro']);
	            $data['rule'] = htmlspecialchars($_POST['rule']);
	            $data['invitemode'] = intval($_POST['invitemode']);
	            $data['maxusers'] = intval($_POST['maxusers']);
	            
	            $tid = intval($_POST['tid']);
	            
	            if(empty($data['tname'])){
	                showmessage('群名称为空','goback', 1000);
	            }
	            $saved = \think\Db::name('group')->where('tname',$data['tname'])->where('status',1)->where('id','<>',$data['id'])->count();
	            if($saved > 0){
	                showmessage('群名称重复','goback', 1000);
	            }
	            if(empty($data['icon'])){
	                showmessage('群头像为空','goback', 1000);
	            }
	            if(empty($data['intro'])){
	                showmessage('群介绍为空','goback', 1000);
	            }
	            if(empty($data['rule'])){
	                $data['rule'] = \think\Db::name('page')->where('catid','=',120)->value('content');
	            }
	            
	            if($data['maxusers']<2  || $data['maxusers']>200){
	                showmessage('群人数上限范围为2-200','goback', 1000);
	            }
	            
	            //$data['icon'] = empty($data['icon'])?pc_base::load_config('yunxin','group_icon'):$data['icon'];//群头像
	            $group = \think\Db::name('group')->where('tid',$tid)->field('accid,members_num')->find();
	            if($data['maxusers'] < $group['members_num']){
	                showmessage('群人数上限低于当前群内人数','goback', 1000);
	            }
	            
	            $accid = $group['accid'];
	            $return = yunxin::groupUpdate($tid,$accid,$data['tname'],$data['intro'],$data['icon'],$data['invitemode'],$data['maxusers']);
	            if($return['code']!=200){
	                showmessage($return['desc'],'goback', 1000);
	            }
	            
	            $members = $_POST['members'];
	            
	            $memberStack = \think\Db::name('group_members')->where('tid',$tid)->column('accid');
	            $addmembers = [];
	            foreach ($members as $key=>$memberAccid){
	                if(!in_array($memberAccid, $memberStack)){
	                    $addmembers[] = $memberAccid;
	                }
	            }
	            yunxin::addMember($tid, $accid, $addmembers);
	            
	            $masterStack = \think\Db::name('group_members')->where('tid',$tid)->where('is_master',1)->column('accid');
	            $masters = [];
	            foreach ($members as $key=>$masterAccid){
	                if(!in_array($masterAccid, $masterStack)){
	                    $masters[] = $masterAccid;
	                }
	            }
	            $re = yunxin::managerAdd($tid, $accid, $masters);
	            
	            $notInSupporterStack = \think\Db::name('user')->where('is_supporter',1)->where('status',99)->whereNotIn('accid',$members)->column('accid');
	            foreach ($memberStack as $key=>$item){
	                if(in_array($item, $notInSupporterStack)){
	                    $unsetMasters[] = $item;
	                }
	            }
	            $re2 = yunxin::managerRemove($tid, $accid, $unsetMasters);
	            $re3 = yunxin::removeMember($tid, $accid, $unsetMasters);
	            
	            
	            \think\Db::name('group')->update($data);
	        } catch (Exception $e) {
	            showmessage($e->getMessage(),'goback', 1000);
	        }
	        showmessage(L('operation_success'),'?m=chat&c=group&a=edit&tid='.$tid, 1000);
	    }
	    else{
	        $tid = intval($_REQUEST['tid']);
	        $info = \think\Db::name('group')->where('tid',$tid)->find();
	        
	        $groupCountSql = \think\Db::name('group_members')->field('count(0)')->where("accid = u.accid")->where('is_master',1)->buildSql();
	        $masterList = \think\Db::name('user')
	        ->alias('u')
	        ->field("*,$groupCountSql as group_count")
	        ->where('is_supporter',1)
	        ->where('status',99)
	        ->order(['group_count'=>'DESC'])
	        ->select();
	        
	        $masterStack = \think\Db::name('group_members')->where('tid',$tid)->where('is_master',1)->column('accid');
	        foreach ($masterList as $key=>$master){
	            $masterList[$key]['checked'] = in_array($master['accid'], $masterStack)?1:0;
	        }
	        
	        include $this->admin_tpl('group_edit');
	    }
	    
	}
	
	function delete(){
	    $tid = intval($_REQUEST['tid']);
	    $accid = \think\Db::name('group')->where('tid',$tid)->value('accid');
	    $return = yunxin::groupRemove($tid,$accid);
	    if($return['code']!=200){
	        showmessage($return['desc'],'goback', 1000);
	    }
	    \think\Db::name('group')->where('tid',$tid)->setField('status',-1);
	    \think\Db::name('group_log_link')->where('tid',$tid)->delete();
	    \think\Db::name('group_members')->where('tid',$tid)->delete();
	    showmessage(L('operation_success'),'goback');
	}
	
}
?>