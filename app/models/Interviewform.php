<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interviewform".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $interviewid
 * @property int $aspekpenilaianid
 * @property string $nilai
 * @property string $desc
 */
class Interviewform extends \yii\db\ActiveRecord
{
  public $aspekpenilaian;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interviewform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nilai'], 'required'],
            [['userid', 'interviewid', 'aspekpenilaianid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['nilai'], 'string', 'max' => 45],
            [['desc'], 'string', 'max' => 445],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'interviewid' => 'Interviewid',
            'aspekpenilaianid' => 'Aspekpenilaianid',
            'nilai' => 'Nilai',
            'desc' => 'Desc',
        ];
    }
}
