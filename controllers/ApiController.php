<?php
/**
 * 对外接口管理
 *
 * ApiController
 *
 * @copyright chinamcloud
 * @author liuyunzhi
 * @time 2017-12-05
 * @version v1.0
 */

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Json;
use Hprose\Http\Client;
use app\library\ClassLib;
use app\models\UserPackageItemService;
use app\models\GroupBalanceService;

class ApiController extends Controller{

    /**
     * 每次请求验证，框架级
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 接口入口
     * @param string $method
     * @return string $json
     */
    public function actionIndex() {
        $request = yii::$app->getRequest();

        $method = $request->get('method');

        if($method == ''){
            ClassLib::exit_json(10002);
        }

        if(method_exists($this, $method) == false){
            ClassLib::exit_json(10003);
        }

        call_user_func(array($this, $method));
    }

    /**
     * 登录验证
     */
    private function login() {
        ClassLib::exit_json(10000);
        // $params = ClassLib::verify_param(['account', 'password']);
        // $account = $params['account'];
        // $password = $params['password'];
        // if (!$account || !$password) {
        //     ClassLib::exit_json(10004);
        // } else {
        //     ClassLib::exit_json(10000);
        // }
    }
}