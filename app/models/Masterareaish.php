<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterareaish".
 *
 * @property int $id
 * @property string $area
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $updatedby
 */
class Masterareaish extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterareaish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'createtime', 'updatetime', 'createdby', 'updatedby'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['createdby', 'updatedby'], 'integer'],
            [['area'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Area',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
        ];
    }
}
