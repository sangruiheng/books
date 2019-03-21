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
use Manage\Model\ListenstoryModel;
use Manage\Model\SalbumModel;
use Manage\Model\ScategoryModel;
use Think\Controller;

class SalbumController extends CommonController
{

    public function listenSalbumList()
    {
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('salbum', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $map['salbum_type'] = C('Story.ListenStory');
        $salbumModel = new SalbumModel();
        $salbum = $salbumModel->relation(array('sCategory'))->where($map)->order('id desc')->select();
        $count = $salbumModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('list', $salbum);
        $this->display();
    }


    public function addListenSalbum()
    {
        $scategoryModel = new ScategoryModel();
        $map['scategory_type'] = C('Story.ListenStory');
        $sCategory = $scategoryModel->where($map)->select();
        $this->assign('sCategory', $sCategory);
        $this->display();
    }


    public function addListenSalbumData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->salbum_type = C('Story.ListenStory');
                $sql->salbum_addtime = time();
                $result = $sql->add();
            } else {  //修改
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl . '/scategory_id/' . $_POST['scategory_id']));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }

    public function delListenSalbum()
    {
        $salbumModel = new SalbumModel();
        $listenstoryModel = new ListenstoryModel();
        $table = $_POST['table'];
        $ids = $_POST['delID'];
        $sql = M($table);
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }

        //删除故事
        $map['salbum_id'] = array('in', $ids);
        $listenstory = $listenstoryModel->where($map)->select();
        foreach ($listenstory as $value){
            $file = ('Uploads/Manage/' . $value["listen_story_music"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        $listenstoryModel->where($map)->delete();


        //删除专辑
        $where['id'] = array('in', $ids);
        $salbum = $salbumModel->where($where)->select();
        foreach ($salbum as $value) {
//            $file = ($_SERVER["DOCUMENT_ROOT"] . 'Uploads/Manage/' . $value["banner_img"]);
            $file = ('Uploads/Manage/' . $value["salbum_headimg"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return $Result = $sql->delete($ids);
    }



    public function tellingSalbumList()
    {
//        $scategory_id = $_GET['scategory_id'];
        if($_GET['scategory_id']){
            session("scategory_id",$_GET['scategory_id']);
        }
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('salbum', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $map['salbum_type'] = C('Story.TellingStory');
        $salbumModel = new SalbumModel();
        $scategoryModel = new ScategoryModel();
        $salbum = $salbumModel->where($map)->where("scategory_id=".I('session.scategory_id'))->select();
        $thisScategory = $scategoryModel->where("id=".I('session.scategory_id'))->find();
        $count = $salbumModel->where($map)->where("scategory_id=".I('session.scategory_id'))->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('thisScategory', $thisScategory);
        $this->assign('list', $salbum);
        $this->display();
    }

    public function addTellingSalbum()
    {
        $scategory_id = $_GET['scategory_id'];
        $this->assign('scategory_id', $scategory_id);
        $this->display();
    }


    public function addTellingSalbumData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->salbum_type = C('Story.TellingStory');
                $sql->salbum_addtime = time();
                $result = $sql->add();
            } else {  //修改
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl . '/scategory_id/' . $_POST['scategory_id']));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }


    public function delTellingSalbum()
    {
        $salbumModel = new SalbumModel();
        $table = $_POST['table'];
        $ids = $_POST['delID'];
        $sql = M($table);
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }
        //删除图片
        $map['id'] = array('in', $ids);
        $salbum = $salbumModel->where($map)->select();
        foreach ($salbum as $value) {
//            $file = ($_SERVER["DOCUMENT_ROOT"] . 'Uploads/Manage/' . $value["banner_img"]);
            $file = ('Uploads/Manage/' . $value["salbum_headimg"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return $Result = $sql->delete($ids);
    }


}