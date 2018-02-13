<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class group extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('group_model');
		$this->db_office = pc_base::load_model('member_office_model');
	}

	public function init() {
		if($_GET['typeid']!=''){
			$where = array('typeid'=>intval($_GET['typeid']),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,id DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=group&c=group&a=add\', title:\'添加团购\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);','添加团购');
		include $this->admin_tpl('group_list');
	}

	/*
	 *判断标题重复和验证 
	 */
	public function public_name() {
		$link_title = isset($_GET['link_name']) && trim($_GET['link_name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['link_name'])) : trim($_GET['link_name'])) : exit('0');
			
		$linkid = isset($_GET['linkid']) && intval($_GET['linkid']) ? intval($_GET['linkid']) : '';
		$data = array();
		if ($linkid) {

			$data = $this->db->get_one(array('linkid'=>$linkid), 'name');
			if (!empty($data) && $data['name'] == $link_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$link_title), 'linkid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加团购优惠
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			$_POST['link']['addtime'] = SYS_TIME;
			$_POST['link']['siteid'] = $this->get_siteid();
			if(empty($_POST['link']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['link']['name'] = safe_replace($_POST['link']['name']);
			}
			if ($_POST['link']['logo']) {
				$_POST['link']['logo'] = safe_replace($_POST['link']['logo']);
			}
			$data = new_addslashes($_POST['link']);
			$linkid = $this->db->insert($data,true);
			if(!$linkid) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['link']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
			}
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			$offices = $this->db_office->getList();
			
 			include $this->admin_tpl('group_add');
		}

	}
	
	/**
	 * 说明:异步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('linkid'=>$_GET['linkid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $linkid => $listorder) {
				$linkid = intval($linkid);
				$this->db->update(array('listorder'=>$listorder),array('linkid'=>$linkid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
		
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			if(!is_array($_POST['link']) || empty($_POST['link'])) return false;
			if((!$_POST['link']['name']) || empty($_POST['link']['name'])) return false;
			$this->db->update($_POST['link'],array('linkid'=>$linkid));
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['link']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
			}
			showmessage(L('operation_success'),'?m=link&c=link&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//解出链接内容
			$info = $this->db->get_one(array('linkid'=>$_GET['linkid']));
			if(!$info) showmessage(L('link_exit'));
			extract($info); 
 			include $this->admin_tpl('link_edit');
		}

	}

	/**
	 * 删除友情链接  
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {
  		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['linkid'])){
				foreach($_POST['linkid'] as $linkid_arr) {
 					//批量删除友情链接
					$this->db->delete(array('linkid'=>$linkid_arr));
					//更新附件状态
					if(pc_base::load_config('system','attachment_stat')) {
						$this->attachment_db = pc_base::load_model('attachment_model');
						$this->attachment_db->api_delete('link-'.$linkid_arr);
					}
				}
				showmessage(L('operation_success'),'?m=link&c=link');
			}else{
				$linkid = intval($_GET['linkid']);
				if($linkid < 1) return false;
				//删除友情链接
				$result = $this->db->delete(array('linkid'=>$linkid));
				//更新附件状态
				if(pc_base::load_config('system','attachment_stat')) {
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete('link-'.$linkid);
				}
				if($result){
					showmessage(L('operation_success'),'?m=link&c=link');
				}else {
					showmessage(L("operation_failure"),'?m=link&c=link');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}    
	
	/**
	 * 说明:对字符串进行处理
	 * @param $string 待处理的字符串
	 * @param $isjs 是否生成JS代码
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
 
 
	
}
?>