<?php
/**
 * 学生模型
 *
 * Student
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-08
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Student extends ActiveRecord{

    public static function tableName(){
        return '{{%student}}';
    }

}