<?php
/**
 * 学生服务管理
 *
 * StudentService
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-08
 * @version v1.0
 */
namespace app\models;

use yii;

class StudentService{

    /**
     * 根据student_id获取student对象
     * 
     * @param int $student_id 学号
     * @return Object
     */
    public static function getStudent($student_id) {
        return Student::findOne(['student_id' => $student_id]);
    }

    /**
     * 验证密码
     * 
     * @param Object $student student对象
     * @param string $password 密码
     * @return boolean
     */
    public static function validate($student, $password) {
        return $student->validatePassword($password);
    }
  
    /**
     * 注册student
     * 
     * @param int $student_id 学号
     * @param string $password 密码
     * @param string $person_id 身份证号
     * @param string $name 姓名
     * @param int $gender 性别（0-男，1-女）
     * @param string $college 学院
     * @param string $faculty 系
     * @param string $phone 电话
     */
    public static function registerStudent($student_id, $password, $person_id, $name, $gender, $college, $faculty, $phone) {
        $student = new Student();
        $student->student_id = $student_id;
        $student->person_id = $person_id;
        $student->setPassword($password);
        $student->name = $name;
        $student->gender = $gender;
        $student->college = $college;
        $student->faculty = $faculty;
        $student->phone = $phone;
        return $student->insert();
    }
}