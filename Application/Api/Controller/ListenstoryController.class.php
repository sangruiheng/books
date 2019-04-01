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
use Api\Exception\ScategoryException;
use Api\Model\BannerModel;
use Api\Model\SalbumModel;
use Api\Validate\SearchName;
use Manage\Model\ScategoryModel;
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


    //首页筛选
    public function getPageSearch()
    {
        $scategoryModel = new ScategoryModel();
        $search = array(
            'salbum_age' => array(
                '0-3岁',
                '6岁+',
                '10岁+'
            ),
            'salbum_sex' => array(
                '男生',
                '女生'
            ),
            'salbum_category' => array()
        );

        $map['scategory_type'] = C('Story.ListenStory');
        $scategory = $scategoryModel->where($map)->select();
        foreach ($scategory as $value) {
            array_push($search['salbum_category'], $value);
        }

        if (!$search) {
            $this->ajaxReturn((new ScategoryException([
                'code' => 50001,
                'msg' => '筛选失败'
            ]))->getException());
        }

        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $search
        ]);


    }


}