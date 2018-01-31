<?php
/*后台模块*/
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',false);

class hansel extends admin{

	function __construct() {
		$this->db = pc_base::load_model('hansel_model');
	}

	public function init() {

		//分页显示数据
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo('', 'id DESC', $page,15);
		$pages = $this->db->pages;

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=hansel&c=hansel&a=add\', title:\'添加会员\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加会员');

		include $this->admin_tpl('hansel_list');

	}


	public function add() {

		if (isset($_POST['dosubmit'])) {

			$_POST['hansel']['create_time'] = SYS_TIME;
			//用户名是否存在的检测之类的
			$res = $this->db->insert($_POST['hansel']);
			if (!$res) {
				showmessage('添加失败',HTTP_REFERER);
			}
			//关闭弹窗  并且刷新列表
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');

		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			include $this->admin_tpl('hansel_add');
		}
		
	}

	//修改
	public function edit() {

		if (isset($_POST['dosubmit'])) {

			$id = intval($_POST['id']);
			if($id < 1) return false;

			if(!is_array($_POST['hansel']) || empty($_POST['hansel'])) return false;
			if((!$_POST['hansel']['username']) || empty($_POST['hansel']['username'])) 
				showmessage('请填写用户名');;

			$this->db->update($_POST['hansel'],array('id'=>$id));
			showmessage('操作成功','?m=hansel&c=hansel&a=edit','', 'edit');
			

		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);

			$info = $this->db->get_one( array('id'=>$_GET['id']) );
			if(!$info) showmessage('测试信息不存在');
			//把每个变量变成单个数据
			extract($info);
			include $this->admin_tpl('hansel_edit');
		}
	}


	public function delete() {
		$id = intval($_GET['id']);
		if($id < 1) return false;
		//删除测试会员
		$res = $this->db->delete(array('id'=>$id));
		//更新附件状态
		if(pc_base::load_config('system','attachment_stat')) {
			$this->attachment_db = pc_base::load_model('attachment_model');
			$this->attachment_db->api_delete('hansel-'.$id);
		}
		if($res){
			showmessage('操作成功','?m=hansel&c=hansel');
		}else {
			showmessage('操作失败','?m=hansel&c=hansel');
		}
	}








}