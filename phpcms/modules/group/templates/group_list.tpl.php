<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

<form name="myform" id="myform" action="?m=group&c=group&a=listorder" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('groupid[]');"></th>
			<th width="35" align="center">排序</th>
			<th>标题</th>
			<th width="12%" align="center">所属机构</th>
			<th width="10%" align="center">开始时间</th>
			<th width='10%' align="center">结束时间</th>
			<th width="8%" align="center">团购价</th>
			<th width="8%" align="center">已报名</th>
			<th width="8%" align="center">人气值</th>
			<th width="12%" align="center"><?php echo L('operations_manage')?></th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td align="center" width="35"><input type="checkbox" name="groupid[]" value="<?php echo $info['id']?>"></td>

		<td align="center" width="35">
			<input name='listorders[<?php echo $info['id']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c">
		</td>

		<td><a href="/index.php?m=group&c=index&a=details&id=<?php echo $info['id'];?>" title="<?php echo new_html_special_chars($info['title'])?>" target="_blank"><?php echo new_html_special_chars($info['title'])?></a> </td>

		<td align="center" width="12%">
			<?php echo $offices[$info['office_id']] ?>
		</td>

		<td align="center" width="10%"><?php echo date('Y-m-d',$info['start_time']);?></td>
		<td align="center" width="10%"><?php echo date('Y-m-d',$info['end_time']);?></td>


		<td width="8%" align="center"><?php echo $info['low_price'] ?></td>

		<td width="8%" align="center"><?php echo $info['sign_num']?></td>

		<td width="8%" align="center"><?php echo $info['popular'] ?></td>

		<td align="center" width="12%">
			<a href="###" onclick="edit(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['title']))?>')" title="修改">修改</a> |  
			<a href="###" onclick="intro(<?php echo $info['id']?>, '<?php echo new_addslashes(new_html_special_chars($info['title']))?>')" title="修改">详情</a> |  
			<a href='?m=group&c=group&a=delete&groupid=<?php echo $info['id']?>' onClick="return confirm('<?php echo L('confirm', array('message' => new_addslashes(new_html_special_chars($info['title']))))?>')">删除</a>  |  
			<a href='?m=group&c=group_sign&a=init&groupid=<?php echo $info['id']?>'>报名列表</a>
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="btn"> 
<input name="dosubmit" type="submit" class="button" value="排序">&nbsp;&nbsp;
<input type="submit" class="button" name="dosubmit" onClick="document.myform.action='?m=group&c=group&a=delete'" value="删除"/>
</div>
<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">

//编辑弹窗
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?m=group&c=group&a=edit&groupid='+id,width:'700',height:'450'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

//详情弹窗
function intro(id, name) {
	window.top.art.dialog({id:'intro'}).close();
	window.top.art.dialog({title:' '+name+' 的详情',id:'intro',iframe:'?m=group&c=group&a=intro&groupid='+id,width:'900',height:'450'}, function(){var d = window.top.art.dialog({id:'intro'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'intro'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='groupid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:"<?php echo L('before_select_operations')?>",lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}
</script>
</body>
</html>
