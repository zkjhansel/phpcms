<?php
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">

</script>

<div class="pad_10">
<form action="?m=hansel&c=hansel&a=edit&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<tr>
		<th width="100">用户名：</th>
		<td><input type="text" name="hansel[username]" id="username"
			size="30" class="input-text" value="<?php echo $username;?>"></td>
	</tr>
	
	<tr>
		<th width="100">姓名：</th>
		<td><input type="text" name="hansel[truename]" id="truename"
			size="30" class="input-text" value="<?php echo $truename;?>"></td>
	</tr>


	<tr>
		<th width="100">年龄：</th>
		<td><input type="text" name="hansel[age]" id="age"
			size="30" class="input-text" value="<?php echo $age;?>"></td>
	</tr>

	<tr>
		<th width="100">性别：</th>
		<td><input type="radio" name="hansel[sex]" <?php if ($sex==0) echo 'checked'?> class="input-text" value="0">男
			&nbsp;
			<input type="radio" name="hansel[sex]" <?php if ($sex==1) echo 'checked'?> class="input-text" value="1">女
		</td>
	</tr>


	<tr>
		<th width="100">注册时间：</th>
		<td>
			<?php echo form::date('hansel[create_time]', date('Y-m-d H:i:s',$create_time),1)?>
		</td>
	</tr>

	<tr>
		<th width="100">头像：</th>
		<td><?php echo form::images('hansel[head_logo]', 'head_logo', $info['head_logo'], 'hansel')?></td>
	</tr>

<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?m=hansel&c=hansel&a=edit"> 
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交修改"></td>
	</tr>

</table>
</form>
</div>
</body>
</html>

