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
var URL = '/manage.php/Story';
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

    <!--<script type="text/javascript" src="/Public/Manage/tools/ueditor1_4_3-utf8-php/ueditor.config.js"></script>-->
    <!--<script type="text/javascript" src="/Public/Manage/tools/ueditor1_4_3-utf8-php/ueditor.all.min.js"></script>-->
    <!--<script type="text/javascript" src="/Public/Manage/tools/ueditor1_4_3-utf8-php/lang/zh-cn/zh-cn.js"></script>-->
    <!--<link rel="stylesheet" type="text/css" href="/Public/Manage/tools/webuploader-0.1.5/dist/webuploader.css" />-->
    <!--<link rel="stylesheet" type="text/css" href="/Public/Manage/tools/webuploader-0.1.5/examples/image-upload/style.css" />-->


    <script>
        $(document).ready(function (e) {
            getEditData(function (e) {
                var str = `
                             <audio id="upload_story_music" src='/Uploads/Manage/${e.listen_story_music}' controls="controls">
                                Your browser does not support the audio element.
                            </audio>
                        `;
                $('.uploaded').html(str);
                editGetAlbum(e.scategory_id, e.salbum_id);

            });

            function editGetAlbum(scategory_id, salbum_id) {
                $.ajax({
                    url: APP + '/Story/editGetSalbum',
                    type: 'POST',
                    data: {
                        salbum_id: salbum_id,
                        scategory_id: scategory_id
                    },
                    success: function (res) {
                        console.log(res);
                        if (res.code == 200) {
                            var str = "";
                            var str1 = "";
                            for (var i = 0; i < res.scategory.length; i++) {
                                var edit_scategory_id = res.scategory[i].id;
                                var edit_scategory_name = res.scategory[i].scategory_name;
                                scategory_id == edit_scategory_id ? str += `<option selected value="${edit_scategory_id}">${edit_scategory_name}</option>` : str += `<option value="${edit_scategory_id}">${edit_scategory_name}</option>`;
                            }
                            $("#scategory_id").html(str);

                            for (var i = 0; i < res.salbum.length; i++) {
                                var edit_salbum_id = res.salbum[i].id;
                                var edit_salbum_name = res.salbum[i].salbum_name;
                                salbum_id == edit_salbum_id ? str += `<option selected value="${edit_salbum_id}">${edit_salbum_name}</option>` : str += `<option value="${edit_salbum_id}">${edit_salbum_name}</option>`;
                                $("#salbum_id").html(str);
                            }

                        } else {
                            str = `<option value="">--请选择--</option>`;
                            $("#salbum_id").html(str);
                            $("#scategory_id").html(str);
                        }
                    },
                    fail: function (err) {
                        console.log(err);
                    }
                });
            }
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
        <a class="navbar-brand" href="#"><i class="fa fa-plus" aria-hidden="true"></i> <span id="changeTitle">添加</span>故事(听)</a>
    </div>
</nav>

<div class="add-box">
    <form class="addForm ajax-alert" id="form1" name="form1" method="post"
          action="/manage.php/Story/addListenStoryData/controller/Story/backUrl/listenStoryList/table/listenstory">
        <input name="id" type="hidden" id="id" value="<?php echo ($_GET['id']); ?>"/>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>

            <tr>
                <td align="center">所属分类</td>
                <td colspan="5">
                    <select id="scategory_id" name="scategory_id" class="form-control">
                        <option value="">--请选择--</option>
                        <?php if(is_array($scategory)): $i = 0; $__LIST__ = $scategory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["scategory_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>


            <tr>
                <td align="center">所属专辑</td>
                <td colspan="5">
                    <select name="salbum_id" id="salbum_id" class="form-control">
                        <option value="">--请选择--</option>
                    </select>
                </td>
            </tr>


            <tr>
                <td align="center">故事名称</td>
                <td>
                    <input type="text" name="listen_story_name" id="listen_story_name" class="form-control"
                           placeholder="请输入故事名称"/>
                </td>
            </tr>

            <tr>
                <td align="center">故事音乐</td>
                <td>
                    <button class="file">上传故事
                        <input type="file" name="listen_story_music_upload">
                    </button>

                </td>
            </tr>


            <tr>
                <td align="center">已上传故事</td>
                <td class="uploaded">
                </td>
                <input type="hidden" name="listen_story_music" class="listen_story_music" value="">
                <input type="hidden" name="listen_story_music_time" class="listen_story_music_time" value="">
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
    changeSalbum();
    validataSbumit();

    //上传音频
    function uploadStory() {
        $('input[type="file"]').on('change', function () {
            var formData = new FormData();
            formData.append('file', $('input[name="listen_story_music_upload"]')[0].files[0]);
            $.ajax({
                url: APP + '/Story/uploadStory',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.code == 200) {
                        // alert(JSON.stringify(res));
                        var str = `
                                     <audio id="upload_story_music" src='/Uploads/Manage/${res.data.url}' controls="controls">
                                        Your browser does not support the audio element.
                                    </audio>
                                `;
                        $('.uploaded').html(str);
                        $('.listen_story_music').val(res.data.url);
                        //时长
                        var myVid = document.getElementById("upload_story_music");
                        if (myVid != null) {
                            var duration;
                            myVid.load();
                            myVid.oncanplay = function () {
                                // console.log("myVid.duration",myVid.duration);
                                $('.listen_story_music_time').val(myVid.duration);
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

    //切换专辑
    function changeSalbum() {
        $('#scategory_id').on('change', function () {
            var scategoryID = $(this).val();
            $.ajax({
                url: APP + '/Story/getSalbum',
                type: 'POST',
                data: {
                    scategoryID: scategoryID
                },
                success: function (res) {
                    if (res.code == 200) {
                        var str = "";
                        for (var i = 0; i < res.data.length; i++) {
                            var salbum_id = res.data[i].id;
                            var salbum_name = res.data[i].salbum_name
                            str += `<option value="${salbum_id}">${salbum_name}</option>`;
                        }
                        $("#salbum_id").html(str);
                    } else {
                        str = `<option value="">--请选择--</option>`;
                        $("#salbum_id").html(str);
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

            if ($('#upload_story_music').length < 1) {
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