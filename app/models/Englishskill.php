<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "englishskill".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $havetoefl
 * @property string $testtoefldate
 * @property string $institutions
 * @property double $toeflscore
 *
 * @property User $user
 */
class Englishskill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'englishskill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'havetoefl'], 'required'],
            [['userid', 'havetoefl'], 'integer'],
            [['createtime', 'updatetime', 'testtoefldate'], 'safe'],
            [['toeflscore'], 'number'],
            [['institutions'], 'string', 'max' => 75],
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
            'userid' => 'Userid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'havetoefl' => 'Do you take the TOEFL Exam?',
			'testtoefldate' => Yii::t('app', 'Exam Date'),
            'institutions' => Yii::t('skill', 'Institutions'),
            'toeflscore' => Yii::t('skill', 'TOEFL Score'),
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
