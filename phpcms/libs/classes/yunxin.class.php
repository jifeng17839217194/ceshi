<?php
/**
 * 网易云信服务端接口
 */
pc_base::load_sys_class('thinkorm', '', 0);
class yunxin {
    
    const AppKey	=   'ecd43d99b20fa6e273d287bdcc45a836';
    const AppSecret =	'a4fa231ae5e6';
    const HEX_DIGITS = "0123456789abcdef";
    
    /**
	 * 用户创建
	 * @param string $accid
	 * @param string $name
	 * @return mixed
	 */
	public static function userCreate($accid,$name,$icon = ""){
	    $data['accid'] = $accid;//账号
	    $data['name'] = $name;//昵称
	    $data['icon'] = empty($icon)?pc_base::load_config('yunxin','user_icon'):$icon;
		$url="https://api.netease.im/nimserver/user/create.action";
		return self::postDataCurl($url,$data);
	}
    
	/**
	 * 
	 * @param string $accid
	 * @param boolean $mute
	 * @return mixed
	 */
	public static function muteUser($accid,$mute = "true"){
	    $data['accid'] = $accid;//账号
	    $data['mute'] = $mute;//是否全局禁言：true：全局禁言，false:取消全局禁言
	    
	    $url="https://api.netease.im/nimserver/user/mute.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 群聊创建
	 * @param string $own_accid
	 * @param string $tname
	 * @param array $members
	 * @param string $intro
	 * @param string $rule
	 * @param string $icon
	 * @return mixed
	 */
	public static function groupCreate($own_accid,$tname,$members,$intro = '',$icon = ''){
	    if(empty($intro)){
	        $intro = "我是群描述";
	    }
	    $data['tname'] = $tname;//群名称
	    $data['owner'] = $own_accid;//群主用户帐号
	    foreach ($members as $k=>$v){
	        if($v!=$own_accid){
	            $members_arr[] = $v;
	        }
	    }
	    $data['members'] = json_encode($members);//["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
	    //$data['custom'] = json_encode(['rule'=>$rule]);
	    //$data['announcement'] = $announcement;//群公告，最大长度1024字符
	    $data['intro'] = $intro;//群描述，最大长度512字符
	    
	    $data['msg'] = $tname;//邀请发送的文字
	    $data['magree'] = 0;//管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群
	    $data['joinmode'] = 1;//群建好后，sdk操作时，0不用验证，1需要验证,2不允许任何人加入
	    $data['icon'] = empty($icon)?pc_base::load_config('yunxin','group_icon'):$icon;//群头像
	    $data['beinvitemode'] = 1;//被邀请人同意方式，0-需要同意(默认),1-不需要同意
	    $data['invitemode'] = 1;//谁可以邀请他人入群，0-管理员(默认),1-所有人
	    
	    $url="https://api.netease.im/nimserver/team/create.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 编辑群资料
	 * @param string $tid
	 * @param string $own_accid
	 * @param string $tname
	 * @param string $intro
	 * @param string $rule
	 * @param string $icon
	 * @return mixed
	 */
	public static function groupUpdate($tid,$own_accid,$tname = '',$intro = '',$icon = '',$invitemode = 0,$maxusers){
	    $data['tid'] = $tid;//群名称
	    $data['owner'] = $own_accid;//群主用户帐号
	    $data['tname'] = $tname;//群名称
	    //$data['custom'] = json_encode(['rule'=>$rule]);
	    //$data['announcement'] = $announcement;//群公告，最大长度1024字符
	    $data['intro'] = $intro;//群描述，最大长度512字符
	    $data['icon'] = empty($icon)?pc_base::load_config('yunxin','group_icon'):$icon;//群头像
	    $data['invitemode'] = $invitemode;//谁可以邀请他人入群，0-管理员(默认),1-所有人。其它返回414
	    
	    $data['teamMemberLimit'] = $maxusers;//该群最大人数(包含群主)，范围：2至应用定义的最大群人数(默认:200)。其它返回414
	    
	    $url="https://api.netease.im/nimserver/team/update.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 解散群
	 * @param string $tid
	 * @param string $own_accid
	 * @return mixed
	 */
	public static function groupRemove($tid,$own_accid){
	    $data['tid'] = $tid;//群名称
	    $data['owner'] = $own_accid;//群主用户帐号
	    
	    $url="https://api.netease.im/nimserver/team/remove.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 群详情
	 * @param string $tid
	 * @return mixed
	 */
	public static function groupDetail($tid){
	    $data['tid'] = $tid;//群ID
	    
	    $url="https://api.netease.im/nimserver/team/queryDetail.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 任命管理员
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function managerAdd($tid,$owner,$members){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    foreach ($members as $k=>$v){
	        if($v!=$owner){
	            $members_arr[] = $v;
	        }
	    }
	    $data['members'] = json_encode($members_arr);//["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
	    
	    $url="https://api.netease.im/nimserver/team/addManager.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 移除管理员
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function managerRemove($tid,$owner,$members){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    foreach ($members as $k=>$v){
	        if($v!=$owner){
	            $members_arr[] = $v;
	        }
	    }
	    $data['members'] = json_encode($members_arr);//["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
	    
	    $url="https://api.netease.im/nimserver/team/removeManager.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 移交群主
	 * @param string $tid
	 * @param string $owner
	 * @param string $newowner
	 * @return mixed
	 */
	public static function changeOwner($tid,$owner,$newowner){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    $data['newowner'] = $newowner;//新群主用户帐号
	    $data['leave'] = 2;//1:群主解除群主后离开群，2：群主解除群主后成为普通成员。其它414
	    
	    $url="https://api.netease.im/nimserver/team/changeOwner.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 禁言某成员
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function muteMember($tid,$owner,$accid){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    $data['accid'] = $accid;//新群主用户帐号
	    $data['mute'] = 1;//1-禁言，0-解禁
	    
	    $url="https://api.netease.im/nimserver/team/muteTlist.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 取消禁言某成员
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function unmuteMember($tid,$owner,$accid){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    $data['accid'] = $accid;//新群主用户帐号
	    $data['mute'] = 0;//1-禁言，0-解禁
	    
	    $url="https://api.netease.im/nimserver/team/muteTlist.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 群拉人
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function addMember($tid,$owner,$members){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    foreach ($members as $k=>$v){
	        if($v!=$owner){
	            $members_arr[] = $v;
	        }
	    }
	    $data['members'] = json_encode($members_arr);//["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
	    $data['magree'] = 0;//管理后台建群时，0不需要被邀请人同意加入群，1需要被邀请人同意才可以加入群。其它会返回414
	    $data['msg'] = '群邀请';
	    
	    $url="https://api.netease.im/nimserver/team/add.action";
	    return self::postDataCurl($url,$data);
	}
	
	
	
	/**
	 * 群踢人-批量
	 * @param string $tid
	 * @param string $owner
	 * @param array $members
	 * @return mixed
	 */
	public static function removeMember($tid,$owner,$members){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    foreach ($members as $k=>$v){
	        if($v!=$owner){
	            $members_arr[] = $v;
	        }
	    }
	    $data['members'] = json_encode($members_arr);//["aaa","bbb"](JSONArray对应的accid，如果解析出错会报414)，一次最多拉200个成员
	    
	    $url="https://api.netease.im/nimserver/team/kick.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 群踢人-单个
	 * @param unknown $tid
	 * @param unknown $owner
	 * @param unknown $members
	 * @return mixed
	 */
	public static function removeOneMember($tid,$owner,$accid){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    $data['member'] = $accid;
	    
	    $url="https://api.netease.im/nimserver/team/kick.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 更新用户群昵称
	 * @param string $tid
	 * @param string $owner
	 * @param string $accid
	 * @param string $nick
	 * @return mixed
	 */
	public static function updateTeamNick($tid,$owner,$accid,$nick){
	    $data['tid'] = $tid;//群ID
	    $data['owner'] = $owner;//群主用户帐号
	    $data['accid'] = $accid;
	    $data['nick'] = $nick;
	    
	    $url="https://api.netease.im/nimserver/team/updateTeamNick.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 更新用户头像
	 * @param string $accid
	 * @param string $icon
	 */
	public static function updateAvatar($accid,$icon = ""){
	    $data['icon'] = empty($icon)?pc_base::load_config('yunxin','user_icon'):$icon;
	    return self::updateUser($accid, $data);
	}
	
	/**
	 * 更新用户名片
	 * @param string $accid
	 * @param array $data = [
	 *     'name'=>''      //String	否	用户昵称，最大长度64字符，可设置为空字符串
	 *     'icon'=>''      //String	否	用户头像，最大长度1024字节，可设置为空字符串
	 *     'sign'=>''      //String	否	用户签名，最大长度256字符，可设置为空字符串
	 *     'email'=>''     //String	否	用户email，最大长度64字符，可设置为空字符串
	 *     'birth'=>''     //String	否	用户生日，最大长度16字符，可设置为空字符串
	 *     'mobile'=>''    //String	否	用户mobile，最大长度32字符，非中国大陆手机号码需要填写国家代码(如美国：+1-xxxxxxxxxx)或地区代码(如香港：+852-xxxxxxxx)，可设置为空字符串
	 *     'gender'=>''    //int	否	用户性别，0表示未知，1表示男，2女表示女，其它会报参数错误
	 *     'ex'=>''        //String	否	用户名片扩展字段，最大长度1024字符，用户可自行扩展，建议封装成JSON字符串，也可以设置为空字符串
	 * ]
	 * @return mixed
	 */
	public static function updateUser($accid,$data){
	    $data['accid'] = $accid;
	    $url="https://api.netease.im/nimserver/user/updateUinfo.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 群信息与成员列表查询
	 * @param array $tids //群id列表，如["3083","3084"]
	 * @param number $ope //1表示带上群成员列表，0表示不带群成员列表，只返回群信息
	 */
	public static function findGroups($tids,$ope = 0){
	    $data['tids'] = json_encode($tids);
	    $data['ope'] = $ope;
	    $url="https://api.netease.im/nimserver/team/query.action";
	    return self::postDataCurl($url,$data);
	}
	
	/**
	 * 发送自定义群系统消息
	 * @param string $from
	 * @param string $to
	 * @param json $attach
	 * @return mixed
	 */
	public static function sendGroupMsg($from,$to,$attach){
        $data['from'] = $from;
        $data['msgtype'] = 1;
        $data['to'] = $to;
        $data['attach'] = $attach;
        $url="https://api.netease.im/nimserver/msg/sendAttachMsg.action";
        return self::postDataCurl($url,$data);
	}
	
	/**
	 * 发送自定义系统通知消息
	 * @param string $toAccid
	 * @param array $attach
	 * @return mixed
	 */
	public static function sendOneMsg($toAccid,$attach = []){
	    $data['from'] = pc_base::load_config('yunxin','notice_accid');
	    $data['msgtype'] = 0;
	    $data['to'] = $toAccid;
	    $data['attach'] = json_encode($attach);
	    $url="https://api.netease.im/nimserver/msg/sendAttachMsg.action";
	    return self::postDataCurl($url,$data);
	}
	
	public static function updateGroupMembers($tid){
	    $return = self::groupDetail($tid);
	    $groupInfo = $return['tinfo'];
	    
	    $member = [];
	    $member['accid'] = $groupInfo['owner']['accid'];
	    $member['group_nickname'] = $groupInfo['owner']['nick'];
	    $member['is_master'] = 0;
	    $member['is_own'] = 1;
	    $member['is_mute'] = $groupInfo['owner']['mute']?1:0;
	    $member['tid'] = $tid;
	    
	    $memberList[] = $member;
	    foreach ($groupInfo['admins'] as $masterInfo){
	        $member = [];
	        $member['accid'] = $masterInfo['accid'];
	        $member['group_nickname'] = $masterInfo['nick'];
	        $member['is_master'] = 1;
	        $member['is_own'] = 0;
	        $member['is_mute'] = $masterInfo['mute']?1:0;
	        $member['tid'] = $tid;
	        $memberList[] = $member;
	    }
	    foreach ($groupInfo['members'] as $memberInfo){
	        $member = [];
	        $member['accid'] = $memberInfo['accid'];
	        $member['group_nickname'] = $memberInfo['nick'];
	        $member['is_master'] = 0;
	        $member['is_own'] = 0;
	        $member['is_mute'] = $memberInfo['mute']?1:0;
	        $member['tid'] = $tid;
	        $memberList[] = $member;
	    }
	    
	    \think\Db::name('group_members')->where(['tid'=>$tid])->delete();
	    \think\Db::name('group_members')->insertAll($memberList);
	    
	    $data = [];
	    $data['accid'] = $groupInfo['owner']['accid'];
	    $data['members_num'] = count($memberList);
	    \think\Db::name('group')->where(['tid'=>$tid])->update($data);
	}
	
	private static function getAppKey(){
	    $appKey = pc_base::load_config('yunxin','app_key');
	    return empty($appKey)?self::AppKey:$appKey;
	}
	
	private static function getAppSecret(){
	    $appSecret = pc_base::load_config('yunxin','app_secret');
	    return empty($appSecret)?self::AppSecret:$appSecret;
	}
	
	private static function checkSumBuilder($nonce,$curTime){
	    return sha1(self::getAppSecret().$nonce.$curTime);
	}
	
	private static function createNonce(){
	    $hex_digits = self::HEX_DIGITS;
	    $nonce = '';
	    for($i=0;$i<128;$i++){           //随机字符串最大128个字符，也可以小于该数
	        $nonce.= $hex_digits[rand(0,15)];
	    }
	    return $nonce;
	}
	
	private static function postDataCurl($url,$data){
	    $nonce = self::createNonce();
	    $curTime = (string)(time());
	    $checkSum = self::checkSumBuilder($nonce, $curTime);
	    
	    $data = http_build_query($data);
	    
	    $timeout = 5000;
	    $http_header = [
	        'AppKey:'.self::getAppKey(),
	        'Nonce:'.$nonce,
	        'CurTime:'.$curTime,
	        'CheckSum:'.$checkSum,
	        'Content-Type: application/x-www-form-urlencoded;'
	    ];
	    $ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_POST, 1);
	    curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt ($ch, CURLOPT_HEADER, false);
	    curl_setopt ($ch, CURLOPT_HTTPHEADER,$http_header);
	    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,false);
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    
	    $result = curl_exec($ch);
	    if (false === $result) {
	        $result =  curl_errno($ch);
	    }
	    curl_close($ch);
	    return json_decode($result,true) ;
	} 
    
}
?>