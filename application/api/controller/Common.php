<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/30
 * Time: 18:17
 */

namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\exception\BaseException;
use app\common\lib\IAuth;
use app\Common\Validate\AppValidate;
use think\Cache;
use think\Controller;

/**
 * Class Common
 * @package app\api\controller
 * API模块，共公的控制器
 */
class Common extends Controller
{
    /**
     * @var
     * 请求头数据
     */
    public $header;
    /**
     * 控制器初始化
     */
    public function _initialize()
    {
        $this->checkAuthRequest();
        //$this->testAes();
    }

    /**
     *测试AES加密算法
     */
    public function testAes() {
        $param = request()->header();
        $data = [
            'did'=>'123yfy',
            'version'=>'1',
            'time'=>$this->getTimeStamp()
        ];
        $string = http_build_query($data);
        $str = (new Aes())->encrypt($string);
        $arr =  (new Aes())->decrypt($str);
        parse_str($arr,$str);
        exit;
    }

    /**
     * @throws BaseException
     * 每次APP请求接口都要检查合法性
     */
    public function checkAuthRequest() {
        $header = request()->header();
        //参数检查
        (new AppValidate())->goCheck();

        if(!IAuth::checkSign($header)) {
            throw new BaseException([
                'code'=>10001,
                'message'=>'sign授权失败',
                'httpCode'=>401
            ]);
        }
        Cache::set($header['sign'],1,config('app.app_cache_time'));
        $this->header = $header;
    }

    /**
     * @return string
     * 获得当前的时间戳13位，不用10位的，为了时间戳的唯一性
     */
    public function getTimeStamp() {
        list($t1,$t2) = explode(' ',microtime());
        return $t2 . ceil($t1 * 1000);
    }

    /**
     * @param array $data
     * @return array
     * 处理获取的新闻数据
     */
    public function getDealNews($data = array()) {
        if(empty($data)) {
            return [];
        }
        $cats = config('cats.lists');
        foreach ($data as $k=>$v) {
            $data[$k]['catename'] = $cats[$v['catid']] ? $cats[$v['catid']] : '-';
        }
        return $data;
    }
}