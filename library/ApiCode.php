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

    public static $codeMap = array(
        '000000' => '操作成功！',

        '100001' => '缺少接口！',
        '100002' => '无相应接口！',
        '100003' => '非法请求类型！',
        '100004' => '缺少参数！',
        '100005' => '参数格式错误！',
        '100006' => '缺少相应参数！',
        '100007' => '指定参数为空！',

        '200001' => '无相应账号！',
        '200002' => '密码错误！',

        '999999' => '操作失败！'
    );
}