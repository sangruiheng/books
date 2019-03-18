<?php

namespace Manage\Model;

use Think\Model\RelationModel;

class TellingstoryModel extends RelationModel
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
        array('telling_story_name', 'require', '故事名称不能为空'),
        array('telling_story_author', 'require', '故事作者不能为空'),
        array('telling_story_content', 'require', '故事详情不能为空'),
    );


}