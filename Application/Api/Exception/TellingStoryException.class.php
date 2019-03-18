<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午10:17
 */

namespace Api\Exception;


class TellingStoryException extends BaseException
{
    public $code = 60000;

    public $msg = "故事不存在(讲)";

//    public $errorCode = 70000;
}

