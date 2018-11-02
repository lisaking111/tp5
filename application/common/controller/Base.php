<?php

namespace app\common\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function _initialize(){
        if(Seesion('admin_login') <= 0){
            $this->redirect('login/login');
        }
    }
}
