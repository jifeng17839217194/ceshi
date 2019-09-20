<?php
/**
 * 管理员后台会员审核操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('sendsms');
pc_base::load_sys_class('yunxin', '', 0);
class member_verify extends admin {
	
	private $db, $member_db;
	
	function __construct() {
		parent::__construct();
		$this->member_db = pc_base::load_model('member_model');
		$this->db = pc_base::load_model('member_verify_model');
		$this->groupdb = pc_base::load_model('member_group_model');
		$this->userdata = pc_base::load_model('member_data_model');
		$this->wenwenmoduledb = pc_base::load_model('wenwen_module_model');
		$this->areadb = pc_base::load_model('linkage_model');
	}
	
	/**
	 * defalut
	 */
	function init() {
		include $this->admin_tpl('member_init');
	}
	
	/**
	 * member list
	 */
	function manage() {
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$group=$this->groupdb->listinfo('','groupid desc',$page,10);
		foreach ($group as $key=>$v){
			$grouparray[$v['groupid']]=$v['name'];
		}
		//用户擅长类型
		$groupmodulelist = $this->wenwenmoduledb->select('', $data='fid,name');
		foreach($groupmodulelist as $_key=>$_value) {
			$wenmodulelist[$_value['fid']] = $_value['name'];
		}
		$memberlist = $this->db->listinfo($where, 'regdate DESC', $page, 5);
		foreach($memberlist as $key=>$v){
			if($v['sex']=='m'){
				$memberlist[$key]['sex']= '男';
			}elseif($v['sex']=='f'){
				$memberlist[$key]['sex']= '女';
			}else{
				$memberlist[$key]['sex']= '';
			}
			$skill=explode(',',$memberlist[$key]['skill']);
			foreach($skill as $val){
				$skillname[]=$wenmodulelist[$val];
			}
			$memberlist[$key]['skill']=implode(' ',$skillname);
		}
		$pages = $this->db->pages;
		include $this->admin_tpl('member_verify');
	}
	function search() {
		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$status = isset($_GET['status']) ? $_GET['status'] : 99;
		if (isset($_GET['search'])) {
			$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
			$end_time = isset($_GET['end_time']) ? $_GET['end_time'] :'';
			$where = '';
			if($status=='99') {
				$where .= " 1 AND ";
			}else{
				$where .= "`status` = '$status' AND ";
			}
			if($start_time && $end_time){
				$where .= "`regdate` > ".strtotime($start_time)." AND `regdate` < ".strtotime($end_time)." AND ";
			}elseif($end_time){
				$where .= " `regdate` < ".strtotime($end_time)."  AND ";
			}elseif($start_time){
				$where .= " `regdate` > ".strtotime($start_time)."  AND ";
			}else{
				$where .= " 1 AND ";
			}
			if($keyword) {
				if ($type == '1') {
					$where .= "`mobile` LIKE '%$keyword%'";
				} elseif($type == '2') {
					$where .= "`nickname` LIKE '%$keyword%'";
				} else {
					$where .= "`mobile` like '%$keyword%'";
				}
			} else {
				$where .= '1';
			}
			
		}else{
			$where = '';
		}
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$group=$this->groupdb->listinfo('','groupid desc',$page,10);
		foreach ($group as $key=>$v){
			$grouparray[$v['groupid']]=$v['name'];
		}
		//用户擅长类型
		$groupmodulelist = $this->wenwenmoduledb->select('', $data='fid,name');
		foreach($groupmodulelist as $_key=>$_value) {
			$wenmodulelist[$_value['fid']] = $_value['name'];
		}
		$memberlist = $this->db->listinfo($where, 'id DESC', $page, 5);
		foreach($memberlist as $key=>$v){
			if($v['sex']=='m'){
				$memberlist[$key]['sex']= '男';
			}else{
				$memberlist[$key]['sex']= '女';
			}
			$skill=explode(',',$memberlist[$key]['skill']);
			foreach($skill as $val){
				$skillname[]=$wenmodulelist[$val];
			}
			$memberlist[$key]['skill']=implode(' ',$skillname);
		}
		$pages = $this->db->pages;
		include $this->admin_tpl('member_verify');
	}
	function modelinfo() {
		$userid = !empty($_GET['userid']) ? intval($_GET['userid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$modelid = !empty($_GET['modelid']) ? intval($_GET['modelid']) : showmessage(L('illegal_parameters'), HTTP_REFERER);
		
		$memberinfo = $this->db->get_one(array('userid'=>$userid));
		//模型字段名称
		$this->member_field_db = pc_base::load_model('sitemodel_field_model');
		$model_fieldinfo = $this->member_field_db->select(array('modelid'=>$modelid), "*", 100);
		//用户模型字段信息
		$member_fieldinfo = string2array($memberinfo['modelinfo']);
		//交换数组key值
		foreach($model_fieldinfo as $v) {
			if(array_key_exists($v['field'], $member_fieldinfo)) {
				$tmp = $member_fieldinfo[$v['field']];
				unset($member_fieldinfo[$v['field']]);
				$member_fieldinfo[$v['name']] = $tmp;
				unset($tmp);
			}
		}
		include $this->admin_tpl('member_verify_modelinfo');
	}
		
	/**
	 * 批量通过专家申请(未启用)
	 */
	function pass() {
		if (isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'mobile');
			$userarr = $this->db->listinfo($where);
			$success_uids = array();
			foreach($userarr as $key=>$v) {
				$status = $this->member_db->get_one(array('username'=>$v['mobile']));
				$message=str_replace('@',$v['mobile'],'恭喜您成为蜂博士的认证专家。请使用@手机号登录蜂博士为蜂农答疑解惑。');
				if (!$status) {
					$basicinfo['username'] = $v['mobile'];
					$basicinfo['nickname'] = $v['nickname'];
					$basicinfo['email'] = $v['email'] ? $v['email']:'';
					$basicinfo['mobile'] = $v['mobile'];
					$basicinfo['avatar'] = $v['avatar'];
					$basicinfo['regip'] = ip();	
					$basicinfo['regdate'] = SYS_TIME;
					$basicinfo['lastlogindate'] = SYS_TIME;
					$basicinfo['status'] = 99;
					$basicinfo['usertype'] = $v['usertype'];
					$basicinfo['grade'] = $v['grade']?$v['grade']:1;
					$basicinfo['sn'] = create_order_number();
					$basicinfo['expbegintime'] = SYS_TIME;
					$this->member_db->insert($basicinfo);
					$otherinfo['userid'] = $this->member_db->insert_id();
					$otherinfo['birthday'] = $v['birthday'];
					$otherinfo['sex'] = $v['sex'];
					$otherinfo['idcard'] = $v['idcard'];
					$otherinfo['introduction'] = $v['introduction'];
					$otherinfo['company'] = $v['company'];
					$otherinfo['duty'] = $v['duty'];
					$otherinfo['skill'] = $v['skill'];
					$otherinfo['province'] = $v['province'];
					$otherinfo['city'] = $v['city'];
					$otherinfo['county'] = $v['county'];
					$otherinfo['street'] = $v['street'];
					$otherinfo['address'] = $v['address'];
					$this->userdata->insert($otherinfo);
				}elseif(!in_array($status['usertype'],array(9,10,11))){
					//更新用户表
					$basicinfo['nickname'] = $v['nickname'];
					$basicinfo['email'] = $v['email'] ? $v['email']:'';
					$basicinfo['mobile'] = $v['mobile'];
					$basicinfo['status'] = 99;
					$basicinfo['usertype'] = $v['usertype'];
					$basicinfo['grade'] = $v['grade']?$v['grade']:1;
					$basicinfo['expbegintime'] = SYS_TIME;
					$this->member_db->update($basicinfo,array('username'=>$v['mobile']));
					$otherinfo['birthday'] = $v['birthday'];
					$otherinfo['sex'] = $v['sex'];
					$otherinfo['idcard'] = $v['idcard'];
					$otherinfo['introduction'] = $v['introduction'];
					$otherinfo['company'] = $v['company'];
					$otherinfo['duty'] = $v['duty'];
					$otherinfo['skill'] = $v['skill'];
					$otherinfo['province'] = $v['province'];
					$otherinfo['city'] = $v['city'];
					$otherinfo['county'] = $v['county'];
					$otherinfo['street'] = $v['street'];
					$otherinfo['address'] = $v['address'];
					$this->userdata->update($otherinfo,array('userid'=>$status['userid']));
				}
				
			}		
			$this->db->update(array('status'=>1, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), $where);
			
	
			if($_POST['sendsms']) {
				$memberinfo = $this->db->select($where);
				$up = new sendsms();
				foreach ($memberinfo as $v) {
					if(!in_array($v['usertype'],array(9,10,11))){
						$smadata=$up->send($message,$v['mobile']);
					}
				}
			}
			showmessage(L('pass').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/**
	 * 通过专家申请(单用户)
	 */
	function passsingle() {
		header("Access-Control-Allow-Origin: *");
		$id = isset($_GET['mpid']) ? $_GET['mpid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$v = $this->db->get_one(array('id'=>$id));
		$status = $this->member_db->get_one(array('username'=>$v['mobile']));
		if(in_array($status['usertype'],array(9,10,11))){
			exit('2');
		}
		$message=str_replace('@',$v['mobile'],'恭喜您成为蜂博士的认证专家。请使用@手机号登录蜂博士为蜂农答疑解惑。');
		// 用户不存在
		if (!$status) {
			$basicinfo['username'] = $v['mobile'];
			$basicinfo['nickname'] = $v['nickname'];
			$basicinfo['email'] = $v['email'] ? $v['email']:'';
			$basicinfo['mobile'] = $v['mobile'];
			$basicinfo['avatar'] = $v['avatar'];
			$basicinfo['regip'] = ip();	
			$basicinfo['regdate'] = SYS_TIME;
			$basicinfo['lastlogindate'] = SYS_TIME;
			$basicinfo['status'] = 99;
			$basicinfo['usertype'] = $v['usertype'] ? $v['usertype']: 10;
			$basicinfo['grade'] = $v['grade']?$v['grade']:1;
			$basicinfo['sn'] = create_order_number();
			$basicinfo['expbegintime'] = SYS_TIME;
			$accid = md5($_POST['info']['username'].pc_base::load_config('system','app_key').uniqid());
			$basicinfo['accid'] = $accid;
			$result = yunxin::userCreate($accid, $basicinfo['nickname']);
			$basicinfo['token'] = empty($result['info']['token'])?"":$result['info']['token'];
			$this->member_db->insert($basicinfo);
			$otherinfo['userid'] = $this->member_db->insert_id();
			$otherinfo['birthday'] = $v['birthday'];
			$otherinfo['sex'] = $v['sex'];
			$otherinfo['idcard'] = $v['idcard'];
			$otherinfo['introduction'] = $v['introduction'];
			$otherinfo['company'] = $v['company'];
			$otherinfo['duty'] = $v['duty'];
			$otherinfo['skill'] = $v['skill'];
			$otherinfo['province'] = $v['province'];
			$otherinfo['city'] = $v['city'];
			$otherinfo['county'] = $v['county'];
			$otherinfo['street'] = $v['street'];
			$otherinfo['address'] = $v['address'];
			$this->userdata->insert($otherinfo);
		}elseif(!in_array($status['usertype'],array(9,10,11))){
			//更新用户表
			$sdata = $this->userdata->get_one(array('userid'=>$status['userid']));
			$basicinfo['nickname'] = $v['nickname'] ? $v['nickname']: $status['nickname'];
			$basicinfo['email'] = $v['email'] ? $v['email'] : $status['email'];
			$basicinfo['mobile'] = $v['mobile'] ? $v['mobile'] : $status['mobile'];
			$basicinfo['avatar'] = $v['avatar'] ? $v['avatar'] : $status['avatar'];
			$basicinfo['status'] = 99;
			$basicinfo['usertype'] = $v['usertype'] ? $v['usertype']: 10;
			$basicinfo['grade'] = $v['grade'] ? $v['grade'] : 1;
			$basicinfo['expbegintime'] = SYS_TIME;
			$accid = md5($_POST['info']['username'].pc_base::load_config('system','app_key').uniqid());
			$basicinfo['accid'] = $accid;
			$result = yunxin::userCreate($accid, $basicinfo['nickname']);
			$basicinfo['token'] = empty($result['info']['token'])?"":$result['info']['token'];
			$this->member_db->update($basicinfo,array('username'=>$v['mobile']));
			
			$otherinfo['birthday'] = $v['birthday'] ? $v['birthday'] : $sdata['birthday'];
			$otherinfo['sex'] = $v['sex'] ? $v['sex'] : $sdata['sex'];
			$otherinfo['idcard'] = $v['idcard'] ?  $v['idcard']:  $sdata['idcard'];
			if(!$sdata['introduction']){
				$otherinfo['introduction'] = $v['introduction'];
			}
			$otherinfo['company'] = $v['company'] ? $v['company']:$sdata['company'];
			$otherinfo['duty'] = $v['duty'] ? $v['duty']:$sdata['duty'];
			$otherinfo['skill'] = $v['skill'] ? $v['skill']:$sdata['skill'];
			$otherinfo['province'] = $v['province'] ? $v['province']:$sdata['province'] ;
			$otherinfo['city'] = $v['city']? $v['city'] : $sdata['city'];
			$otherinfo['county'] = $v['county']? $v['county']: $sdata['county'];
			$otherinfo['street'] = $v['street'] ? $v['street']:$sdata['street'];
			$otherinfo['address'] = $v['address'] ? $v['address']: $sdata['address'];
			$this->userdata->update($otherinfo,array('userid'=>$status['userid']));
		}
		$lastoper=$this->db->update(array('status'=>1, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), array('id'=>$id));
		// echo $this->db->lastsql();
		//发送短信
		$up = new sendsms();
		if(!in_array($status['usertype'],array(9,10,11))){
			$smadata=$up->send($message,$v['mobile']);
		}
		if($sdata['introduction'] && $v['introduction'] && $v['introduction']!=$sdata['introduction'] ){
			exit('6');
		}elseif($lastoper){
			exit('1');
		}else{
			exit('0');
		}
	}
	/**
	 * 删除
	 */
	function delete() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$message = stripslashes($_POST['message']);
			$where = to_sqls($uidarr, '', 'mobile');
			$this->db->delete($where);
						
			showmessage(L('delete').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/*
	 * 拒绝
	 */
	function reject() {
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'mobile');
			$message='抱歉，您因填写的信息不完善，蜂博士拒绝了您的认证专家申请。';
			$res = $this->db->update(array('status'=>4, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), $where);
			//发送短信通知
			if($res) {
				if($_POST['sendsms']) {
					$memberinfo = $this->db->select($where);	
					$up = new sendsms();
					foreach ($memberinfo as $v) {
						$smadata=$up->send($message,$v['mobile']);
					}
				}
			}
			
			showmessage(L('reject').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	
	/*
	 * 拒绝
	 */
	function rejectsingle() {
		header("Access-Control-Allow-Origin: *");
		if(isset($_GET['mpid'])) {
			$id = isset($_GET['mpid']) ? $_GET['mpid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$message='抱歉，您因填写的信息不完善，蜂博士拒绝了您的认证专家申请。';
			$exp=$this->db->get_one(array('id'=>$id));
			$status = $this->member_db->get_one(array('username'=>$exp['mobile']));
			if(in_array($status['usertype'],array(9,10,11))){
				$this->db->update(array('status'=>2, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), array('id'=>$id));
				exit('2');
			}
			$res = $this->db->update(array('status'=>4, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), array('id'=>$id));
			if($res) {
				$memberinfo = $this->db->get_one(array('id'=>$id));
				$up = new sendsms();
				$smadata=$up->send($message,$memberinfo['mobile']);
			}
			exit('1');
		} else {
			exit('0');
		}
	}

	/**
	 * 忽略
	 */
	function ignore() {
		header("Access-Control-Allow-Origin: *");
		$message=$_GET['message'];
		if(isset($_GET['mpid'])) {
			$id = isset($_GET['mpid']) ? $_GET['mpid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$message=$message ? $message :'';
			$res = $this->db->update(array('status'=>2, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), array('id'=>$id));
			if($res) {
				$memberinfo = $this->db->get_one(array('id'=>$id));
				//$up = new sendsms();
				//$smadata=$up->send($message,$memberinfo['mobile']);
			}
			exit('1');
		} else {
			exit('0');
		}
		/*
		if(isset($_POST['userid'])) {
			$uidarr = isset($_POST['userid']) ? $_POST['userid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$where = to_sqls($uidarr, '', 'mobile');
			$message='抱歉，您因填写的信息不完善，蜂博士拒绝了您的认证专家申请。';
			$res = $this->db->update(array('status'=>2, 'message'=>$message,'checkdate'=>SYS_TIME,'manager'=>param::get_cookie('admin_username')), $where);
			if($res) {
				
				if($_POST['sendsms']) {
					$memberinfo = $this->db->select($where);	
					$up = new sendsms();
					foreach ($memberinfo as $v) {
						$smadata=$up->send($message,$v['mobile']);
					}
				}
			}
			showmessage(L('ignore').L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
		*/
	}
		
	/*
	 * change password
	 */
	function _edit_password($userid, $password){
		$userid = intval($userid);
		if($userid < 1) return false;
		if(!is_password($password))
		{
			showmessage(L('password_format_incorrect'));
			return false;
		}
		$passwordinfo = password($password);
		return $this->db->update($passwordinfo,array('userid'=>$userid));
	}
	
	private function _checkuserinfo($data, $is_edit=0) {
		if(!is_array($data)){
			showmessage(L('need_more_param'));return false;
		} elseif (!is_username($data['username']) && !$is_edit){
			showmessage(L('username_format_incorrect'));return false;
		} elseif (!isset($data['userid']) && $is_edit) {
			showmessage(L('username_format_incorrect'));return false;
		}  elseif (empty($data['email']) || !is_email($data['email'])){
			showmessage(L('email_format_incorrect'));return false;
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
	 *根据积分算出用户组
	 * @param $point int 积分数
	 */
	private function _get_usergroup_bypoint($point=0) {
		$groupid = 2;
		if(empty($point)) {
			$member_setting = getcache('member_setting');
			$point = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		}
		$grouplist = getcache('grouplist');
		
		foreach ($grouplist as $k=>$v) {
			$grouppointlist[$k] = $v['point'];
		}
		arsort($grouppointlist);

		//如果超出用户组积分设置则为积分最高的用户组
		if($point > max($grouppointlist)) {
			$groupid = key($grouppointlist);
		} else {
			foreach ($grouppointlist as $k=>$v) {
				if($point >= $v) {
					$groupid = $tmp_k;
					break;
				}
				$tmp_k = $k;
			}
		}
		return $groupid;
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
	 * check uername status
	 */
	public function checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		$username = iconv('utf-8', CHARSET, $username);
		
		$status = $this->client->ps_checkname($username);
		if($status == -4) {	//deny_register
			exit('0');
		}
		
		$status = $this->client->ps_get_member_info($username, 2);
		if (is_array($status)) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/**
	 * check email status
	 */
	public function checkemail_ajax() {
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);
		
		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//deny_register
			exit('0');
		}
				
		$status = $this->client->ps_get_member_info($email, 3);
		if(isset($_GET['phpssouid']) && isset($status['uid'])) {
			if ($status['uid'] == intval($_GET['phpssouid'])) {
				exit('1');
			}
		}

		if (is_array($status)) {
			exit('0');
		} else {
			exit('1');
		}
	}
}
?>