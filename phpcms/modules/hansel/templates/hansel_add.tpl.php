<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">

$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});

	$("#username").formValidator({onshow:"请输入用户名",onfocus:"请正确输入用户名"}).inputValidator({min:3,onerror:"用户名至少三个字符"});

 	$("#truename").formValidator({onshow:"请输入会员姓名",onfocus:"请输入会员的真实姓名"}).inputValidator({min:1,onerror:"至少一个字符"});

 	$("#age").formValidator({onshow:"请输入会员年龄",onfocus:"请输入会员年龄"}).inputValidator({min:1,onerror:"最小为1"});
	 
})

</script>

<div class="pad_10">
<form action="?m=hansel&c=hansel&a=add" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	
	<tr>
		<th width="100">用户名：</th>
		<td><input type="text" name="hansel[username]" id="username"
			size="30" class="input-text"></td>
	</tr>

	<tr>
		<th width="100">姓名：</th>
		<td><input type="text" name="hansel[truename]" id="truename"
			size="30" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100">性别：</th>
		<td>
		<input name="hansel[sex]" type="radio" value="0" checked="checked" style="border:0" class="radio_style">
	男&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="hansel[sex]" value="1" style="border:0" class="radio_style">
	女
		</td>
	</tr>
	
	<tr>
		<th width="100">年龄：</th>
		<td><input type="text" name="hansel[age]" id="age" size="30" class="input-text"></td>
	</tr>


	<tr id="logolink">
		<th width="100">头像：</th>
		<td><?php echo form::images('hansel[head_logo]', 'head_logo', '', 'hansel')?></td>
	</tr>
	

<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?m=hansel&c=hansel&a=add"> 
			<input type="submit" name="dosubmit" id="dosubmit" class="dialog" value="提交"></td>
	</tr>

</table>
</form>
</div>
</body>
</html> 