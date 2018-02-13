<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">

$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});

	$("#group_title").formValidator({onshow:"请输入团购标题",onfocus:"请输入团购标题"}).inputValidator({min:1,onerror:"请输入团购标题"});


	 
})

</script>

<div class="pad_10">
<form action="?m=group&c=group&a=add" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="20%">所属机构：</th>
		<td>
			<select name="group[office_id]">
			<?php foreach($offices as $oid=>$name){ ?>
				<option value="<?php echo $oid;?>"><?php echo $name;?></option>
			<?php }?>
			</select>
			</td>
	</tr>
	
	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="group[title]" id="group_title" size="30" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100">简短描述：</th>
		<td><input type="text" name="group[desc]" id="group_desc" size="30" class="input-text"></td>
	</tr>
	
	<tr id="logogroup">
		<th width="100">封面图：</th>
		<td><?php echo form::images('group[image]', 'image', '', 'group')?></td>
	</tr>
	
	<tr>
		<th width="100">开始时间：</th>
		<td><input type="text" name="group[start_time]" id="start_time" size="30" class="input-text"></td>
	</tr>

	<tr>
		<th>结束时间：</th>
		<td><input type="text" name="group[end_time]" id="end_time" size="30" class="input-text"></td>
	</tr>
	<tr>
		<th>市场价：</th>
		<td><input type="text" name="group[market_price]" id="market_price" size="30" class="input-text"></td>
	</tr>
	 
	<tr>
		<th>团购价：</th>
		<td><input type="text" name="group[low_price]" id="low_price" size="30" class="input-text"></td>
	</tr>

	<tr>
		<th>客服电话：</th>
		<td><input type="text" name="group[phone]" id="phone" size="30" class="input-text"></td>
	</tr>

	<tr>
		<th>最大报名数：</th>
		<td><input type="text" name="group[max_num]" id="max_num" size="30" class="input-text"></td>
	</tr>
	



<tr>
		<th></th>
		<td><input type="hidden" name="forward" value="?m=group&c=group&a=add"> <input
		type="submit" name="dosubmit" id="dosubmit" class="dialog"
		value=" <?php echo L('submit')?> "></td>
	</tr>

</table>
</form>
</div>
</body>
</html> 