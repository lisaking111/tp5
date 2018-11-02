<?php

namespace app\admin\controller;

use think\Loader;
use think\Request;

class Role extends Base
{
    public function _initialize(){
        parent::_initialize();
        $this->model = Loader::model('Role');
//        $this->model = model('Role');
    }
    //角色列表
    public function lst(Request $request){
        $res = $this->model->all();
        foreach ($res as $k=>$v){
            $users = $this->model->getRoleMember($v->id);
            $user_arr = [];
            foreach ($users as $user){
                    $user_arr[] =$user['username'];
            }
            $res[$k]['users'] = implode(',',$user_arr);
        }
        return $this->fetch('role/list',['data'=>$res]);
    }

    //添加角色
    public function cu(Request $request){
        if($request->isPost()){
            $data = $request->post();
            if(!empty($data['ids'])){
                $data['rules'] = implode(',',$data['ids']);
                unset($data['ids']);
            }else{
                $data['rules'] = '';
            }


            $res = $this->model->_save($data);
            if($res){
                return ['code'=>10000,'msg'=>'操作成功'];
            }else{
                return ['msg'=>'失败'];
            }
        }
        $id = $request->param('id');
        $info = $this->model->getRoleInfoById($id);
        $permission =  model('Permission');
        $list =$permission->getPermissionList(['p_id'=>0]);

        $result = [];
        foreach ($list as $k=>$v){
            $result[$v['title']] = $permission->getPermissionList(['p_id'=>$v['id']]);
        }
//        var_dump($result);die;
        return $this->fetch('role/add',['info'=>$info,'list'=>$result]);
    }
    //编辑角色
    public function edit(){

    }

    //保存角色
    public function save(){

    }

    //删除角色
    public function del(){

    }

}
