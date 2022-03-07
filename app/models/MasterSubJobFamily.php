<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastersubjobfamily".
 *
 * @property int $id
 * @property int $id_job_family
 * @property string $sub_job_family
 * @property string $createtime
 * @property string $updatetime
 */
class Mastersubjobfamily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastersubjobfamily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_job_family', 'sub_job_family', 'createtime', 'updatetime'], 'required'],
            [['id_job_family'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['sub_job_family'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_job_family' => 'Id Job Family',
            'sub_job_family' => 'Sub Job Family',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
