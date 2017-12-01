<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 16:23
 */

namespace app\Common\Validate;
use app\common\lib\exception\BaseException;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @return bool
     * 验证器的入口
     */
    public function goCheck() {
        $params = request()->param();
        $header = request()->header();
        $params = array_merge($params,$header);
        $result = $this->batch()->check($params);
        if(!$result) {
            $error = $this->error;
            if(is_array($error)) {
                $error = implode(',',$error);
            }
            throw new BaseException([
                'code'=>10000,
                'message'=>$error,
                'httpCode'=>401
            ]);
        }else {
            return true;
        }
    }
}