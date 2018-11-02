<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Db;
use think\Request;
class Login extends Controller
{
    public function login(Request $request){
        if($request->isPost()){
            $username = $request->post('username');
//            var_dump($username);die;
            $res = Db::name('admin')->where('username',$username)->field('id,password,login_time')->find();
            if(empty($res)){
                return ['code'=>10020,'msg'=>'用户不存在'];
            }
            if(!password_verify($request->post('password'),$res['password'])){
                return ['code'=>10010,'msg'=>'密码错误'];
            }
            $result = model('Admin')->getAdminInfoById($res['id']);
           Session::set('admin_id',$res['id']);
           Session::set('role_id',$result['group_id']);
           Session::set('username',$result['username']);
            $data['last_login_ip'] = $_SERVER["REMOTE_ADDR"];
            $data['last_login_time'] = date('Y-m-d H:i:s');
            $data['login_time'] = $res['login_time']+1;
            $info = Db::name('admin')->where(['id'=>$res['id']])->update($data);
            return ['code'=>10000,'msg'=>'登陆成功'];
        }
        return view('login/login');
    }

    public function logout(){
        //登陆ip
        $admin_id = Session::get('admin_id','o2o');
        $res = Db::name('admin')->where('id',$admin_id)->find();
        $data['last_login_ip'] = $_SERVER["REMOTE_ADDR"];
        $data['last_login_time'] = date('Y-m-d H:i:s');
        $data['login_time'] = $res['login_time']+1;
        $info = Db::name('admin')->where(['id'=>$res['id']])->update($data);
        Session::set('admin_id','');

        $this->redirect('/admin/Login/login');
    }
}
