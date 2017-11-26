<?php
namespace app\admin\controller;

use app\Common\Validate\AdminValidate;
use think\Controller;

class Admin extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function add() {
        if(request()->isPost()) {
            (new AdminValidate())->goCheck();
            $post = input('post.');
            $data = array();
            $data['username'] = $post['username'];
            $data['password'] = md5($post['password'].'yfyjsz');
            $data['last_login_ip'] = request()->ip();
            $id = model('AdminUser')->add($data);
            if($id) {
                $this->success('添加成功');
            }else {
                $this->error('添加失败');
            }
        }else {
            return $this->fetch();
        }

    }
}
