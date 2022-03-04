<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mapping_city".
 *
 * @property int $id
 * @property string $city_id
 * @property string $city_name
 * @property string $province_id
 * @property int $manar
 * @property int $manar2
 */
class MappingCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mapping_city';
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
            [['city_name'], 'required'],
            [['manar', 'manar2'], 'integer'],
            [['city_id', 'province_id'], 'string', 'max' => 11],
            [['city_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'province_id' => 'Province ID',
            'manar' => 'Manar',
            'manar2' => 'Manar2',
        ];
    }
}
