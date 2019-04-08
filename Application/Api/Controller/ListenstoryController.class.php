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
use Api\Validate\PageSearch;
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
    public function getShowPageSearch()
    {
        $scategoryModel = new ScategoryModel();
        $search = array(
            'salbum_age' => array(
                array(
                    'is_age' => 0,
                    'name' => '0-3岁'
                ),
                array(
                    'is_age' => 1,
                    'name' => '6岁+'
                ),
                array(
                    'is_age' => 2,
                    'name' => '10岁+'
                )
            ),
            'salbum_sex' => array(
              array(
                  'is_sex' => 0,
                  'name' => '男生'
              ),
                array(
                    'is_sex' => 1,
                    'name' => '女生'
                )
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


    //筛选搜索
    public function getPageSearch(){
        $is_age = $_POST['is_age'];
        $is_sex = $_POST['is_sex'];
        $scategory_id = $_POST['scategory_id'];
        (new PageSearch())->goCheck();
        $salbumModel = new SalbumModel();
        $map['is_age'] = $is_age;
        $map['is_sex'] = $is_sex;
        $map['scategory_id'] = $scategory_id;
        $salbum = $salbumModel->where($map)->select();
        foreach ($salbum as &$value) {
            $value['salbum_headimg'] = C('Story.img_prefix') . $value['salbum_headimg'];
            $value['storySum'] = $salbumModel::getStorySum($value['id']);
        }
        if (!$salbum) {
            $this->ajaxReturn((new ScategoryException([
                'code' => 50001,
                'msg' => '暂无筛选'
            ]))->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $salbum
        ]);


    }


}