<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/30
 * Time: 11:36
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

class Test extends  Common
{
    public function index() {
        $data = [
            'status'=>0,
            'message'=>'ok',
            'data'=>array()
        ];
        $data['ids'];
        return $data;
    }
}