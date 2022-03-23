<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterregion".
 *
 * @property int $id
 * @property string $regionname
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $updatedby
 */
class Masterregion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterregion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regionname', 'createtime', 'updatetime', 'createdby', 'updatedby'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['createdby', 'updatedby'], 'integer'],
            [['regionname'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regionname' => 'Regionname',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
        ];
    }
}
