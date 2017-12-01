<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 16:57
 */

namespace app\admin\controller;


use app\common\lib\IAuth;
use app\Common\Model\AdminUser;
use app\Common\Validate\LoginValidate;
use think\Controller;

class Login extends Base
{
  public function _initialize()
  {
  }
    /**
     * @return mixed
     * 登录功能开发
     */
    public function index() {
        if(request()->isPost()) {
            (new LoginValidate())->goCheck();
            $post = input('post.');
            $res = captcha_check($post['code']);
            if(!$res) {
               return show(0,'验证码错误');
            }
            $rel = AdminUser::get(array('username'=>$post['username']));
            if(!$rel || $rel->status != config('code.status_normal')) {
                return show(0,'用户名不存在');
            }
            $pwd =IAuth::setPassword($post['password']);
            $user = AdminUser::get(array('password'=>$pwd));
            if(!$user) {
                return show(0,'密码错误');
            }
            //修改登录状态，保存到session
            $data = array('last_login_time'=>time(),'last_login_ip'=>request()->ip());
            try{
                model('AdminUser')->save($data,['id'=>$rel->id]);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            session(config('admin.session_user'),$user,config('admin.session_scope'));
            return show(1,'登录成功');
        }else {
            $isLogin = $this->isLogin();
            if($isLogin) {
                $this->redirect('index/index');
            }
            return $this->fetch();
        }
    }

    /**
     *退出登录
     */
    public function logout() {
        //清空session
        session(null,config('admin.session_scope'));
        $this->redirect('login/index');
    }
}