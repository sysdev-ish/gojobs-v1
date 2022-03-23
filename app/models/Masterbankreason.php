<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterbankreason".
 *
 * @property int $id
 * @property string $reason
 */
class Masterbankreason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterbankreason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['reason'], 'string', 'max' => 445],
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
        ];
    }
}
