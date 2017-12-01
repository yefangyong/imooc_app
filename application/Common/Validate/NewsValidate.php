<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/11/29
 * Time: 14:26
 */

namespace app\Common\Validate;


class NewsValidate extends BaseValidate
{
    protected $rule = [
        'title'=>'require',
        'small_title'=>'require',
        'catid'=>'require',
        'listorder'=>'require',
        'description'=>'require',
        'is_allowcomments'=>'require',
        'is_head_figure'=>'require',
        'is_position'=>'require',
        'source_type'=>'require',
        'image'=>'require',
        'content'=>'require',
    ];
}