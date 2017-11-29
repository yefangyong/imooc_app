<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 17:35
 */

namespace app\common\lib;


class IAuth
{
    /**
     * @param $data
     * @return string
     * 设置密码
     */
    public static function setPassword($data) {
        return md5($data.config('app.password_pre'));
    }
}