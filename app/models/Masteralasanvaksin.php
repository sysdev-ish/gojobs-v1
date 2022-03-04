<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masteralasanvaksin".
 *
 * @property int $id
 * @property string $alasan
 */
class Masteralasanvaksin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masteralasanvaksin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alasan'], 'required'],
            [['alasan'], 'string', 'max' => 145],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alasan' => 'Alasan',
        ];
    }
}
