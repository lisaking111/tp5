<?php

namespace app\admin\controller;

use think\Request;

class Permission extends Base
{
    private $model;

    public function _initialize(){
        parent::_initialize();
        $this->model = model('Permission');
    }

    //权限列表
    public function lst(){
        $res = $this->model->getAllPermission();
        $res = infinite($res,0,0);
        foreach ($res as $k=>$v){
            $res[$k]['title'] = str_repeat('&nbsp;',$v['deep']*4).'|-'.$v['title'];
        }
        return $this->fetch('permission/list',['data'=>$res]);
    }

    //添加修改权限
    public function cu(Request $request){
        $select = $this->model->getPermissionList();
        $data = $request->post();
        if($request->isPost()){
            if($this->model->cuPermission($data)){
                return ['code'=>10000,'msg'=>'操作成功'];
            }else{
                return ['code'=>10020,'msg'=>'操作失败'];
            }
        }
        $id = $request->param('id');
        $res = $this->model->getPermissionInfoById($id);
        return $this->fetch('permission/add',['select'=>$select,'data'=>$res]);

    }
    //删除权限
    public function del(Request $request){
        $id = $request->param('id');
        $res = $this->model->_del($id);
        if($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],1,'success');
        }
    }
}
