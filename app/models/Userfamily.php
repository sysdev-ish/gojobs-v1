<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userfamily".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $fullname
 * @property string $gender
 * @property string $birthdate
 * @property string $birthplace
 * @property int $lasteducation
 * @property string $jobtitle
 * @property string $companyname
 * @property string $description
 * @property string $relationship
 *
 * @property User $user
 * @property Mastereducation $lasteducation0
 */
class Userfamily extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userfamily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'gender', 'birthdate', 'birthplace', 'lasteducation', 'jobtitle', 'relationship'], 'required'],
            [['userid', 'lasteducation'], 'integer'],
            [['createtime', 'updatetime', 'birthdate'], 'safe'],
            [['gender', 'description', 'relationship'], 'string'],
            [['fullname', 'birthplace'], 'string', 'max' => 255],
            [['jobtitle', 'companyname'], 'string', 'max' => 75],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
            [['lasteducation'], 'exist', 'skipOnError' => true, 'targetClass' => Mastereducation::className(), 'targetAttribute' => ['lasteducation' => 'idmastereducation']],
            [['birthplace'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/','message' => 'Birth place must be Character'],
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
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'fullname' => 'Fullname',
            'gender' => 'Gender',
            'birthdate' => 'Birth Date',
            'birthplace' => 'Birth Place',
            'lasteducation' => 'Last Education',
            'jobtitle' => 'Job Title',
            'companyname' => 'Company Name',
            'description' => 'Description',
            'relationship' => 'Relationship',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLasteducation0()
    {
        return $this->hasOne(Mastereducation::className(), ['idmastereducation' => 'lasteducation']);
    }
}
