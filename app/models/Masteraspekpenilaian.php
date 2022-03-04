<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masteraspekpenilaian".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property int $grouppenilaian
 * @property int $subgrouppenilaian
 * @property string $aspekpenilaian
 */
class Masteraspekpenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masteraspekpenilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime', 'grouppenilaian', 'subgrouppenilaian', 'aspekpenilaian'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['grouppenilaian', 'subgrouppenilaian'], 'integer'],
            [['aspekpenilaian'], 'string', 'max' => 1045],
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
            'grouppenilaian' => 'Grouppenilaian',
            'subgrouppenilaian' => 'Subgrouppenilaian',
            'aspekpenilaian' => 'Aspekpenilaian',
        ];
    }
}
