function beevideo($field, $value) {
	$beevideoarray = $_POST[$field.'_bee_item'];
	$bee_title = $_POST[$field.'_bee_title'];
	$bee_displaytime = $_POST[$field.'_bee_displaytime'];
	$bee_video = $_POST[$field.'_bee_video'];
	$bee_audio = $_POST[$field.'_bee_audio'];
	$bee_displaytime = $_POST[$field.'_bee_displaytime'];
	$array = $temp = array();
	if(!empty($beevideoarray)) {
		foreach($beevideoarray as $key=>$hote) {
			$temp['id'] = $beevideoarray[$key];
			$temp['title'] = $bee_title[$key];
			$temp['displaytime'] = $bee_displaytime[$key];
			$temp['video'] = $bee_video[$key];
			$temp['audio'] = $bee_audio[$key];
			$array[$key] = $temp;
		}
	}
	$array = array2string($array);
	return $array;
}