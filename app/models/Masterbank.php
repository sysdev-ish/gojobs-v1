<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterbank".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $bank
 */
class Masterbank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterbank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime', 'bank'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['bank'], 'string', 'max' => 255],
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
            'bank' => 'Bank',
        ];
    }
}
