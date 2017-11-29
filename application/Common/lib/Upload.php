<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/27
 * Time: 16:24
 */

namespace app\common\lib;

//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;
class Upload
{
    /**
     * @return null|string
     * 七牛云图片上传
     */
    public static function image() {
        $file  = $_FILES['file']['tmp_name'];
        if(empty($_FILES['file']['tmp_name'])) {
            exception('提交的数据不合法',404);
        }

        //第一种方法获得文件的后缀
//        $ext = pathinfo($_FILES['file']['name']);
//        $ext = $ext['extension'];

        //第二种获得文件的后缀
        $ext = explode('.',$_FILES['file']['name']);
        $ext = $ext[1];
        //构建一个鉴权对象
        $config = config('qiniu');

        $auth = new Auth($config['key'],$config['appSecret']);
        //生成上传token
        $token = $auth->uploadToken($config['buckt']);

        //上传后保存到七牛云的文件名
        $key = date('Y').'/'.date('m').'/'.date('d').'/'.md5(substr($file,0,5)).rand(0,9999).$ext;
       //初始化UploadManager
        $uploadManager = new UploadManager();
        //上传到七牛云
        list($ret,$err) = $uploadManager->putFile($token,$key,$file);
        if($err!=null) {
            return null;
        }else {
            return $key;
        }
    }
}