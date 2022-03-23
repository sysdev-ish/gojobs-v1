<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rolepermission".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property int $roleid
 * @property string $modulecode
 */
class Rolepermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rolepermission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['roleid'], 'integer'],
            [['modulecode'], 'string', 'max' => 45],
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
            'roleid' => 'Roleid',
            'modulecode' => 'Modulecode',
        ];
    }
}
