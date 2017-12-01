<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 18:34
 */

namespace app\admin\controller;


use think\Controller;
use think\Exception;

class Base extends Controller
{
    /**
     * @var
     * 页码
     */
    public $page;

    /**
     * @var
     * 每页显示多少条
     */
    public $size;

    /**
     * @var
     * limit的起始位置
     */
    public $from;
    /**
     *初始化
     */

    /**
     * @var
     * 数据表对应的model
     */
    public $model;

    public function _initialize()
    {
        $isLogin = $this->isLogin();
        if(!$isLogin) {
            $this->redirect('login/index');
        }
    }

    /**
     * @return bool
     * 判断是否登录
     */
    public function isLogin() {
        $user = session(config('admin.session_user'),'',config('admin.session_scope'));
        if(!$user || !$user->id) {
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * 获取分页的page 和 size
     */
    public function getPageSize($data) {
        $this->page = !empty($data['page'])?$data['page']:1;
        $this->size = !empty($data['pageSize'])?$data['pageSize']:config('pagination.list_rows');
        $this->from = ($this->page-1)*$this->size;
    }

    /**
     * @return string
     * 公用的修改状态和删除的方法
     */
    public function status() {
        $params = request()->param();
        if(!intval($params['id'])){
            return show(0,'id不合法');
        }
        //获取当前控制器的名字，一般控制器名字和model和数据表名字一直，如果不一致，我们可以在model里面，直接声明model
        //例如 $this->model = 'model名'
        $model = $this->model?$this->model:request()->controller();

        try {
            $res = model($model)->save(['status'=>$params['status']],['id'=>$params['id']]);
        }catch (Exception $e) {
            return show(0,$e->getMessage());
        }
        if($res) {
            return show(1,'操作成功');
        }else {
            return show(0,'操作失败');
        }


    }
}