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
        return 'masterjobfamily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobfamily', 'createtime', 'updatetime'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['jobfamily','icon'], 'string', 'max' => 256],
            [['status'], 'integer'],
            [['jobfamily'], 'unique', 'targetAttribute'=>['jobfamily'],'message'=>'Data sudah ada'],
            // type_id needs to exist in the column "id" in the table defined in ProductType class
            // ['id', 'exist', 'targetClass' => Mastersubjobfamily::class, 'targetAttribute' => ['id' => 'id']],
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
            'icon' => 'Icon',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'status' => 'Status',
        ];
    }
}
