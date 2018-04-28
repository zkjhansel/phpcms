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

	private function _session_start() {
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		pc_base::load_sys_class($session_storage);
	}
	
	 /**
	 *	申请报名
	 */
	public function signup() {
		$this->_session_start();

		$phpcms_auth = param::get_cookie('auth');
		if (!$phpcms_auth) {
			exit('请先登录');
		}

		$signData = array();
		$signData['mobile'] = (isset($_POST['mobile']) && !empty($_POST['mobile'])) ? trim($_POST['mobile']) : exit('请填写手机号码');
		$signData['truename']=(isset($_POST['truename']) && !empty($_POST['truename'])) ? trim($_POST['truename']) : exit('请填写您的姓名');
		$signData['group_id'] = (isset($_POST['group_id']) && !empty($_POST['group_id'])) ? trim($_POST['group_id']) : exit('预约失败');

		if(!preg_match('/^1([0-9]{10})$/',$signData['mobile'])) {
			exit('请提供正确的手机号码！');
		}
		$verify = (isset($_POST['verify']) && !empty($_POST['verify'])) ? trim($_POST['verify']) : exit('请填写验证码');
		if ($_SESSION['code'] != strtolower($verify)) {
			$_SESSION['code'] = '';
			exit('验证码输入错误');
		}

		//验证group_id是否存在
		$where = "`start_time` < '".SYS_TIME."' AND `end_time` > '".SYS_TIME."' ";
		$groupids = $this->db->select($where, 'id');
		$ids = array();
		foreach ($groupids as $key => $value) {
			$ids[] = $value['id'];
		}
		if (!in_array($signData['group_id'],$ids)) {
			exit('该团购信息不存在');
		}

		//该团购是否限制最大报名人数
		$groupInfo = $this->db->get_one( array('id'=>$signData['group_id']) );
		if ($groupInfo['max_num']>0 && $groupInfo['sign_num']>=$groupInfo['max_num']) {
			exit('该团购人数已达上限，请选择其他的优惠吧');
		}

		$auth_key = $auth_key = get_auth_key('login');
		list($userid, $password) = explode("\t", sys_auth($phpcms_auth, 'DECODE', $auth_key));
		$userid = intval($userid);

		$signData['office_id'] = $groupInfo['office_id'];
		$signData['add_time'] = SYS_TIME;
		$signData['user_id'] = $userid;


		$this->db_group_sign = pc_base::load_model('group_sign_model');
		$have = $this->db_group_sign->get_one( array('user_id'=>$userid,'group_id'=>$signData['group_id']) );
		if ($have) {
			exit('您已经预约过了该团购');
		}

		$res = $this->db_group_sign->insert($signData,true);
		//更新报名人数
		$this->db->update(array('sign_num'=>'+=1',),array('id'=>$signData['group_id']));
		if (!$res) exit('预约失败');
		
		exit('success');


	} 

	public function ajax_get_details() {

		$group_id = trim($_POST['group_id']);
		if (!is_numeric($group_id)) {
			exit('参数错误');
		}
		$this->db_intro = pc_base::load_model('group_intro_model');

		$intro = $this->db_intro->get_one( array('group_id'=>$group_id) );
		if (empty($intro) || empty($intro['content'])) {
			exit('暂无详情介绍');
		}

		echo $intro['content'];die;

	}


	//个人中心显示我的报名列表
	public function show() {

		$phpcms_auth = param::get_cookie('auth');
		if (!$phpcms_auth) {
			showmessage('请先登录', 'index.php?m=member&c=index&a=login');
		}
		include template('group','show');


	}
	
}
?>