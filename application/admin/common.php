

<?php
function status($status){
    if($status == 1){
        return "<span class='label label-success radius'>正常</span>";
    }elseif ($status == 0){
        return "<span class='label label-danger radius'>停用</span>";
    }
}

function admin_source($source){
    switch ($source){
        case 1:
            return '自行选题';break;
        case 2:
            return '采访';break;
        case 3:
            return '约稿';break;
        case 4:
            return '转载';break;
        default:
            return '';
    }
}

function admin_type($type){
    switch ($type){
        case 1:
            return '编写';break;
        case 2:
            return '校对';break;
        default:
            return '';
    }
}
function admin_field($field){
    switch ($field){
        case 1:
            return '呼吸系肿瘤';break;
        case 2:
            return '消化系肿瘤';break;
        case 3:
            return '泌尿生殖系肿瘤';break;
        case 4:
            return '血液肿瘤';break;
        case 5:
            return '妇科肿瘤';break;
        case 6:
            return '乳腺肿瘤';break;
        case 7:
            return '综合或其他';break;
        default:
            return '';
    }
}
function admin_media($media){
    switch ($media){
        case 1:
            return 'IC';break;
        case 2:
            return 'ID';break;
        case 3:
            return 'IH';break;
        case 4:
            return 'IOT';break;
        case 5:
            return 'IOF';break;
        default:
            return '';
    }
}

function category_type($type){
    switch ($type){
        case 1:
            return '厂家';break;
        case 2:
            return '产品';break;
        case 3:
            return '会议';break;
        default:
            return '';
    }
}
/**
 * @param array $list
 * @param int $parent_id
 * @param int $deep
 * @return array
 * 无限极分类
 */
function infinite($list = [],$parent_id = 0,$deep = 0){
    static $arr = [];
    foreach ($list as $v){
        if($v['p_id'] == $parent_id){
            $v['deep'] = $deep;
            $arr[] = $v;
            infinite($list,$v['id'],$deep + 1);
        }
    }
    return $arr;
}

/***
 * 学术领域
 */

function get_field(){
    return [
    //ic循环
    ['高血压','心力衰竭/心肌病','脑血管疾病','肺循环疾病','预防策略','冠心病/心肌梗死','结构性心脏病','外周血管病','基础研究','血糖/血脂代谢异常','心律失常/电生理','综合/其他领域'],
    //id糖尿病
    ['1型糖尿病','2型糖尿病','肥胖','血脂异常和心血管疾病','甲状腺疾病','骨代谢疾病','生殖内分泌疾病','下丘脑垂体肾上腺疾病','临床研究','神经病变','其他','媒体','综合'],
    //ih肝病
    ['脂肪肝','肝硬化','胆汁淤积性肝病','肝移植','丙肝','肝癌','乙肝','肝衰竭','药物性肝损伤','酒精性肝病','自身免疫性肝病','肝纤维化','肝胆汁淤积','病毒性肝炎','门脉高压','其他'],
    //iot眼科
    ['白内障','青光眼','角膜病','斜弱视小儿眼科','眼视光学','眼整形眼眶病','眼免疫学葡萄膜病','神经眼科学','视觉生理','眼科药理','眼科病理','眼科教育','眼科护理','眼科基础研究','防盲与流行病','中西医结合','多学科交叉','转化医学','基因治疗','其他','玻璃体视网膜','眼表疾病','眼外伤','角巩膜疾病'],
    //iof肿瘤
    ['呼吸系肿瘤','消化系肿瘤','泌尿生殖系肿瘤','血液肿瘤','妇科肿瘤','乳腺肿瘤','综合或其他'],
    ];
}