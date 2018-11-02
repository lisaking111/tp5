<?php
namespace app\admin\validate;
use think\Validate;
class WorkLoad extends Validate {
    protected $rule = [
        ['title','require|max:10','标题不能为空|标题名不能超过20个字符'],
        ['link','require','链接不能为空'],
        ['publish_time','require','推送时间不能为空'],

    ];

    protected $scene = [
        'add'=>['title','link','publish_time'],
    ];
}