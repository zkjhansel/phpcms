<?php include $this->admin_tpl('header','admin');?>
<script type="text/javascript">

	$(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}}); 

	$("#group_title").formValidator({onshow:"请输入团购标题",onfocus:"请输入团购标题"}).inputValidator({min:1,onerror:"请输入团购标题"});

	$("#image").formValidator({onshow:"上传封面",onfocus:"上传封面"}).inputValidator({min:1,onerror:"上传封面"});

	$("#start_time").formValidator({onshow:"请选择开始时间",onfocus:"请选择开始时间"}).inputValidator({min:1,onerror:"请选择开始时间"});

	$("#end_time").formValidator({onshow:"请选择结束时间",onfocus:"请选择结束时间"}).inputValidator({min:1,onerror:"请选择结束时间"});
	
	})

</script>

<style type="text/css" media="screen">
	#start_time,#end_time {
		width: 140px;
	}
</style>

<div class="pad_10">
<form action="?m=group&c=group&a=edit&id=<?php echo $id; ?>" method="post" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">


	<tr>
		<th width="20%">所属机构：</th>
		<td>
			<select name="group[office_id]">

			<?php foreach($offices as $oid=>$name){ ?>
				<option value="<?php echo $oid;?>" <?php if($oid==$office_id){echo "selected";}?> ><?php echo $name;?></option>
			<?php }?>
 
		</select></td>
	</tr>
	
	<tr>
		<th width="100">标题：</th>
		<td><input type="text" name="group[title]" value="<?php echo $title;?>" id="group_title" size="50" class="input-text"></td>
	</tr>
	
	<tr>
		<th width="100">简短描述：</th>
		<td><input type="text" name="group[desc]" value="<?php echo $desc;?>" id="group_desc" size="50" class="input-text"></td>
	</tr>
	
	<tr id="logogroup">
		<th width="100">封面图：</th>
		<td><?php echo form::images('group[image]', 'image', $image, 'group')?>
		</td>
	</tr>
 
	<tr>
		<th width="100">开始时间：</th>
		<td>
			<?php echo form::date('group[start_time]',date('Y-m-d',$start_time))?>
		</td>
	</tr>

	<tr>
		<th>结束时间：</th>
		<td>
		<?php echo form::date('group[end_time]',date('Y-m-d',$end_time))?>
		</td>
	</tr>

 
	<tr>
		<th>市场价：</th>
		<td><input type="number" name="group[market_price]" value="<?php echo $market_price;?>" id="market_price" size="30" class="input-text">
		<span style="color: red">不填写则显示"待定"</span>
		</td>
	</tr>
	 
	<tr>
		<th>团购价：</th>
		<td><input type="number" name="group[low_price]" value="<?php echo $low_price;?>" id="low_price" size="30" class="input-text">
		<span style="color: red">不填写则显示"待定"</span>
	</td>
	</tr>
	
	<tr>
		<th>授课地址：</th>
		<td><input type="text" name="group[address]" size="30" value="<?php echo $address;?>" class="input-text"></td>
	</tr>

	<tr>
		<th>客服电话：</th>
		<td><input type="text" name="group[phone]" id="phone" value="<?php echo $phone;?>" size="30" class="input-text"></td>
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

