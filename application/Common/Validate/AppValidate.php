<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/1
 * Time: 10:32
 */

namespace app\Common\Validate;
class AppValidate extends BaseValidate
{
    protected $rule = [
        'sign'=>'require',
        'did'=>'require',
        'version'=>'require'
    ];
}