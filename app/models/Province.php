<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $id
 * @property string $province_name
 * @property string $name_province
 * @property string $layanan
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
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
            [['province_name', 'name_province'], 'required'],
            [['province_name'], 'string', 'max' => 255],
            [['name_province'], 'string', 'max' => 250],
            [['layanan'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_name' => 'Province Name',
            'name_province' => 'Name Province',
            'layanan' => 'Layanan',
        ];
    }
}
