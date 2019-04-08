<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\SalbumException;
use Api\Exception\SuccessException;
use Api\Exception\UserException;
use Api\Model\UseralbumlikeModel;
use Api\Model\UseralbumModel;
use Api\Model\UserModel;
use Api\Service\Token;
use Api\Service\UserToken;
use Api\Validate\IDMustBePostiveInt;


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

    //获取用户手机号
    public function wxPhone()
    {
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

    //个人中心
    public function PersonalCenter()
    {
        $uid = Token::getCurrentUid();
        $userModel = new UserModel();
        $user = $userModel->field('nickName,avatarUrl,lastTime')->find($uid);
        $user['lastTime'] = date('Y-m-d', $user['lastTime']);
        $user['nickName'] = urldecode($user['nickName']);
        if (!$user) {
            $this->ajaxReturn((new UserException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $user
        ]);
    }


    //收藏专辑
    public function likeUserAlbum()
    {
        $uid = Token::getCurrentUid();
        $likeType = $_POST['likeType'];
        (new IDMustBePostiveInt())->goCheck();
        $album_user_id = $_POST['id'];
        $useralbumlikeModel = new UseralbumlikeModel();
        if (!$likeType) {
            $this->ajaxReturn((new UserException([
                'code' => 70009,
                'msg' => 'likeType为空',
            ]))->getException());
        }
        if ($likeType == 1) {
            $useralbumlikeModel->user_id = $uid;
            $useralbumlikeModel->user_album_id = $album_user_id;
            $userAlbumLike = $useralbumlikeModel->add();
        } else if ($likeType == 2) {
            $map['user_id'] = $uid;
            $map['user_album_id'] = $album_user_id;
            $userAlbumLike = $useralbumlikeModel->where($map)->delete();
        }

        if (!$userAlbumLike) {
            $this->ajaxReturn((new UserException([
                'code' => 70008,
                'msg' => '收藏失败或取消收藏失败',
            ]))->getException());
        }
        $this->ajaxReturn((new SuccessException())->getException());
    }


    //用户专辑列表
    public function UserAlbum()
    {
        $uid = Token::getCurrentUid();
        $UseralbumModel = new UseralbumModel();
        $map['user_id'] = $uid;
        $userAlbum = $UseralbumModel->relation(array('userStory'))->where($map)->select();
        foreach ($userAlbum as &$value) {
            $value['countUserStory'] = count($value['userStory']);
            $value['user_album_headimg'] = C('Story.img_prefix') . $value['user_album_headimg'];
            unset($value['userStory']);
        }
        if (!$userAlbum) {
            $this->ajaxReturn((new SalbumException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $userAlbum
        ]);
    }

    //获取用户专辑主页
    public function getUserHomeAlbum()
    {
        $uid = Token::getCurrentUid();
        $user_album_id = $_POST['id'];
        (new IDMustBePostiveInt())->goCheck();
        $useralbumModel = new UseralbumModel();
        $userModel = new UserModel();
        $map['id'] = $user_album_id;
        $map['user_id'] = $uid;
        $userAlbum = $useralbumModel->relation(array('userAlbumLike','sCategory','userStorylabel'))->where($map)->find();
        $userAlbum['likeUser'] = count($userAlbum['userAlbumLike']);
        $userAlbum['is_like'] = $userModel->is_UserLike($uid, $user_album_id) ? 1 : 2;
        if (!$userAlbum) {
            $this->ajaxReturn((new SalbumException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $userAlbum
        ]);

    }


}
