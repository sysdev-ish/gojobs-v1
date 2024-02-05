<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_recruitment_form".
 *
 * @property int $id
 * @property int $userid
 * @property string $fullname
 * @property int $count
 * @property string $date
 * @property int $classification
 *
 * @property WoRecruitmentInterview[] $woRecruitmentInterviews
 */
class WoRecruitmentForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_recruitment_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'fullname', 'count', 'date', 'classification'], 'required'],
            [['userid', 'count', 'classification'], 'integer'],
            [['date'], 'safe'],
            [['fullname'], 'string', 'max' => 155],
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
            'fullname' => 'Fullname',
            'count' => 'Count',
            'date' => 'Date',
            'classification' => 'Classification',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoRecruitmentInterviews()
    {
        return $this->hasMany(WoRecruitmentInterview::className(), ['form_id' => 'id']);
    }
}
