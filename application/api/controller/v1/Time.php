<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/1
 * Time: 14:12
 */

namespace app\api\controller\v1;


class Time
{
    public function index() {
        return show(1,'服务器端时间',['time'=>time()]);
    }
}