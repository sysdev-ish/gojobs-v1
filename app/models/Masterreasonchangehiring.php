<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterreasonchangehiring".
 *
 * @property int $id
 * @property string $reason
 * @property int $status
 */
class Masterreasonchangehiring extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterreasonchangehiring';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'integer'],
            [['reason'], 'string', 'max' => 145],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Reason',
            'status' => 'Status',
        ];
    }
}
