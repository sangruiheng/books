<?php
namespace Manage\Model;
use Think\Model\RelationModel;
class BgmModel extends RelationModel{
	protected $_link = array(
        'mCategory' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'mcategory',//要关联的表名
            'foreign_key' => 'mcategory_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
        ),
	);
    protected $_validate = array(
        array('bgm_title','require','背景音乐名称不能为空'),
        array('bgm_author','require','背景音乐作者不能为空'),
        array('mcategory_id','require','背景音乐分类不能为空'),
    );



}