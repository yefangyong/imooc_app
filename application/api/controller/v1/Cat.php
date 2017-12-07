<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/1
 * Time: 16:11
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

class Cat extends Common
{
    /**
     * @return \think\response\Json
     * 获取到分类的内容
     */
    public function getCat() {
        $cats = config('cats.lists');
        $result [] = [
            'catid'=>0,
            'catname'=>'首页'
        ];
        foreach ($cats as $catid=>$catname) {
            $result[] = [
                'catid'=>$catid,
                'catname'=>$catname
            ];
        }
        return show(1,'ok',$result,200);
    }
}