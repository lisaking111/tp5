<?php

namespace app\admin\model;

use Think\Db;
use think\Model;

class Admin extends Model
{
    //
    protected $autoWriteTimestamp = 'datetime';


    /**
     * 管理员详细列表
     * @return false|\PDOStatement|string|\think\Collection
     *
     */

    public function getAdminList(){
        $res = $this->alias('a')
                    ->join('role_access s','a.id=s.uid','left')
                    ->join('role r','s.group_id = r.id','left')
                    ->field('a.*,r.title role')
                    ->order('a.status desc,s.group_id')
                    ->paginate();
        return $res;
    }

    public function getEditorList(){
        $role_id = config('editor_role_id');
        $res = $this->where('a.status',1)
                    ->where('s.group_id',$role_id)
                    ->alias('a')
                    ->join('role_access s','a.id=s.uid','left')
                    ->field('a.username,a.id')
                    ->select();
        return $res;
    }

    public function getBriefAdminList($where){
        $res = $this->where($where)->field('id,realname')->select();
        return $res;
    }

    public function getAdminInfoById($id){
        $res = $this->where('a.id',$id)
                    ->alias('a')
                    ->join('role_access r','a.id=r.uid','left')
                    ->field('a.id,a.username,a.company,r.group_id')
                    ->find();
        return $res;
    }

    public function _add($data){

        if(!empty($data['id'])){
            return self::_save($data);
        }else{
            $data['password'] = password_hash($data['password'],true);
            $data['status'] = 1;
            unset($data['password2']);
            try{
                Db::startTrans();
                $res1 = $this->allowField(true)->data($data)->save();
                $res2 = Db::name('role_access')->insert(['uid'=>$this->id,'group_id'=>$data['group_id']]);
                if($res1 && $res2){
                    Db::commit();
                    return true;
                }
            }catch (\Exception $e){
                Db::rollback();
                return false;
            }
        }
    }

    public function _save($data){
        $res = Db::name('role_access')->where(['uid'=>$data['id']])->update(['group_id'=>$data['group_id']]);
        return $res;
    }

    public function change($data){
        $res = $this->where('id',$data['id'])->update(['status'=>$data['status']]);
        if($res){
            return true;
        }
    }
}
