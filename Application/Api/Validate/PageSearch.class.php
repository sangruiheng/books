<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午12:22
 */

namespace Api\Validate;


class PageSearch extends BaseValidate
{
    protected $rule = [
        'scategory_id' => 'isPositiveInteger|require',
        'is_age' => 'require',
        'is_sex' => 'require',
    ];

    protected $message = [
        'scategory_id.isPositiveInteger' => "scategory_id必须是正整数",
        'scategory_id.require' => "scategory_id必须存在",
        'is_age.require' => "is_age必须存在",
        'is_sex.require' => "is_sex必须存在",
    ];

}