<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class Sort extends BaseValidate
{
    protected $rule = [
        'order_type' => 'isPositiveInteger|require',
//        'page_id' => 'isPositiveInteger|require',
    ];

    protected $message = [
        'order_type.isPositiveInteger' => "order_type必须是正整数",
        'order_type.require' => "order_type必须存在",
//        'mcategory_id.isPositiveInteger' => "mcategory_id必须是正整数",
//        'mcategory_id.require' => "mcategory_id必须存在",
    ];

}