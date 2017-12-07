<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/7
 * Time: 11:12
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Exception;

class Rank extends Common
{
    /**
     * @return \think\response\Json
     * 获取排行榜的数据
     */
    public function index() {
        try{
            $result = model('News')->getRankNormalNews(5);
            $result = $this->getDealNews($result);
        }catch (Exception $e) {
            return show(0,$e->getMessage(),'',401);
        }
        return show(config('app.success'),'ok',$result,200);
    }
}