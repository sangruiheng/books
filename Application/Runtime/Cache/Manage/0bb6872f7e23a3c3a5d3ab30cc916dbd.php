<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<!--公共css-->
<link rel="stylesheet" type="text/css" href="/Public/Manage/tools/bootstrap-3.2.0-dist/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/fontIcon/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/common/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/alert.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/tools/iCheck/flat/blue.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/js/tools/icpntDialog/css/icpntDialog.css" />
<!--公共js-->
<script type="text/javascript" src="/Public/Manage/js/common/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/Public/Manage/js/common/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Manage/tools/bootstrap-3.2.0-dist/js/bootstrap.js"></script>
<script type="text/javascript" src="/Public/Manage/tools/Validform_v5.3.2/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="/Public/Manage/js/tools/icpntDialog/js/icpntDialog.js"></script>
<script type="text/javascript" src="/Public/Manage/tools/iCheck/icheck.js"></script>
<script type="text/javascript" src="/Public/Manage/js/common/common.js"></script>
<script type="text/javascript" src="/Public/Manage/postInfo/postInfo.js"></script>
<script>
//定义ThinkPHP模板常量，方便在js中使用
var APP = '/manage.php';
var PUBLIC = '/Public/Manage';
var URL = '/manage.php/System';
var CONTROLLER_NAME = '<?php echo (CONTROLLER_NAME); ?>';
var ACTION_NAME = '<?php echo (ACTION_NAME); ?>';
var GROUPID = '<?php echo ($_SESSION['crm_rules']); ?>';
var AUTH_ADD_ID = '<?php echo C('AUTH_MODULE.auth_add_id');?>';
var AUTH_DEL_ID = '<?php echo C('AUTH_MODULE.auth_del_id');?>';
var AUTH_SAVE_ID = '<?php echo C('AUTH_MODULE.auth_save_id');?>';
var AUTH_USER_ID = '<?php echo C('AUTH_MODULE.auth_user_id');?>';
var AUTH_GROUP_ID = '<?php echo C('AUTH_MODULE.auth_group_id');?>';
var PAGE = '<?php echo ($_GET['p']); ?>';
var KEYWORD = '<?php echo ($_GET['keyWord']); ?>';
$(document).ready(function(e) {
    $('input[data-name=multi-select]').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue'
	});
	
});
</script>
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/common/rightCommon.css" />
<style>
.uploadify-button {height: 30px;line-height: 30px;width: 120px;border-radius: inherit;background: #5cb85c;border: none;font-family: '宋体';}
.addForm tr td .on{background-color: #449d44;color:#fff;}
.select-all{float: left;margin: 6px 17px;border: 1px solid #ccc;border-radius: 5px;background: #ccc;height: 34px;line-height: 34px; padding-left: 12px;padding-right: 12px;cursor: pointer;}
i.faTd{padding:5px; font-size:16px; cursor:pointer;}
i.faTd:hover{ background:#000; color:#fff; border-radius:2px;}
</style>
<script>
$(document).ready(function(e) {
	getEditData(function(jdata){
		var parentID = parseInt(jdata.parent_id);
		var moduleLink = jdata.moduleLink;
		if(parentID > 0){
			$('select.moduleType').val(2);
			$.post(APP+'/Common/getEditData',{table:'Module',where:'parent_id = 0',field:'id,moduleName'},function(ret){
				if(parseInt(ret.code) == 200){
					var thisHTML = '<tr class="moduleList"><td align="center">主模块列</td><td colspan="3"><div>';
					for(var i=0;i<ret.data.length;i++){
						if(parseInt(ret.data[i].id) == parentID){
							thisHTML += '<div class="select-all on" data-id="'+ret.data[i].id+'">'+ret.data[i].moduleName+'</div>';
						}else{
							thisHTML += '<div class="select-all" data-id="'+ret.data[i].id+'">'+ret.data[i].moduleName+'</div>';
						}
						
					}
					thisHTML += '</div></td></tr>';
					$('tr.moduleTypeList').after(thisHTML);
					
					//增加子模块链接
					$('td.module_name').attr('colspan','');
					var trHTML = '<td align="center" class="module_link">模块链接</td>';
					trHTML += '<td class="module_link"><input type="text" class="form-control" value="'+moduleLink+'" name="moduleLink" id="moduleLink" placeholder="请输入模块链接" /></td>';
					$('td.module_name').after(trHTML);
				}
			});
		}
	});
	//选择模块分类
	$('select.moduleType').change(function(){
		var thisVal = $(this).val();
		if(parseInt(thisVal) == 2){
			$('tr.moduleList').remove();
			$.post(APP+'/Common/getEditData',{table:'Module',where:'parent_id = 0',field:'id,moduleName'},function(ret){
				if(parseInt(ret.code) == 200){
					var thisHTML = '<tr class="moduleList"><td align="center">主模块列</td><td colspan="3"><div>';
					for(var i=0;i<ret.data.length;i++){
						thisHTML += '<div class="select-all" data-id="'+ret.data[i].id+'">'+ret.data[i].moduleName+'</div>';
					}
					thisHTML += '</div></td></tr>';
					$('tr.moduleTypeList').after(thisHTML);
					//增加子模块链接
					$('td.module_name').attr('colspan','');
					var trHTML = '<td align="center" class="module_link">模块链接</td>';
					trHTML += '<td class="module_link"><input type="text" class="form-control" name="moduleLink" id="moduleLink" placeholder="请输入模块链接" /></td>';
					$('td.module_name').after(trHTML);
				}else{
					updateAlert(ret.msg);
                    setTimeout(function(){
                        $('#top-alert').find('button').click();
                        $('#top-alert').removeClass('disabled').prop('disabled',false);
                    },1500);
				}
			});
		}else{
			$('tr.moduleList').remove();
			$('td.module_link').remove();
			$('td.module_name').attr('colspan',3);
		}
	});
	//主模板点击事件
	$('div.add-box').on('click','div.select-all',function(){
		$(this).addClass('on').siblings().removeClass('on');
		$('input#parent_id').val($(this).attr('data-id'));
	});
	//icon点击事件
	$('i.faTd').click(function(){
		var thisName = $(this).attr('name');
		$('input#moduleIcon').val(thisName);
	});
});
</script>
</head>

<body>
<!--alert弹窗Start  -->
<div id="top-alert" class="fixed alert alert-error" style="display:none;">
	<button class="close fixed" style="margin-top: -18px;margin-right: 7px;">&times;</button>
    <div class="alert-content">这是内容</div>
</div>
<!--alert弹窗end  -->
<nav class="navbar navbar-default" role="navigation">
<div class="navbar-header">
<a class="navbar-brand" href="#"><i class="fa fa-plus" aria-hidden="true"></i> <span id="changeTitle">添加</span>模块</a>
</div>
</nav>

<div class="add-box">
<form class="addForm ajax-fadein" id="form1" name="form1" method="post" action="/manage.php/Common/addData/controller/System/backUrl/moduleList/table/Module">
<input name="id" type="hidden" id="id" value="<?php echo ($_GET['id']); ?>" />
<input type="hidden" name="parent_id" id="parent_id" value="0"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
      <tr class="moduleTypeList">
        <td align="center">模块分类</td>
        <td colspan="3"><select class="form-control moduleType">
          <option value="0" selected="selected">请选择模块分类</option>
          <option value="1">主模块</option>
          <option value="2">子模块</option>
        </select></td>
      </tr>
      
      <tr>
        <td align="center">模块名称</td>
        <td colspan="3" class="module_name"><input type="text" class="form-control" name="moduleName" id="moduleName" placeholder="请输入模块名称" /></td>
        <!-- <td align="center">模块链接</td>
        <td><input type="text" class="form-control" name="moduleLink" id="moduleLink" placeholder="请输入模块链接" /></td> -->
      </tr>
      
      <tr>
        <td align="center">选择图标</td>
        <td><input type="text" class="form-control" name="moduleIcon" id="moduleIcon" readonly /></td>
        <td align="center">排序</td>
        <td><input type="text" class="form-control" name="sort" id="sort" value="0" placeholder="数字越大越靠前"/></td>
      </tr>
      
      <tr>
        <td align="center">选择图标</td>
        <td colspan="3">
	        <?php if(is_array($iconList)): $i = 0; $__LIST__ = $iconList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><i class="fa faTd fa-<?php echo ($vo["iconName"]); ?>" name="<?php echo ($vo["iconName"]); ?>" aria-hidden="true"></i><?php endforeach; endif; else: echo "" ;endif; ?>
        </td>
      </tr>
      
      <tr>
        <td align="center">状态</td>
        <td ><select name="status" id="status" class="form-control">
          <option value="0" selected="selected">显示前台</option>
          <option value="1">禁止显示</option>
        </select></td>
        <td align="center">是否生成文件</td>
        <td><select name="is_file" id="is_file" class="form-control">
        	<option value="0" selected="selected">否</option>
          	<option value="1">是</option>
        </select></td>
      </tr>
      
      <tr>
        <td align="center">是否生成添加\修改文件</td>
        <td><select name="is_add_file" id="is_add_file" class="form-control">
        	<option value="0" selected="selected">否</option>
          	<option value="1">是</option>
        </select></td>
        <td align="center">表名</td>
        <td><input type="text" class="form-control" name="is_table" id="is_table" placeholder="请输入表名" /></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
        <button type="submit" class="btn btn-success" id="saveButton"><i class="fa fa-check" aria-hidden="true"></i> 添加</button>
        <button type="button" class="btn btn-default" id="cancelButton"><i class="fa fa-times" aria-hidden="true"></i> 取消</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>  
</div>

</body>
</html>