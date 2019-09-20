<?php
/**
* description：mobile message class
  $message_result = $mobile_message->send('内容','18158203300');
*/
class sendsms{
	private $config = array(
			'apiurl'     => 'http://api.chanzor.com/dr?', 
			'target'     => 'http://api.chanzor.com/send?',		
			'account'     => '98ac5d',
			'password'  => 'uw7fv542qz',
			'signature'	=>	'【蜂博士】'
	);
	private $send_data = '';
	private $send_mobile = '';
	public function __construct($config=array()){
		$this->config = array_merge($this->config,$config);
	}
	/*
	 * 返回值
	 * SimpleXMLElement Object
		(
		    [returnstatus] => Success   //Success或Faild
		    [message] => 操作成功
		    [remainpoint] => 19908
		    [taskID] => 1506161106243834
		    [successCounts] => 1
		)
	 */
	public function send($send_data,$send_mobile){
		extract($this->config);
		$password=strtoupper(md5($password));
		$this->send_data = $send_data.$signature;
		$this->send_mobile = $send_mobile;
		$post_data = 'userid=&account='.$account.'&password='.$password.'&mobile='.$this->send_mobile.'&sendTime=&content='.rawurlencode($this->send_data);
		$result =$this->chanzorPost($post_data,$target);
		$start=strpos($result,"<?xml");
		$data=substr($result,$start);
		$xml=simplexml_load_string($data);
 		$aaa=json_decode(json_encode($xml));
		return $aaa;
	}
	//获取
	public function getStatus($taskid){
		extract($this->config);
		$password=strtoupper(md5($password));
		$post_data = 'account='.$account.'&password='.$password.'&taskId='.$taskid;
		$result =GetCurl($apiurl.$post_data);
		$result=json_decode($result,true);
        return $result;
	}
	public function chanzorPost($data, $target){
		$url_info = parse_url($target);
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader .= "Host:" . $url_info['host'] . "\r\n";
		$httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader .= "Content-Length:" . strlen($data) . "\r\n";
		$httpheader .= "Connection:close\r\n\r\n";
		//$httpheader .= "Connection:Keep-Alive\r\n\r\n";
		$httpheader .= $data;
		$fd = fsockopen($url_info['host'], 80);
		fwrite($fd, $httpheader);
		$gets = "";
		while(!feof($fd)) {
			$gets .= fread($fd, 128);
		}
		fclose($fd);
		return $gets;
	}
}
?>
