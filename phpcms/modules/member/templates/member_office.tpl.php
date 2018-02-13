<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');?>
<?php if(ROUTE_A=='manage') {?>
<form name="myform" action="?m=member&c=member_office&a=listorder" method="post">
<div class="pad-lr-10">
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="80">排序</th>
            <th width="100">id</th>
            <th>机构名称</th>
            <th>联系电话</th>
            <th>联系人</th>
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

		$("#name").formValidator({onshow:"请输入机构名称",onfocus:"请输入机构名称",oncorrect:"请输入机构名称"}).inputValidator({min:1,onerror:"请输入机构名称"});


		$("#tel").formValidator({onshow:"请输入联系电话",onfocus:"请输入联系电话",oncorrect:"请输入联系电话"}).inputValidator({min:1,onerror:"请输入联系电话"});

		$("#contract").formValidator({onshow:"请输入联系人",onfocus:"请输入联系人",oncorrect:"请输入联系人"}).inputValidator({min:1,onerror:"请输入联系人"});

		$("#address").formValidator({tipid:'a_tip',onshow:"请输入地址",onfocus:"请输入地址",oncorrect:"请输入地址"}).inputValidator({min:1,onerror:"请输入地址"});
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
<form name="myform" id="myform" action="?m=member&c=member_office&a=add" method="post">
<table width="100%" class="table_form contentWrap">

      <tr>
         <th>机构名称：</th>
         <td><input type="text" name="info[name]" id="name" class="input-text" ></td>
      </tr>


    	<tr>
          <th>联系电话：</th>
          <td><input type="text" name="info[tel]" id="tel" class="input-text" ></td>
      </tr>

    	<tr>
          <th>联系人：</th>
          <td><input type="text" name="info[contract]" id="contract" class="input-text" ></td>
      </tr>

    	<tr>
          <th>地址：</th>
          <td><input type="text" name="info[address]" id="address" class="input-text" ></td>
      </tr>

      <tr>
          <th>排序：</th>
          <td><input type="text" name="info[listorder]" id="listorder" value="0" class="input-text" ></td>
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

    $("#name").formValidator({onshow:"请输入机构名称",onfocus:"请输入机构名称",oncorrect:"请输入机构名称"}).inputValidator({min:1,onerror:"请输入机构名称"});


    $("#tel").formValidator({onshow:"请输入联系电话",onfocus:"请输入联系电话",oncorrect:"请输入联系电话"}).inputValidator({min:1,onerror:"请输入联系电话"});

    $("#contract").formValidator({onshow:"请输入联系人",onfocus:"请输入联系人",oncorrect:"请输入联系人"}).inputValidator({min:1,onerror:"请输入联系人"});

    $("#address").formValidator({tipid:'a_tip',onshow:"请输入地址",onfocus:"请输入地址",oncorrect:"请输入地址"}).inputValidator({min:1,onerror:"请输入地址"});
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
<form name="myform" id="myform" action="?m=member&c=member_office&a=edit" method="post">
<table width="100%" class="table_form contentWrap">


      <tr>
        <th>机构名称：：</th>
        <td><input type="text" name="info[name]" id="name" class="input-text" value="<?php echo $name?>"></td>
      </tr>

    	<tr>
          <th>联系电话：</th>
          <td><input type="text" name="info[tel]" id="tel" class="input-text" value="<?php echo $tel?>"></td>
      </tr>

    	<tr>
            <th>联系人：</th>
            <td><input type="text" name="info[contract]" id="contract" class="input-text" value="<?php echo $contract?>"></td>
      </tr>
    	
      <tr>
            <th>地址：</th>
            <td><input type="text" name="info[address]" id="address" class="input-text" value="<?php echo $address?>"></td>
      </tr>
      <tr>
            <th>排序：</th>
            <td><input type="text" name="info[listorder]" class="input-text" value="<?php echo $listorder?>"></td>
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