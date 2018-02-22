<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	function __construct() {
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
  		$this->db = pc_base::load_model('group_model');
  		$this->db_office = pc_base::load_model('member_office_model');
	}
	
	public function init() {
		$siteid = SITEID;
		$SEO = seo($siteid);

		$where = "1";
		//搜索关键字
		if ($_POST['searchword']) {
			$searchword = trim($_POST['searchword']);
			$where .= " AND title LIKE '%$searchword%'";
		}
		$page  = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
		$where .= " AND `start_time` < '".SYS_TIME."' AND `end_time` > '".SYS_TIME."' ";
		$group_list = $this->db->listinfo($where, 'listorder ASC', $page,5);

		$count = $this->db->count($where);
		//echo '<pre>';print_r($group_list);die;
		$pages = $this->db->pages;
		$offices = $this->db_office->getList();

		pc_base::load_sys_class('form', '', 0);
		include template('group', 'index');
	}

	//ajax判断是否登录
	public function ajax_check_login() {
		$phpcms_auth = param::get_cookie('auth');
		if (!$phpcms_auth) {
			exit('0');
		}
		exit('success');
	}
	
	 /**
	 *	申请报名
	 */
	public function signup() {
		
		$phpcms_auth = param::get_cookie('auth');
		if (!$phpcms_auth) {
			exit('请先登录');
		}
		if (empty($_POST['mobile'])) exit('请填写手机号码');
		if (empty($_POST['truename'])) exit('请填写您的姓名');
		if (empty($_POST['verify'])) exit('请填写验证码');

		

		$mobile = $_POST['mobile'];


	} 
 	
	 /**
	 *	申请友情链接 
	 */
	public function register() { 
 		$siteid = SITEID;
 		if(isset($_POST['dosubmit'])){
 			if($_POST['name']==""){
 				showmessage(L('sitename_noempty'),"?m=link&c=index&a=register&siteid=$siteid");
 			}
 			if($_POST['url']=="" || !preg_match('/^http:\/\/(.*)/i', $_POST['url'])){
 				showmessage(L('siteurl_not_empty'),"?m=link&c=index&a=register&siteid=$siteid");
 			}
 			if(!in_array($_POST['linktype'],array('0','1'))){
 				$_POST['linktype'] = '0';
 			}
 			$link_db = pc_base::load_model(link_model);
 			$_POST['logo'] =new_html_special_chars($_POST['logo']);

			$logo = safe_replace(strip_tags($_POST['logo']));
			if(!preg_match('/^http:\/\/(.*)/i', $logo)){
				$logo = '';
			}
			$name = safe_replace(strip_tags($_POST['name']));
			$url = safe_replace(strip_tags($_POST['url']));
			$url = trim_script($url);
 			if($_POST['linktype']=='0'){
 				$sql = array('siteid'=>$siteid,'typeid'=>intval($_POST['typeid']),'linktype'=>intval($_POST['linktype']),'name'=>$name,'url'=>$url);
 			}else{
 				$sql = array('siteid'=>$siteid,'typeid'=>intval($_POST['typeid']),'linktype'=>intval($_POST['linktype']),'name'=>$name,'url'=>$url,'logo'=>$logo);
 			}
 			$link_db->insert($sql);
 			showmessage(L('add_success'), "?m=link&c=index&siteid=$siteid");
 		} else {
  			$setting = getcache('link', 'commons');
			$setting = $setting[$siteid];
 			if($setting['is_post']=='0'){
 				showmessage(L('suspend_application'), HTTP_REFERER);
 			}
 			$this->type = pc_base::load_model('type_model');
 			$types = $this->type->get_types($siteid);//获取站点下所有友情链接分类
 			pc_base::load_sys_class('form', '', 0);
  			$SEO = seo(SITEID, '', L('application_links'), '', '');
   			include template('link', 'register');
 		}
	} 
	
}
?>