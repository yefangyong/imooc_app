<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use Think\Route;

Route::post('api/:version/test','api/:version.test/index');
Route::get('api/:version/time','api/:version.time/index');
Route::get('api/:version/cat','api/:version.cat/getCat');
Route::get('api/:version/index','api/:version.index/index');
Route::resource('api/:version/news','api/:version.news');