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
var URL = '/manage.php/Salbum';
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
</head>

<body>
<!--alert弹窗Start  -->
<div id="top-alert" class="fixed alert alert-error" style="display:none;">
	<button class="close fixed" style="margin-top: 4px;">&times;</button>
	<div class="alert-content">这是内容</div>
</div>
<!--alert弹窗end  -->
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<a class="navbar-brand" href="#">当前分类:<?php echo ($thisScategory["scategory_name"]); ?></a>
	</div>
	<div>
		<button type="button" class="btn btn-default navbar-btn listButton" onclick="window.location.href = '/manage.php/Scategory/tellingScategoryList'"><i class="fa fa-times" aria-hidden="true"></i> 返回讲故事分类</button>
		<button type="button" value="<?php echo ($thisScategory["id"]); ?>" class="btn btn-danger navbar-btn listButton" onclick="deleteTellingSalbum(this,'salbum')"><i class="fa fa-trash-o" aria-hidden="true"></i> 删除</button>
		<button type="button" class="btn btn-info navbar-btn listButton" onclick="editData('addTellingSalbum')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 修改</button>
		<button type="button" value="<?php echo ($thisScategory["id"]); ?>" class="btn btn-success navbar-btn listButton" onclick="openAddTellingSalbum(this,'addTellingSalbum')"><i class="fa fa-plus" aria-hidden="true"></i> 新建</button>
		<form class="navbar-form navbar-right listSearch" role="search" method="get" action="/manage.php/Salbum/tellingSalbumList">

			<div class="form-group">
				<input name="keyWord" type="text" class="form-control" id="keyWord" placeholder="请输入关键词进行搜索">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> 搜索</button>
		</form>
	</div>
</nav>
<input name="navcate_pid" type="hidden" id="navcate_pid" value="<?php echo ($_GET['navcate_pid']); ?>" />
<div class="list-box">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th>选择</th>
			<th>编号</th>
			<th>专辑名称</th>
			<th>专辑类型</th>
			<th>专辑头图</th>
		</tr>
		</thead>
		<tbody>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><input type="checkbox" name="del_listID" id="del_listID" data-name="multi-select" value="<?php echo ($vo["id"]); ?>" /></td>
				<td><?php echo ($vo["id"]); ?></td>
				<td><?php echo ($vo["salbum_name"]); ?></td>
				<td><?php echo $vo['salbum_type']==0?'听故事':'讲故事' ?></td>
				<td>
					<img  src="/Uploads/Manage/<?php echo $vo['salbum_headimg']?>" width="100" height="100" class="newsimgs" alt="图片未找到" style="padding: 5px">
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>

<ul class="pagination">
	<?php echo ($page); ?>
</ul>
<script src="/Public/Manage/js/status/status.js"></script>
<script>
    function openAddTellingSalbum(obj,src){
        var scategory_id = $(obj).attr('value');
        if (typeof(src) != "undefined") {
            window.location.href = APP+'/'+CONTROLLER_NAME+'/'+src+'/scategory_id/'+scategory_id;
        }else{
            $.show({
                title : '提示',
                isConfirm: false,
                content : '未检测到指定页面'
            });
        }
    }
    //删除
    function deleteTellingSalbum(obj,table){
        var scategory_id = $(obj).attr('value');
        var delID = '';
        $("input[name=del_listID]:checked").each(function() {
            delID += $(this).val() + ",";
        });
        if(delID.length <= 0){
            $.show({
                title : '提示',
                isConfirm: false,
                content : '请选择要删除的数据！'
            });
        }else{
            $.showAsk({
                title : '删除数据',
                type : 'warning',
                content : '确定要删除吗？',
                callback : function(){
                    $.post(APP+'/Salbum/delTellingSalbum',{delID : delID,table : table},function(){
                        window.location.href=APP+'/Salbum/tellingSalbumList?scategory_id='+scategory_id ;
                    });
                }
            });
        }
    }

</script>
</body>
</html>