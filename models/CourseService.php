<?php
/**
 * 课程服务管理
 *
 * CourseService
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-23
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\data\Pagination;

class CourseService{

    /**
     * 按条件查找课程
     * [
     *  'id' => ,
     *  'name' => ,
     *  'position' => ,
     *  'created_date' => ['start' => ,'end' => ],
     *  'update_date' => ['start' => ,'end' => ]
     * ]
     * 按需添加
     * 
     * @param array $search_array 查找条件
     * @return object Query对象
     */
    public static function searchCourses($search_array) {

        if (empty($search_array)) {
            return array();
        } else {
            $courses = Courses::find();
            foreach ($search_array as $key => $value) {
                switch ($key) {
                    case 'id':
                        $courses->andWhere(['id'=>$value]);
                        break;
                    case 'name':
                        $courses->andWhere(['like','name',$value]);
                        break;
                    case 'position':
                        $courses->andWhere(['like','position',$value]);
                        break;
                    case 'created_date':
                        $courses->andWhere(['between','created_at',$value['start'],$value['end']]);
                        break;
                    case 'update_date':
                        $courses->andWhere(['between','update_at',$value['start'],$value['end']]);
                        break;
                }
            }
        }

        return $courses;
    }

    /**
     * 获取课程列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @param array $searching 检索条件
     * @return array 课程列表
     */
    public static function getCourseList( $page, $page_size, $searching ) {

        if (empty($searching)) {
            $courses = Courses::find();
        } else {
            $courses = self::searchCourses($searching);
        }

		$courses_count = $courses->count();
		$Pagination = new Pagination(['totalCount' => $courses_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $courses_array = $courses->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id asc')->all();

        $list = array();
        foreach ($courses_array as $course) {
            $list[] = [
            	'id' => $course->id,
            	'name' => $course->name,
                'position' => $course->position,
            	'longitude' => $course->longitude,
            	'latitude' => $course->latitude,
            	'time' => $course->time,
            	'teacher' => $course->teacher,
            	'created_date' => $course->created_date,
            	'update_date' => $course->update_date
            ];
        }

		$result = [
            'total' => $courses_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }

    /**
     * 添加course
     * 
     * @param string $name 课程名
     * @param string $position 教室
     * @param string $longitude 经度
     * @param string $latitude 纬度
     * @param string $time 上课时间
     * @param string $teacher 授课教师
     */
    public static function addCourse($name, $position, $longitude, $latitude, $time, $teacher) {
        $course = new Courses();
        $course->name = $name;
        $course->position = $position;
        $course->longitude = $longitude;
        $course->latitude = $latitude;
        $course->time = $time;
        $course->teacher = $teacher;
        $course->created_date = date('Y-m-d H:i:s');
        $course->update_date = date('Y-m-d H:i:s');
        return $course->insert();
    }

    /**
     * 更新course
     * 
     * @param int $id 课程ID
     * @param string $name 课程名
     * @param string $position 教室
     * @param string $longitude 经度
     * @param string $latitude 纬度
     * @param string $time 上课时间
     * @param string $teacher 授课教师
     */
    public static function updateCourse($id, $name, $position, $longitude, $latitude, $time, $teacher) {
        $course = Courses::findOne($id);
        $course->name = $name;
        $course->position = $position;
        $course->longitude = $longitude;
        $course->latitude = $latitude;
        $course->time = $time;
        $course->teacher = $teacher;
        $course->update_date = date('Y-m-d H:i:s');
        return $course->update();
    }

    /**
     * 删除course
     * 
     * @param int $id 课程ID
     */
    public static function deleteCourse($id) {
        $course = Courses::findOne($id);
        return $course->delete();
    }
}