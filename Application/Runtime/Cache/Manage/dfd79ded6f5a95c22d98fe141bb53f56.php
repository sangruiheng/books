<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
var URL = '/manage.php/Bgm';
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


    <script>
        $(document).ready(function (e) {
            getEditData(function (e) {
                var str = `
                             <audio id="upload_bgm_url" src='/Uploads/Manage/${e.bgm_url}' controls="controls">
                                Your browser does not support the audio element.
                            </audio>
                        `;
                $('.uploaded').html(str);
            });
        });
    </script>

    <style>
        .file {
            position: relative;
            display: inline-block;
            background: #D0EEFF;
            border: 1px solid #99D3F5;
            border-radius: 4px;
            padding: 4px 12px;
            overflow: hidden;
            color: #1E88C7;
            text-decoration: none;
            text-indent: 0;
            line-height: 20px;
        }

        .file input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
        }

        .file:hover {
            background: #AADFFD;
            border-color: #78C3F3;
            color: #004974;
            text-decoration: none;
        }
    </style>
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
        <a class="navbar-brand" href="#"><i class="fa fa-plus" aria-hidden="true"></i> <span id="changeTitle">添加</span>背景音乐</a>
    </div>
</nav>

<div class="add-box">
    <form class="addForm ajax-alert" id="form1" name="form1" method="post"
          action="/manage.php/Bgm/addBgmData/controller/Bgm/backUrl/bgmList/table/bgm">
        <input name="id" type="hidden" id="id" value="<?php echo ($_GET['id']); ?>"/>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>

            <tr>
                <td align="center">所属音乐分类</td>
                <td colspan="5">
                    <select id="mcategory_id" name="mcategory_id" class="form-control">
                        <option value="">--请选择--</option>
                        <?php if(is_array($mcategory)): $i = 0; $__LIST__ = $mcategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["mcategory_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>


            <tr>
                <td align="center">背景音乐名称</td>
                <td><input type="text" name="bgm_title" id="bgm_title" class="form-control" placeholder="请输入背景音乐名称"/></td>
            </tr>


            <tr>
                <td align="center">背景音乐作者</td>
                <td><input type="text" name="bgm_author" id="bgm_author" class="form-control" placeholder="请输入背景音乐作者"/></td>
            </tr>


            <tr>
                <td align="center">背景音乐</td>
                <td>
                    <button class="file">上传音乐
                        <input type="file" name="bgm_url_upload">
                    </button>

                </td>
            </tr>


            <tr>
                <td align="center">已上传背景音乐</td>
                <td class="uploaded">
                </td>
                <input type="hidden" name="bgm_url" class="bgm_url" value="">
                <input type="hidden" name="bgm_time" class="bgm_time" value="">
            </tr>




            <tr>
                <td>&nbsp;</td>
                <td>
                    <button class="btn btn-success ajax-post" type="submit" id="saveButton"
                            target-form="form-horizontal"><i class="fa fa-check" aria-hidden="true"></i> 添加
                    </button>
                    <button type="button" class="btn btn-default" id="cancelButton"><i class="fa fa-times"
                                                                                       aria-hidden="true"></i> 取消
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

</body>
</html>
<script>
    uploadStory();
    validataSbumit();

    //上传音频
    function uploadStory() {
        $('input[type="file"]').on('change', function () {
            var formData = new FormData();
            formData.append('file', $('input[name="bgm_url_upload"]')[0].files[0]);
            $.ajax({
                url: APP + '/Bgm/uploadBgm',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.code == 200) {
                        // alert(JSON.stringify(res));
                        var str = `
                                     <audio id="upload_bgm_url" src='/Uploads/Manage/${res.data.url}' controls="controls">
                                        Your browser does not support the audio element.
                                    </audio>
                                `;
                        $('.uploaded').html(str);
                        $('.bgm_url').val(res.data.url);
                        //时长
                        var myVid = document.getElementById("upload_bgm_url");
                        if (myVid != null) {
                            var duration;
                            myVid.load();
                            myVid.oncanplay = function () {
                                // console.log("myVid.duration",myVid.duration);
                                $('.bgm_time').val(myVid.duration);
                            }
                        }
                    }
                },
                fail: function (err) {
                    console.log(err);
                }
            });
        });
    }


    //验证
    function validataSbumit() {
        $('.ajax-post').on('click', function () {

            if ($('#upload_bgm_url').length < 1) {
                $.show({
                    title: '提示',
                    isConfirm: false,
                    content: '故事不能为空'
                });
                return false;
            }
        });
    }


</script>