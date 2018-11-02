<?php

namespace app\common\model;

use think\Model;

class Shoot extends Base{
    public function test(){
        $shoot = new Shoot;
        return $shoot->where('id','1')->select();
    }
}
