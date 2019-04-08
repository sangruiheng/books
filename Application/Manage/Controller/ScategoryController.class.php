<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 19-2-27
 * Time: 上午10:24
 */

namespace Manage\Controller;

use Manage\Model\BrandlableModel;
use Manage\Model\BrandModel;
use Manage\Model\SalbumModel;
use Manage\Model\ScategoryModel;
use Think\Controller;

class ScategoryController extends CommonController
{

    public function listenScategoryList()
    {
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('scategory', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $map['scategory_type'] = C('Story.ListenStory');
        $scategoryModel = new ScategoryModel();
        $scategory = $scategoryModel->where($map)->select();
        $count = $scategoryModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('list', $scategory);
        $this->display();
    }


    public function addListenScategoryData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->scategory_type = C('Story.ListenStory');
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


    //删除分类
    public function deleteScategory()
    {
        $scategoryModel = new ScategoryModel();
        $ids = $_POST['delID'];
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }
        $map['id'] = array('in', $ids);
        $scategory = $scategoryModel->where($map)->select();
        foreach ($scategory as $value) {   //删除专辑图片
            $file = ('Uploads/Manage/' . $value["scategory_headimg"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        $scategoryModel->delete($ids);      //删除分类
    }


    public function tellingScategoryList()
    {
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('scategory', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $map['scategory_type'] = C('Story.TellingStory');
        $scategoryModel = new ScategoryModel();
        $scategory = $scategoryModel->where($map)->select();
        $count = $scategoryModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('list', $scategory);
        $this->display();
    }


    public function addTellingScategoryData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->scategory_type = C('Story.TellingStory');
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