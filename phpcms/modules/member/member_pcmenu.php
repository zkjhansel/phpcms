<?php
/**
 * 管理员后台会员中心菜单管理类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class member_pcmenu extends admin {
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('member_pcmenu_model');
	}
	
	public function manage() {
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$userid = $_SESSION['userid'];
		$admin_username = param::get_cookie('admin_username');

		$result = $this->db->select('','*','','listorder ASC,id DESC');

		foreach($result as $r) {
			$r['cname'] = $r['name'];
			$r['str_manage'] = '<a href="?m=member&c=member_pcmenu&a=edit&id='.$r['id'].'&menuid='.$_GET['menuid'].'">'.L('edit').'</a> | <a href="javascript:confirmurl(\'?m=member&c=member_pcmenu&a=delete&id='.$r['id'].'&menuid='.$_GET['menuid'].'\',\''.L('confirm',array('message'=>$r['cname'])).'\')">'.L('delete').'</a> ';
			$array[] = $r;
		}

		$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$cname</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$tree->init($array);
		$categorys = $tree->get_tree(0, $str);
		include $this->admin_tpl('member_pcmenu');
	}

	public function add() {
		if(isset($_POST['dosubmit'])) {
			$this->db->insert($_POST['info']);
			//结束
			showmessage('添加成功');
		} else {
			$show_validator = '';
			/*用于扩展二级三级菜单用的
			$tree = pc_base::load_sys_class('tree');
			$result = $this->db->select();
			foreach($result as $r) {
				$r['cname'] = L($r['name'], '', 'member_pcmenu');
				$r['selected'] = $r['id'] == $_GET['parentid'] ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);*/
			include $this->admin_tpl('member_pcmenu');
		}
	}

	public function delete() {
		$_GET['id'] = intval($_GET['id']);
		$menu = $this->db->get_one(array("id"=>$_GET['id']));
		if(!$menu) showmessage('菜单不存在！请返回！',HTTP_REFERER);

		$this->db->delete(array('id'=>$_GET['id']));
 		showmessage('操作成功');
	}
	
	function edit() {
		if(isset($_POST['dosubmit'])) {

			$id = intval($_POST['id']);
			$this->db->update($_POST['info'],array('id'=>$id));			
			showmessage('操作成功');

		} else {
			$show_validator = '';
			
			$id = intval($_GET['id']);
			$r = $this->db->get_one(array('id'=>$id));
			if($r) extract($r);

			/*暂时用不到
			$tree = pc_base::load_sys_class('tree');
			$result = $this->db->select();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);*/
			include $this->admin_tpl('member_pcmenu');
		}
	}
	
	/**
	 * 排序
	 */
	function listorder() {
		if(isset($_POST['dosubmit'])) {

			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage('操作成功');
		} else {
			showmessage('操作失败');
		}
	}
}
?>