<?php
function getpolyvdetail($vid){
	header("Content-type: text/html; charset=utf-8");
	$format="json";
	$ptime=time()*1000;//13位
	$str="format=".$format."&ptime=".$ptime."&vid=".$vid.PLOYV_KEY;
	$hash=strtoupper(sha1($str));
	$url='http://api.polyv.net/v2/video/'.PLOYV_ID.'/get-video-msg';
	$post_data = array (
		"format" => $format,
		"ptime" => $ptime,
		"vid" => $vid,
		"sign" => $hash,
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	$output=json_decode($output,true);
	$tempData['mp4']=$output['data'][0]['mp4'];
	return $tempData;
	// print_r($output);
}
// 获取最新视频/全部视频列表
function getpolyvlist($field){
	// useId：用于保利威视服务器与您的服务器进行通讯的时候的身份验证
	// secretkey：调用保利威视的API接口做签名访问时要用到
	header("Content-type: text/html; charset=utf-8");
	$catatree="1";
	$format="json";
	$numPerPage=10000;
	$pageNum=1;
	$ptime=time()*1000;
	$startDate="2017-03-19";//2017-08-19
	$endDate="";//2017-08-28
	$post_data = array (
	  "catatree" => $catatree,
	  "endDate" => $endDate,
	  "format" => $format,
	  "numPerPage" => $numPerPage,
	  "pageNum" => $pageNum,
	  "ptime" => $ptime,
	  "startDate" => $startDate, 
	);
	$str="";
	foreach ($post_data as $key => $value) {
	if (empty($value)) {
	  unset($post_data[$key]);
	}
	else $str.=$key."=".$value."&";
	}
	$str=substr($str,0,(strlen($str)-1));
	$str.=PLOYV_KEY;
	$hash=strtoupper(sha1($str));
	$post_data["sign"]=$hash;
	$url="http://api.polyv.net/v2/video/".PLOYV_ID."/get-new-list";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	$output=json_decode($output,true);
	foreach($output['data'] as $key=>$val){
	  $forum_arr[$key]['vid']=$val['vid'];
	  $forum_arr[$key]['title']=$val['title'];
	  $forum_arr[$key]['ptime']=$val['ptime'];
	  // $forum_arr[$key]['sindex']=return_firstpy($val['title']);
	}
	$fields = explode(",", $field);
	$str="<select name=\"info[{$fields[1]}]\" id=\"{$fields[1]}\"  class='dept_select'>";
	$str.="<option value=''>请选择视频</option><option value=''></option>";
	foreach( $forum_arr as $_key=>$_value)
	{
		if($fields[0] == $_value['vid'])
		{
			$str.="<option value='{$_value['vid']}' selected='selected' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";	
		}else{
			$str.="<option value='{$_value['vid']}' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";
		}
	}
	$str.="</select>";
	return $str;
}
// 获取最新视频/全部视频列表
function getchatlogvideolist($field,$value){
    // useId：用于保利威视服务器与您的服务器进行通讯的时候的身份验证
    // secretkey：调用保利威视的API接口做签名访问时要用到
    header("Content-type: text/html; charset=utf-8");
    $catatree="1";
    $format="json";
    $numPerPage=10000;
    $pageNum=1;
    $ptime=time()*1000;
    $startDate="2017-03-19";//2017-08-19
    $endDate="";//2017-08-28
    $post_data = array (
        "catatree" => $catatree,
        "endDate" => $endDate,
        "format" => $format,
        "numPerPage" => $numPerPage,
        "pageNum" => $pageNum,
        "ptime" => $ptime,
        "startDate" => $startDate,
    );
    $str="";
    foreach ($post_data as $key => $val) {
        if (empty($val)) {
            unset($post_data[$key]);
        }
        else $str.=$key."=".$val."&";
    }
    $str=substr($str,0,(strlen($str)-1));
    $str.=PLOYV_KEY;
    $hash=strtoupper(sha1($str));
    $post_data["sign"]=$hash;
    $url="http://api.polyv.net/v2/video/".PLOYV_ID."/get-new-list";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
    $output=json_decode($output,true);
    foreach($output['data'] as $key=>$val){
        $forum_arr[$key]['vid']=$val['vid'];
        $forum_arr[$key]['title']=$val['title'];
        $forum_arr[$key]['ptime']=$val['ptime'];
        $forum_arr[$key]['cataid']=$val['cataid'];
        // $forum_arr[$key]['sindex']=return_firstpy($val['title']);
    }
    $str="<select name=\"$field\" id=\"$field\"  class='dept_select'>";
    $str.="<option value=''>请选择视频</option><option value=''></option>";
    foreach( $forum_arr as $_key=>$_value)
    {
        if($_value['cataid'] == '1557141930952'){
            if($value == $_value['vid'])
            {
                $str.="<option value='{$_value['vid']}' selected='selected' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";
            }else{
                $str.="<option value='{$_value['vid']}' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";
            }
        }
    }
    $str.="</select>";
    return $str;
}
// 获取最新视频/全部视频列表
function getadvideolist($field,$value){
    // useId：用于保利威视服务器与您的服务器进行通讯的时候的身份验证
    // secretkey：调用保利威视的API接口做签名访问时要用到
    header("Content-type: text/html; charset=utf-8");
    $catatree="1";
    $format="json";
    $numPerPage=10000;
    $pageNum=1;
    $ptime=time()*1000;
    $startDate="2017-03-19";//2017-08-19
    $endDate="";//2017-08-28
    $post_data = array (
        "catatree" => $catatree,
        "endDate" => $endDate,
        "format" => $format,
        "numPerPage" => $numPerPage,
        "pageNum" => $pageNum,
        "ptime" => $ptime,
        "startDate" => $startDate,
    );
    $str="";
    foreach ($post_data as $key => $val) {
        if (empty($val)) {
            unset($post_data[$key]);
        }
        else $str.=$key."=".$val."&";
    }
    $str=substr($str,0,(strlen($str)-1));
    $str.=PLOYV_KEY;
    $hash=strtoupper(sha1($str));
    $post_data["sign"]=$hash;
    $url="http://api.polyv.net/v2/video/".PLOYV_ID."/get-new-list";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
    $output=json_decode($output,true);
    foreach($output['data'] as $key=>$val){
        $forum_arr[$key]['vid']=$val['vid'];
        $forum_arr[$key]['title']=$val['title'];
        $forum_arr[$key]['ptime']=$val['ptime'];
        $forum_arr[$key]['cataid']=$val['cataid'];
        // $forum_arr[$key]['sindex']=return_firstpy($val['title']);
    }
    $str="<select name=\"$field\" id=\"$field\"  class='dept_select'>";
    $str.="<option value=''>请选择视频</option><option value=''></option>";
    foreach( $forum_arr as $_key=>$_value)
    {
        if($_value['cataid'] == '1557216614128'){
            if($value == $_value['vid'])
            {
                $str.="<option value='{$_value['vid']}' selected='selected' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";
            }else{
                $str.="<option value='{$_value['vid']}' id='{$_value['sindex']}'>{$_value['title']} 【{$_value['ptime']}】</option>";
            }
        }
    }
    $str.="</select>";
    return $str;
}

/**
 * 生成15位的会员号
 * @return string 会员号
 */
function create_order_number(){
	$year_code = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $date_code = array('0','1', '2', '3', '4', '5', '6', '7', '8', '9', 'A','C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M','N', 'O', 'P', 'Q', 'R', 'T', 'U', 'V', 'W', 'X', 'Y');
    //一共15位会员号,同一秒内重复概率1/10000000,26年一次的循环\
    $order_sn = $year_code[(intval(date('Y')) - 2010) % 26]. //年 1位
	strtoupper(dechex(date('m'))) . //月(16进制) 1位
	$date_code[intval(date('d'))] . //日 1位
	substr(time(), -5) . substr(microtime(), 2, 5) . //秒 5位 // 微秒 5位
	sprintf('%02d', rand(0, 99)); //  随机数 2位
    return $order_sn;
}

/**
 *  extention.func.php 用户自定义函数库
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-10-27
 */
function get_area_name($field)
{
	$fields = explode(",", $field);
	$catid=$_GET['catid'];
	//另外种思路可以考虑缓存文件，PHP函数 array_push();方式
	$linkage_db=pc_base::load_model('linkage_model');
	$forum_arr=$linkage_db->select("parentid=0 and keyid=1 ",'linkageid,name','','linkageid asc');
	if($catid==102){
		$str="<select name=\"info[{$fields[1]}]\" id=\"{$fields[1]}\" >";
		$str.="<option value=''>请选择地区</option>";
		foreach( $forum_arr as $_key=>$_value)
		{
			if($fields[0] == $_value['linkageid'])
			{
				
			$str.="<option value='{$_value['linkageid']}' selected='selected'>{$_value['name']}</option>";	
			}
			else
			{
			$str.="<option value='{$_value['linkageid']}'>{$_value['name']}</option>";
			}
		}
		$str.="</select>";
		return $str;
	}
}


?>