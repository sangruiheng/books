<?php

namespace Manage\Controller;

use Manage\Model\BannerModel;
use Think\Controller;

class McategoryController extends CommonController
{

    public function mcategoryList()
    {
        $this->getDlist('mcategory', $_GET['keyWord']);
    }


    //添加、编辑数据的方法
    public function addMcategoryData()
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
                $result = $sql->add();
            } else {  //修改
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }


}

?>