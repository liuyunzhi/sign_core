<?php
/**
 * 接口返回错误码
 *
 * ApiCode
 * @copyright chinamcloud
 * @author liuranggang
 * @time 2017-06-15
 * @version v2.1
 */
namespace app\library;

use yii;

class ApiCode{

    public static $code = array(
        10000 => '操作成功！',
        10001 => '非法请求类型！',
        10002 => '缺少方法名！',
        10003 => '没有对应的接口！',
        10004 => '缺少相关参数！',
        10005 => '参数格式错误！',
        10006 => '',
        99999 => '操作失败！'
    );
}