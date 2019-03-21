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
use Manage\Model\StoryModel;
use Manage\Model\TellingstoryModel;
use Think\Controller;

class StoryController extends CommonController
{

    //听故事
    public function listenStoryList()
    {
        $salbum_id = $_GET['salbum_id'];
        $salbumModel = new SalbumModel();
        $salbum = $salbumModel->where("id=$salbum_id")->find();
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('listenstory', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $listenstoryModel = new ListenstoryModel();
        $map['salbum_id'] = $salbum_id;
        $listenStory = $listenstoryModel->relation(array('sCategory', 'sAlbum'))->where($map)->order('id desc')->select();
        $count = $listenstoryModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('salbum', $salbum);
        $this->assign('list', $listenStory);
        $this->display();
    }


    public function addListenStory()
    {
        $salbum_id = $_GET['salbum_id'];
//        $scategoryModel = new ScategoryModel();
//        $map['scategory_type'] = C('Story.ListenStory');
//        $scategory = $scategoryModel->where($map)->select();
        $this->assign('salbum_id', $salbum_id);
        $this->display();
    }


    public function addListenStoryData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->listen_story_time = time();
                $result = $sql->add();
            } else {  //修改
                $sql->listen_story_time = time();
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl . '/salbum_id/' . $_POST['salbum_id']));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }


    public function uploadStory()
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


    //切换时获取分类专辑
    public function getSalbum()
    {
        $scategoryID = $_POST['scategoryID'];
        $salbumModel = new SalbumModel();
        $map['scategory_id'] = $scategoryID;
        $salbum = $salbumModel->field('id,scategory_id,salbum_name')->where($map)->select();
        if (!$salbum) {
            $this->ajaxReturn([
                'code' => 400,
                'msg' => 'error'
            ]);
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $salbum,
        ]);
    }

    //修改时获取分类专辑
    public function editGetSalbum()
    {
        $scategory_id = $_POST['scategory_id'];
        $scategoryModel = new ScategoryModel();
        $salbumModel = new SalbumModel();
        $scategory = $scategoryModel->field('id,scategory_name')->where('scategory_type=' . C('Story.ListenStory'))->select();
        $map['salbum_type'] = C('Story.ListenStory');
        $map['scategory_id'] = $scategory_id;
        $salbum = $salbumModel->field('id,scategory_id,salbum_name')->where($map)->select();
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'scategory' => $scategory,
            'salbum' => $salbum,
        ]);


    }


    public function deletelistenStory()
    {
        $listenstoryModel = new ListenstoryModel();
        $table = $_POST['table'];
        $ids = $_POST['delID'];
        $sql = M($table);
        if (strlen($ids) > 0) {
            $ids = substr($ids, 0, strlen($ids) - 1);
        }
        //删除图片
        $map['id'] = array('in', $ids);
        $listenStory = $listenstoryModel->where($map)->select();
        foreach ($listenStory as $value) {
            $file = ('Uploads/Manage/' . $value["listen_story_music"]);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        return $Result = $sql->delete($ids);
    }


    //讲故事
    public function tellingStoryList()
    {
        $keyWord = $_GET['keyWord'];
        if (!empty($keyWord)) {
            $map = $this->Search('tellingstory', $keyWord);
            $search['keyWord'] = $keyWord;
        }
        $p = $_GET['p'];
        if (empty($p)) {
            $p = 1;
        }
        $tellingstoryModel = new TellingstoryModel();
        $tellingStory = $tellingstoryModel->relation(array('sCategory'))->where($map)->select();
        $count = $tellingstoryModel->where($map)->count();
        $Page = getpage($count, 10);
        foreach ($map as $key => $val) {
            $page->parameter .= "$key=" . urlencode($val) . '&';
        }
        $this->assign('search', $search);
        $this->assign('page', $Page->show());
        $this->assign('list', $tellingStory);
        $this->display();
    }

    public function addTellingStory()
    {
        $scategoryModel = new ScategoryModel();
        $map['scategory_type'] = C('Story.TellingStory');
        $scategory = $scategoryModel->where($map)->select();
        $this->assign('scategory', $scategory);
        $this->display();
    }


    public function addTellingStoryData()
    {
        $backUrl = $_GET['backUrl'];
        $table = $_GET['table'];
        $controller = $_GET['controller'];
        $id = $_POST['id'];
        $sql = D($table);
        if ($sql->create()) {
            if (empty($id)) { //添加
                $sql->id = NULL;
                $sql->telling_story_time = time();
                $result = $sql->add();
            } else {  //修改
                $sql->telling_story_time = time();
                $result = $sql->save();
            }
            if ($result) {
                $this->success('编辑成功！', U($controller . '/' . $backUrl . '/scategory_id/' . $_POST['scategory_id']));
            }
        } else {
            $this->error($sql->getError(), $jumpUrl = '', $ajax = true);
        }
    }

    public function editGetTellingstory()
    {
        $scategory_id = $_POST['scategory_id'];
        $scategoryModel = new ScategoryModel();
        $salbumModel = new SalbumModel();
        $scategory = $scategoryModel->field('id,scategory_name')->where('scategory_type=' . C('Story.TellingStory'))->select();
        $map['salbum_type'] = C('Story.TellingStory');
        $map['scategory_id'] = $scategory_id;
        $salbum = $salbumModel->field('id,scategory_id,salbum_name')->where($map)->select();
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'scategory' => $scategory,
            'salbum' => $salbum,
        ]);

    }



}