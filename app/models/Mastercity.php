<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastercity".
 *
 * @property int $kotaid
 * @property int $provinsiid
 * @property string $kota
 */
class Mastercity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastercity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provinsiid'], 'integer'],
            [['kota'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kotaid' => 'Kotaid',
            'provinsiid' => 'Provinsiid',
            'kota' => 'Kota',
        ];
    }
}
