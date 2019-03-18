<?php
namespace Manage\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	$this->display();
    }
	
	public function verCode(){
		$config = array(
				'useImgBg' => true,
				'codeSet' => '0123456789',
				'useNoise' => false
		);
		$verify = new \Think\Verify($config);
		$verify->entry();
	}
	//验证验证码
	public function check_verify($code, $id = ''){    
		$verify = new \Think\Verify();    
		return $verify->check($code, $id);
	}
	
	//查找是否存在后台用户，如果存在则登录，否则提示
	public function doLogin(){
		$userName = I('username');
		if(empty($userName))$this->ajaxReturn(array('code'=>400,'msg'=>'请输入用户名'));
		$passWord = I('password');
		if(empty($passWord))$this->ajaxReturn(array('code'=>400,'msg'=>'请输入密码'));
		$verCode = I('VerCode');
		if(empty($verCode))$this->ajaxReturn(array('code'=>400,'msg'=>'请输入验证码'));
		$isCode = $this->check_verify($verCode);
		if(empty($isCode))$this->ajaxReturn(array('code'=>400,'msg'=>'验证码不正确'));
		$map['username'] = array('eq',$userName);
		$map['password'] = array('eq',md5($passWord));
		$info = M('adminuser')->where($map)->field('id,groupID')->find();
		if(empty($info))$this->ajaxReturn(array('code'=>400,'msg'=>'用户名或密码不正确','data'=>$info));
		$data['id'] = $info['id'];
		$data['nextLoginIp'] = get_client_ip();
		$data['nextLoginTime'] = time();
		$data['lastLoginIp'] = get_client_ip();
		$data['lastLoginTime'] = time();
		$rs = M('adminuser')->save($data);
		if($rs){
			session('crm_uid',$info['id']);
			session('crm_groupID',$info['groupID']);
			$this->ajaxReturn(array('code'=>200,'msg'=>'登录成功','data'=>__APP__.'/Index/index'));
		}else{
			$this->ajaxReturn(array('code'=>400,'msg'=>'登录失败请联系管理员'));
		}
	}
}
?>