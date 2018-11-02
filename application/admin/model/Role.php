<?php

namespace app\admin\model;

use Think\Db;
use think\Model;

class Role extends Model
{
    //某角色下的成员
   public function getRoleMember($role_id){
       $res = Db::name('role_access')
                ->alias('c')
                ->where('c.group_id',$role_id)
                ->join('admin a','a.id = c.uid','right')
                ->select();
       return $res;
   }

    public function getRoleInfoById($id){
        $res = $this->where('id',$id)
                    ->find();
        return $res;
    }

    public function _save($data){
        if(!empty($data['id'])){
            $res = $this->save($data,['id'=>$data['id']]);
        }else{
            $res = $this->data($data)->save();
        }
        return $res;
    }
}
