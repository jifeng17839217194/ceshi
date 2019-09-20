function beevideo($field, $value, $fieldinfo) {
	extract(string2array($fieldinfo['setting']));
	$list_str = '';
	if($value) {
	$value = string2array(html_entity_decode($value,ENT_QUOTES));
	if(is_array($value)) {
		foreach($value as $_k=>$_v) {
		$list_str .= "<div id='beevideo{$_k}'> <input type='text' name='{$field}_bee_item[]' value='{$_v[id]}' style='width:80px;' class='input-text'> <input type='text' name='{$field}_bee_title[]' value='{$_v[title]}' style='width:150px;' class='input-text'>  <input type='text' name='{$field}_bee_displaytime[]' value='{$_v[displaytime]}' style='width:100px;' class='input-text'> <input type='text' name='{$field}_bee_video[]' value='{$_v[video]}' style='width:100px;' class='input-text'>  <input type='text' name='{$field}_bee_audio[]' value='{$_v[audio]}' style='width:100px;' class='input-text'><a href=\"javascript:remove_div('beevideo{$_k}')\"><b> 减少一行 </b></a></div>";
		}
	}
}
$string ='<script type=text/javascript>
function add_textsfile(returnid) {
var ids = parseInt(Math.random() * 10000);
var str = "<li id=\'beevideo"+ids+"\'> <input type=\'text\' name=\'"+returnid+"_bee_item[]\' value=\'\' style=\'width:80px;\' class=\'input-text\'> <input type=\'text\' name=\'"+returnid+"_bee_title[]\' value=\'\' style=\'width:150px;\' class=\'input-text\'>   <input type=\'text\' name=\'"+returnid+"_bee_displaytime[]\' value=\'\' style=\'width:100px;\' class=\'input-text\'>  <input type=\'text\' name=\'"+returnid+"_bee_video[]\' value=\'\' style=\'width:100px;\' class=\'input-text\'>  <input type=\'text\' name=\'"+returnid+"_bee_audio[]\' value=\'\' style=\'width:100px;\' class=\'input-text\'><a href=\"javascript:remove_div(\'beevideo"+ids+"\')\"><b> 减少一行 </b></a> </li>";
$(\'#\'+returnid).append(str);
}</script>';
$string .= '<input name="info['.$field.']" type="hidden" value="1">
<fieldset class="blue pad-10">
<legend>'.L('bee_list').'</legend>
<div id="tt">
<input type="text" value="'.L('bee_id').'" readonly style="width:80px;border:0;" class="input-text">
<input type="text" value="'.L('bee_name').'" readonly style="width:150px;border:0;" class="input-text">
<input type="text" value="'.L('bee_video').'" readonly style="width:100px;border:0;" class="input-text">
<input type="text" value="'.L('bee_audio').'" readonly style="width:100px;border:0;" class="input-text">
<input type="text" value="'.L('bee_displaytime').'" readonly style="width:100px;border:0;" class="input-text">
</div>';
$string .= $list_str;
$string .= '<ul id="'.$field.'" class="picList"></ul>
</fieldset>
<div class="bk10"></div>
';
$string .= $str."<input type=\"button\" class=\"button\" value=\"".L('video_addone')."\" onclick=\"add_textsfile('{$field}')\">";
return $string;
}