<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class LoadMore extends BaseValidate
{
    protected $rule = [
        'mcategory_id' => 'isPositiveInteger|require',
        'page_id' => 'isPositiveInteger|require',
    ];

    protected $message = [
        'page_id.isPositiveInteger' => "page_id必须是正整数",
        'page_id.require' => "page_id必须存在",
        'mcategory_id.isPositiveInteger' => "mcategory_id必须是正整数",
        'mcategory_id.require' => "mcategory_id必须存在",
    ];

}