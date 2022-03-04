<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterinfoofrecruitment".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $infoofrecruitment
 */
class Masterinfoofrecruitment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterinfoofrecruitment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime', 'infoofrecruitment'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['infoofrecruitment'], 'string', 'max' => 145],
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
            'infoofrecruitment' => 'Infoofrecruitment',
        ];
    }
}
