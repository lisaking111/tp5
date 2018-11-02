<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Admin extends Base
{
    public function _initialize(){
        parent::_initialize();
        $this->model = model('Admin');
    }


    //管理员列表
    public function lst(){
        $data = $this->model->getAdminList();
        $num = $data->total();
        return $this->fetch('admin/list',['data'=>$data,'num'=>$num]);
    }
    //添加管理员
    public function cu(Request $request){
        if($request->isPost()){
            $data = $request->post();
            $res = $this->model->_add($data);
            if($res == true){
                return ['code'=>10000,'msg'=>'操作成功'];
            }else{
                return ['msg'=>"操作失败"];
            }
        }
        $id = $request->param('id');
        $info = $this->model->getAdminInfoById($id);
        $list = \app\admin\model\Role::all();
        return $this->fetch('admin/add',['list'=>$list,'info'=>$info]);
    }
    //编辑管理员
    public function change(Request $request){
        $data = $request->post();
        if ($this->model->change($data)){
            return ['code'=>10000,'msg'=>'操作成功'];
        }else{
            return ['msg'=>"操作失败"];
        }

    }
    //保存管理员
    public function save(){

    }
    //删除管理员
    public function del(){

    }


}
