<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/7
 * Time: 10:24
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Exception;

class News extends Common
{
    /**
     * @return \think\response\Json
     * 根据分类ID获取数据
     * 列表页的接口
     */
    public function index() {
        //validate 验证机制，验证参数的合法性
        $data = input('get.');

        $this->getPageSize($data);

        $whereData['status'] = config('code.status_normal');
        if(!empty($data['catid'])) {
            $whereData['catid'] = input('get.catid', 0, 'intval');
        }
        if(!empty($data['title'])) {
            $whereData['title'] = ['like',"%".$data['title']."%"];
        }
        //总数
        $total = model('News')->getNewsCountByCondition($whereData);

        //内容
        $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);

        $this->getDealNews($news);

        $result = [
            'total'=>$total,
            'lists'=>$news,
            'page_num'=>ceil($total / $this->size)
        ];
        return show(config('app.success'),'ok',$result,200);
    }

    /**
     * @return \think\response\Json
     * 详情页面的接口
     */
    public function read() {
        //验证参数是否合法 (new NewsValidate())->gocheck();
        $id = intval(input('param.id'));
        try{
            $new =\app\Common\Model\News::get(array('id'=>$id,'status'=>config('code.status_normal')));
        }catch (Exception $e) {
            return show(500,$e->getMessage(),'',500);
        }
        if(empty($new)) {
            return show(404,'该新闻不存在','',404);
        }
        $cats = config('cats.lists');

        $new->catname = $cats[$new->catid];

        try {
            model('News')->where(['id'=>$new->id])->setInc('read_count');
        }catch (Exception $e) {
            return show(500,$e->getMessage(),'',500);
        }
        return show(1,'ok',$new,200);
    }
}