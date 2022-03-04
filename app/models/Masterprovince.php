<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterprovince".
 *
 * @property int $provinsiid
 * @property string $provinsi
 */
class Masterprovince extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterprovince';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provinsi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'provinsiid' => 'Provinsiid',
            'provinsi' => 'Provinsi',
        ];
    }
}
