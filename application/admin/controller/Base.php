<?php

namespace app\admin\controller;

use think\Auth;
use think\Controller;
use think\Request;
use think\Session;


class Base extends Controller
{
    public function _initialize(){
        if(Session::get('admin_id','o2o') <= 0){
            $this->redirect('login/login');
        }
        if(Session::get('role_id','o2o') == 1){
            return true;
        }
        $auth = new Auth();
        if ($auth->check(Request::instance()->module() . '/' . Request::instance()->controller() . '/' . Request::instance()->action(), Session::get('admin_id','o2o'))) {
            return true;
        } else {
            if(request()->isAjax()){
                exit(json_encode(['code'=>'100020','msg'=>'抱歉，您不具备该权限!']));
            }
//            $html=<<<html
//    <html>
//    <head>
//        <link rel="stylesheet" type="text/css" href="/static/admin/css/H-ui.admin.css" />
//        <link href="/static/admin/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
//        <script type="text/javascript" src="/static/admin/lib/jquery/1.9.1/jquery.min.js"></script>
//        <script type="text/javascript" src="/static/admin/lib/layer/2.4/layer.js"></script>
//    </head>
//    <body>
//        <script type="text/javascript">
//            $(function(){
//              setInterval("closeWindow()",1500);
//                layer.msg('抱歉，您不具备该权限！',{icon: 7,time:1500});
//              });
//            function closeWindow(){
//                var index = parent.layer.getFrameIndex(window.name);
//                parent.layer.close(index);
//           }
//        </script>
//    </body>
//</html>
//html;
//            echo $html;exit;
            $this->error('对不起 你没有该权限');
        }
    }
}
