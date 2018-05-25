<?php
/**
 * 学生课程关联模型
 *
 * StudentCourse
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-25
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\db\ActiveRecord;

class StudentCourse extends ActiveRecord{

    public static function tableName(){
        return '{{%student_course}}';
    }
}