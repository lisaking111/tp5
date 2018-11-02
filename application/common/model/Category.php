<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = true;
    //添加分类
    public function cu($data)
    {
        if (!empty($data['id'])) {
            $res = $this->save($data,['id'=>$data['id']]);
            return $res;
        }
        $data['status'] = 1;
        $res = $this->data($data)->save();
        return $res;
    }

    //获取正常分类
    public function getAllCategory($where){
        $res = $this->where($where)->paginate();
        return $res;
    }

    //获取会议列表
    public function getCategoryList($media,$type) {
        $res = $this->where('media',$media)
                    ->where('type',$type)
                    ->field('id,name')
                    ->select();
        return $res;
    }

    //获取产品列表
    public function getProductList($client_id){
        $res = $this->where('parent',$client_id)
                    ->field('id,name')
                    ->select();
        return $res;
    }
    //修改分类
    public function _save($data){
        $res = $this->save($data,['id'=>$data['id']]);
        return $res;
    }
}
