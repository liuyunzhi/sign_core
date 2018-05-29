<?php
/**
 * 考勤记录模型
 *
 * Records
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-08
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Records extends ActiveRecord{

    public static function tableName(){
        return '{{%records}}';
    }

    public function getStudent()
    {
        return $this->hasOne(Students::className(), ['id' => 'student_id']);
    }

    public function getCourse()
    {
        return $this->hasOne(Courses::className(), ['id' => 'course_id']);
    }
}