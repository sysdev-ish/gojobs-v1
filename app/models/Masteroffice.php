<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masteroffice".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $officename
 * @property string $address
 * @property double $long
 * @property double $lat
 */
class Masteroffice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masteroffice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['officename','address','long', 'lat'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['long', 'lat'], 'number'],
            [['officename'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'officename' => 'Officename',
            'address' => 'Address',
            'long' => 'Long',
            'lat' => 'Lat',
        ];
    }
}
