<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="post" >

<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
				报名时间：
				<?php echo form::date('start_time', $_POST['start_time'])?>-
				<?php echo form::date('end_time', $_POST['end_time'])?>
				手机号码：
				<input name="mobile" type="text" placeholder="报名输入的手机号码" value="<?php if(isset($_POST['mobile'])) {echo $_POST['mobile'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="搜索" />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="?m=group&c=group_sign&a=allDo" method="post" onsubmit="checkuid();return false;">
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
			
			<th align="left">用户ID</th>
			<th align="left">手机号码</th>
			<th align="left">姓名</th>
			<th align="left">报名时间</th>
			<th align="left">机构名称</th>
			<th align="left">状态</th>
			<th align="left">操作</th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($infos)){
	foreach($infos as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="id[]"></td>
		<td align="left"><?php echo $v['user_id']?></td>
		<td align="left"><?php echo $v['mobile']?></td>
		<td align="left"><?php echo $v['truename']?></td>
		<td align="left"><?php echo format::date($v['add_time'], 1);?></td>
		<td align="left"><?php echo $offices[$v['office_id']]?></td>
		<td align="left">
			<?php 
				if ($v['status']==0) {
					echo '未审核';
				} elseif ($v['status']==1) {
					echo "<span style='color:green'>已通过</span>";
				} elseif ($v['status']==2) {
					echo "<span style='color:red'>已拒绝</span>";
				} elseif ($v['status']==3) {
					echo "<span style='color:red'>已放弃</span>";
				}
			?>
		</td>
		<td align="left">
			<a href="javascript:edit(<?php echo $v['id']?>, '<?php echo $v['truename']?>')">[审核]</a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
	<label for="check_box">全选/取消</label>
	<input type="submit" class="button" name="dosubmit" value="批量审核" onclick="return confirm('批量通过么？')"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'审核报名会员【'+name+'】',id:'edit',iframe:'?m=group&c=group_sign&a=edit&id='+id,width:'700',height:'300'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}


function checkuid() {
	var ids='';
	$("input[name='id[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});

	if(ids=='') {
		window.top.art.dialog({content:'请选择要批量操作的内容',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}



</script>
</body>
</html>