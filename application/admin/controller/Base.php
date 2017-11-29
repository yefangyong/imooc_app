<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 18:34
 */

namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{
    /**
     *初始化
     */
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
}