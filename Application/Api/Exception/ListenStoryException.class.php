<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午10:17
 */

namespace Api\Exception;


class ListenStoryException extends BaseException
{
    public $code = 90000;

    public $msg = "故事不存在(听)";

//    public $errorCode = 70000;
}

