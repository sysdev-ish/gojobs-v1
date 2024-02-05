<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_status".
 *
 * @property int $id
 * @property string $status_name
 * @property int $is_active
 */
class WoStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['status_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'is_active' => 'Is Active',
        ];
    }
}
