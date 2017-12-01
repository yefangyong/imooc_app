<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param $status
 * @param $message
 * @param array $data
 * @param int $httpCode http状态码
 * @return \think\response\Json
 * 公共的API调用函数，返回JSON数据
 */
function show($status,$message,$data = array(),$httpCode = 200) {
    $arr = [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
   return json($arr,$httpCode);
}

/**
 * @param $obj
 * @return string|void
 * 分页样式
 */
function pagination($obj) {
    if(!$obj) {
        return ;
    }
    $params = request()->param();
    return "<div class='imooc-app'>".$obj->appends($params)->render()."</div>";
}

/**
 * @param $catId
 * 获取分类的名称
 */
function getCatName($catId) {
    if(!$catId) {
        return ;
    }
    $config = config('cats.lists');
    return $config[$catId];
}

/**
 * @param $id
 * @return string
 * 是否推荐
 */
function isYesNo($id) {
    return $id==0?'否':"<span style='color: red'>是</span>";
}

/**
 * @param $status
 * @return string|void
 * 状态
 */
function status($status) {
    $str = '';
    if($status == config('code.status_padding')) {
        $str = '待审';
    }else if($status == config('code.status_normal')){
        $str = '正常';
    }
    return $str;
}
