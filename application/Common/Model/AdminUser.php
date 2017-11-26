<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/26
 * Time: 16:42
 */

namespace app\Common\Model;


use think\Model;

class AdminUser extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * @param $data
     * @return mixed
     * 管理员的添加
     */
    public function add($data) {
        if(!is_array($data)) {
            exception('传递的参数不合法');
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }
}