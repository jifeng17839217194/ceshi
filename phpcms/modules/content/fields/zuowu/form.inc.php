function zuowu($field, $value, $fieldinfo) {
	extract(string2array($fieldinfo['setting']));
	$list_str = '';
	if($value) {
	$value = string2array(html_entity_decode($value,ENT_QUOTES));
	if(is_array($value)) {
		foreach($value as $_k=>$_v) {
		$list_str .= "<div id='zuowu{$_k}'> <input type='text' name='{$field}_zuowu_item[]' value='{$_v[name]}' style='width:80px;' class='form-control'> <input type='text' name='{$field}_zuowu_title[]' value='{$_v[mushu]}' style='width:80px;' class='form-control'>  <input type='text' name='{$field}_zuowu_displaytime[]' value='{$_v[address]}' style='width:300px;' class='form-control'> <a href=\"javascript:remove_div('zuowu{$_k}')\"><b> -- </b></a></div>";
		}
	}
}
$string ='<script type=text/javascript>
function add_textsfile(returnid) {
var ids = parseInt(Math.random() * 10000);
var str = "<li id=\'zuowu"+ids+"\'> <input type=\'text\' name=\'"+returnid+"_zuowu_item[]\' value=\'\' style=\'width:80px;\' class=\'form-control\'> <input type=\'text\' name=\'"+returnid+"_zuowu_title[]\' value=\'\' style=\'width:80px;\' class=\'form-control\'>   <input type=\'text\' name=\'"+returnid+"_zuowu_displaytime[]\' value=\'\' style=\'width:300px;\' class=\'form-control\'> <a href=\"javascript:remove_div(\'zuowu"+ids+"\')\"><b> -- </b></a> </li>";
$(\'#\'+returnid).append(str);
}</script>';
$string .= '<input name="info['.$field.']" type="hidden" value="1">
<fieldset class="blue pad-10">
<legend>'.L('zuowu_list').'</legend>
<div id="tt">
<input type="text" value="'.L('zuowu_name').'" readonly style="width:80px;border:0;" class="form-control">
<input type="text" value="'.L('zuowu_mushu').'" readonly style="width:80px;border:0;" class="form-control">
<input type="text" value="'.L('zuowu_address').'" readonly style="width:300px;border:0;" class="form-control">
</div>';
$string .= $list_str;
$string .= '<ul id="'.$field.'" class="picList"></ul>
</fieldset>
<div class="bk10"></div>
';
$string .= $str."<input type=\"button\" class=\"button\" value=\"".L('video_addone')."\" onclick=\"add_textsfile('{$field}')\">";
return $string;
}