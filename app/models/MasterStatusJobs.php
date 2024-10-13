<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_status_jobs".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $statusname
 * @property string $label
 */
class MasterStatusJobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_status_jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['statusname', 'label'], 'string', 'max' => 45],
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
            'statusname' => 'Statusname',
            'label' => 'Label',
        ];
    }
}
