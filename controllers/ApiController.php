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
use app\library\ClassLib;
use app\models\StudentService;
use app\models\CourseService;

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
            ClassLib::exit_json('100001');
        }

        if(method_exists($this, $method) == false){
            ClassLib::exit_json('100002');
        }

        call_user_func(array($this, $method));
    }

    /**
     * 登录验证
     */
    private function login() {
        $params = ClassLib::verify_post_params(['account', 'password']);
        $account = $params['account'];
        $password = $params['password'];
        $student = StudentService::getStudent($account);
        if (empty($student)) {
            ClassLib::exit_json('200001');
        }
        if (StudentService::validate($student, $password)) {
            $studentInfo = [
                'id' => $student->id,
                'student_id' => $student->student_id,
                'person_id' => $student->person_id,
                'name' => $student->name,
                'gender' => $student->gender ? '女' : '男',
                'college' => $student->college,
                'faculty' => $student->faculty,
                'faculty' => $student->faculty,
                'phone' => $student->phone,
            ];
            ClassLib::exit_json('000000', $studentInfo);
        } else {
            ClassLib::exit_json('200002');
        }
    }

    private function getCurrentCourse(){
        $params = ClassLib::verify_post_params(['id']);
        $id = $params['id'];
        $course = StudentService::getCourseById($id);
        if ($course) {
            $courseInfo = [
                'id' => $course->id,
                'name' => $course->name,
                'position' => $course->position,
                'time' => $course->time,
                'longitude' => $course->longitude,
                'latitude' => $course->latitude,
                'teacher' => $course->teacher
            ];
            ClassLib::exit_json('000000', $courseInfo);
        } else {
            ClassLib::exit_json('200003');
        }
    }

    private function modifyPasword() {
        $params = ClassLib::verify_post_params(['account','old','new']);
        $account = $params['account'];
        $old = $params['old'];
        $new = $params['new'];
        $student = StudentService::getStudent($account);
        if (StudentService::validate($student, $old)) {
            if (StudentService::modifyPassword($student, $new)) {
                ClassLib::exit_json('000000');
            } else {
                ClassLib::exit_json('999999');
            }
        } else {
            ClassLib::exit_json('200004');
        }
    }

}