<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userhealth".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $sick
 * @property string $when
 * @property string $effect
 * @property string $illnessdesc
 * @property string $accident
 * @property string $whenaccident
 * @property string $efffectaccident
 * @property string $accidentdesc
 *
 * @property User $user
 */
class Userhealth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userhealth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sick', 'accident'], 'required'],
            [['userid', 'sick'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['when', 'illnessdesc'], 'string', 'max' => 75],
            [['effect'], 'string', 'max' => 255],
            [['accident', 'whenaccident', 'efffectaccident', 'accidentdesc'], 'string', 'max' => 45],
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
			'sick' => Yii::t('app', 'Have you ever experienced seriously ill?'),
            'when' => Yii::t('app', 'If yes, When?'),
            'effect' => Yii::t('app', 'what are the consequences until now'),
            'illnessdesc' => Yii::t('app', 'Illness Description'),
            'accident' => Yii::t('app', 'have you ever had an accident?'),
            'whenaccident' => Yii::t('app', 'If yes, When?'),
            'efffectaccident' => Yii::t('app', 'what are the consequences until now'),
            'accidentdesc' => Yii::t('app', 'Accident Description'),
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
