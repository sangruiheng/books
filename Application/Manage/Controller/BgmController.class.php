<?php

namespace Manage\Controller;

use Manage\Model\BannerModel;
use Manage\Model\BgmModel;
use Manage\Model\ListenstoryModel;
use Manage\Model\McategoryModel;
use Think\Controller;

class BgmController extends CommonController
{

    public function bgmList()
    {
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('bgm', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $bgmModel = new BgmModel();
        $bgm = $bgmModel->relation(array('mCategory'))->where($map)->select();
        $count = $bgmModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('list', $bgm);
        $this->display();
    }


    public function addBgm()
    {
        $mcategoryModel = new McategoryModel();
        $mcategory = $mcategoryModel->select();
        $this->assign('mcategory', $mcategory);
        $this->display();
    }


    //添加、编辑数据的方法
    public function addBgmData()
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

    public function uploadBgm()
    {
        $listenstoryModel = new ListenstoryModel();
        if (!empty($_FILES)) {
            $info = $listenstoryModel::uploadStory();
            if ($info) {
                $this->ajaxReturn([
                    'code' => 200,
                    'msg' => '上传成功',
                    'data' => $info,
                ]);
            }
        } else {
            $this->ajaxReturn([
                'code' => 400,
                'msg' => '上传失败'
            ]);
        }
    }

    public function deleteBgm()
    {
        $bgmModel = new BgmModel();
        $table = $_POST['table'];
        $ids = $_POST['delID'];
        $sql = M($table);
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }
        //删除图片
        $map['id'] = array('in', $ids);
        $bgm = $bgmModel->where($map)->select();
        foreach ($bgm as $value) {
            $file = ('Uploads/Manage/' . $value["bgm_url"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return $Result = $sql->delete($ids);
    }


}

?>