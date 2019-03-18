<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\SalbumException;
use Api\Model\SalbumModel;
use Api\Validate\IDMustBePostiveInt;
use Api\Validate\Sort;

class SalbumController extends CommonController
{

    //根据分类获取专辑(听故事)
    public function getListenSalbum()
    {
        (new IDMustBePostiveInt())->goCheck();
        $id = $_POST['id'];
        $salbumModel = new SalbumModel();
        $map['scategory_id'] = $id;
        $salbum = $salbumModel->where($map)->select();
        foreach ($salbum as &$val) {
            $val['salbum_headimg'] = C('Story.img_prefix') . $val['salbum_headimg'];
        }
        if (!$salbum) {
            $this->ajaxReturn((new SalbumException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $salbum
        ]);
    }


    //专辑根据综合排序(听)
    public function listenIDSort()
    {
        (new Sort())->goCheck();
        $salbumModel = new SalbumModel();
        $order_type = $_POST['order_type'] == 1 ? 'desc':'asc' ;
        $map['salbum_type'] = C('Story.ListenStory');
        $salbum = $salbumModel->field('scategory_id,salbum_addtime', true)->where($map)->order("id $order_type")->select();
        foreach ($salbum as &$val) {
            $val['salbum_headimg'] = C('Story.img_prefix') . $val['salbum_headimg'];
            $val['storySum'] = $salbumModel::getStorySum($val['id']);
        }
        if (!$salbum) {
            $this->ajaxReturn((new SalbumException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $salbum
        ]);
    }


    //专辑根据播放量排序(听)
    public function listenPlayVolumeSort(){

    }


    //专辑根据最新排序(听)
    public function listenNewestSort(){
        (new Sort())->goCheck();
        $salbumModel = new SalbumModel();
        $order_type = $_POST['order_type'] == 1 ? 'desc':'asc' ;
        $map['salbum_type'] = C('Story.ListenStory');
        $salbum = $salbumModel->where($map)->order("salbum_addtime $order_type")->select();
        foreach ($salbum as &$val) {
            $val['salbum_headimg'] = C('Story.img_prefix') . $val['salbum_headimg'];
            $val['storySum'] = $salbumModel::getStorySum($val['id']);
        }
        if (!$salbum) {
            $this->ajaxReturn((new SalbumException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $salbum
        ]);
    }


    //专辑根据时长排序(听)
    public function listenDurationSort(){
        (new Sort())->goCheck();
        $salbumModel = new SalbumModel();
        $map['salbum_type'] = C('Story.ListenStory');
        $salbum = $salbumModel->where($map)->relation(array('Listenstory'))->select();
        $newSalbum = $salbumModel::getStoryDuration($salbum);
        $score = [];
        foreach ($newSalbum as $key => $value) {
            $score[$key] = $value['storyDuration'];
        }
        $_POST['order_type'] == 1 ? array_multisort($score, SORT_DESC, $newSalbum):array_multisort($score, SORT_ASC, $newSalbum) ;
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $newSalbum
        ]);

    }



}