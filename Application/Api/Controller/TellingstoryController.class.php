<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 上午11:58
 */

namespace Api\Controller;


use Api\Exception\BgmException;
use Api\Exception\ScategoryException;
use Api\Exception\SuccessException;
use Api\Exception\TellingStoryException;
use Api\Model\BgmlikeModel;
use Api\Model\BgmModel;
use Api\Model\McategoryModel;
use Api\Model\ScategoryModel;
use Api\Model\TellingstoryModel;
use Api\Model\UseralbumModel;
use Api\Service\Token;
use Api\Validate\IDMustBePostiveInt;
use Api\Validate\LoadMore;
use Api\Validate\SearchName;
use Api\Validate\Sort;
use Api\Validate\UserAlbum;

class TellingstoryController extends CommonController
{

    //获取背景音乐及分类
    public function getBgmAndMcategory()
    {
        $mcategoryModel = new McategoryModel();
        $bgm = $mcategoryModel->relation(array('bgm'))->select();
        foreach ($bgm as &$value) {
            foreach ($value['bgm'] as &$item) {
                if ($item['bgm_url']) {
                    $item['bgm_url'] = C('Story.img_prefix') . $item['bgm_url'];
                }
            }
        }
        if (!$bgm) {
            $this->ajaxReturn((new BgmException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $bgm
        ]);
    }


    //搜索歌曲
    public function searchBgm()
    {
        (new SearchName())->goCheck();
        $bgmModel = new BgmModel();
        $bgm_title = $_POST['title'];
        $data['bgm_title'] = array('like', "%$bgm_title%");
        $bgm = $bgmModel->where($data)->select();
        foreach ($bgm as &$value) {
            $value['bgm_url'] = C('Story.img_prefix') . $value['bgm_url'];
        }
        if (!$bgm) {
            $this->ajaxReturn((new BgmException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $bgm
        ]);
    }


    //下拉加载更多歌曲
    public function loadMoreBgm()
    {
        //分类id  页数id
        (new LoadMore())->goCheck();
        $page_id = $_POST['page_id'];
        $mcategory_id = $_POST['mcategory_id'];
        $bgmModel = new BgmModel();
        $statr_page = ($page_id - 1) * 5;
        $page = 5;
        $map['mcategory_id'] = $mcategory_id;
        $loadBgm = $bgmModel->where($map)->limit($statr_page, $page)->select();
        foreach ($loadBgm as &$value) {
            if ($value['bgm_url']) {
                $value['bgm_url'] = C('Story.img_prefix') . $value['bgm_url'];
            }
        }
        if (!$loadBgm) {
            $this->ajaxReturn((new BgmException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $loadBgm
        ]);
    }


    //收藏背景音乐
    public function likeBgm()
    {
        (new IDMustBePostiveInt())->goCheck();
        $user_id = Token::getCurrentUid();
        $bgm_id = $_POST['id'];
        $bgmlikeModel = new BgmlikeModel();
        $bgmlikeModel->user_id = $user_id;
        $bgmlikeModel->bgm_id = $bgm_id;
        $bgmLike = $bgmlikeModel->add();
        if (!$bgmLike) {
            $this->ajaxReturn((new BgmException([
                'code' => 40001,
                'msg' => '收藏失败'
            ]))->getException());
        }
        $this->ajaxReturn((new SuccessException([
            'msg' => '收藏成功'
        ]))->getException());
    }


    //取消收藏背景音乐
    public function cancelLikeBgm()
    {
        (new IDMustBePostiveInt())->goCheck();
        $user_id = Token::getCurrentUid();
        $bgm_id = $_POST['id'];
        $bgmlikeModel = new BgmlikeModel();
        $map['user_id'] = $user_id;
        $map['bgm_id'] = $bgm_id;
        $bgmLike = $bgmlikeModel->where($map)->delete();
        if (!$bgmLike) {
            $this->ajaxReturn((new BgmException([
                'code' => 40002,
                'msg' => '取消收藏失败'
            ]))->getException());
        }
        $this->ajaxReturn((new SuccessException([
            'msg' => '取消收藏成功'
        ]))->getException());

    }


    //搜索文章作家(讲)
    public function getSearchTellingStory()
    {
        (new SearchName())->goCheck();
        $telling_story_name = $_POST['title'];
        $tellingstoryModel = new TellingstoryModel();
        $map['telling_story_name | telling_story_author'] = array('like', "%$telling_story_name%");
        $tellingStory = $tellingstoryModel->field('id,telling_story_name,telling_story_author,telling_story_content,telliing_story_like,telliing_story_play')->where($map)->select();
        foreach ($tellingStory as &$value) {
            $value['telling_story_content'] = $this->subtext($value['telling_story_content'], 30);
        }
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);

    }


    //故事根据综合排序(讲)
    public function tellingIDSort()
    {
        (new Sort())->goCheck();
        $tellingstoryModel = new TellingstoryModel();
        $order_type = $_POST['order_type'] == 1 ? 'desc' : 'asc';
        $tellingStory = $tellingstoryModel->field('id,telling_story_name,telling_story_author,telling_story_content,telliing_story_like,telliing_story_play')->order("id $order_type")->select();
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);
    }

    //故事根据播放量排序(讲)
    public function tellingPlayVolumeSort()
    {
        (new Sort())->goCheck();
        $tellingstoryModel = new TellingstoryModel();
        $order_type = $_POST['order_type'] == 1 ? 'desc' : 'asc';
        $tellingStory = $tellingstoryModel->field('id,telling_story_name,telling_story_author,telling_story_content,telliing_story_like,telliing_story_play')->order("telliing_story_play $order_type")->select();
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);
    }


    //故事根据最新排序(讲)
    public function tellingNewestSort()
    {
        (new Sort())->goCheck();
        $tellingstoryModel = new TellingstoryModel();
        $order_type = $_POST['order_type'] == 1 ? 'desc' : 'asc';
        $tellingStory = $tellingstoryModel->field('id,telling_story_name,telling_story_author,telling_story_content,telliing_story_like,telliing_story_play')->order("telling_story_time $order_type")->select();
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);
    }

    //根据故事ID获取故事内容
    public function getTellingStoryContent()
    {
        (new IDMustBePostiveInt())->goCheck();
        $tellingstory_id = $_POST['id'];
        $tellingstoryModel = new TellingstoryModel();
        $map['id'] = $tellingstory_id;
        $tellingStory = $tellingstoryModel->field('id,telling_story_name,telling_story_author,telling_story_content')->where($map)->find();
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);
    }


    //上传作品显示页
    public function showUploadWorks()
    {
        (new IDMustBePostiveInt())->goCheck();
        $tellingstory_id = $_POST['id'];
        $tellingstoryModel = new TellingstoryModel();
        $tellingStory = $tellingstoryModel->field('id,telling_story_name')->find($tellingstory_id);
        if (!$tellingStory) {
            $this->ajaxReturn((new TellingStoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $tellingStory
        ]);

    }

    //故事存草稿箱
    public function saveDrafts()
    {
        //根据token来获取uid
//        $this->uid = Token::getCurrentUid();
    }

    //获取新建专辑分类
    public function getCreateScategory()
    {
        $scategoryModel = new ScategoryModel();
        $map['scategory_type'] = C('Story.TellingStory');
        $sCategory = $scategoryModel->where($map)->select();
        if (!$sCategory) {
            $this->ajaxReturn((new ScategoryException())->getException());
        }
        $this->ajaxReturn([
            'code' => 200,
            'msg' => 'success',
            'data' => $sCategory
        ]);

    }


    //新建用户专辑
    public function createUserAlbum()
    {
        $this->uid = Token::getCurrentUid();
        (new UserAlbum())->goCheck();
        $user_album_title = $_POST['user_album_title'];
        $user_album_authority = $_POST['user_album_authority'];
        $scategory_id = $_POST['scategory_id'];
        $useralbumModel = new UseralbumModel();
        $useralbumModel->user_album_title = $user_album_title;
        $useralbumModel->user_album_authority = $user_album_authority;
        $useralbumModel->scategory_id = $scategory_id;
        $userAlbum = $useralbumModel->add();
        if (!$userAlbum) {
            $this->ajaxReturn((new TellingStoryException([
                'code' => 60001,
                'msg' => '新建专辑失败'
            ]))->getException());
        }
        $this->ajaxReturn((new SuccessException())->getException());

    }


}