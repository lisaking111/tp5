<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
class Common extends Controller
{
    Public function getProductList(Request $request){
        $client_id = $request->post('client_id');
        $model = model('category');
        //获取
        $res = $model->getProductList($client_id);
        return $res;
    }

    Public function getFieldList(Request $request){
        $key = $request->post('media')-1;
        $all_field = get_field();
        return $all_field[$key];
    }
}
