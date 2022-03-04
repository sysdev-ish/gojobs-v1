<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterjobfamily".
 *
 * @property int $id
 * @property string $job_family
 * @property string $createtime
 * @property string $updatetime
 */
class MasterJobFamily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterjobfamily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_family', 'createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['job_family'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_family' => 'Job Family',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
