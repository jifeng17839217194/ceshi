<?php
define('CODETABLEDIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'encoding'.DIRECTORY_SEPARATOR); 
class my_Getpy {

    function __construct(){
		    $_dat = CODETABLEDIR.'py.dat';
            $_fd  = false;
            $this->_dat = $_dat;
			$this->load();
    }

    function load($pdat = ''){
        if ('' == $pdat)
            $pdat = $this->_dat;
        $this->_fd = @fopen($pdat, 'rb');
        if (!$this->_fd){
            trigger_error("unable to load PinYin data file $pdat", E_USER_WARNING);
            return false;
        }
        return true;
    }

    function unload(){
        if ($this->_fd){
            @fclose($this->_fd);
            $this->_fd = false;
        }
    }

    function get($zh){
        if (strlen($zh) != 2){
            trigger_error("$zh is not a valid GBK hanzi", E_USER_WARNING);
            return false;
        }

        if (!$this->_fd && !$this->load())
            return false;

        $high = ord($zh[0]) - 0x81;
        $low  = ord($zh[1]) - 0x40;

        // 计算偏移位置
        $nz = ($ord0 - 0x81);
        $off = ($high<<8) + $low - ($high * 0x40);

        // 判断 off 值
        if ($off < 0){
            trigger_error("$zh is not a valid GBK hanzi-2", E_USER_WARNING);
            return false;
        }
        fseek($this->_fd, $off * 8, SEEK_SET);
        $ret = fread($this->_fd, 8);
        $ret = unpack('a8py', $ret);
        return substr(trim($ret['py']),0,-1);//不要注音
    }

//多字串,外部调用时调用此方法即可
	function strs($str){

	if(CHARSET != 'gbk') {
		$str = iconv(CHARSET,'gbk',$str);
	}

	   if(strlen($str) == 2) return $this->get($str);
	   $len = strlen($str);
	   $pinyin = array();
	       for ($i = 0; $i < $len; $i++){
        if (ord($str[$i]) > 0x80){
            $xx = $this->get(substr($str, $i, 2));
            $pinyin[] = ($xx ? $xx: substr($str, $i, 2));    
            $i++;
        }
        else{
            $pinyin[] = $str[$i];
        }
          }
		  $this->unload();
		  return $pinyin;
	}

}

?>