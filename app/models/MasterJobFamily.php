<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Masterjobfamily".
 *
 * @property int $id
 * @property string $jobfamily
 * @property string $createtime
 * @property string $updatetime
 */
class Masterjobfamily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Masterjobfamily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobfamily', 'createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['jobfamily'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jobfamily' => 'Job Family',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
