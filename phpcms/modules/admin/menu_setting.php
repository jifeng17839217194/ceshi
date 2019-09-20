<?php
use think\Db;

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('thinkorm', '', 0);
pc_base::load_sys_class('tree', '', 0);
pc_base::load_app_class('menu_op','admin',0);

class menu_setting extends admin {
	function __construct() {
		parent::__construct();
	}
	
	public function init(){
	    $result     = Db::name('menu')->order(["listorder" => "ASC"])->select();
	    $tree       = new Tree();
	    $tree->icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
	    $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
	    
	    $tree->init($result);
	    $category = $tree->get_tree_array(0);
	    foreach ($category as $key=>$val){
	        $category[$key]['category'] = $this->_getTreeMenu($val['children']);
	        unset($category[$key]['children']);
	    }
	    include $this->admin_tpl('menu','admin','menu');
	}
	
	protected function _getTreeMenu($arr){
	    $str = '<ol class="dd-list">';
	    foreach ($arr as $key=>$val){
	        $path = "";
	        if(!(empty($val['m']) || empty($val['c']) || empty($val['a']))){
	            $path = $val['m']."/".$val['c']."/".$val['a'];
	            if(!empty($val['data'])){
	                $path .= "?".$val['data'];
	            }
	        }
	        $url = "?m=admin&c=menu_setting&a=edit&id=".$val['id']."&pc_hash=".$_SESSION['pc_hash'];
	        $str .= <<<html
<li class="dd-item dd-item-alt menu-{$val['id']}" data-id="{$val['id']}">
    <div class="dd-handle">
        <i class="fa fa-arrows"></i>
    </div>
    <div class="dd-content" data-href="{$url}">
        <span class="menu-name menu-title-{$val['id']}">{$val['name']}&nbsp;{$path}</span>
        <i class="pull-right fa fa-angle-right"></i>
    </div>
html;
	        if(!empty($val['children'])){
	            $str .= $this->_getTreeMenu($val['children']);
	        }
	        $str .= "</li>";
	    }
	    $str .= '</ol>';
	    return $str;
	}
	
	public function sort(){
	    $id = intval($_POST['id']);
	    $pid = intval($_POST['pid']);
	    $sortArr = $_POST['sort_arr'];
	    Db::name('menu')->where('id',$id)->setField('parentid',$pid);
	    $i = 0;
	    foreach ($sortArr as $key=>$val){
	        Db::name('menu')->where('id',$val)->setField('listorder',$i);
	        $i++;
	    }
	    menu_op::updateMenuCache();
	    exit(json_encode(['code'=>200,'msg'=>"排序成功！",'data'=>'']));
	}
	
	public function copy(){
	    $cpid = intval($_GET['cpid']);
	    $data = Db::name('menu')->where(['id'=>$cpid])->find();
	    $parentid = $data['parentid'];
	    include $this->admin_tpl('add','admin','menu');
	}
	
	public function add(){
	    if($this->isPost()){
	        
	        $data['name'] = trim($_POST['name']);
	        if(empty($data['name'])){
	            exit(json_encode(['code'=>500,'msg'=>"请输入菜单名称！",'data'=>'']));
	        }
	        $data['m'] = trim($_POST['module']);
	        $data['c'] = trim($_POST['controller']);
	        $data['a'] = trim($_POST['action']);
	        $data['data'] = trim($_POST['data']);
	        $data['icon'] = trim($_POST['icon']);
	        $data['type'] = intval($_POST['type']);
	        $data['status'] = intval($_POST['status']);
	        $data['parentid'] = intval($_POST['parentid']);
	        if($data['parentid'] == 0){
	            exit(json_encode(['code'=>500,'msg'=>"不允许添加顶级菜单！",'data'=>'']));
	        }
	        $data['update_time'] = date('Y-m-d H:i:s');
	        $data['id'] = Db::name('menu')->field(true)->insertGetId($data);
	        if ($data['id']) {
	            menu_op::updateMenuCache();
	            $path = "";
	            if(!(empty($data['m']) || empty($data['c']) || empty($data['a']))){
	                $path = $data['m']."/".$data['c']."/".$data['a'];
	                if(!empty($data['data'])){
	                    $path .= "?".$data['data'];
	                }
	            }
	            $url = "?m=admin&c=menu_setting&a=edit&id=".$data['id']."&pc_hash=".$_SESSION['pc_hash'];
	            $html = <<<html
                <li class="dd-item dd-item-alt menu-{$data['id']}" data-id="{$data['id']}">
                    <div class="dd-handle">
                        <i class="fa fa-arrows"></i>
                    </div>
                    <div class="dd-content" data-href="{$url}">
                    <span class="menu-name menu-title-{$data['id']}">{$data['name']}&nbsp;{$path}</span>
                        <i class="pull-right fa fa-angle-right"></i>
                    </div>
                </li>
html;
	            $returndata = $data;
	            $returndata['before_id'] = intval($_POST['before_id']);
	            $returndata['after_id'] = intval($_POST['after_id']);
	            $returndata['pid'] = $data['parentid'];
	            $returndata['html'] = $html;
	            $returndata['url'] = "?m=admin&c=menu_setting&a=edit&id=".$data['id']."&pc_hash=".$_SESSION['pc_hash'];
	            exit(json_encode(['code'=>200,'msg'=>"添加成功！",'data'=>$returndata]));
	        } else {
	            exit(json_encode(['code'=>500,'msg'=>"添加失败！",'data'=>'']));
	        }
	    }
	    $parentid = intval($_GET['parentid']);
	    include $this->admin_tpl('add','admin','menu');
	}
	
	public function edit(){
	    $id= intval($_REQUEST['id']);
	    if($this->isPost()){
	        $data['name'] = trim($_POST['name']);
	        if(empty($data['name'])){
	            exit(json_encode(['code'=>500,'msg'=>"请输入菜单名称！",'data'=>'']));
	        }
	        $data['m'] = trim($_POST['module']);
	        $data['c'] = trim($_POST['controller']);
	        $data['a'] = trim($_POST['action']);
	        $data['data'] = trim($_POST['data']);
	        $data['icon'] = trim($_POST['icon']);
	        $data['type'] = intval($_POST['type']);
	        $data['status'] = intval($_POST['status']);
	        $data['update_time'] = date('Y-m-d H:i:s');
	        $re = Db::name('menu')->field(true)->where('id',$id)->update($data);
	        if ($re) {
	            menu_op::updateMenuCache();
	            $path = "";
	            if(!(empty($data['m']) || empty($data['c']) || empty($data['a']))){
	                $path = $data['m']."/".$data['c']."/".$data['a'];
	                if(!empty($data['data'])){
	                    $path .= "?".$data['data'];
	                }
	            }
	            
	            exit(json_encode(['code'=>200,'msg'=>"保存成功！",'data'=>'','path'=>$path,'id'=>$id]));
	        } else {
	            exit(json_encode(['code'=>500,'msg'=>"保存失败！",'data'=>'']));
	        }
	    }
	    $data = Db::name('menu')->where(['id'=>$id])->find();
	    include $this->admin_tpl('edit','admin','menu');
	}
	
	public function delete(){
	    $id = intval($_REQUEST['id']);
	    $ids = menu_op::getMenuAllIds($id);
	    
	    if (Db::name('menu')->delete($ids) !== false) {
    	    menu_op::updateMenuCache();
	        exit(json_encode(['code'=>200,'msg'=>"删除菜单成功！",'data'=>'','path'=>$path]));
	    } else {
	        exit(json_encode(['code'=>500,'msg'=>"删除失败！",'data'=>'','path'=>$path]));
	    }
	}
	
	public function status(){
	    $id = $this->request->param('id',0,'intval');
	    if(empty($id)){
	        $this->error('参数错误');
	    }
	    $type = $this->request->param('type');
	    $data[$type] = $this->request->param('value',0,'intval');
	    $re = Db::name('menu')->field('status,sort')->where(['id'=>$id])->update($data);
	    if($re){
	        menu_op::updateMenuCache();
	        $this->success('修改成功'.$type);
	    }
	    else{
	        $this->error('修改失败');
	    }
	}
	
	// 导入新菜单
	/* public function getactions(){
	    $dirs = pc_base::load_config('menu_scan');
	    if(empty($dirs)){
	        exit(json_encode(['code'=>500,'msg'=>"扫描配置文件不存在",'data'=>'']));
	    }
	    foreach ($dirs as $m=>$actions){
	        foreach ($actions as $c){
                require_once PC_PATH."modules/$m/$c.php";
                $class = new $c();
                if($class instanceof admin){
                    $adminbaseaction=new admin();
                    $base_methods=get_class_methods($adminbaseaction);
                    
                    $methods=get_class_methods($class);
                    $methods=array_diff($methods, $base_methods);
                    foreach ($methods as $a){
                        if(!($m =='admin' && $c =='index' && in_array($a, array('login', 'public_card')))) {
                            if(!(strpos($a, "_") === 0) && !(strpos($a, "spmy_") === 0)){
                                
                                $count = Db::name('menu')->where('m',$m)->where('c',$c)->where('a',$a)->count();
                                if(!$count){
                                    $data['parentid']=1;
                                    $data['m']=$m;
                                    $data['c']=$c;
                                    $data['a']=$a;
                                    $data['type']=0;
                                    $data['status']=1;
                                    $data['name']="未知";
                                    $data['listorder']="0";
                                    $data['update_time']=date('Y-m-d H:i:s');
                                    $result=Db::name('menu')->insert($data);
                                }
                            }
        	            }
                    }
                }
	        }
	    }
	    exit(json_encode(['code'=>200,'msg'=>"导入成功！",'data'=>'']));
	} */
	
	public function update_cache(){
	    menu_op::updateMenuCache();
	    exit(json_encode(['code'=>200,'msg'=>"更新成功！",'data'=>'']));
	}
}
?>