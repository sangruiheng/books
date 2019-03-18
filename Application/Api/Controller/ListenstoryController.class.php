<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\BannerException;
use Api\Exception\SalbumException;
use Api\Model\BannerModel;
use Api\Model\SalbumModel;
use Api\Validate\SearchName;
use Think\Controller;

class ListenstoryController extends CommonController
{

    //搜索故事名(听)
    public function getSearchListenStory()
    {
        (new SearchName())->goCheck();
        $salbum_name = $_POST['title'];
        $salbumModel = new SalbumModel();
        $map['salbum_name'] = array('like', "%$salbum_name%");
        $salbum = $salbumModel->where($map)->select();
        foreach ($salbum as &$value) {
            $value['salbum_headimg'] = C('Story.img_prefix') . $value['salbum_headimg'];
            $value['storySum'] = $salbumModel::getStorySum($value['id']);
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



}