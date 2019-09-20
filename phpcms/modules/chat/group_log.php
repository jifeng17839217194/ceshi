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

class group_log extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('page_model');
		
	}
	
	public function init() {
	    $countSql = \think\Db::name('group_log_link')->field('count(*)')->where("log_id = gl.id")->buildSql();
	    $group_log = \think\Db::name('group_log')
	    ->field("gl.*,$countSql as count")->alias('gl');
	    
	    $start_time = $_GET['start_time'];
	    $end_time = $_GET['end_time'];
	    if(!empty($start_time) || !empty($end_time)){
	        $group_log = $group_log->whereTime('gl.create_time', 'BETWEEN',[$start_time.' 00:00:00',$end_time.' 23:59:59'],'and');
	    }
	    $title = trim($_GET['title']);
	    if(!empty($title)){
	        $group_log = $group_log->whereLike('gl.title', "%$title%");
	    }
	    $keyword = trim($_GET['keyword']);
	    if(!empty($keyword)){
	        $group_log = $group_log->whereLike('gl.creator', "$keyword%");
	    }
	    
	    $group_log = $group_log->order(['gl.create_time'=>'DESC','gl.id'=>'DESC'])->paginate(20,false,['query'=>$_GET]);
	    $group_log->each(function($item){
	        return $item;
	    });
        $list = $group_log->items();
        $pages = $group_log->render();
	    
	    include $this->admin_tpl('group_log','chat');
	}
	
	
	public function lists() {
	    
	    $tid = intval($_REQUEST['tid']);
	    
	    $group_log = \think\Db::name('group_log')
	    ->field("gl.*,link.log_id,link.id as id")
	    ->alias('gl')
	    ->join("group_log_link link","link.log_id = gl.id");
	    
	    $group_log = $group_log->where('link.tid', $tid);
	    
	    $title = trim($_GET['title']);
	    if(!empty($title)){
	        $group_log = $group_log->whereLike('gl.title', "%$title%");
	    }
	    $start_time = $_GET['start_time'];
	    $end_time = $_GET['end_time'];
	    if(!empty($start_time) || !empty($end_time)){
	        $group_log = $group_log->whereTime('gl.create_time', 'BETWEEN',[$start_time.' 00:00:00',$end_time.' 23:59:59']);
	    }
	    $keyword = trim($_GET['keyword']);
	    if(!empty($keyword)){
	        $group_log = $group_log->whereLike('gl.creator', "$keyword%");
	    }
	    
	    $group_log = $group_log->order(['gl.create_time'=>'DESC','gl.id'=>'DESC'])->paginate(20,false,['query'=>$_GET]);
	    $group_log->each(function($item){
	        return $item;
	    });
        $list = $group_log->items();
        $pages = $group_log->render();
        
        $tname = \think\Db::name('group')->where('tid',$tid)->value('tname');
        
        include $this->admin_tpl('group_log_lists','chat');
	}
	
	public function add(){
	    $tid = intval($_REQUEST['tid']);
	    if(isset($_POST['dosubmit'])){
	        
	        $data['title'] = trim(htmlspecialchars($_POST['title']));
	        $data['creator'] = param::get_cookie('admin_username');
	        $data['thumb'] = htmlspecialchars($_POST['thumb']);
	        $data['date'] = htmlspecialchars($_POST['date']);
	        $data['video'] = htmlspecialchars($_POST['video']);
	        $data['info'] = stripslashes($_POST['info']);
	        $data['create_time'] = date('Y-m-d H:i:s');
	        
	        $logid = \think\Db::name('group_log')->insertGetId($data);
	        
	        if(!empty($tid)){
	            \think\Db::name('group_log_link')->insert(['tid'=>$tid,'log_id'=>$logid]);
	        }
	        
	        showmessage(L('operation_success'),HTTP_REFERER,1000,'add');
	    }
	    include $this->admin_tpl('group_log_edit','chat');
	}
	
	public function edit(){
	    $id = intval($_REQUEST['id']);
	    if(isset($_POST['dosubmit'])){
	        
	        $data['title'] = trim(htmlspecialchars($_POST['title']));
	        $data['thumb'] = htmlspecialchars($_POST['thumb']);
	        $data['date'] = htmlspecialchars($_POST['date']);
	        $data['video'] = htmlspecialchars($_POST['video']);
	        $data['info'] = stripslashes($_POST['info']);
	        
	        \think\Db::name('group_log')->where(['id'=>$id])->update($data);
	        
	        showmessage(L('operation_success'),HTTP_REFERER);
	    }
	    $info = \think\Db::name('group_log')
        ->where(['id'=>$id])
        ->find();
	    
        $data = getpolyvdetail($info['video']);
	    
	    include $this->admin_tpl('group_log_edit','chat');
	}
	
	public function delete(){
	    $id = $_REQUEST['id'];
	    if(is_array($id)){
	        \think\Db::name('group_log')->whereIn('id',$id)->delete();
	        \think\Db::name('group_log_link')->whereIn('log_id',$id)->delete();
	    }
	    else{
	        $id = intval($id);
	        \think\Db::name('group_log')->where('id',$id)->delete();
	        \think\Db::name('group_log_link')->where('log_id',$id)->delete();
	    }
	    
	    showmessage('操作成功',HTTP_REFERER);
	}
	
	public function groups(){
	    $logid = intval($_GET['id']);
	    
	    $group = \think\Db::name('group_log_link')
	    ->field("g.*,link.log_id")
	    ->alias('link')
	    ->join("group g","g.tid = link.tid")
	    ->where('link.log_id',$logid)
	    ->where('g.status','1')
	    ->order('g.create_time','DESC')
	    ->paginate(10,false,['query'=>$_GET]);
	    
	    $list = $group->items();
	    $pages = $group->render();
	    
	    include $this->admin_tpl('group_log_groups','chat');
	}
	
	public function link(){
	    header("Content-Type: application/json; charset=utf-8");
	    $logid = intval($_GET['logid']);
	    $logkey = intval($_GET['logkey']);
	    $tid = intval($_GET['tid']);
	    $type = intval($_GET['type']);
	    
	    if(empty($tid)){
	        exit(json_encode(['code'=>501,'msg'=>'参数错误','data'=>'']));
	    }
	    
	    if($type == 1){
	        $log = \think\Db::name('group_log')->where('id',$logid)->whereOr('id', $logkey)->find();
	        if(empty($log)){
	            exit(json_encode(['code'=>502,'msg'=>'日志不存在','data'=>'']));
	        }
	        $count = \think\Db::name('group_log_link')->where(['tid'=>$tid,'log_id'=>$log['id']])->count();
	        if($count<=0){
	            \think\Db::name('group_log_link')->insert(['tid'=>$tid,'log_id'=>$log['id']]);
	        }
	    }
	    else{
	        \think\Db::name('group_log_link')->where(['tid'=>$tid,'log_id'=>$logid])->delete();
	    }
	    exit(json_encode(['code'=>1,'msg'=>'操作成功','data'=>'']));
	}
	
	public function edit_link(){
	    header("Content-Type: application/json; charset=utf-8");
	    $id = intval($_GET['id']);
	    $logid = intval($_GET['logid']);
	    $logkey = intval($_GET['logkey']);
	    
	    if(empty($id)){
	        exit(json_encode(['code'=>0,'msg'=>'参数错误','data'=>'']));
	    }
	    
	    $log = \think\Db::name('group_log')->where('id',$logid)->whereOr('id', $logkey)->find();
	    if(empty($log)){
	        exit(json_encode(['code'=>0,'msg'=>'日志不存在','data'=>'']));
	    }
	    
	    \think\Db::name('group_log_link')->where(['id'=>$id])->setField('log_id',$log['id']);
	    
	    exit(json_encode(['code'=>1,'msg'=>'操作成功','data'=>'']));
	}
	
	public function delete_link(){
	    $id = $_REQUEST['id'];
	    if(is_array($id)){
	        \think\Db::name('group_log_link')->whereIn('id',$id)->delete();
	    }
	    else{
	        $id = intval($id);
	        \think\Db::name('group_log_link')->where('id',$id)->delete();
	    }
	    
	    header("Location:".HTTP_REFERER);
	}
	
	public function log_json(){
	    header("Content-Type: application/json; charset=utf-8");
	    
	    $query = htmlspecialchars($_REQUEST['query']);
	    
	    $list = \think\Db::name('group_log')->field('title as value,id as data')->whereLike('title',"%$query%")->limit(10)->select();
	    
	    foreach ($list as $key=>$val){
	        $list[$key]['value'] = "[ID:".$val['data']."]".$val['value'];
	    }
	    
	    exit(json_encode(['query'=>'','suggestions'=>$list]));
	}
}
?>