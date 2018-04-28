<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>
<div id="main_frameid" class="pad-10 display" style="_margin-right:-12px;_width:98.9%;">
<script type="text/javascript">
$(function(){if ($.browser.msie && parseInt($.browser.version) < 7) $('#browserVersionAlert').show();}); 
</script>
<div class="explain-col mb10" style="display:none" id="browserVersionAlert">
<?php echo L('ie8_tip')?></div>
<div class="col-2 lf mr10" style="width:48%">
	<h6>我的个人信息</h6>
	<div class="content">
	您好，<?php echo $admin_username?><br />
	所属角色：<?php echo $rolename?> <br />
	<div class="bk20 hr"><hr /></div>
	上次登录时间：<?php echo date('Y-m-d H:i:s',$logintime)?><br />
	上次登录IP：<?php echo $loginip?> <br />
	</div>
</div>
<div class="col-2 col-auto">
	<h6>安全提示</h6>
	<div class="content" style="color:#ff0000;">
	<?php if($pc_writeable) {?>	
	<?php echo L('main_safety_permissions')?><br />
	<?php } ?>

	<?php if(pc_base::load_config('system','debug')) {?>
	<?php echo L('main_safety_debug')?><br />
	<?php } ?>

	<?php if(!pc_base::load_config('system','errorlog')) {?>
	<?php echo L('main_safety_errlog')?><br />
	<?php } ?>

	<div class="bk20 hr"><hr /></div>	
	<?php if(pc_base::load_config('system','execution_sql')) {?>	
	<?php echo L('main_safety_sql')?> <br />
	<?php } ?>

	<?php if($logsize_warning) {?>	
	<?php echo L('main_safety_log',array('size'=>$common_cache['errorlog_size'].'MB'))?>
	 <br />
	<?php } ?>

	<?php 
	$tpl_edit = pc_base::load_config('system','tpl_edit');
	if($tpl_edit=='1') {?>
	<?php echo L('main_safety_tpledit')?><br />
	<?php } ?>
	</div>
</div>
<div class="bk10"></div>

</div>

<div class="col-2 fl mr10" style="width:48%;float:left;">
	<h6>临沂思学网站开发团队</h6>
	<div class="content">
	版权所有：临沂思学网络传媒有限公司<br />
	团队成员：程序：郑凯建<br />
	UI 设 计：来源网络<br />
	官方网站：<a href="<?php echo SITE_PROTOCOL.SITE_URL?>" target="_blank"><?php echo SITE_PROTOCOL.SITE_URL;?></a> <br />
	资讯Q Q：1125014902 <br />
	联系电话：18264929491
	</div>
</div>

<div class="col-2 col-auto mr10">
	<h6>系统信息</h6>
	<div class="content">
	程序版本：Phpcms <?php echo PC_VERSION?>  Release <?php echo PC_RELEASE?><br />
	操作系统：<?php echo $sysinfo['os']?> <br />
	服务器软件：<?php echo $sysinfo['web_server']?> <br />
	MYSQL版本：<?php echo $sysinfo['mysqlv']?><br />
	上传文件：<?php echo $sysinfo['fileupload']?><br />	
	</div>
</div>
<div class="bk10"></div>




    <div class="bk10"></div>
</div>
</body></html>