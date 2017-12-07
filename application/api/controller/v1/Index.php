<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/1
 * Time: 17:31
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

class Index extends Common
{
    /**
     * @return \think\response\Json
     * APP首页的数据
     */
    public function index() {
        $heads = model('News')->getHeadNormalNews();

        $positions= model('News')->getPositionNormalNews();

        $position = $this->getDealNews($positions);

        $result = [
            'heads'=>$heads,
            'positions'=>$position
        ];
        return show(config('app.success'),'ok',$result,200);
    }
}