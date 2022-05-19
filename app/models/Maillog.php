<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maillog".
 *
 * @property int $id
 * @property int $userid
 * @property int $count
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
            [['userid', 'count'], 'required'],
            [['userid', 'count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'count' => 'Count',
        ];
    }
}
