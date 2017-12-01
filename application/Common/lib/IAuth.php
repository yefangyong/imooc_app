<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 17:35
 */

namespace app\common\lib;


use think\Cache;

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

    /**
     * @param $data
     * @return bool
     * 校验sign是否合法
     */
    public static function checkSign($data) {
        if(empty($data['sign'])) {
            return false;
        }
        $str = (new Aes())->decrypt($data['sign']);
        if(empty($str)) {
            return false;
        }
        //解析解码后的字符串did=123yfy&version=1
        parse_str($str,$arr);//$arr = ['did'=>'123yfy','version'=>1];

        if(!is_array($arr) || $arr['did'] != $data['did'] || empty($arr['did'])){
            return false;
        }
        if(config('app_debug')) {
            //验证是否过期,时间戳为秒数+毫秒的前三位，唯一性
            if(time() - ceil($arr['time'] / 1000) > config('app.app_sign_time')) {
                return false;
            }
            //验证唯一性,请求成功后，会写入缓存，再次请求，如果存在，返回false
            if(Cache::get($arr['sign'])) {
                return false;
            }
        }
        return true;
    }


}