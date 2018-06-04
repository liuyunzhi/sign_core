<?php
/**
 * 考勤记录服务管理
 *
 * RecordService
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-08
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\data\Pagination;

class RecordService{

     /**
     * 按条件查找考勤记录
     * [
     *  'id' => ,
     *  'student_id' => ,
     *  'course_id' => ,
     *  'created_date' => ['start' => ,'end' => ],
     *  'update_date' => ['start' => ,'end' => ]
     * ]
     * 按需添加
     * 
     * @param array $search_array 查找条件
     * @return object Query对象
     */
    public static function searchRecords($search_array) {

        if (empty($search_array)) {
            return array();
        } else {
            $records = Records::find();
            foreach ($search_array as $key => $value) {
                switch ($key) {
                    case 'id':
                        $records->andWhere(['id'=>$value]);
                        break;
                    case 'student_id':
                        $records->andWhere(['student_id'=>$value]);
                        break;
                    case 'course_id':
                        $records->andWhere(['course_id'=>$value]);
                        break;
                    case 'result':
                        $records->andWhere(['result'=>$value]);
                        break;
                    case 'created_date':
                        $records->andWhere(['between','created_at',$value['start'],$value['end']]);
                        break;
                    case 'update_date':
                        $records->andWhere(['between','update_at',$value['start'],$value['end']]);
                        break;
                }
            }
        }

        return $records;
    }

    /**
     * 新增考勤记录
     * 
     * @param string $student_id 学号
     * @param string $course_id 课程号
     * @param string $result 考勤结果（0-到勤，1-迟到，2-缺勤，3-早退，4-正常，5-异常）
     * @param string $longitude 经度
     * @param string $latitude 纬度
     * @param string $time 时间
     */
    public static function addRecord($student_id, $course_id, $result, $longitude, $latitude, $time) {
        $record = new Records();
        $record->student_id = $student_id;
        $record->course_id = $course_id;
        $record->result = $result;
        $record->longitude = $longitude;
        $record->latitude = $latitude;
        $record->time = $time;
        $record->created_date = date('Y-m-d H:i:s');
        $record->update_date = date('Y-m-d H:i:s');
        return $record->insert();
    }

    /**
     * 获取考勤记录列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @param array $searching 检索条件
     * @return array 考勤记录列表
     */
    public static function getRecordList( $page, $page_size, $searching ) {

        if (empty($searching)) {
            $records = Records::find();
        } else {
            $records = self::searchRecords($searching);
        }

		$records_count = $records->count();
		$Pagination = new Pagination(['totalCount' => $records_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $records_array = $records->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id desc')->all();

        $list = array();
        foreach ($records_array as $record) {
            $list[] = [
            	'id' => $record->id,
                'student' => $record->student->name,
                'course' => $record->course->name,
            	'result' => $record->result,
            	'longitude' => $record->longitude,
            	'latitude' => $record->latitude,
            	'time' => $record->time,
            	'created_date' => $record->created_date,
            	'update_date' => $record->update_date
            ];
        }

		$result = [
            'total' => $records_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }
    
    /**
     * 更新考勤记录信息
     * 
     * @param int $id ID
     * @param int 更新行数
     */
    public static function updateRecord($id, $result) {
        $student = Records::findOne($id);
        $student->result = $result;
        $student->update_date = date('Y-d-m H:i:s');
        return $student->update();
    }

    /**
     * 根据学生ID获取考勤记录列表
     * 
     * @param int $id ID
     * @return array 考勤记录列表
     */
    public static function getRecordListByStudentId( $student_id, $page, $page_size ) {

        $records = self::searchRecords(['student_id' => $student_id]);

		$records_count = $records->count();
		$Pagination = new Pagination(['totalCount' => $records_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $records_array = $records->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id desc')->all();

        $list = array();
        foreach ($records_array as $record) {
            $list[] = [
            	'id' => $record->id,
                'course' => $record->course->name,
            	'status' => $record->status,
            	'result' => $record->result,
            	'longitude' => $record->longitude,
            	'latitude' => $record->latitude,
            	'date' => $record->date,
            	'time' => $record->time,
            	'created_date' => $record->created_date,
            	'update_date' => $record->update_date
            ];
        }

		$result = [
            'total' => $records_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }

    /**
     * 根据课程ID获取考勤记录列表
     * 
     * @param int $id ID
     * @return array 考勤记录列表
     */
    public static function getRecordListByCourseId( $course_id, $page, $page_size ) {

        $records = self::searchRecords(['course_id' => $course_id]);

		$records_count = $records->count();
		$Pagination = new Pagination(['totalCount' => $records_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $records_array = $records->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id desc')->all();

        $list = array();
        foreach ($records_array as $record) {
            $list[] = [
            	'id' => $record->id,
                'student' => $record->student->name,
            	'result' => $record->result,
            	'longitude' => $record->longitude,
            	'latitude' => $record->latitude,
            	'time' => $record->time,
            	'created_date' => $record->created_date,
            	'update_date' => $record->update_date
            ];
        }

		$result = [
            'total' => $records_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }

    /**
     * 获取出勤率
     */
    public static function getAttendanceRate() {

        $regular_records = Records::find()->select(['course_id', "count(course_id) as total"])->where(['result'=>[0,4]])->groupBy('course_id')->indexBy('course_id')->asArray()->all();
        $all_records = Records::find()->select('course_id, count(course_id) as total')->groupBy('course_id')->indexBy('course_id')->asArray()->all();
        $rates = array();

        foreach ($all_records as $key => $value) {
            if (isset($regular_records[$key])) {
                $rates[$key] = $regular_records[$key]['total'] / $value['total'];
            } else {
                $rates[$key] = 0 / $value['total'];
            }
        }
        
        return $rates;
    }

    /**
     * 根据学生ID获取考勤记录
     * 
     * @param int $id ID
     * @return array 考勤记录
     */
    public static function getRecordsByStudentId( $student_id ) {

        $records = self::searchRecords(['student_id' => $student_id]);
        $records_array = $records->orderBy('id desc')->all();

        $list = array();
        foreach ($records_array as $record) {
            $list[] = [
                'course' => $record->course->name,
            	'status' => $record->status,
            	'result' => $record->result,
            	'date' => $record->date,
            	'time' => $record->time,
            ];
        }

        return $list;
    }
}