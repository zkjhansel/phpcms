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

		$where = array('siteid'=>$this->get_siteid());

 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,id DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		
		$offices = $this->db_office->getList();

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=group&c=group&a=add\', title:\'添加团购\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);','添加团购');
		include $this->admin_tpl('group_list');
	}
	 
	//添加团购优惠
 	public function add() {

 		$siteid = $this->get_siteid();

 		if(isset($_POST['dosubmit'])) {
			$_POST['group']['add_time'] = SYS_TIME;
			$_POST['group']['siteid'] = $siteid;
			if(empty($_POST['group']['title'])) {
				showmessage('请填写团购名称',HTTP_REFERER);
			}
			if(empty($_POST['group']['image'])) {
				showmessage('请上传团购封面',HTTP_REFERER);
			}
			if(empty($_POST['group']['start_time']) || empty($_POST['group']['end_time'])) {
				showmessage('请选择开始时间或者结束时间',HTTP_REFERER);
			}
			$_POST['group']['title'] = safe_replace($_POST['group']['title']);
			$_POST['group']['image'] = safe_replace($_POST['group']['image']);
			$_POST['group']['start_time'] = strtotime($_POST['group']['start_time']);
			$_POST['group']['end_time'] = strtotime($_POST['group']['end_time']);

			//echo '<pre>';print_r($_POST['group']);die;
			$data = new_addslashes($_POST['group']);
			$groupid = $this->db->insert($data,true);
			if(!$groupid) showmessage('增加团购失败',HTTP_REFERER);
 			
	 		//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['group']['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['group']['image'],'group-'.$groupid,1);
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

	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {

			foreach($_POST['listorders'] as $groupid => $listorder) {
				$groupid = intval($groupid);
				$this->db->update(array('listorder'=>$listorder),array('id'=>$groupid));
			}
			showmessage('排序成功',HTTP_REFERER);
		} 
	}
		
 
	public function edit() {
		if(isset($_POST['dosubmit'])){

 			$id = intval($_GET['id']);
			if($id < 1) return false;

			if(!is_array($_POST['group']) || empty($_POST['group'])) return false;
			if((!$_POST['group']['title']) || empty($_POST['group']['title'])) return false;

			$_POST['group']['start_time'] = strtotime($_POST['group']['start_time']);
			$_POST['group']['end_time'] = strtotime($_POST['group']['end_time']);

			$this->db->update($_POST['group'],array('id'=>$id));
			//更新附件状态
			if(pc_base::load_config('system','attachment_stat') & $_POST['group']['image']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['group']['image'],'group-'.$id,1);
			}
			showmessage(L('operation_success'),'?m=link&c=link&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);


			$offices = $this->db_office->getList();
			//解出链接内容
			$info = $this->db->get_one(array('id'=>$_GET['groupid']));
			if(!$info) showmessage('信息不存在');
			extract($info);
 			include $this->admin_tpl('group_edit');
		}

	}

	/**
	 * 删除友情链接  
	 * @param	intval	$sid	友情链接ID，递归删除
	 */
	public function delete() {

  		if((!isset($_GET['groupid']) || empty($_GET['groupid'])) && (!isset($_POST['groupid']) || empty($_POST['groupid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {

			if(is_array($_POST['groupid'])){
				foreach($_POST['groupid'] as $groupid_arr) {
 					//批量删除友情链接
					$this->db->delete(array('id'=>$groupid_arr));
					//更新附件状态
					if(pc_base::load_config('system','attachment_stat')) {
						$this->attachment_db = pc_base::load_model('attachment_model');
						$this->attachment_db->api_delete('group-'.$groupid_arr);
					}
				}
				showmessage(L('operation_success'),'?m=group&c=group');
			}else{
				$groupid = intval($_GET['groupid']);
				if($groupid < 1) return false;
				//删除友情链接
				$result = $this->db->delete(array('id'=>$groupid));
				//更新附件状态
				if(pc_base::load_config('system','attachment_stat')) {
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete('link-'.$groupid);
				}
				if($result){
					showmessage(L('operation_success'),'?m=group&c=group');
				}else {
					showmessage(L("operation_failure"),'?m=group&c=group');
				}
			}
			showmessage('操作成功', HTTP_REFERER);
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