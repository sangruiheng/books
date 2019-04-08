<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-9
 * Time: 上午9:50
 */

namespace Api\Model;


use Api\Controller\CommonController;
use Api\Exception\SalbumException;
use Api\Exception\UserException;
use Api\Service\UserToken;
use Think\Model\RelationModel;

class UseralbumModel extends RelationModel
{
    protected $_link = array(

        'userStory' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'userstory',//要关联的表名
            'foreign_key' => 'user_album_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
//            'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        ),
        'userAlbumLike' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'useralbumlike',//要关联的表名
            'foreign_key' => 'user_album_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
//            'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        ),
        'sCategory' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'scategory',//要关联的表名
            'foreign_key' => 'scategory_id', //本表的字段名称
            'condition' => 'scategory_type=1', //本表的字段名称
            'as_fields' => 'scategory_name:scategory_name',  //被关联表中的字段名：要变成的字段名
//            'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        ),
        'userStorylabel' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'userstorylabel',//要关联的表名
            'foreign_key' => 'user_album_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
//            'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        ),

    );

    //上传用户专辑头图
    public function UploadUserAlbumImg()
    {
        $useralbumModel = new UseralbumModel();
        if (!$_FILES) {
            $result = (new SalbumException([
                'code' => 30003,
                'msg' => '上传图片为空'
            ]))->getException();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            die; //抛出异常
        }
        $info = (new CommonController())->uploadCommon();
        foreach ($info as $file) {
            $data['user_album_headimg'] = $file['savepath'] . $file['savename'];
            $useralbum_id = $useralbumModel->add($data);
        }
        if (!$useralbum_id) {
            $result = (new SalbumException([
                'code' => 30002,
                'msg' => '上传失败'
            ]))->getException();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            die; //抛出异常
        }
        return $useralbum_id;
    }


    //上传用户专辑标签
    public function UploadUserTags($arrayStoryLabel, $user_album_id)
    {
        if (is_array($arrayStoryLabel) || !$arrayStoryLabel) {
            return true;
        }
        if(count($arrayStoryLabel) > 10){
            $result = (new SalbumException([
                'code' => 30003,
                'msg' => '专辑标签最多10个'
            ]))->getException();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            die; //抛出异常
        }
        $UserstorylabelModel = new UserstorylabelModel();
        foreach ($arrayStoryLabel as $value) {
            $UserstorylabelModel->slabel_name = $value['slabel_name'];
            $UserstorylabelModel->user_album_id = $user_album_id;
            $userstorylabel = $UserstorylabelModel->add();
        }
        if (!$userstorylabel) {
            $result = (new SalbumException([
                'code' => 30004,
                'msg' => '专辑标签添加失败'
            ]))->getException();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            die; //抛出异常
        }
        return true;
    }

    //上传用户专辑其他信息
    public function UploadUserAlbumOther($uid, $user_album_title, $user_album_authority, $user_album_describe, $scategory_id, $user_album_id)
    {
        $useralbumModel = new UseralbumModel();
        $useralbumModel->user_id = $uid;
        $useralbumModel->user_album_title = $user_album_title;
        $useralbumModel->user_album_authority = $user_album_authority;
        $useralbumModel->scategory_id = $scategory_id;
        $useralbumModel->user_album_describe = $user_album_describe;
        $map['id'] = $user_album_id;
        $userAlbum = $useralbumModel->where($map)->save();
        return $userAlbum;
    }

}
