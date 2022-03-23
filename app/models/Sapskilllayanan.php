<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sapskilllayanan".
 *
 * @property string $value1
 * @property string $value2
 */
class Sapskilllayanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sapskilllayanan';
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
            [['value1'], 'required'],
            [['value1', 'value2'], 'string', 'max' => 145],
            [['value1'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'value1' => 'Value1',
            'value2' => 'Value2',
        ];
    }
}
