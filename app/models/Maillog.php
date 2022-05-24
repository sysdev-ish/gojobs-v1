<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maillog".
 *
 * @property int $id
 * @property int $userid
 * @property int $count
 * @property string $createtime
 */
class Maillog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maillog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'klasifikasi'], 'integer'],
            [['fullname'], 'string'],
            [['date'], 'safe'],
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
            'date' => 'Date',
            'count' => 'Count',
            'fullname' => 'Fullname',
            'klasifikasi' => 'Klasifikasi',
        ];
    }
}
