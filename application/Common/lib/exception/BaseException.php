<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/30
 * Time: 13:23
 */

namespace app\common\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    /**
     * @var mixed
     * 业务状态码
     */
    public $code = 401;

    /**
     * @var
     * 错误信息
     */
    public $message = '参数错误';

    /**
     * @var
     * http码
     */
    public $httpCode = '500';

    public function __construct($param = [])
    {
        if(!is_array($param)) {
            return ;
        }
        if(array_key_exists('code',$param)) {
            $this->code = $param['code'];
        }

        if(array_key_exists('message',$param)) {
            $this->message = $param['message'];
        }

        if(array_key_exists('httpCode',$param)) {
            $this->httpCode = $param['httpCode'];
        }
    }
}