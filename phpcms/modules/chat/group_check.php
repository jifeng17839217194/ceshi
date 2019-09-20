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

class group_check extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	function init() {

	    $group = \think\Db::name('group')
	    ->field('g.id,icon,tname,nickname,username,intro,rule,g.create_time,g.status,g.refuse_reason')
	    ->alias('g')
	    ->join("user u","u.accid = g.accid");
	    
	    $status = $_GET['status'];
	    if(is_numeric($status)){
	        $group = $group->where('g.status',$status);
	    }
	    else{
	        $group = $group->where('g.status','>=',0);
	    }
	    
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
	            ->whereOr('u.username', $keyword)
	            ->whereLike('u.nickname', "$keyword%",'OR');
	        });
	    }
	    
	    $group = $group->order(['g.create_time'=>'DESC','g.id'=>'DESC'])->paginate(10,false,['query'=>$_GET]);
	    $group->each(function($item){
	        $item['intro'] = str_replace(["
","\r\n", "\r", "\n"], "<br>", $item['intro']);
	        $item['rule'] = str_replace(["
","\r\n", "\r", "\n"], "<br>", $item['rule']); 
	        return $item;
	    });
	    $list = $group->items();
	    
	    
	    $pages = $group->render();
	    
	    $groupCountSql = \think\Db::name('group_members')->field('count(0)')->where("accid = u.accid")->where('is_master',1)->buildSql();
	    $masterList = \think\Db::name('user')
	    ->alias('u')
	    ->field("*,$groupCountSql as group_count")
	    ->where('is_supporter',1)
	    ->where('status',99)
	    ->order(['group_count'=>'DESC'])
	    ->select();
	    
	    include $this->admin_tpl('group_check','chat');
	    
	}
	
	public function apply_agree_confirm(){
	    header("Content-Type: application/json; charset=utf-8");
	    
	    $tname = htmlspecialchars($_POST['tname']);
	    $count = \think\Db::name('group')->where(['tname'=>$tname,'status'=>1])->count();
	    if($count>0){
	        exit(json_encode(['code'=>500,'msg'=>'群名【'.$tname.'】与已有的群重复，无法通过申请，请做拒绝申请操作','data'=>'']));
	    }
	    exit(json_encode(['code'=>200,'msg'=>'可以通过','data'=>'']));
	}
	
	public function apply_agree(){
	    header("Content-Type: application/json; charset=utf-8");
	    
	    $id = intval($_POST['id']);
	    $data = \think\Db::name('group')->where(['id'=>$id])->find();
	    
	    $count = \think\Db::name('group')->where(['tname'=>$data['tname'],'status'=>1])->count();
	    if($count>0){
	        exit(json_encode(['code'=>500,'msg'=>'群名【'.$data['tname'].'】与已有的群重复，无法通过申请，请做拒绝申请操作','data'=>'']));
	    }
	    
	    $members = $_POST['members'];
	    $return = yunxin::groupCreate($data['accid'], $data['tname'], $members,$data['intro'],$data['icon']);
	    if($return['code']!=200){
	        exit(json_encode(['code'=>500,'msg'=>$return['desc'],'data'=>'']));
	    }
	    
	    \think\Db::name('group')->where(['id'=>$id])->update(['status'=>1,'tid'=>$return['tid'],'maxusers'=>200]);
	    yunxin::managerAdd($return['tid'], $data['accid'], $members);
	    
	    yunxin::updateGroupMembers($return['tid']);
	    
	    $notice['title'] = pc_base::load_config('yunxin','notice_name');
	    $notice['top_title'] = "同意申请";
	    $notice['msg'] = "同意你创建群";
	    $notice['sub_msg'] = $data['tname'];
	    $notice['info'] = "";
	    $notice['icon'] = pc_base::load_config('yunxin','notice_icon');
	    $notice['create_time'] = time();
	    
	    $notice['account_type'] = 'SYSTEM';
	    $notice['from_account'] = pc_base::load_config('yunxin','notice_accid');
	    $notice['to_account'] = $data['accid'];
	    $notice['tid'] = $return['tid'];
	    $notice['msg_type'] = 'TEAM_CREATE_AGREE';
	    $notice['apply_status'] = 0;
	    $notice['notice_id'] = \think\Db::name('group_notice')->insertGetId($notice);
	    $notice['create_time'] = $this->cmf_notice_time($notice['create_time']);
	    
	    yunxin::sendOneMsg($data['accid'],$notice);
	    
	    exit(json_encode(['code'=>200,'msg'=>'操作成功','data'=>$notice]));
	}
	
	public function apply_refuse(){
	    $id = intval($_POST['id']);
	    $data = \think\Db::name('group')->where(['id'=>$id])->find();
	    $refuse_reason = htmlspecialchars($_POST['refuse_reason']);
	    
	    \think\Db::name('group')->where(['id'=>$id])->update(['status'=>'2','refuse_reason'=>$refuse_reason]);
	    
	    $notice['title'] = pc_base::load_config('yunxin','notice_name');
	    $notice['top_title'] = "拒绝申请";
	    $notice['msg'] = "拒绝你创建群";
	    $notice['sub_msg'] = $data['tname'];
	    $notice['info'] = $refuse_reason;
	    $notice['icon'] = pc_base::load_config('yunxin','notice_icon');
	    $notice['create_time'] = time();
	    
	    $notice['account_type'] = 'SYSTEM';
	    $notice['from_account'] = pc_base::load_config('yunxin','notice_accid');
	    $notice['to_account'] = $data['accid'];
	    $notice['tid'] = "";
	    $notice['msg_type'] = 'TEAM_CREATE_REFUSE';
	    $notice['apply_status'] = 0;
	    $notice['notice_id'] = \think\Db::name('group_notice')->insertGetId($notice);
	    $notice['create_time'] = $this->cmf_notice_time($notice['create_time']);
	    
	    yunxin::sendOneMsg($data['accid'],$notice);
	    
	    exit(1);
	}
	
	private function cmf_notice_time($time){
	    if(date('Y',$time) == date('Y')){
	        if(date('m-d',$time) == date('m-d')){
	            $returnTime = "今天 ".date('H:i',$time);
	        }
	        else if(date('m-d',$time) == date('m-d','-1 day')){
	            $returnTime = "昨天 ".date('H:i',$time);
	        }
	        else{
	            $returnTime = date('m-d H:i',$time);
	        }
	    }
	    else{
	        $returnTime = date('Y-m-d',$time);
	    }
	    return $returnTime;
	}
}
?>