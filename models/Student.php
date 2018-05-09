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

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current student
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

}