<?php include $this->admin_tpl('header','admin');?>

<style type="text/css" media="screen">
	#start_time,#end_time {
		width: 140px;
	}
</style>

<div class="pad_10">
<form action="?m=group&c=group&a=intro&group_id=<?php echo $group_id; ?>" method="post" name="myform" id="myform" enctype="multipart/form-data">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	
	
	<tr>
		<th width="80"> 详情介绍：</th>
		<td>
			<textarea name="content" id="content"><?php echo $content?></textarea>
			<?php echo form::editor('content','full','','','',1,1)?>
		</td>
	</tr>
 

	<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?m=group&c=group&a=edit"> <input
		type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>

</table>
</form>
</div>
</body>
</html>

