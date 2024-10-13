<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_temp_files".
 *
 * @property string $ref_id
 * @property int $workorder_id
 * @property int $type
 * @property string $file_name
 */
class JobTempFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_temp_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_id'], 'required'],
            [['workorder_id', 'type'], 'integer'],
            [['ref_id', 'file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ref_id' => 'Ref ID',
            'workorder_id' => 'Workorder ID',
            'type' => 'Type',
            'file_name' => 'File Name',
        ];
    }
}
