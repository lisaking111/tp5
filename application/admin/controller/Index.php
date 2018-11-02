<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Config;
use think\Session;

class Index extends Base
{
    public function index()
    {
        $uid = Session::get('admin_id');
        $res = \app\admin\model\Admin::get($uid);
        $role = Session::get('role_id');
        if($role ==  Config::get('web_editor_role_id')){
            $this->redirect('/admin/Workload/numList');
        }elseif ($role == Config::get('editor_role_id')){
            $this->redirect('/admin/Workload/lst');
        }else{
            return $this->fetch('index/index',['data'=>$res]);
        }

    }
}
