<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_function".
 *
 * @property int $id
 * @property string $job_function_name
 * @property int $function_category
 * @property string $name_job_function
 */
class Jobfunction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_function';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbjo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_function_name', 'function_category', 'name_job_function'], 'required'],
            [['function_category'], 'integer'],
            [['job_function_name', 'name_job_function'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_function_name' => 'Job Function Name',
            'function_category' => 'Function Category',
            'name_job_function' => 'Job Function',
        ];
    }
    public function getJobcat()
    {
        return $this->hasOne(Jobfunctioncategory::className(), ['id' => 'function_category']);
    }
}
