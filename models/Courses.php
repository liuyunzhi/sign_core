<?php
/**
 * 课程模型
 *
 * Courses
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-23
 * @version v1.0
 */
namespace app\models;

use yii;
use yii\db\ActiveRecord;

class Courses extends ActiveRecord{

    public static function tableName(){
        return '{{%courses}}';
    }

}