<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class UserStory extends BaseValidate
{
    protected $rule = [
        'user_story' => 'require',
        'telling_story_id' => 'isPositiveInteger|require',
        'bgm_id' => 'isPositiveInteger|require',
    ];

    protected $message = [
        'telling_story_id.isPositiveInteger' => "telling_story_id必须是正整数",
        'telling_story_id.require' => "telling_story_id必须存在",
        'bgm_id.isPositiveInteger' => "bgm_id必须是正整数",
        'bgm_id.require' => "bgm_id必须存在",
        'user_story.require' => "user_story必须存在",
    ];

}