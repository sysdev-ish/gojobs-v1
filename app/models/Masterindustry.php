<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterindustry".
 *
 * @property int $id
 * @property string $industry_type
 * @property string $createtime
 * @property string $updatetime
 */
class Masterindustry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterindustry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['industry_type', 'createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['industry_type'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'industry_type' => 'Type Industry',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
