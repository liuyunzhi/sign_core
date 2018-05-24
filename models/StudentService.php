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
use yii\data\Pagination;

class StudentService{

    /**
     * 按条件查找学生
     * [
     *  'id' => ,
     *  'name' => ,
     *  'college' => ,
     *  'created_date' => ['start' => ,'end' => ],
     *  'update_date' => ['start' => ,'end' => ]
     * ]
     * 按需添加
     * 
     * @param array $search_array 查找条件
     * @return object Query对象
     */
    public static function searchStudents($search_array) {

        if (empty($search_array)) {
            return array();
        } else {
            $students = Students::find();
            foreach ($search_array as $key => $value) {
                switch ($key) {
                    case 'id':
                        $students->andWhere(['id'=>$value]);
                        break;
                    case 'student_id':
                        $students->andWhere(['student_id'=>$value]);
                        break;
                    case 'person_id':
                        $students->andWhere(['person_id'=>$value]);
                        break;
                    case 'name':
                        $students->andWhere(['like','name',$value]);
                        break;
                    case 'college':
                        $students->andWhere(['like','college',$value]);
                        break;
                    case 'faculty':
                        $students->andWhere(['like','faculty',$value]);
                        break;
                    case 'created_date':
                        $students->andWhere(['between','created_at',$value['start'],$value['end']]);
                        break;
                    case 'update_date':
                        $students->andWhere(['between','update_at',$value['start'],$value['end']]);
                        break;
                }
            }
        }

        return $students;
    }

    /**
     * 根据student_id获取student对象
     * 
     * @param int $student_id 学号
     * @return Object
     */
    public static function getStudent($student_id) {
        return self::searchStudents(['student_id' => $student_id]);
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
     * @param string $student_id 学号
     * @param string $password 密码
     * @param string $person_id 身份证号
     * @param string $name 姓名
     * @param int $gender 性别（0-男，1-女）
     * @param string $college 学院
     * @param string $faculty 系
     * @param string $phone 电话
     */
    public static function registerStudent($student_id, $password, $person_id, $name, $gender, $college, $faculty, $phone) {
        $student = new Students();
        $student->student_id = $student_id;
        $student->person_id = $person_id;
        $student->setPassword($password);
        $student->name = $name;
        $student->gender = $gender;
        $student->college = $college;
        $student->faculty = $faculty;
        $student->phone = $phone;
        $student->created_date = date('Y-m-d H:i:s');
        $student->update_date = date('Y-m-d H:i:s');
        return $student->insert();
    }

    /**
     * 获取学生列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @param array $searching 检索条件
     * @return array 课程列表
     */
    public static function getStudentList( $page, $page_size, $searching ) {

        if (empty($searching)) {
            $students = Students::find();
        } else {
            $students = self::searchStudents($searching);
        }

		$students_count = $students->count();
		$Pagination = new Pagination(['totalCount' => $students_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $students_array = $students->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id asc')->all();

        $list = array();
        foreach ($students_array as $student) {
            $list[] = [
            	'id' => $student->id,
                'student_id' => $student->student_id,
                'person_id' => $student->person_id,
            	'name' => $student->name,
            	'gender' => $student->gender,
            	'college' => $student->college,
            	'faculty' => $student->faculty,
            	'phone' => $student->phone,
            	'created_date' => $student->created_date,
            	'update_date' => $student->update_date
            ];
        }

		$result = [
            'total' => $students_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }

    /**
     * 根据ID获取学生信息
     * 
     * @param array $ids ID
     * @return array 学生信息
     */
    public static function getStudentByIds( $ids = null ) {

        if (empty($ids)) {
            $students = Students::find();
        } else {
            $students = self::searchStudents(['id' => $ids]);
        }

        $students_array = $students->orderBy('id asc')->asArray()->all();

        return $students_array;
    }

    /**
     * 更新student信息
     * 
     * @param int $id ID
     * @param string $student_id 学号
     * @param string $college 学院
     * @param string $faculty 系
     * @param string $phone 电话
     */
    public static function updateStudent($id, $student_id, $college, $faculty, $phone) {
        $student = Students::findOne($id);
        $student->student_id = $student_id;
        $student->college = $college;
        $student->faculty = $faculty;
        $student->phone = $phone;
        $student->update_date = date('Y-d-m H:i:s');
        return $student->update();
    }

    /**
     * 修改密码
     * 
     * @param int $id
     * @param string $password
     */
    public static function modifyPassword($id, $password) {
        $student = Students::findOne($id);
        $student->setPassword($password);
        $student->update_date = date('Y-d-m H:i:s');
        return $student->update();
    }

    /**
     * 删除student
     * 
     * @param int $id ID
     */
    public static function deleteStudent($id) {
        $course = Students::findOne($id);
        return $course->delete();
    }
}