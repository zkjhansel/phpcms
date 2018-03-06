<?php include $this->admin_tpl('header','admin');?>


<style type="text/css" media="screen">
	#start_time,#end_time {
		width: 140px;
	}
</style>

<div class="pad_10">
<form action="?m=group&c=group_sign&a=edit&id=<?php echo $id; ?>" style="margin-top: 10px;" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="20%">所属机构：</th>
		<td><?php echo $offices[$office_id]?></td>
	</tr>
	
	<tr>
		<th width="100">姓名：</th>
		<td><input type="text" value="<?php echo $truename;?>" disabled size="50" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100">手机号：</th>
		<td><input type="text" value="<?php echo $mobile;?>" disabled size="50" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100">报名时间：</th>
		<td>
			<?php echo date('Y-m-d H:i:s',$add_time)?>
		</td>
	</tr>
	
	<tr>
		<th width="20%">审核状态：</th>
		<td>
			<select name="status" <?php if ($status>0) echo "disabled";?> >
				<option value="1" <?php if ($status==1) echo "selected";?>>审核通过</option>
				<option value="2" <?php if ($status==2) echo "selected";?>>不通过</option>
 				<option value="3" <?php if ($status==3) echo "selected";?>>已放弃</option>
			</select>
		<?php if ($status>0) echo "<span style='color:red'>该信息已审核</span>";?></td>
	</tr>

	<tr>
		<th width="100">审核说明：</th>
		<td>
			<textarea name="desc" <?php if ($status>0) echo "disabled";?> style="width: 360px;height: 59px;" placeholder="没有特殊情况可不填写"><?php echo $desc;?></textarea>
		</td>
	</tr>


	<tr>
		<th></th>
		<td>
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value=" <?php echo L('submit')?> ">
		</td>
	</tr>

</table>
</form>
</div>
</body>
</html>

