<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterstatushiring".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $statusname
 */
class Masterstatushiring extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterstatushiring';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['statusname'], 'string', 'max' => 45],
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
            'statusname' => 'Statusname',
        ];
    }
}
