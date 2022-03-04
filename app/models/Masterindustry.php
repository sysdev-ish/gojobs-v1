<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterindustry".
 *
 * @property int $id
 * @property string $type_industry
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
            [['type_industry', 'createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['type_industry'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_industry' => 'Type Industry',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
