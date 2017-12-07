<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/30
 * Time: 13:22
 */

namespace app\common\lib\exception;

use Exception;
use think\exception\Handle;
use think\Log;

class ExceptionHandle extends Handle
{
    public $code;
    public $message;
    public $httpCode;

    public function render(Exception $e)
    {
        if($e instanceof BaseException) {
            //用户行为导致的错误，直接返回，无需记录日志
            $this->code = $e->code;
            $this->message = $e->message;
            $this->httpCode = $e->httpCode;
        }else {
            //服务器内部错误，需要记录日志,不可预知的错误处理方案
            if(config('app_debug')) {
                //return default error page
                parent::render($e);
            }else {
                $this->code = 999;
                $this->message = $e->getMessage();
                $this->httpCode = 500;
                //记录到日志文件
                $this->recordToLog($e);
            }
        }
        $data = [
            'code'=>$this->code,
            'message'=>$this->message,
            'url'=>request()->url()
        ];
        return show(0,$this->message,$data,$this->httpCode);
    }

    /**
     * @param Exception $e
     * 记录错误异常，用户导致的异常无需记录日志，意义不大，
     * 服务器内部产生的异常需要记录到日志文件，排错
     * 生产环境下，只能通过日志来排查错误，测试环境下可以直接打断点排查错误
     */
    public function recordToLog($e) {
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }
}