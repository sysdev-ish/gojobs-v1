<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organizationactivity".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $organizationname
 * @property string $organizationplace
 * @property string $organizationskill
 * @property string $duration
 * @property string $position
 *
 * @property User $user
 */
class Organizationactivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organizationactivity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organizationname', 'organizationplace', 'organizationskill', 'duration', 'position'], 'required'],
            [['userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['organizationname', 'organizationplace', 'organizationskill'], 'string', 'max' => 255],
            [['duration', 'position'], 'string', 'max' => 75],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'User ID',
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'organizationname' => 'Organization Name',
            'organizationplace' => 'Organization Place',
            'organizationskill' => 'Organization Skill',
            'duration' => 'Duration',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
