<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title><?php echo C('PROJECT_TITLE.ICON_TITLE');?>|v1.0</title>
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/login/normalize.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/login/demo.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/login/component.css" />
<link rel="stylesheet" type="text/css" href="/Public/Manage/css/login/login.css" />
<script src="/Public/Manage/js/common/jquery-1.8.2.min.js"></script>
</head>
<body>
		<div class="container demo-2">
			<div class="content">
				<div id="large-header" class="large-header">
					<canvas id="demo-canvas"></canvas>
				</div>
				<div class="loginBox">
					<form class="form" autocomplete="off" method="post" action="doLogin">
					<div class="loginTitle" style="background:none;text-align: center;font-size: 40px;color: #fff;line-height: 45px;text-shadow: 0px 1px 2px #484848;"><?php echo C('PROJECT_TITLE.LOGIN_TITLE');?>·管理系统</div>
					<div class="userInput"><label>用　户</label><input type="text" name="username" id="username" datatype="*" nullmsg="请输入用户名！" errormsg="用户名不能为空！"  autocomplete="off" ></div>
					<div class="userInput passInput"><label>密　码</label><input type="password" name="password" id="password" datatype="*" nullmsg="密码不能为空！"></div>
					<div class="userInput codeInput"><label>验证码</label><input type="text" name="VerCode" id="VerCode" datatype="*" nullmsg="验证码不能为空！" autocomplete="off" ><a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a></div>
					<div class="codeImg"><img src="<?php echo U('Login/verCode');?>" class="verifyimg reloadverify" style="cursor:pointer" title="点击刷新验证码" /></div>
					<div class="errorinfo"></div>
					<div class="buttonDiv"><input type="submit" class="login_button" value="登陆" /></div>
					</form>
				</div>
			</div>
		</div>
</body>
<script src="/Public/Manage/js/jquery-js/TweenLite.min.js"></script>
<script src="/Public/Manage/js/jquery-js/EasePack.min.js"></script>
<script src="/Public/Manage/js/jquery-js/rAF.js"></script>
<script src="/Public/Manage/js/jquery-js/demo-1.js"></script>
<script>
$(function(){
	//初始化选中用户名输入框
	$("#username").focus();
	//刷新验证码
	var verifyimg = $(".verifyimg").attr("src");
    $(".reloadverify").click(function(){
        if( verifyimg.indexOf('?')>0){
            $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
        }else{
            $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
        }
    });
});
$(".form").submit(function(){
	var self = $(this);
	$.post(self.attr("action"), self.serialize(), success);
	return false;
	function success(ret){
		if(parseInt(ret.code) == 200){
			var url = ret.data;
			window.location.href = url;
			console.log(url);
		}else{
			self.find(".errorinfo").html(ret.msg).show();
			$('#VerCode').val('');
			$(".reloadverify").click();
		}
	}
});
</script>
</html>