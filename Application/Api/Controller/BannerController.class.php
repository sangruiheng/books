<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\BannerException;
use Api\Model\BannerModel;
use Think\Controller;

class BannerController extends CommonController
{

    //获取banner
    public function getBanner()
    {
        $bannerModel = new BannerModel();
        $banner = $bannerModel->field('sort',true)->select();
        foreach ($banner as &$value) {
            $value['banner_img'] = C('Story.img_prefix') . $value['banner_img'];
        }
        if (!$banner) {
            $this->ajaxReturn((new BannerException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $banner
        ]);
    }



}