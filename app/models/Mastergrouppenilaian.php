<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastergrouppenilaian".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $group
 */
class Mastergrouppenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastergrouppenilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['group'], 'string', 'max' => 45],
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
            'group' => 'Group',
        ];
    }
}
