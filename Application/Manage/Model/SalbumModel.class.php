<?php
namespace Manage\Model;
use Think\Model\RelationModel;
class SalbumModel extends RelationModel{
	protected $_link = array(
        'sCategory' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'scategory',//要关联的表名
            'foreign_key' => 'scategory_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
        ),
	);
    protected $_validate = array(
        array('is_age','require','适合性别不能为空'),
        array('is_sex','require','年龄段不能为空'),
        array('salbum_title','require','专辑名称不能为空'),
        array('scategory_id','require','分类不能为空'),
        array('salbum_describe','require','专题描述不能为空'),
    );



}