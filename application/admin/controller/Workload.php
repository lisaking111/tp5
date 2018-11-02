<?php

namespace app\admin\controller;

use think\Config;
use think\Session;
use Think\Db;
use think\Request;
use think\Validate;

class Workload extends Base
{
    private $model;

    public function _initialize(){
        parent::_initialize();
        $this->model = model('Workload');
    }
    /**
     * 工作量列表
     *
     * @return \think\Response
     */
    public function lst(Request $request)
    {
        //
        $where = [];
        if(!empty($request->get('search_title'))){
            $title = $request->get('search_title');
            $where['title'] = ['like',"%$title%"];
        }
        if(!empty($request->get('search_type'))){
            $where['type'] = $request->get('search_type');
        }
        if(!empty($request->get('search_media'))){
            $where['media'] = $request->get('search_media');
        }
        if(!empty($request->get('search_source'))){
            $where['source'] = $request->get('search_source');
        }

        if(!empty($request->get('search_field'))){
            $where['field'] = $request->get('search_field');
        }
        if(!empty($request->get('start_time'))){
            $start_time = $request->get('start_time');
        }
        if(!empty($request->get('end_time'))){
            $end_time = $request->get('end_time');
        }

        if(!empty($start_time) && empty($end_time)){
            $where['publish_time'] = ['gt',$start_time];
        }
        if(empty($start_time) && !empty($end_time)){
            $where['publish_time'] = ['lt',$end_time];
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['publish_time'] = [['gt',$start_time],['lt',$end_time],'and'];
        }
        //如果是编辑登陆 只显示自己的
        if( Session::get('role_id','o2o') == config('editor_role_id')){
            $where['editor'] = Session::get('username','o2o');
            //视图中不显示按编辑搜索
            $status = 0;
        }else{
            if($request->get('search_editor')){
                $where['editor'] = $request->get('search_editor');
            }
            //视图中显示按编辑搜索
            $status = 1;
        }
        $where['status'] = 0;
        //编辑列表
        $editors = model('Role')->getRoleMember(config('editor_role_id'));
        //工作量列表
        $res = $this->model->getWorkLoadList($where);
        $num = $res->total();
        foreach ($res as $k=>$v){
            $res[$k]['username'] = \app\admin\model\Admin::where('id',$v['uid'])->value('username');
            $res[$k]['publish_time'] = date('Y-m-d',strtotime($v['publish_time']));
        }
        $fields = get_field();
        return $this->fetch('workload/list',['data'=>$res,'status'=>$status,'editors'=>$editors,'num'=>$num,'fields'=>$fields]);
    }

    /**
     * 编辑修改.
     *
     * @return \think\Response
     */
    public function cu(Request $request)
    {
        if($request->isPost()){
            $data = $request->post();
            $validate = validate('Workload');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $data['uid'] = Session::get('admin_id');
            $res = $this->model->cu($data);
            if($res){
                return ['code'=>10000,'msg'=>'操作成功!'];
            }else{
                return ['code'=>10020,'msg'=>'操作失败!'];
            }
        }
        $id = $request->param('id');
//        $info = $this->model->getWorkLoadById($id);
        //
        $info = \app\admin\model\Workload::get($id);
        //所有会议
        $model = model('category');
        $meetings = $model->getCategoryList($info['media'],3);
        $clients = $model->getCategoryList($info['media'],1);
        $products = $model->getCategoryList($info['media'],2);
        $fields = get_field();
        //编辑列表
        $model = model('admin');
        $editors = $model->getEditorList();
        return $this->fetch('workload/cu',['data'=>$info,'meetings'=>$meetings,'editors'=>$editors,'clients'=>$clients,'products'=>$products,'fields'=>$fields[$info['media']-1]]);
    }

    /**
     * 工作量数量列表
     */

    public function numList(Request $request){


        $where = [];
        if(!empty($request->get('search_title'))){
            $title = $request->get('search_title');
            $where['title'] = ['like',"%$title%"];
        }
        if(!empty($request->get('start_time'))){
            $start_time = $request->get('start_time');
        }
        if(!empty($request->get('end_time'))){
            $end_time = $request->get('end_time');
        }

        if(!empty($start_time) && empty($end_time)){
            $where['publish_time'] = ['gt',$start_time];
        }
        if(empty($start_time) && !empty($end_time)){
            $where['publish_time'] = ['lt',$end_time];
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['publish_time'] = [['gt',$start_time],['lt',$end_time],'and'];
        }


        $admin_id = Session::get('admin_id','o2o');
        $role_id = Session::get('role_id','o2o');
        //网编登陆 只看自己的
        $where['status'] = 0;
        if($role_id == Config::get('web_editor_role_id')){
            $where['web_editor'] = $admin_id;
            $res = $this->model->getNumList($where);
        }else{
//            $res = \app\admin\model\Workload::where('status','0')->paginate(10);
            $res = $this->model->getNumList($where);
        }
        foreach ($res as $k=>$v){
            $res[$k]['publish_time'] = date('Y-m-d',strtotime($v['publish_time']));
            $res[$k]['username'] = \app\admin\model\Admin::where('id',$v['uid'])->value('username');
        }
        $num = $res->total();
        return $this->fetch('workload/numlist',['data'=>$res,'num'=>$num]);
    }

    /**
     * 工作量数量编辑
     * @param Request $request
     * @return
     */
    public function numEdit(Request $request){
        if($request->isPost()){
            $data = $request->post();
            $data['web_editor'] = Session::get('username');
            $res = $this->model->cu($data);
            if($res){
                return ['code'=>10000,'msg'=>'操作成功!'];
            }else{
                return ['code'=>10020,'msg'=>'操作失败!'];
            }
        }
        $id = $request->param('id');
//        $info = $this->model->getWorkLoadById($id);
        $info = \app\admin\model\Workload::get($id);
        //编辑列表
        $model = model('admin');
        $editors = $model->getEditorList();
        return $this->fetch('workload/numedit',['data'=>$info,'editors'=>$editors]);
    }

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

   public function getSearchList(Request $request){
        //type:client
        $parent = $request->post('parent');
        $str = $request->post('name');
        $type = $request->post('type');
        if(empty($str)){
            return '';
        }
        $where = '';
       if($type =='client'){
            $where = ['name'=>$parent.'-客户'];
       }elseif ($type =='product'){
           $where = ['name'=>$parent];
       }elseif ($type == 'web_editor'){
           $where = ['name'=>$parent.'-网编'];
       }
       //获取选项p_id
       $pid = Db::name('category')->where($where)->value('id');
       //获取所有选项
       $res = Db::name('category')->where('p_id',$pid)->where('name','like',"%$str%")->select();
        if ($res){
            return ['code'=>0,'data'=>$res];
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
