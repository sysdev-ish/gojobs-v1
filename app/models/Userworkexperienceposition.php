<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userworkexperienceposition".
 *
 * @property int $id
 * @property int $idworkexperience
 * @property string $createtime
 * @property string $updatetime
 * @property string $position
 * @property int $salary
 * @property string $jobdesc
 *
 * @property Userworkexperience $workexperience
 */
class Userworkexperienceposition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userworkexperienceposition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'salary', 'jobdesc'], 'required'],
            [['idworkexperience', 'salary'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['position', 'jobdesc'], 'string', 'max' => 255],
            [['idworkexperience'], 'exist', 'skipOnError' => true, 'targetClass' => Userworkexperience::className(), 'targetAttribute' => ['idworkexperience' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idworkexperience' => 'Idworkexperience',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'position' => 'Position',
            'salary' => 'Salary',
            'jobdesc' => 'Jobdesc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkexperience()
    {
        return $this->hasOne(Userworkexperience::className(), ['id' => 'idworkexperience']);
    }
}
