<?php

namespace Manage\Controller;

use Manage\Model\BannerModel;
use Think\Controller;

class BannerController extends CommonController
{

    public function bannerList()
    {
        $this->getDlist('banner', $_GET['keyWord']);
    }


    //添加、编辑数据的方法
    public function addBannerData()
    {
        $bannerModel = new BannerModel();
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->banner_img = substr($_POST['hid'][0], 16);
                $result = $sql->add();
            } else {  //修改
                if ($_POST['hid']) {
                    $banner = $bannerModel->where("id=$id")->find();
                    $file = ('Uploads/Manage/' . $banner['banner_img']);
                    if (file_exists($file)) {
                        @unlink($file);
                    }
                    $sql->banner_img = substr($_POST['hid'][0], 16);
                }
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }


    //删除轮播及图片
    public function deleteBanner()
    {
        $table = $_POST['table'];
        $ids = $_POST['delID'];
        $sql = M($table);
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }
        //删除图片
        $map['id'] = array('in', $ids);
        $GroupImg_list = M('banner')->where($map)->select();
        foreach ($GroupImg_list as $value) {
//            $file = ($_SERVER["DOCUMENT_ROOT"] . 'Uploads/Manage/' . $value["banner_img"]);
            $file = ('Uploads/Manage/' . $value["banner_img"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return $Result = $sql->delete($ids);
    }

}

?>