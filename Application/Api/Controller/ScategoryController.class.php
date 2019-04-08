<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\CategoryException;
use Api\Exception\ScategoryException;
use Api\Exception\UserException;
use Api\Model\GroupsModel;
use Api\Validate\IDMustBePostiveInt;
use Manage\Model\ScategoryModel;
use Think\Controller;

class ScategoryController extends CommonController
{


    //获取听故事分类
    public function getListenScategory()
    {
        $scategoryModel = new ScategoryModel();
        $map['scategory_type'] = C('Story.ListenStory');
        $scategory = $scategoryModel->field('scategory_type', true)->where($map)->select();
        foreach ($scategory as &$value) {
            $value['scategory_headimg'] = C('Story.img_prefix') . $value['scategory_headimg'];
        }
        if (!$scategory) {
            $this->ajaxReturn((new ScategoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $scategory
        ]);
    }

    //获取讲故事分类
    public function getTellingScategory()
    {
        $scategoryModel = new ScategoryModel();
        $map['scategory_type'] = C('Story.TellingStory');
        $scategory = $scategoryModel->field('scategory_type', true)->where($map)->select();
        foreach ($scategory as &$value) {
            $value['scategory_headimg'] = C('Story.img_prefix') . $value['scategory_headimg'];
        }
        if (!$scategory) {
            $this->ajaxReturn((new ScategoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $scategory
        ]);
    }

}