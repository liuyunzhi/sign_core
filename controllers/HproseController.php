<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use Hprose\Yii\Server;
use app\models\CourseService;
use app\models\StudentService;

class HproseController extends Controller{

    /**
     * 每次请求验证，框架级
     * @var bool
     */
    public $enableCsrfValidation = false;

    public function actionIndex() {
        $server = new Server();
        $server->setGetEnabled(true);

        $courseService = new CourseService();
        $studentService = new StudentService();

        $server->addClassMethods($courseService);
        $server->addClassMethods($studentService);

        return $server->start();
    }
}