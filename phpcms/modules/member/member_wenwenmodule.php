<?php
/**
	用户擅长类型管理
*/

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class member_wenwenmodule extends admin {
	
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('wenwen_module_model');
	}

	/**
	 * 首页
	 */
	function init() {
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member_wenwenmodule&a=add\', title:\''.L('add').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add'));
		include $this->admin_tpl('member_wenwenmodule');
	}
	
	/**
	 * 列表
	 */
	function manage() {
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$member_group_list = $this->db->listinfo('', 'sort ASC', $page, 15);
		$this->member_db = pc_base::load_model('member_model');
		//TODO 此处循环中执行sql，会严重影响效率，稍后考虑在memebr_group表中加入会员数字段和统计会员总数功能解决。
		foreach ($member_group_list as $k=>$v) {
			$membernum = $this->member_db->count(array('usertype'=>$v['fid']));
			$member_group_list[$k]['membernum'] = $membernum;
		}
		$pages = $this->db->pages;
		
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=member&c=member_wenwenmodule&a=add\', title:\''.L('add').'\', width:\'500\', height:\'300\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add'));
		include $this->admin_tpl('member_wenwenmodule');
	}
			
	/**
	 * 添加
	 */
	function add() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			if(!$this->_checkname($_POST['info']['name'])){
				showmessage('名称已经存在');
			}
			$info = $_POST['info'];

			$this->db->insert($info);
			if($this->db->insert_id()){
				showmessage(L('operation_success'),'', '', 'add');
			}
		} else {
			$show_header = $show_scroll = true;
			include $this->admin_tpl('member_wenwenmodule_add');
		}
		
	}
	
	/**
	 * 修改
	 */
	function edit() {
		if(isset($_POST['dosubmit'])) {
			$info = array();
			$info = $_POST['info'];
			$info['issystem']=$info['issystem'] ? 1 : 0;
			$this->db->update($info, array('fid'=>$info['fid']));
			showmessage(L('operation_success'), '', '', 'edit');
		} else {					
			$show_header = $show_scroll = true;
			$fid = isset($_GET['fid']) ? $_GET['fid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			
			$groupinfo = $this->db->get_one(array('fid'=>$fid));
			include $this->admin_tpl('member_wenwenmodule_edit');		
		}
	}
	
	/**
	 * 排序
	 */
	function sort() {		
		if(isset($_POST['sort'])) {
			foreach($_POST['sort'] as $k=>$v) {
				$this->db->update(array('sort'=>$v), array('fid'=>$k));
			}
			

			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}
	/**
	 * 删除
	 */
	function delete() {	
		$groupidarr = isset($_POST['fid']) ? $_POST['fid'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
		$where = to_sqls($groupidarr, '', 'fid');
		if ($this->db->delete($where)) {
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}
	}

	/**
	 * 检查用户名是否合法
	 * @param string $name
	 */
	private function _checkname($name = NULL) {
		if(empty($name)) return false;
		if ($this->db->get_one(array('name'=>$name),'fid')){
			return false;
		}
		return true;
	}
	
	/**
	 * 更新列表缓存
	 */
	private function _updatecache() {
		$groupmodulelist = $this->db->listinfo('', '', 1, 1000, 'fid');
		setcache('groupmodulelist', $groupmodulelist);
	}
	
	public function public_checkname_ajax() {
		$name = isset($_GET['name']) && trim($_GET['name']) ? trim($_GET['name']) : exit(0);
		$name = iconv('utf-8', CHARSET, $name);
		
		if ($this->db->get_one(array('name'=>$name),'fid')){
			exit('0');
		} else {
			exit('1');
		}
	}

}
?>