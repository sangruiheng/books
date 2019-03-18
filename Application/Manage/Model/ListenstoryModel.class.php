<?php

namespace Manage\Model;

use Think\Model\RelationModel;

class ListenstoryModel extends RelationModel
{
    protected $_link = array(
        'sCategory' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'scategory',//要关联的表名
            'foreign_key' => 'scategory_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
        ),
        'sAlbum' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'salbum',//要关联的表名
            'foreign_key' => 'salbum_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
        )

    );
    protected $_validate = array(
        array('scategory_id', 'require', '所属分类不能为空'),
        array('salbum_id', 'require', '所属专辑专辑不能为空'),
        array('listen_story_name', 'require', '故事名称不能为空'),
    );


    public static function uploadStory()
    {
        $config = array(
            'mimes' => array(), //允许上传的文件MiMe类型
            'maxSize' => 0, //上传的文件大小限制 (0-不做限制)
            'exts' => array('jpg', 'gif', 'png', 'jpeg', 'mp4', 'mp3', 'wma', 'wav'), //允许上传的文件后缀
            'autoSub' => true, //自动子目录保存文件
            'subName' => array('date', 'Ymd'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath' => './Uploads/Manage/', //保存根路径
            'savePath' => '',//保存路径
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info = $upload->upload();
        if (!$info) {
            return $upload->getError();
        } else {
            foreach ($info as $file) {
                $data['url'] = $file['savepath'] . $file['savename'];
            }
            return $data;
        }
    }


}