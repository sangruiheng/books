<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class SearchName extends BaseValidate
{
    protected $rule = [
        'title' => 'require',
    ];

    protected $message = [
        'title.require' => "title必填",
    ];

}