<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterreasoncanceljoin".
 *
 * @property int $id
 * @property string $reason
 * @property int $status
 */
class Masterreasoncanceljoin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterreasoncanceljoin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason', 'status'], 'required'],
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
