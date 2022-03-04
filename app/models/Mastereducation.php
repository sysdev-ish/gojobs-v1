<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastereducation".
 *
 * @property int $idmastereducation
 * @property string $createtime
 * @property string $updatetime
 * @property string $education
 *
 * @property Userfamily[] $userfamilies
 */
class Mastereducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastereducation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'safe'],
            [['education'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmastereducation' => 'Idmastereducation',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'education' => 'Education',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserfamilies()
    {
        return $this->hasMany(Userfamily::className(), ['lasteducation' => 'idmastereducation']);
    }
}
