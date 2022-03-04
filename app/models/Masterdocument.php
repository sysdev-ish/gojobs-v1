<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterdocument".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $documentname
 */
class Masterdocument extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterdocument';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createtime', 'updatetime', 'documentname'], 'required'],
            [['userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['documentname'], 'string', 'max' => 145],
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
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'documentname' => 'Documentname',
        ];
    }
}
