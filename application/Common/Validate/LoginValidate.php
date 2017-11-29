<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 17:21
 */

namespace app\Common\Validate;


class LoginValidate extends BaseValidate
{
    protected $rule = [
        'username'=>'require|max:10|min:3',
        'code'=>'require',
        'password'=>'require|max:10'
    ];
}