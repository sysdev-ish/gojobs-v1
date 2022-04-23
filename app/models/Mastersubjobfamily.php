<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastersubjobfamily".
 *
 * @property int $id
 * @property int $jobfamily_id
 * @property int $status
 * @property string $subjobfamily
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
            [['jobfamily_id', 'subjobfamily'], 'required'],
            [['jobfamily_id'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['subjobfamily'], 'string', 'max' => 256],
            [['status'], 'integer'],
            [['subjobfamily'], 'unique', 'targetAttribute' => ['subjobfamily'], 'message' => 'Data sudah ada']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jobfamily_id' => 'Job Family',
            'subjobfamily' => 'Sub Job Family',
            'status' => 'Status',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public function getMasterjobfamily()
    {
        return $this->hasOne(Masterjobfamily::className(), ['id' => 'jobfamily_id']);
    }

    public function getMappingjob()
    {
        return $this->hasOne(Mappingjob::className(), ['subjobfamilyid' => 'id']);
    }
}
