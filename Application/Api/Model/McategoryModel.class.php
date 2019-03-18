<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-9
 * Time: 上午9:50
 */

namespace Api\Model;


use Think\Model\RelationModel;

class McategoryModel extends RelationModel
{
    protected $_link = array(
        'bgm' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'bgm',//要关联的表名
            'foreign_key' => 'mcategory_id', //外键的字段名称
            'mapping_limit' => '0,2',  //被关联表中的字段名：要变成的字段名
            //       'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        )
    );



}
