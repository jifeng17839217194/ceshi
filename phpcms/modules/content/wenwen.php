<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
class wenwen extends admin {
	private $wendb,$postdb;
	public $siteid;
	public function __construct() {
		parent::__construct();
		$this->wendb = pc_base::load_model('wenwen_model');
		$this->postdb = pc_base::load_model('wenpost_model');
		$this->forum=pc_base::load_model('wenwen_module_model');
		$this->member_db = pc_base::load_model('member_model');
	}
	//最新问题列表
	public function init()
	{
		$keyword = isset($_GET['keyword']) && $_GET['keyword'] ? trim($_GET['keyword']) :'';
		$author = isset($_GET['author']) && $_GET['author'] ? trim($_GET['author']) :'';
		$zuowu = isset($_GET['zuowu']) && $_GET['zuowu'] ? $_GET['zuowu'] :'';
		$status = isset($_GET['status']) && $_GET['status'] ? $_GET['status'] :'99';
		$start_time = $_GET['search']['start_time'];
		$end_time=isset($_GET['search']['end_time'])&& $_GET['search']['end_time'] ? $_GET['search']['end_time'] : SYS_TIME;
		if($start_time && $end_time)
		{
			$start = strtotime($start_time);
			$end = strtotime($end_time);
			$wherereg = "`dateline` >= '$start' AND `dateline` <= '$end' ";
		}else{
			$wherereg=1;
		}
		if($author){
			$ausql=" username='".$author."' ";
		}else{
			$ausql=1;
		}
		switch($status)
		{
			// 正常显示状态 0，删除为1 关闭为2 精华为3 置顶为4  审核为 9
			case 99:
				$rsql="1";
				break;
			case 15:
				$rsql="replies>0";
				break;
				
			case 999:
				$rsql="replies>0 and status!=2";
				break;
				
			case 25:
				$rsql="replies='0'";
				break;
				
			case 2:
				$rsql="status='2'";
				break;
			case 3:
				$rsql="status='3'";
				break;
			case 4:
				$rsql="status='4'";
				break;
			case 9:
				$rsql="status='9'";
				break;

		}
		$datazuo= $this->GetFormArray();
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		if($zuowu)
		{
			$infos = $this->wendb->listinfo(" fid=".$zuowu." and ".$rsql." and ".$ausql." and ".$wherereg." and content like '%".$keyword."%'",$order = 'tid desc',$page, $pages = '12');
		}else{
			$infos = $this->wendb->listinfo(" ".$wherereg." and ".$rsql."  and ".$ausql." and content like '%".$keyword."%'",$order = 'tid desc',$page, $pages = '12');
		}
		foreach($infos as $key=>$v){
			if($v['replies']>0){
				$infos[$key]['wenstatus']=$this->getwenstatus($v['status']);
			}elseif($v['status']==2){
				$infos[$key]['wenstatus']=$this->getwenstatus($v['status']);
			}else{
				$infos[$key]['wenstatus']="<span class='glyphicon glyphicon-question-sign' style='color:red'>待解答</span>";
			}
			
			$infos[$key]['attachment']=count(string2array($v['attachment']))>0 ? count(string2array($v['attachment'])) : 0;
			
			if($v['expertid']){
				$r=$this->member_db->get_one(array('userid'=>$v['expertid']));
				$infos[$key]['expertid']=$r['nickname'];
			}else{
				$infos[$key]['expertid']='';
			}
			
				
		}
		$pages = $this->wendb->pages;
		include $this->admin_tpl('thread_list');
	}
	//问题status 正常显示状态 0，删除为1 关闭为2 精华为3 置顶为4 审核为 9
	private function getwenstatus($status){
		$tempArray=array(
		'1'=>"<span class='glyphicon glyphicon-minus-sign' style='color:red'>删除</span>",
		'2'=>"<span class='glyphicon glyphicon-lock' style='color:red'>关闭</span>",
		'3'=>"<span class='glyphicon gglyphicon-thumbs-up' style='color:red'>精华</span>",
		'4'=>"<span class='glyphicon glyphicon-circle-arrow-up' style='color:green'>置顶</span>",
		'0'=>"<span class='glyphicon glyphicon-ok-circle' style='color:black'>正常</span>",
		'9'=>"<span class='glyphicon glyphicon-exclamation-sign' style='color:orange'>审核</span>"
		);
		// print_r($tempArray);
		return $tempArray[$status];
	}
	//最新回复列表
	public function managepost()
	{
		$keyword = isset($_GET['keyword']) && $_GET['keyword'] ? trim($_GET['keyword']) :'';
		$searchtype = isset($_GET['searchtype']) && $_GET['searchtype'] ? trim($_GET['searchtype']) : 1;
		$zuowuid = isset($_GET['zuowu']) && $_GET['zuowu'] ? $_GET['zuowu'] :'';
		$start_time = $_GET['search']['start_time'];
		$end_time=isset($_GET['search']['end_time'])&& $_GET['search']['end_time'] ? $_GET['search']['end_time'] : '';
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$wheresql=array();
		
		switch($searchtype){
			case 1:
			if($keyword){
				$tidarr=$this->wendb->select(" content like '%".$keyword."%' ",'tid');
				if(!empty($tidarr)){
					// print_r($tidarr);
					$tidarr=implode(',',array_column($tidarr,'tid'));
					$wheresql[]=" tid in(".$tidarr.") ";
				}else{
					$wheresql[]=" tid=0";
				}
			}
			
			break;
			case 2:
			$wheresql[]=" username like '%".$keyword."%' ";
			break;
			case 3:
			$wheresql[]=" message like '%".$keyword."%' ";
			break;
			default:
			$wheresql[]=array();
			break;
		}
		if($start_time && $end_time)
		{
			$start = strtotime($start_time);
			$end = strtotime($end_time.' 23:59:59');
			$wheresql[]= " dateline >= $start ANDdateline <= $end ";
		}elseif($start_time){
			$start = strtotime($start_time);
			$wheresql[]= " dateline >= $start ";
		}elseif($end_time){
			$end = strtotime($end_time.' 23:59:59');
			$wheresql[]=" dateline <= $end ";
		}
		if($zuowuid){
			$wheresql[]=" fid=$zuowuid	";
		}
		$sqlwhere=implode(' AND ',$wheresql);
			
		$infos = $this->postdb->listinfo($sqlwhere,$order = 'pid desc',$page, $pages = '10');
		// echo $this->postdb->lastsql();
		foreach($infos as $key=>$val){
			$r=$this->member_db->get_one(array('userid'=>$val['userid']));
			$infos[$key]['nickname']=$r['nickname'];
			$infos[$key]['mobile']=$r['mobile'];
			
			$t=$this->wendb->get_one(array('tid'=>$val['tid']));
			$infos[$key]['content']=$t['content'];
		}
		$pages = $this->postdb->pages;
		$datazuo= $this->GetFormArray();
		include $this->admin_tpl('thread_post_list');
	}
	//编辑回复
	public function editanswer()
	{
		$id=intval($_GET['id']) ? intval($_GET['id']) : '';
		if(!$id) return false;
		if(isset($_POST['dosubmit']))
		{
			$content=$_POST['info']['content'];
			$this->postdb->update(array('message'=>$content),array('pid'=>$id));
			showmessage(L("operation_success"),'','','editanswer');
			// showmessage(L("operation_success").L('2s_close'),'blank','','','function set_time() {$("#secondid").html(1);}setTimeout("set_time()", 500);setTimeout("window.close()", 1200);');
		}else{
			
			$rowname = $this->postdb->get_one(array('pid'=>$id));
			include  $this->admin_tpl('thread_editanswer');
		}
	}
	
	//回复删除
	public function delanswer(){
		if(count($_POST['pid'])==0)
			{
				showmessage(L('illegal_parameters'),HTTP_REFERER);
			}
			if(is_array($_POST['pid']))
			{
				foreach($_POST['pid'] as $ids)
				{
					$data_tid=$this->postdb->get_one(array('pid'=>$ids));
					$this->wendb->update(array('replies'=>'-=1'),array('tid'=>$data_tid['tid']));
					$this->postdb->delete(array('pid'=>$ids));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}
	}
	//回复推荐
	public function setelitepost(){
		if(count($_POST['pid'])==0)
			{
				showmessage(L('illegal_parameters'),HTTP_REFERER);
			}
			if(is_array($_POST['pid']))
			{
				$status=$_GET['status'];
				foreach($_POST['pid'] as $ids)
				{
					$p=$this->postdb->get_one(array('pid'=>$ids));
					//信息提示专家20180515
					$notification['type']='rec';
					$notification['new']='1';
					$notification['dateline']=SYS_TIME;
					$notification['from_id']=$p['tid'];
					$notification['from_num']='1';
					$notification['userid']=$p['userid'];
					$notification['note']=$p['message'];
					$notification['content']='';
					$notification['from_idtype']='system';
					$notification['authorid']=$p['userid'];
					$notification['author']=$p['username'];
					$this->db_notification = pc_base::load_model('notification_model');
					$data_notifi=$this->db_notification->get_one(array('userid'=>$p['userid'],'type'=>'rec','from_id'=>$p['tid']));
					if(empty($data_notifi))
					{
						$this->db_notification->insert($notification,true);
					}
					$this->postdb->update(array('elite'=>$status),array('pid'=>$ids));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}
	}
	//问题编辑
	public function edit()
	{
		if (isset($_POST['dosubmit']))
		{
			$tid = intval($_GET['tid']);
			if($tid < 1) return false;
			// 正常显示状态 0，删除为1 关闭为2 精华为3 置顶为4  审核为 9
			
			$data = $this->wendb->get_one(array('tid'=>$tid));
			if($data['status']==1){
				showmessage('问题不存在或已删除',HTTP_REFERER);
			}elseif($data){
				$fid =$_POST['info']['fid'];
				$this->wendb->update(array('expertid'=>$_POST['info']['expertid'],'content'=>$_POST['info']['content'],'fid'=>$fid),array('tid'=>$tid));
				//信息提示专家
				if($_POST['info']['expertid'])
				{
					
					$notification['type']='invite';
					$notification['new']='1';
					$notification['dateline']=SYS_TIME;
					$notification['from_id']=$tid;
					$notification['from_num']='1';
					$notification['userid']=$_POST['info']['expertid'];
					$notification['note']=$data['content'];
					$notification['content']='';
					$notification['from_idtype']='system';
					$notification['authorid']=$data['userid'];
					$notification['author']=$data['username'];
					$this->db_notification = pc_base::load_model('notification_model');
					$data_notifi=$this->db_notification->get_one(array('userid'=>$_POST['info']['expertid'],'type'=>'invite','from_id'=>$tid));
					if(empty($data_notifi))
					{
						$this->db_notification->insert($notification,true);
					}
					
				}
				// showmessage(L("operation_success"),HTTP_REFERER);
				showmessage(L("operation_success"),'','','editwen');
			}else{
				showmessage(L("missing_part_parameters"),HTTP_REFERER);
			}
			
		}
		else
		{
			$tid = intval($_GET['id']);
			$result=$this->wendb->get_one(array('tid'=>$tid));
			
			$forumtypes =  $this->GetFormArray();
			$rowname = $this->forum->get_one(array('fid'=>$result['fid']));
			$fname=$rowname['name'];
			$show_validator = $show_scroll = $show_header = true;
			//获取专家用户组array('issystem'=>0)
			$this->gdb = pc_base::load_model('member_group_model');
			$groupArray = $this->gdb->listinfo('', 'sort ASC','', 15);
			$groupArray=array_column($groupArray,'groupid');
			$where="usertype in(".implode(',',$groupArray).")";
			$types = $this->member_db->listinfo($where,$order = 'convert(nickname using gb2312) asc',$page, $pages = '150');
			
			$result['pic_images']=string2array($result['attachment']);
			$result['pic_images']=$result['pic_images']['thumb'];
			//图片数组
			extract($result);
			// print_r($result);
			if($replies==0){
			
				$status="<span class='glyphicon glyphicon-question-sign' style='color:red'>待解答</span>";
			}else{
					$status=$this->getwenstatus($status);
			}
			include $this->admin_tpl('thread_edit');
		}

	}
	//删除图片
	public function del_thread_pic(){
		$tid=intval($_GET['tid']);
		$aid=intval($_GET['aid']);
		$data = $this->wendb->get_one(array('tid'=>$tid));
		$picdata=string2array($data['attachment']);
	
		unset($picdata['url'][$aid]);
		unset($picdata['thumb'][$aid]);
		$picoutdata['url']=$picdata['url'];
		$picoutdata['thumb']=$picdata['thumb'];
		// print_r($picoutdata);
		$this->wendb->update(array('attachment'=>array2string($picoutdata)),array('tid'=>$tid));
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	
	//编辑分类
	public function editsort()
	{
		$id=intval($_GET['id']) ? intval($_GET['id']) : '';
		$fid=intval($_GET['fid']) ? intval($_GET['fid']) : '';
		if(!$id || !$fid) return false;
		if(isset($_POST['dosubmit']))
		{
			$bigfid=$_POST['info']['fid'];
			
			$this->wendb->update(array('fid'=>$bigfid),array('tid'=>$id));
			showmessage(L("operation_success"),HTTP_REFERER);
		}else{
			$forumtypes = $this->GetFormArray();
			$rowname = $this->forum->get_one(array('fid'=>$fid));
			$fname=$rowname['name'];
			include  $this->admin_tpl('thread_editsort');
		}
	}
	public function GetFormArray(){
		$forumtypes = $this->forum->listinfo('',$order = ' sort asc',$page, $pages = '150');
		return $forumtypes;
	}
	//批量管理问题
	public function wenoperateall()
	{
		$act=$_GET['act'] ? $_GET['act'] : '';
		$status=$_GET['status'] ? $_GET['status'] : 0;
		if(!isset($_POST['tid']) || empty($_POST['tid']))
		{
			showmessage(L('you_do_not_check'), HTTP_REFERER);
		}else{
			if(is_array($_POST['tid']))
			{
				foreach($_POST['tid'] as $id_arr)
				{
					$vtd = $this->wendb->get_one(array('tid'=>$id_arr));
					if($vtd)
					{
						switch($status){
							case 0:
							
							$newzjid=string2array($vtd['zhuanjiaid']);
							//发送消息到专家用户
							//批量审核通过
							$this->wendb->update(array('status'=>$status),array('tid'=>$id_arr));
							break;				
							case 1:
							$this->wendb->delete(array('tid'=>$id_arr));
							$this->postdb->delete(array('tid'=>$id_arr));
							break;
							
							
							default:
							
							if($act=='cancel'){
								$this->wendb->update(array('status'=>0),array('tid'=>$id_arr));
							}else{
								$this->wendb->update(array('status'=>$status),array('tid'=>$id_arr));
							}	
							
							break;
						}
						
						
					}else{
						showmessage(L("illegal_parameters"),HTTP_REFERER);
					}
				}
			}
			showmessage(L("operation_success"),HTTP_REFERER);
		}
	}
}
?>