<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/29
 * Time: 14:25
 */

namespace app\Common\Model;


class News extends Base
{
    /**
     * @param $data
     * @return \think\Paginator
     * 模式一，获取文章列表页
     */
    public function getNews($data) {
        $data['status'] = [
            'neq',config('code.status_delete')
        ];
        $order = ['id'=>'desc'];
        $res = $this->where($data)->order($order)->paginate();
        return $res;
    }

    /**
     * @param $condition
     * @param $from
     * @param $size
     * @return false|\PDOStatement|string|\think\Collection
     * 模式二，获取分页的数据
     */
    public function getNewsByCondition($condition,$from,$size) {
        $condition['status'] = [
            'neq',config('code.status_delete')
        ];
        $order = ['id'=>'desc'];
        $res = $this->where($condition)->limit($from,$size)->order($order)->select();
        return $res;
    }

    /**
     * @param $condition
     * @return int|string
     * 获取符合条件的总数
     */
    public function getNewsCountByCondition($condition) {
        $condition['status'] = [
            'neq',config('code.status_delete')
        ];
        $count = $this->where($condition)->count();
        return $count;
    }


}