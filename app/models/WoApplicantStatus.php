<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_applicant_status".
 *
 * @property int $id
 * @property string $status_name
 * @property string $description
 * @property int $is_active
 */
class WoApplicantStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_applicant_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['is_active'], 'integer'],
            [['status_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'description' => 'Description',
            'is_active' => 'Is Active',
        ];
    }
}
