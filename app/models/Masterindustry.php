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
            [['industry_type', 'status', 'createtime', 'updatetime'], 'required'],
            [['status'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['industry_type'], 'string', 'max' => 256],
            [['industry_type'], 'unique', 'targetAttribute' => ['industry_type'], 'message' => 'Data sudah ada'],
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
            'status' => 'Status',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
