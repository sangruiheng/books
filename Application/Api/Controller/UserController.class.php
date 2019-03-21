<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Model\UserModel;
use Api\Service\UserToken;


class UserController extends CommonController
{

    //获取openid 并存入数据库
    public function getOpenID($code = '')
    {
        $userToken = new UserToken($code);
        $openID = $userToken->getUserOpenID();
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'openID' => $openID
        ]);
    }


    //用户登陆 返回token
    public function wxLogin()
    {
        //openID nickName avatarUrl city...
        $userToken = new UserToken();
        $wxResult = json_decode($_POST['userInfo'], true);

        $token = $userToken->wxGetUserInfo($wxResult);
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'Token' => $token
        ]);
    }

    public function wxPhone(){
        $userModel = new UserModel();
        $encryptedData = $_POST['encryptedData'];
        $iv = $_POST['iv'];
        $openID = $_POST['openID'];
        $wxPhone = $userModel->getWxPhone($encryptedData, $iv, $openID);
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $wxPhone['phoneNumber']
        ]);
    }


}
