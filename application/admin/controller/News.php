<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/27
 * Time: 11:42
 */

namespace app\admin\controller;


use app\Common\Validate\NewsValidate;
use think\console\command\make\Model;
use think\Exception;

class News extends Base
{
    /**
     * @return string
     * 文章列表
     */
    public function index() {
        $data = input('param.');
        $query = http_build_query($data);
        $whereData = array();
        //组合查询条件
        $start_time = '';
        $end_time = '';
        $title = '';
        $cat = '';

        //分类条件
        if(isset($data['catid']) && !empty($data['catid'])) {
            $whereData['catid'] = $data['catid'];
            $cat = $data['catid'];
        }

        //时间条件
        if(!empty($data['start_time']) && !empty($data['end_time'])) {
            if(strtotime($data['start_time']) < strtotime($data['end_time'])) {
                $whereData['create_time'] =[
                    ['gt',strtotime($data['start_time'])],
                    ['lt',strtotime($data['end_time'])]
                ];
                $start_time = $data['start_time'];
                $end_time = $data['end_time'];
            }
        }
        //标题条件
        if(!empty($data['title'])) {
            $title = $data['title'];
            $whereData['title'] = ['like','%'.$data['title'].'%'];
        }

        //模式一,直接利用TP5的分页机制
        //$news = Model('News')->getNews($data);

        //模式二，利用插件layerPage，获取数据和总页数即可
        $this->getPageSize($data);

        //获取表中的数据根据条件
        $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);

        //获取总数
        $total = model('News')->getNewsCountByCondition($whereData);
        $totalPage = ceil($total/$this->size);

        return $this->fetch('',[
            'news'=>$news,
            'totalPage'=>$totalPage,
            'curr'=>$this->page,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'title' =>$title,
             'cat'=>$cat,
            'query'=>$query,
            'cats'=>config('cats.lists'),
        ]);
    }
    /**
     * @return mixed|string
     * 文章添加
     */
    public function add() {
        if(request()->isPost()) {
            //参数验证
            $post = input('post.');
            (new NewsValidate())->goCheck();
            try{
                $id = model('News')->add($post);
            }catch (Exception $e) {
                show(0,$e->getMessage());
            }
            if($id) {
                return show(1,'添加成功');
            }else {
                return show(0,'添加失败');
            }
        }else {
            return $this->fetch('',['cats'=>config('cats.lists')]);
        }
    }



}