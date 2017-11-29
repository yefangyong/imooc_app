<?php
namespace app\admin\controller;

use app\common\lib\Upload;
use app\Common\Validate\AdminValidate;
use think\Controller;

class Image extends Base
{

    /**
     * 图片上传到本地服务器
     */
    public function upload0() {
        $file = request()->file('file');
       //把图片上传到本地文件夹
        $info = $file->move('upload');
        if($info && $info->getPathname()) {
            $data = [
                'status'=>1,
                'msg'=>'ok',
                'data'=>'/'.$info->getPathname()
            ];
            echo json_encode($data);exit();
        }
        $data = [
            'status'=>0,
            'message'=>'error',
        ];
        echo json_encode($data);exit();
    }

    /**
     *七牛云图片上传功能
     */
    public function upload() {
        $image = Upload::image();
        if($image!=null) {
            $data = [
                'status'=>1,
                'msg'=>'ok',
                'data'=>config('qiniu.image_url').'/'.$image
            ];
            echo json_encode($data);exit();
        }else {
            $data = [
                'status'=>0,
                'message'=>'error',
            ];
            echo json_encode($data);exit();
        }
    }
}
