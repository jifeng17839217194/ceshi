function zuowu($field, $value) {
$zuowu_name = $_POST[$field.'_zuowu_item'];
$video_id = $_POST[$field.'_zuowu_id'];
$video_title = $_POST[$field.'_zuowu_title'];
$video_province = $_POST[$field.'_zuowu_province'];
$video_city = $_POST[$field.'_zuowu_city'];
$video_town = $_POST[$field.'_zuowu_town'];
$video_displaytime = $_POST[$field.'_zuowu_displaytime'];
$array = $temp = array();
if(!empty($zuowu_name)) {
foreach($zuowu_name as $key=>$hote) {
$temp['name'] = $hote;
$temp['id'] = $video_id[$key];
$temp['mushu'] = $video_title[$key];
$temp['province'] = $video_province[$key];
$temp['city'] = $video_city[$key];
$temp['town'] = $video_town[$key];
$temp['address'] = $video_displaytime[$key];
$array[$key] = $temp;
}
}
$array = array2string($array);
return $array;
}