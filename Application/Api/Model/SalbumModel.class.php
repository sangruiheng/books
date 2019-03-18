<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-9
 * Time: 上午9:50
 */

namespace Api\Model;


use Think\Model\RelationModel;

class SalbumModel extends RelationModel
{
    protected $_link = array(
        'Scategory' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'scategory',//要关联的表名
            'foreign_key' => 'scategory_id', //本表的字段名称
//            'as_fields' => 'typeName:typeName',  //被关联表中的字段名：要变成的字段名
//            'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        ),
        'Listenstory' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'listenstory',//要关联的表名
            'foreign_key' => 'salbum_id', //外键的字段名称
//            'as_fields' => 'groupID,imgPath',  //被关联表中的字段名：要变成的字段名
            //       'relation_deep'    =>    'grouptype',   //多表关联  关联第三个表的名称
        )
    );


    //统计专辑下面的故事
    public static function getStorySum($salbum_id)
    {
        $listenstoryModel = new ListenstoryModel();
        $map['salbum_id'] = $salbum_id;
        $storySum = $listenstoryModel->where($map)->count();
        return $storySum;
    }


    //统计专辑下面故事的总时长
    public static function getStoryDuration($salbum){
        foreach($salbum as &$value){
            if(!$value['Listenstory']){
                $value['storyDuration'] = 0;
            }else{
                foreach($value['Listenstory'] as &$item){
                    $value['storyDuration'] += intval($item['listen_story_music_time']);
                }
            }
            unset($value['Listenstory']);
        }
        return $salbum;
    }


}
