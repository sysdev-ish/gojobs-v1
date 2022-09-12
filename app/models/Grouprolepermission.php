<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grouprolepermission".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $grouprolepermission
 */
class Grouprolepermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grouprolepermission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grouprolepermission','createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['grouprolepermission'], 'string', 'max' => 145],
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
            'grouprolepermission' => 'Group user role name',
        ];
    }
}
