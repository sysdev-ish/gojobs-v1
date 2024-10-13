<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_settings".
 *
 * @property int $id
 * @property int $workorder_id
 * @property string $is_set_photo
 * @property string $is_set_martial
 * @property string $is_set_religion
 * @property string $is_set_height
 * @property string $is_set_weight
 * @property string $is_set_document_education
 * @property string $is_set_document_experience
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class JobAdSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id', 'created_by', 'updated_by'], 'integer'],
            [['is_set_photo', 'is_set_martial', 'is_set_religion', 'is_set_height', 'is_set_weight', 'is_set_document_education', 'is_set_document_experience'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workorder_id' => 'Workorder ID',
            'is_set_photo' => 'Is Set Photo',
            'is_set_martial' => 'Is Set Martial',
            'is_set_religion' => 'Is Set Religion',
            'is_set_height' => 'Is Set Height',
            'is_set_weight' => 'Is Set Weight',
            'is_set_document_education' => 'Is Set Document Education',
            'is_set_document_experience' => 'Is Set Document Experience',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
