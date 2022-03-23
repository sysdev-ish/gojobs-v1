<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mailcounter".
 *
 * @property int $id
 * @property string $date
 * @property int $count
 */
class Mailcounter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailcounter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count','klasifikasi'], 'integer'],
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
        ];
    }
}
