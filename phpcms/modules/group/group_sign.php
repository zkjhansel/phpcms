<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class group_sign extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('group_sign_model');
		$this->db_office = pc_base::load_model('member_office_model');
	}

	public function init() {

		$groupid = isset($_GET['groupid']) ? trim($_GET['groupid']) : exit('参数错误');
		
		$where  = '';
		$where .= "group_id = $groupid ";

		if ($_REQUEST['search']) {

			//如果用户量过大时，可默认节选一个月
			$mobile = $_POST['mobile'] ? trim($_POST['mobile']) : '';
			$start_time = $_POST['start_time'] ? strtotime($_POST['start_time']) : '';
			$end_time = $_POST['end_time'] ? strtotime($_POST['end_time']) : '';

			if (!empty($mobile)) {
				$where .= " AND mobile = $mobile ";
			}
			if ( !empty($start_time) && empty($end_time)) {
				$where .= " AND add_time > $start_time ";
			}elseif (!empty($end_time) && empty($start_time)) {
				$where .= " AND add_time < $end_time ";
			}elseif (!empty($start_time) && !empty($end_time)) {
				$where .= " AND add_time > $start_time AND add_time < $end_time";
			}
		}

 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'id DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		
		$offices = $this->db_office->getList();
		
		pc_base::load_sys_class('form');
		pc_base::load_sys_class('format', '', 0);

		include $this->admin_tpl('group_sign_list');
	}

	//批量操作
 	public function allDo() {

 		$ids = $_POST['id'];
 		if (count($ids) == 0) {
 			showmessage('请选择批量操作内容');
 		}
 		$ids = implode(',',$ids);
		$sql = "UPDATE v9_group_sign set status=1 where id in (".$ids.")";
		$re = $this->db->query($sql);

		if ($re !== false) {
			showmessage('批量审核成功',HTTP_REFERER);
		} else {
			showmessage('批量审核失败');
		}
		
	}
		
 
	public function edit() {
		if(isset($_POST['dosubmit'])){

 			$id = intval($_GET['id']);
			if($id < 1) return false;

			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if (!$info) {
				showmessage('信息不存在');
			}
			if ($info['status'] != 0) {
				showmessage('该信息已经审核过了');
			}

			$update = array();
			$update['status'] = $_POST['status'];
			$update['desc'] = $_POST['desc'];

			$this->db->update($update,array('id'=>$id));
			
			showmessage('操作成功','?m=group&c=group_sign&a=init','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);

			$offices = $this->db_office->getList();
			//解出链接内容
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) showmessage('信息不存在');
			extract($info);
 			include $this->admin_tpl('group_sign_edit');
		}

	}
	
 
 
	
}
?>