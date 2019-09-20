<?php
use think\Db;

defined('IN_PHPCMS') or exit('No permission resources.');

//定义在后台
define('IN_ADMIN',true);
class menu_op {	
	public function __construct() {
	    
	}
	
	public static function updateMenu($roleid){
	    if(!$roleid) return null;
	    
	    delcache("admin_menu_".$roleid,"menu");
	    return self::getMenu($roleid);
	}
	
	public static function updateMenuCache() {
	    $roleids = Db::name('admin_role')->column('roleid');
	    foreach ($roleids as $k=>$roleid){
	        delcache("admin_menu_".$roleid,"menu");
	    }
	}
	
	public static function getMenuAllIds($parentId = 0){
	    $parentId = intval($parentId);
	    if($parentId == 0){
	        return [];
	    }
	    $ids[] = $parentId;
	    $menus = Db::name('menu')->where(["parentid" => $parentId])->select();
	    if ($menus) {
	        $ids = array_merge($ids, array_column($menus, 'id'));
	        foreach ($menus as $key => $menu) {
	            $childrenIds = self::getMenuAllIds($menu['id']);
	            $ids = array_merge($ids, $childrenIds);
	        }
	        return $ids;
	    } else {
	        return $ids;
	    }
	}
	
	public static function getMenu($roleid){
	    if(!$roleid){
	        return null;
	    }
	    
	    $menuInfo = getcache("admin_menu_".$roleid,"menu");
	    if(empty($menuInfo)){
	        pc_base::load_sys_class('tree');
	        $tree = new tree();
	        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
	        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
	        
	        if($roleid == 1){
	            $array = Db::name('menu')->where('status',1)->where('type','>',0)->order('listorder ASC,id ASC')->select();
	        }
	        else{
	            $result = Db::name('menu')->where('status',1)->where('type',1)->order('listorder ASC,id ASC')->select();
	            foreach($result as $v) {
	                $r = Db::name('admin_role_priv')->where(['m'=>$v['m'],'c'=>$v['c'],'a'=>$v['a'],'data'=>$v['data'],'roleid'=>$roleid])->find();
	                if($r) $array[] = $v;
	            }
	        }
	        foreach ($array as $key=>$val){
	            $args = array();
	            $args['m'] = $val['m'];
	            $args['c'] = $val['c'];
	            $args['a'] = $val['a'];
	            $args['menu_id'] = $val['id'];
	            parse_str($val['data'],$data);
	            if(!empty($data)){
	                $args = array_merge($args,$data);
	            }
	            $array[$key]['path'] = "?".http_build_query($args);
	        }
	        
	        $tree->init($array);
	        $menuInfo = $tree->get_tree_array(0);
	        setcache("admin_menu_".$roleid,$menuInfo,"menu");
	    }
	    return $menuInfo;
	}
	
}
?>