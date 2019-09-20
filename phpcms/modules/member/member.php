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

class member extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('member_model');
		$this->userdata = pc_base::load_model('member_data_model');
		$this->wenwenmoduledb = pc_base::load_model('wenwen_module_model');
		
	}
	
	/**
	 * defalut
	 */
	function init() {
		$show_header = $show_scroll = true;

		
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d', SYS_TIME-date('t', SYS_TIME)*86400);
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}
		$memberinfo['totalnum'] = $this->db->count();
		$todaytime = strtotime(date('Y-m-d', SYS_TIME));
		$memberinfo['today_member'] = $this->db->count("`regdate` > '$todaytime'");
		
		include $this->admin_tpl('member_init');
	}
	
	/**
	 * 会员搜索
	 */
	function search() {

		//搜索框
		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$action=$_GET['action'] ? $_GET['action'] : ROUTE_A;
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}
		if (isset($_GET['search'])) {
			$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
			$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
			$where = '';
			switch($status){
				
				case 1:
				$where .= "`islock` = 1 AND `status` = 99 AND";
				break;
				case 2:
				$where .= "`status` = 99 AND ";
				break;
				
				default:
				$where .= "`status` = 99 AND ";
				break;
				
			}
			if($groupid) {
				$where .= "`usertype` = '$groupid' AND ";
			}
			if(!$start_time){
				$where .= " `regdate` < ".strtotime($end_time)." AND ";
			}else{
				$where .= "`regdate` > ".strtotime($start_time)." AND `regdate` < ".strtotime($end_time)." AND ";
			}
			
			if($keyword) {
				if ($type == '1') {
					$where .= "`username` LIKE '%$keyword%'";
				} elseif($type == '2') {
					$where .= "`userid` LIKE '%$keyword%'";
				} elseif($type == '3') {
					$where .= "`email` like '%$keyword%'";
				} elseif($type == '4') {
					$where .= "`regip` LIKE '%$keyword%'";
				} elseif($type == '5') {
					$where .= "`nickname` LIKE '%$keyword%'";
				} else {
					$where .= "`username` like '%$keyword%'";
				}
			} else {
				$where .= '1';
			}
			
		}else{
			$where = '';
		}

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$memberlist = $this->db->listinfo($where, 'userid DESC', $page, 15);
		// echo $this->db->lastsql();
		$pages = $this->db->pages;
		$big_menu = array('?m=member&c=member&a=manage&menuid=72', L('member_research'));
		include $this->admin_tpl('member_list');
	}
	
	
	/**
	 * 专家搜索
	 */
	function expsearch() {

		//搜索框
		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$groupid = isset($_GET['groupid']) ? $_GET['groupid'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}
		// if($action=='expertmanage' || in_array($groupid,array(9,10,11))){
			unset($grouplist[1]);
		// }
		if (isset($_GET['search'])) {
			$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
			$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
			$where = '';
			switch($status){
				
				case 1:
				$where .= "`islock` = 1 AND `status` = 99 AND";
				break;
				case 2:
				$where .= "`status` = 99 AND ";
				break;
				
				default:
				$where .= "`status` = 99 AND ";
				break;
				
			}
			if($groupid) {
				$where .= "`usertype` = '$groupid' AND ";
			}else{
				$where .= "`usertype` IN(9,10,11) AND ";
			}
			if(!$start_time){
				$where .= " `regdate` < ".strtotime($end_time)." AND ";
			}else{
				$where .= "`regdate` > ".strtotime($start_time)." AND `regdate` < ".strtotime($end_time)." AND ";
			}
			
			if($keyword) {
				if ($type == '1') {
					$where .= "`username` LIKE '%$keyword%'";
				} elseif($type == '2') {
					$where .= "`userid` LIKE '%$keyword%'";
				} elseif($type == '3') {
					$where .= "`email` like '%$keyword%'";
				} elseif($type == '4') {
					$where .= "`regip` LIKE '%$keyword%'";
				} elseif($type == '5') {
					$where .= "`nickname` LIKE '%$keyword%'";
				} else {
					$where .= "`username` like '%$keyword%'";
				}
			} else {
				$where .= '1';
			}
			
		}else{
			$where = '';
		}

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$memberlist = $this->db->listinfo($where, 'userid DESC', $page, 15);
		// echo $this->db->lastsql();
		$pages = $this->db->pages;
		//用户擅长类型
		$groupmodulelist = $this->wenwenmoduledb->select('', $data='fid,name');
		foreach($groupmodulelist as $_key=>$_value) {
			$wenmodulelist[$_value['fid']] = $_value['name'];
		}
		$big_menu = array('?m=member&c=member&a=manage&menuid=72', L('member_research'));
		include $this->admin_tpl('member_searchexp_list');
	}
	/**
	 * member list
	 */
	function manage() {
		$groupid = isset($_GET['groupid']) ? intval($_GET['groupid']) : '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$where = array('status'=>99);
		$memberlist_arr = $this->db->listinfo($where, 'userid DESC', $page, 15);
		$pages = $this->db->pages;
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
		$grouplist = getcache('grouplist');
		// print_r($grouplist);
		foreach($grouplist as $k=>$v) {
			// if($v['groupid']==1){
				$grouplist[$k] = $v['name'];
			// }
		}
		//查询会员头像
		foreach($memberlist_arr as $k=>$v) {
			$memberlist[$k] = $v;
		}

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member&a=add\', title:\''.L('member_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('member_add'));
		include $this->admin_tpl('member_list');
	}
	
	function expertmanage() {
		$groupid = isset($_GET['groupid']) ? intval($_GET['groupid']) : '';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$where = " usertype in (9,10,11) and status=99 ";
		$memberlist_arr = $this->db->listinfo($where, 'userid DESC', $page, 15);
		$pages = $this->db->pages;
		//搜索框
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
		$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d', SYS_TIME);
		$grouplist = getcache('grouplist');
		foreach($grouplist as $k=>$v) {
			$grouplist[$k] = $v['name'];
		}
		
		unset($grouplist[1]);
		// print_r($grouplist);
		//查询会员头像
		foreach($memberlist_arr as $k=>$v) {
			$memberlist[$k] = $v;
		}
		//用户擅长类型
		$groupmodulelist = $this->wenwenmoduledb->select('', $data='fid,name');
		foreach($groupmodulelist as $_key=>$_value) {
			$wenmodulelist[$_value['fid']] = $_value['name'];
		}

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member&a=add\', title:\''.L('member_add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('member_add'));
		include $this->admin_tpl('member_searchexp_list');
	}
		
	/**
	 * add member
	 */
	function add() {
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			$info = array();
			if(!$this->_checkname($_POST['info']['username'])){
				showmessage(L('member_exist'));
			}
			$info = $this->_checkuserinfo($_POST['info']);
			if(!$this->_checkpasswd($info['password'])){
				showmessage(L('password_format_incorrect'));
			}
			$basicinfo['username'] = $_POST['info']['username'];
			$basicinfo['nickname'] = $_POST['info']['nickname'];
			$basicinfo['email'] = $_POST['info']['email'];
			$basicinfo['encrypt'] = create_randomstr();
			$basicinfo['password'] = password($_POST['info']['password'], $basicinfo['encrypt']);
			$basicinfo['mobile'] = $_POST['info']['username'];
			$basicinfo['regip'] = ip();	
			$basicinfo['regdate'] = SYS_TIME;
			$basicinfo['lastlogindate'] = SYS_TIME;
			$basicinfo['status'] = 99;
			$basicinfo['usertype'] = $_POST['info']['usertype'];
			$basicinfo['grade'] = $_POST['info']['grade'];
			$accid = md5($_POST['info']['username'].pc_base::load_config('system','app_key').uniqid());
			$basicinfo['accid'] = $accid;
			$result = yunxin::userCreate($accid, $basicinfo['nickname']);
			$basicinfo['token'] = empty($result['info']['token'])?"":$result['info']['token'];
			if(in_array($_POST['info']['usertype'],array(9,10,11))){
				$basicinfo['expbegintime'] = SYS_TIME;
			}
			$basicinfo['sn'] = create_order_number();
			$this->db->insert($basicinfo);

			$otherinfo['userid'] = $this->db->insert_id();
			$otherinfo['birthday'] = strtotime($_POST['info']['birthday']);
			$otherinfo['sex'] = $_POST['info']['sex'];
			$otherinfo['idcard'] = $_POST['info']['idcard'];
			$otherinfo['introduction'] = $_POST['info']['introduction'];
			$otherinfo['company'] = $_POST['info']['company'];
			$otherinfo['duty'] = $_POST['info']['duty'];
			$otherinfo['skill'] = implode(',',$_POST['info']['skill']);
			
			$datas = getcache(1,'linkage');
			$infos = $datas['data'];
			
			$otherinfo['province'] = $infos[$_POST['areaid-1']]['name'] ? $infos[$_POST['areaid-1']]['name'] :'';
			$otherinfo['city'] = $infos[$_POST['areaid-2']]['name'] ? $infos[$_POST['areaid-2']]['name'] : '';
			$otherinfo['county'] = $infos[$_POST['areaid-3']]['name'] ? $infos[$_POST['areaid-3']]['name'] :'';
			$otherinfo['street'] = $infos[$_POST['areaid-4']]['name'] ? $infos[$_POST['areaid-4']]['name'] : '';
			
			
			// $otherinfo['province'] = $_POST['areaid-1'];
			// $otherinfo['city'] = $_POST['areaid-2'];
			// $otherinfo['county'] = $_POST['areaid-3'];
			// $otherinfo['street'] = $_POST['areaid-4'];
			$otherinfo['address'] = $_POST['info']['address'];
			$this->userdata->insert($otherinfo);
			if($this->db->insert_id()){
				showmessage(L('operation_success'),'?m=member&c=member&a=add', '', 'add');
			}
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}
			//用户擅长类型
			$groupmodulelist = $this->wenwenmoduledb->select('issystem=0', $data='fid,name');
			foreach($groupmodulelist as $_key=>$_value) {
				$wenmodulelist[$_value['fid']] = $_value['name'];
			}
			//用户等级
			$userdegee=$this->getuserdegree();
			//用户性别
			$usersex=$this->getusersex();
			include $this->admin_tpl('member_add');
		}
		
	}
	function getuserdegree(){
		$arraytemp=array(1=>'初级',2=>'中级',3=>'高级');
		return $arraytemp;
	}
	function getusersex(){
		$arraytemp=array('m'=>'男','f'=>'女','u'=>'保密');
		return $arraytemp;
	}
	/**
	 * edit member
	 */
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$memberinfo = $info = array();
			
			//会员基本信息
			// $info = $this->_checkuserinfo($basicinfo, 1);
			$userid = $_POST['info']['userid'];
			$where = array('userid'=>$userid);
			$userinfo = $this->db->get_one($where);
			if(empty($userinfo)) {
				showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
			}

			//删除用户头像
			if(!empty($_POST['delavatar'])) {
				$this->db->update(array('avatar'=>''),array('userid'=>$userid));
				pc_base::load_sys_class('yunxin', '', 0);
				yunxin::updateAvatar($userinfo['accid']);
			}
			$basicinfo['encrypt']= $userinfo['encrypt']=$userinfo['encrypt'] ? $userinfo['encrypt'] : create_randomstr();
			if($_POST['info']['password'] && !$this->_checkpasswd($_POST['info']['password'])){
				showmessage(L('password_format_incorrect'));
			}elseif($_POST['info']['password']){
				$basicinfo['password'] = password($_POST['info']['password'], $userinfo['encrypt']);
			}else{
				
			}
			
			$basicinfo['nickname'] = $_POST['info']['nickname'];
			$basicinfo['email'] = $_POST['info']['email'];
			$basicinfo['mobile'] = $_POST['info']['mobile'];
			$basicinfo['lastlogindate'] = SYS_TIME;
			$basicinfo['usertype'] = $_POST['info']['usertype'];
			$basicinfo['grade'] = $_POST['info']['grade'];
			if($userinfo['expbegintime']==0 && in_array($_POST['info']['usertype'],array(9,10,11))){
				$basicinfo['expbegintime'] = SYS_TIME;
			}
			
			// print_r($basicinfo);
			$this->db->update($basicinfo,array('userid'=>$userid));
			
			yunxin::updateUser($userinfo['accid'], ['name'=>$basicinfo['nickname']]);

			$otherinfo['birthday'] = strtotime($_POST['info']['birthday']);
			$otherinfo['sex'] = $_POST['info']['sex'];
			$otherinfo['idcard'] = $_POST['info']['idcard'];
			$otherinfo['introduction'] = $_POST['info']['introduction'];
			$otherinfo['company'] = $_POST['info']['company'];
			$otherinfo['duty'] = $_POST['info']['duty'];
			$otherinfo['skill'] =implode(',',$_POST['info']['skill']);
			if($_POST['areaid-1']){
				$datas = getcache(1,'linkage');
				$infos = $datas['data'];
				$otherinfo['province'] = $infos[$_POST['areaid-1']]['name'] ? $infos[$_POST['areaid-1']]['name'] :'';
				$otherinfo['city'] = $infos[$_POST['areaid-2']]['name'] ? $infos[$_POST['areaid-2']]['name'] : '';
				$otherinfo['county'] = $infos[$_POST['areaid-3']]['name'] ? $infos[$_POST['areaid-3']]['name'] :'';
				$otherinfo['street'] = $infos[$_POST['areaid-4']]['name'] ? $infos[$_POST['areaid-4']]['name'] : '';
			}
			$otherinfo['address'] = $_POST['info']['address'];
			$this->userdata->update($otherinfo,array('userid'=>$userid));
			showmessage(L('operation_success'), '', '', 'edit');
			
		} else {
			$show_header = $show_scroll = true;
			$siteid = get_siteid();
			$userid = isset($_GET['userid']) ? $_GET['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			//会员组缓存
			$group_cache = getcache('grouplist', 'member');
			foreach($group_cache as $_key=>$_value) {
				$grouplist[$_key] = $_value['name'];
			}

			//用户擅长类型
			$groupmodulelist = $this->wenwenmoduledb->select('issystem=0', $data='fid,name');
			foreach($groupmodulelist as $_key=>$_value) {
				$wenmodulelist[$_value['fid']] = $_value['name'];
			}
			//用户等级
			$userdegee=$this->getuserdegree();
			//用户性别
			$usersex=$this->getusersex();
			//如果是超级管理员角色，显示所有用户，否则显示当前站点用户
			if($_SESSION['roleid'] == 1) {
				$where = array('userid'=>$userid);
			} else {
				$where = array('userid'=>$userid);
			}

			$memberinfo = $this->db->get_one($where);
			$otherinfo = $this->userdata->get_one($where);
			$memberinfo = array_merge($memberinfo,$otherinfo);
			extract($memberinfo);
			$memberinfo['birthday']=$memberinfo['birthday'] ? $memberinfo['birthday']:'';
			if(empty($memberinfo)) {
				showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
			}
			
			
			$show_dialog = 1;
			include $this->admin_tpl('member_edit');		
		}
	}
	function webcount(){
		$show_header = $show_scroll = true;
		$userid = isset($_GET['userid']) ? $_GET['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$memberinfo = $this->db->get_one($where);
		if(empty($memberinfo)) {
			showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
		}
		$temp_data=GetCurl(API_PATH.'homepage?personid='.$userid);
		// echo API_PATH.'homepage?uid='.$userid;
		$tempArray= json_decode($temp_data,true);
		
		if($tempArray['code']==200){
			$temp=$tempArray['data'];
			
		}else{
			$temp=array();
		}
		// $tempArray=$tempArray['data'];
		// print_r($temp);
		$show_dialog = 1;
		include $this->admin_tpl('member_webcount');
	}
	
	function avatar(){
		$show_header = $show_scroll = true;
		$userid = isset($_GET['userid']) ? $_GET['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$memberinfo = $this->db->get_one($where);
		if(empty($memberinfo)) {
			showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
		}
		$show_dialog = 1;
		include $this->admin_tpl('member_avatar');
	}
	
	function uploadavatar(){
		$userid = isset($_GET['userid']) ? $_GET['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$memberinfo = $this->db->get_one($where);
		if(empty($memberinfo)) {
			showmessage(L('user_not_exist').L('or').L('no_permission'), HTTP_REFERER);
		}
		$temp_data=GetCurl(API_PATH.'uploadatavar?avatar='.$_POST['avatar'].'&uid='.$userid);
		echo API_PATH.'uploadatavar?avatar='.$_POST['avatar'].'&uid='.$userid;
		$tempArray= json_decode($temp_data,true);
		print_r($tempArray);
		if($tempArray['code']==200){
			$temp=$tempArray['data'];
			
		}else{
			$temp=array();
		}
		
	}
	/**
	 * delete member
	 */
	function delete() {
		$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$uidarr = array_map('intval',$uidarr);
		$where = to_sqls($uidarr, '', 'userid');
		
		// $phpsso_userinfo = $this->db->listinfo($where);
		//查询用户信息
		$userinfo_arr = $this->db->select($where, "userid");
		// print_r($uidarr);
		if(is_array($userinfo_arr)) {
			foreach($uidarr as $val){
				$this->db->update(array('status'=>0),array('userid'=>$val));
			}
			$accids = \think\Db::name('user')->whereIn('userid',$uidarr)->column('accid');
			foreach ($accids as $accid){
			    yunxin::muteUser($accid,"true");
			}
			// echo $this->db->lastsql();
			
			// 执行软删除
			// $this->db->delete($where);
			// $this->userdata->delete($where);
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * lock member
	 */
	function lock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('islock'=>1), $where);
			$accids = \think\Db::name('user')->whereIn('userid',$uidarr)->column('accid');
			foreach ($accids as $accid){
			    $re = yunxin::muteUser($accid,"true");
			}
			showmessage(L('member_lock').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/**
	 * unlock member
	 */
	function unlock() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('islock'=>0), $where);
			$accids = \think\Db::name('user')->whereIn('userid',$uidarr)->column('accid');
			foreach ($accids as $accid){
			    yunxin::muteUser($accid,"false");
			}
			showmessage(L('member_unlock').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * move member
	 */
	function move() {
		if(isset($_POST['dosubmit'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$groupid = isset($_POST['groupid']) && !empty($_POST['groupid']) ? $_POST['groupid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			$where = to_sqls($uidarr, '', 'userid');
			$this->db->update(array('usertype'=>$groupid), $where);
			showmessage(L('member_move').L('operation_success'), HTTP_REFERER, '', 'move');
		} else {
			$show_header = $show_scroll = true;
			$grouplist = getcache('grouplist');
			foreach($grouplist as $k=>$v) {
				$grouplist[$k] = $v['name'];
			}
			
			$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']): showmessage(L('illegal_parameters'), HTTP_REFERER);
			array_pop($ids);
			if(!empty($ids)) {
				$where = to_sqls($ids, '', 'userid');
				$userarr = $this->db->listinfo($where);
			} else {
				showmessage(L('illegal_parameters'), HTTP_REFERER, '', 'move');
			}
			
			include $this->admin_tpl('member_move');
		}
	}

	function memberinfo() {
		$show_header = false;
		$userid = !empty($_GET['userid']) ? intval($_GET['userid']) : '';
		if(!empty($userid)) {
			$memberinfo = $this->db->get_one(array('userid'=>$userid));
		} else {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
		if(empty($memberinfo)) {
			showmessage(L('user').L('not_exists'), HTTP_REFERER);
		}
		$show_header = $show_scroll = true;
		$siteid = get_siteid();
		
		
		//会员组缓存
		$group_cache = getcache('grouplist', 'member');
		foreach($group_cache as $_key=>$_value) {
			$grouplist[$_key] = $_value['name'];
		}

		//用户擅长类型
		$groupmodulelist = $this->wenwenmoduledb->select('', $data='fid,name');
		foreach($groupmodulelist as $_key=>$_value) {
			$wenmodulelist[$_value['fid']] = $_value['name'];
		}
		//用户等级
		$userdegee=$this->getuserdegree();
		//用户性别
		$usersex=$this->getusersex();
		$where = array('userid'=>$userid);
		

		// $memberinfo = $this->db->get_one($where);
		$otherinfo = $this->userdata->get_one($where);
		$memberinfo = array_merge($memberinfo,$otherinfo);
		extract($memberinfo);
		if(empty($memberinfo)) {
			showmessage('用户数据不完整');
		}
		$skill=explode(',',$memberinfo['skill']);
		foreach($skill as $v){
			$mem[]=$wenmodulelist[$v];
		}
		$memberinfo['skill']=implode(',',$mem);
		$show_dialog = 1;
		include $this->admin_tpl('member_moreinfo');
	}

	/*
	 * 通过linkageid获取名字路径
	 */
	private function _get_linkage_fullname($linkageid,  $linkagelist) {
		$fullname = '';
		if($linkagelist['data'][$linkageid]['parentid'] != 0) {
			$fullname = $this->_get_linkage_fullname($linkagelist['data'][$linkageid]['parentid'], $linkagelist);
		}
		//所在地区名称
		$return = $fullname.$linkagelist['data'][$linkageid]['name'].'>';
		return $return;
	}
	
	private function _checkuserinfo($data, $is_edit=0) {
		if(!is_array($data)){
			showmessage(L('need_more_param'));return false;
		} elseif (!is_username($data['username']) && !$is_edit){
			showmessage(L('username_format_incorrect'));return false;
		} elseif (!isset($data['userid']) && $is_edit) {
			showmessage(L('username_format_incorrect'));return false;
		}
		return $data;
	}
		
	private function _checkpasswd($password){
		if (!is_password($password)){
			return false;
		}
		return true;
	}
	
	private function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}
	
	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}
	
	/**
	 * 检查用户名
	 * @param string $username	用户名
	 * @return $status {-4：用户名禁止注册;-1:用户名已经存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}

		$status = $this->db->get_one(array('username'=>$username));
			
		if($status) {
			exit('0');
		} else {
			exit('1');
		}
		
	}
	
	/**
	 * 检查邮箱
	 * @param string $email
	 * @return $status {-1:email已经存在 ;-5:邮箱禁止注册;1:成功}
	 */
	public function public_checkemail_ajax() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//禁止注册
			exit('0');
		} elseif($status == -1) {	//用户名已存在，但是修改用户的时候需要判断邮箱是否是当前用户的
			if(isset($_GET['phpssouid'])) {	//修改用户传入phpssouid
				$status = $this->client->ps_get_member_info($email, 3);
				if($status) {
					$status = unserialize($status);	//接口返回序列化，进行判断
					if (isset($status['uid']) && $status['uid'] == intval($_GET['phpssouid'])) {
						exit('1');
					} else {
						exit('0');
					}
				} else {
					exit('0');
				}
			} else {
				exit('0');
			}
		} else {
			exit('1');
		}
	}
	
}
?>