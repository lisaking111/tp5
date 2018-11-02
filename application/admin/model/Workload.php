<?php

namespace app\admin\model;

use Think\Db;
use think\Model;

class Workload extends Model
{
    //
    protected $autoWriteTimestamp = 'datetime';

    public function add($data){
        $res = $this->save($data);
        return $res;
    }

    public function cu($data){
        if(!empty($data['id'])){
            $res = $this->allowField(true)->save($data,['id'=>$data['id']]);
            return $res;
        }
        $res = $this->data($data)->save();
        return $res;
    }

    //工作量列表
    public function getWorkLoadList($where){
        $res = $this->where($where)->paginate(10,false,['query' => request()->param()]);
        return $res;
    }

    //工作量统计列表
    public function getNumList($where){
        $res = $this->where($where)
                    ->field('id,title,link,editor,publish_time,send_num,read_num,read_times,official_num,official_times,timeline_num,timeline_times,share_num,share_times')
                    ->paginate();
        return $res;
    }

    public function getLastWork($uid){
        $res = $this->where('uid',$uid)->order('create_time desc')->field('source,media,type,field,meeting,client,col_editor,web_editor')->find();
        return $res;
    }

    public function getEditorList($str,$media,$type){
        $res = Db::name('editor')
//            ->where('parent')
            ->where('realname','like',"%$str%")
            ->select();
        return $res;
    }
}
