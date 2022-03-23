<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_function_category".
 *
 * @property int $id
 * @property string $job_function_category_name
 * @property string $name_job_function_category
 */
class Jobfunctioncategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_function_category';
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
            [['job_function_category_name', 'name_job_function_category'], 'required'],
            [['job_function_category_name'], 'string', 'max' => 255],
            [['name_job_function_category'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_function_category_name' => 'Job Function Category Name',
            'name_job_function_category' => 'Job Function Category',
        ];
    }
}
