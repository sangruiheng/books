<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class UserAlbum extends BaseValidate
{
    protected $rule = [
        'scategory_id' => 'isPositiveInteger|require',
        'user_album_authority' => 'isPositiveInteger|require',
        'user_album_title' => 'require',
    ];

    protected $message = [
        'scategory_id.isPositiveInteger' => "scategory_id必须是正整数",
        'scategory_id.require' => "scategory_id必须存在",
        'user_album_authority.isPositiveInteger' => "user_album_authority必须是正整数",
        'user_album_authority.require' => "user_album_authority必须存在",
        'user_album_title.require' => "user_album_title必须存在",
    ];

}