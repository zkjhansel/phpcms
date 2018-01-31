<?php 

defined('IN_PHPCMS') or exit('No permission resources.');

/*

pc_base::load_config()
pc_base::load_model();

pc_base::load_app_class();
pc_base::load_app_func();

pc_base::load_sys_class();
pc_base::load_sys_func();

*/
class index {

	public function init() {

		echo 'hansel的初始化方法<br>';
		$demo = pc_base::load_app_class('demo');
		$demo->run();

		$demo = pc_base::load_app_func('hanselFun');

		hclick();


	}


	public function left() {

		echo 'left';

	}

}


?>