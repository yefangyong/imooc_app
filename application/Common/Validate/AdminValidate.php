<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 16:28
 */

namespace app\Common\Validate;


class AdminValidate extends BaseValidate
{
    protected $rule = [
        'username'=>'require|max:10',
        'password'=>'require|max:10|min:5'
    ];
}