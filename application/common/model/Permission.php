<?php

namespace app\common\model;

use think\Model;

class Permission extends Model
{

    public function getAllPermission(){
        $res = $this->field('id,title,name,p_id,status')
                    ->select();
        return $res;
    }
    //
    public function getPermissionList($where = '1=1'){
        $res = $this->where($where)
                    ->field('id,title,p_id')
                    ->select();
        $res = collection($res)->toArray();
        return $res;
    }

    //添加修改权限
    public function cuPermission($data){
        if(!empty($data['id'])){
            $res = $this->save($data,['id'=>$data['id']]);
            return $res;
        }
        $res = $this->data($data)->save();
        return $res;
    }

    public function getPermissionInfoById($id){
        $res= $this->where('id',$id)
                    ->field('id,name,title,type,status,condition,p_id,is_show')
                    ->find();
        return $res;
    }

    public function _del($id){

        $res = $this->save(['status'=>-1],['id'=>$id]);
        return $res;
    }
}
