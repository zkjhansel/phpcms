<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<?php if(ROUTE_A=='manage') {?>
<form name="myform" action="?m=member&c=member_pcmenu&a=listorder" method="post">
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="80">排序</th>
            <th width="100">id</th>
            <th>菜单名称</th>
			       <th>管理操作</th>
            </tr>
        </thead>
      	<tbody>
          <?php echo $categorys;?>
      	</tbody>
    </table>
    <div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>  </div>
</div>
</div>
</form>
</body>
</html>


<?php } elseif(ROUTE_A=='add') {?>
<script type="text/javascript">
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg){}});

		$("#name").formValidator({onshow:"请输入菜单名称",onfocus:"请输入菜单名称",oncorrect:"请输入菜单名称"}).inputValidator({min:1,onerror:"请输入菜单名称"});


		$("#m").formValidator({onshow:"请输入模块名",onfocus:"请输入模块名",oncorrect:"请输入模块名"}).inputValidator({min:1,onerror:"请输入模块名"});

		$("#c").formValidator({onshow:"请输入文件名",onfocus:"请输入文件名",oncorrect:"请输入文件名"}).inputValidator({min:1,onerror:"请输入文件名"});

		$("#a").formValidator({tipid:'a_tip',onshow:"请输入方法名",onfocus:"请输入方法名",oncorrect:"请输入方法名"}).inputValidator({min:1,onerror:"请输入方法名"});
	})

</script>
<style type="text/css">
  #dosubmit {
    padding: 12px;
    line-height: 0;
    cursor: pointer;
  }
</style>
<div class="common-form">
<form name="myform" id="myform" action="?m=member&c=member_pcmenu&a=add" method="post">
<table width="100%" class="table_form contentWrap">

      <tr>
         <th>菜单名称：</th>
         <td><input type="text" name="info[name]" id="name" class="input-text" ></td>
      </tr>


    	<tr>
          <th>模块名：</th>
          <td><input type="text" name="info[m]" id="m" class="input-text" ></td>
      </tr>

    	<tr>
          <th>文件名：</th>
          <td><input type="text" name="info[c]" id="c" class="input-text" ></td>
      </tr>

    	<tr>
          <th>方法名：</th>
          <td><input type="text" name="info[a]" id="a" class="input-text" ></td>
      </tr>

    	<tr>
          <th>附加参数：</th>
          <td><input type="text" name="info[data]" class="input-text" ></td>
      </tr>

      <tr>
          <th>排序：</th>
          <td><input type="text" name="info[listorder]" id="listorder" value="0" class="input-text" ></td>
      </tr>

    	<tr>
        <th>是否显示菜单：</th>
        <td><input type="radio" name="info[display]" value="1" checked> 是
            <input type="radio" name="info[display]" value="0"> 否
        </td>
      </tr>

</table>
<!--table_form_off-->
</div>
    <div class="bk15"></div>
	<div class="btn" style="padding-left: 320px;"><input type="submit" id="dosubmit" class="button" name="dosubmit" value="提交"/></div>
</div>

</form>

<?php } elseif(ROUTE_A=='edit') {?>
<script type="text/javascript">
  
  $(function(){
    $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg){}});

    $("#name").formValidator({onshow:"请输入菜单名称",onfocus:"请输入菜单名称",oncorrect:"请输入菜单名称"}).inputValidator({min:1,onerror:"请输入菜单名称"});


    $("#m").formValidator({onshow:"请输入模块名",onfocus:"请输入模块名",oncorrect:"请输入模块名"}).inputValidator({min:1,onerror:"请输入模块名"});

    $("#c").formValidator({onshow:"请输入文件名",onfocus:"请输入文件名",oncorrect:"请输入文件名"}).inputValidator({min:1,onerror:"请输入文件名"});

    $("#a").formValidator({tipid:'a_tip',onshow:"请输入方法名",onfocus:"请输入方法名",oncorrect:"请输入方法名"}).inputValidator({min:1,onerror:"请输入方法名"});
  })
</script>
<style type="text/css">
  #dosubmit {
    padding: 12px;
    line-height: 0;
    cursor: pointer;
  }
</style>
<div class="common-form">
<form name="myform" id="myform" action="?m=member&c=member_pcmenu&a=edit" method="post">
<table width="100%" class="table_form contentWrap">


      <tr>
        <th>菜单名称：：</th>
        <td><input type="text" name="info[name]" id="name" class="input-text" value="<?php echo $name?>"></td>
      </tr>

    	<tr>
          <th>模块名：</th>
          <td><input type="text" name="info[m]" id="m" class="input-text" value="<?php echo $m?>"></td>
      </tr>

    	<tr>
            <th>文件名：</th>
            <td><input type="text" name="info[c]" id="c" class="input-text" value="<?php echo $c?>"></td>
      </tr>
    	
      <tr>
            <th>方法名：</th>
            <td><input type="text" name="info[a]" id="a" class="input-text" value="<?php echo $a?>"></td>
      </tr>

    	<tr>
            <th>附加参数：</th>
            <td><input type="text" name="info[data]" class="input-text" value="<?php echo $data?>"></td>
      </tr>

      <tr>
            <th>排序：</th>
            <td><input type="text" name="info[listorder]" class="input-text" value="<?php echo $listorder?>"></td>
      </tr>

    	<tr>
        <th>是否显示菜单：</th>
        <td><input type="radio" name="info[display]" value="1" <?php if($display) echo 'checked';?>> 是
           <input type="radio" name="info[display]" value="0" <?php if(!$display) echo 'checked';?>> 否</td>
      </tr>

</table>
<!--table_form_off-->
</div>
    <div class="bk15"></div>
	<input name="id" type="hidden" value="<?php echo $id?>">
    <div class="btn" style="padding-left: 230px;"><input type="submit" id="dosubmit" class="button" name="dosubmit" value="提交"/></div>
</div>

</form>
<?php }?>
</body>
</html>