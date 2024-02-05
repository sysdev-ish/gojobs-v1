<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_client".
 *
 * @property int $id
 * @property string $client_name
 * @property string $industry_name
 * @property int $industry_id
 * @property string $updated_time
 */
class WoClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'industry_id'], 'integer'],
            [['updated_time'], 'safe'],
            [['client_name', 'industry_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_name' => 'Client Name',
            'industry_name' => 'Industry Name',
            'industry_id' => 'Industry ID',
            'updated_time' => 'Updated Time',
        ];
    }
}
