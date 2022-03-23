<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterresignreason".
 *
 * @property int $id
 * @property string $sapid
 * @property string $reason
 */
class Masterresignreason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterresignreason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sapid'], 'required'],
            [['sapid'], 'string', 'max' => 45],
            [['reason'], 'string', 'max' => 145],
            [['sapid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sapid' => 'Sapid',
            'reason' => 'Reason',
        ];
    }
}
