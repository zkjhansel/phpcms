<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<form name="myform" id="myform" action="?m=hansel&c=hansel&a=add" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="5%" align="center">ID</th>
			<th width='10%' align="center">用户名</th>
			<th width='10%' align="center">姓名</th>
			<th width="12%" align="center">年龄</th>
			<th width="10%" align="center">性别</th>
			<th width="12%" align="center">注册时间</th>
			<th width="12%" align="center">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" width="5%"><?php echo $info['id']?></td>

		<td align="center" width="10%"><?php echo $info['username']?></td>
		<td align="center" width="10%"><?php echo $info['truename']?></td>
		<td align="center" width="12%"><?php echo $info['age']?></td>
		<td align="center" width="10%"><?php if ($info['sex']==1) echo '女';else echo '男';?></td>

		<td width="8%" align="center"> <?php echo date('Y-m-d H:i:s',$info['create_time'])?> </td>

		<td align="center" width="12%">
			<a href="###" onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['username']))?>')" title="修改">修改</a> |  
			<a href='?m=hansel&c=hansel&a=delete&id=<?php echo $info['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['username']))))?>')">删除</a> 
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'编辑'+name+' ',id:'edit',iframe:'?m=hansel&c=hansel&a=edit&id='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function checkuid() {
	var ids='';
	$("input[name='linkid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
//向下移动
function listorder_up(id) {
	$.get('?m=link&c=link&a=listorder_up&linkid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('<?php echo L('move_success')?>');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>
</body>
</html>
