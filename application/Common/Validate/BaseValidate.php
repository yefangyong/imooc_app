<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 16:23
 */

namespace app\Common\Validate;


use think\Controller;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @return bool
     * 验证器的入口
     */
    public function goCheck() {
        $params = request()->param();
        $result = $this->batch()->check($params);
        if(!$result) {
            $error = $this->error;
            if(is_array($error)) {
                $error = implode(',',$error);
            }
           exception($error);
        }else {
            return true;
        }
    }
}