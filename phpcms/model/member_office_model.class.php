<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class member_office_model extends model {
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'member_office';
		parent::__construct();
	}

	public function getList() {

		$list = $this->select(array('disabled'=>0),'id,name');
		$new_list = array();
		foreach ($list as $key => $value) {
			$new_list[$value['id']] = $value['name'];
		}
		return $new_list;

	}
}
?>