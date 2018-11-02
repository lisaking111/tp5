<?php

namespace app\admin\controller;

use think\Controller;
use Think\Model;
use think\Request;

class Category extends Controller
{
    private $model;
    public function _initialize(){
        $this->model = model('Category');
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function lst(Request $request)
    {
        $where = [];
        if(!empty($request->get('search_name'))){
            $name = $request->get('search_name');
            $where['name'] = ['like',"%$name%"];
        }
        if(!empty($request->get('search_media'))){
            $where['media'] = $request->get('search_media');
        }
        if(!empty($request->get('search_type'))){
            $where['type'] = $request->get('search_type');
        }
        $list = $this->model->getAllCategory($where);
        return $this->fetch('category/list',['list'=>$list]);
    }


    public function cu(Request $request){
        if($request->isPost()){
            $data = $request->post();
            //修改
                $res = $this->model->cu($data);
                if($res){
                    return ['code'=>'10000','msg'=>'操作成功'];
                }else{
                    return ['msg'=>'操作失败'];
                }
        }
        $id = $request->param('id');
        $data = $this->model->get($id);

        return $this->fetch('category/cu',['data'=>$data]);
    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        if(!$request->isPost()){
            $this->error('失败');
        }
        $data = $request->post();
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        if(!empty($data['id'])){
            return $this->update($data);
        }
        if($this->model->add($data)){
            $this->success('分类创建成功');
        }else{
            $this->error('分类添加失败');
        }

    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    private function update($data)
    {
        $res = $this->model->save($data,['id'=>$data['id']]);
        //
        if($res){
            $this->success('更新成功!');
        }else{
            $this->error('更新失败');
        }
    }


    public function del(Request $request){
        $id = $request->post('id');
        $res = $this->model->save(['status'=>-1],['id'=>$id]);
        if($res){
            return ['code'=>10000,'msg'=>'操作成功'];
        }else{
            return ['code'=>10000,'msg'=>'操作失败'];
        }
    }

}
