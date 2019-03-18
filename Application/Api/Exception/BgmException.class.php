<?php
/**
 * Created by 有情人好聚好散.
 * Author: ASang
 * Date: 18-8-8
 * Time: 下午10:17
 */

namespace Api\Exception;


class BgmException extends BaseException
{
    public $code = 40000;

    public $msg = "背景音乐不存在";

//    public $errorCode = 50000;
}