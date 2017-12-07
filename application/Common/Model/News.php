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
    public function getNewsByCondition($condition,$from = 0,$size = 5) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq',config('code.status_delete')
            ];
        }
        $order = ['id'=>'desc'];
        $res = $this->where($condition)->field($this->_getListFiled())->limit($from,$size)->order($order)->select();
        return $res;
    }

    /**
     * @param $condition
     * @return int|string
     * 获取符合条件的总数
     */
    public function getNewsCountByCondition($condition = []) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq',config('code.status_delete')
            ];
        }
        $count = $this->where($condition)->count();
        return $count;
    }

    /**
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     * 获取头图的数据
     */
    public function getHeadNormalNews($num = 4) {
        $data = [
            'status'=>1,
            'is_head_figure'=>1
        ];
        $order = [
            'id'=>'desc'
        ];
        return $this->where($data)->field($this->_getListFiled())->order($order)->limit($num)->select();
    }

    /**
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     * 获取排行的数据
     */
    public function getRankNormalNews($num = 5) {
        $data = [
            'status'=>1,
        ];
        $order = [
            'read_count'=>'desc'
        ];
        return $this->where($data)->field($this->_getListFiled())->order($order)->limit($num)->select();
    }

    /**
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     * 获取推荐的数据
     */
    public function getPositionNormalNews($num = 20) {
        $data = [
            'status'=>1,
            'is_position'=>1
        ];
        $order = [
            'id'=>'desc'
        ];
        return $this->where($data)->field($this->_getListFiled())->order($order)->limit($num)->select();
    }

    /**
     * @return array
     * 获取通用的字段
     */
    private function _getListFiled() {
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count',
            'status',
            'is_position',
            'update_time',
            'create_time'
        ];
    }


}