<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userabout".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $strengths
 * @property string $weakness
 * @property string $strengthsopinion
 * @property string $weaknessopinion
 * @property string $ambitionandhopefullness
 * @property string $specialskills
 * @property string $yourgoals
 * @property string $activityinsparetime
 * @property string $hobby
 * @property int $readyshift
 * @property int $readyovertime
 * @property int $readyoverstay
 * @property int $readyoutcity
 * @property string $joblikeskill
 * @property string $jobunlikeskill
 * @property string $jobfieldlike
 * @property string $jobfieldunlike
 * @property int $havepsikotest
 * @property int $expectsalary
 * @property string $readyforwork
 * @property string $useraboutcol
 *
 * @property User $user
 */
class Userabout extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userabout';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['strengths', 'weakness', 'strengthsopinion', 'weaknessopinion', 'ambitionandhopefullness', 'specialskills', 'yourgoals', 'activityinsparetime', 'hobby', 'readyshift', 'readyovertime', 'readyoverstay', 'readyoutcity', 'joblikeskill', 'havepsikotest', 'expectsalary', 'readyforwork','infoofrecruitmentid'], 'required' , 'on'=>['create','update','updatepass']],
            [['passbook'],'required','on'=>['updatepass']],
            [['userid', 'readyshift', 'readyovertime', 'readyoverstay', 'readyoutcity', 'havepsikotest', 'expectsalary','bankid','infoofrecruitmentid','bankaccountnumber'], 'integer'],
            [['createtime', 'updatetime','whenpsikotest'], 'safe'],
            [['strengths', 'weakness', 'strengthsopinion', 'weaknessopinion', 'ambitionandhopefullness', 'specialskills', 'activityinsparetime', 'hobby'], 'string', 'max' => 500],
            [['yourgoals'], 'string', 'max' => 45],
            [['passbook'], 'string', 'max' => 145],
            [['purposepsikotest'], 'string', 'max' => 145],
            [['joblikeskill', 'jobunlikeskill', 'jobfieldlike', 'jobfieldunlike', 'readyforwork'], 'string', 'max' => 255],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
            [['whenpsikotest', 'purposepsikotest'], 'required', 'when' => function ($model) {
                  return $model->havepsikotest == 1;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-havepsikotest').val() == '1';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 8, 'max'=> 10, 'when' => function ($model) {
                  return $model->bankid == 1;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '1';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 10, 'max'=> 10, 'when' => function ($model) {
                  return $model->bankid == 10;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '10';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 13, 'max'=> 13, 'when' => function ($model) {
                  return $model->bankid == 4;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '4';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 15, 'max'=> 15, 'when' => function ($model) {
                  return $model->bankid == 2;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '2';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 12, 'max'=> 13, 'when' => function ($model) {
                  return $model->bankid == 11;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '11';
                }
            "), 'on'=>['create','update','updatepass']],
            [['bankaccountnumber'], 'string', 'min'=> 16, 'max'=> 16, 'when' => function ($model) {
                  return $model->bankid == 3;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#userabout-bankid').val() == '3';
                }
            "), 'on'=>['create','update','updatepass']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        // return [
            // 'id' => 'ID',
            // 'userid' => 'Userid',
            // 'createtime' => 'Createtime',
            // 'updatetime' => 'Updatetime',
            // 'strengths' => 'Strengths',
            // 'weakness' => 'Weakness',
            // 'strengthsopinion' => 'Strengths',
            // 'weaknessopinion' => 'Weakness',
            // 'ambitionandhopefullness' => 'Ambition and hopefullness',
            // 'specialskills' => 'Your Special Skills',
            // 'yourgoals' => 'Your goals',
            // 'activityinsparetime' => 'What do you like to do in your spare time?',
            // 'hobby' => 'Hobby',
            // 'readyshift' => 'Ready for work shift?',
            // 'readyovertime' => 'Ready for work overtime?',
            // 'readyoverstay' => 'Ready for task to out of town?',
            // 'readyoutcity' => 'Ready for placed to out of town',
            // 'joblikeskill' => 'Job that you like?',
            // 'jobunlikeskill' => 'Job that you do not like?',
            // 'jobfieldlike' => 'Jobfieldlike',
            // 'jobfieldunlike' => 'Jobfieldunlike',
            // 'havepsikotest' => 'Have you ever done a psychological test?',
            // 'expectsalary' => 'Expectation Salary',
            // 'readyforwork' => 'When you ready for start work',
            // 'bankid' => 'Bank Name',
            // 'bankaccountnumber' => 'Bank Account Number',
            // 'whenpsikotest' => 'When',
            // 'purposepsikotest' => 'Purpose',
            // 'infoofrecruitmentid' => 'Info of recruitment',
            // 'passbook' => 'Passbook (Buku Tabungan)',
        // ];
		
		return [
            'id' => 'ID',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'strengths' => Yii::t('app', 'Strengths'),
            'weakness' => Yii::t('app', 'Weakness'),
            'strengthsopinion' => Yii::t('app', 'Strengths'),
            'weaknessopinion' => Yii::t('app', 'Weakness'),
            'ambitionandhopefullness' => Yii::t('app', 'Ambition and hopefullness'),
            'specialskills' => Yii::t('app', 'Your Special Skills'),
            'yourgoals' => Yii::t('app', 'Your goals'),
            'activityinsparetime' => Yii::t('app', 'What do you like to do in your spare time?'),
            'hobby' => 'Hobby',
            'readyshift' => Yii::t('app', 'Ready for work shift?'),
            'readyovertime' => Yii::t('app', 'Ready for work overtime?'),
            'readyoverstay' => Yii::t('app', 'Ready for task to out of town?'),
            'readyoutcity' => Yii::t('app', 'Ready for placed to out of town'),
            'joblikeskill' => Yii::t('app', 'Job that you like?'),
            'jobunlikeskill' => Yii::t('app', 'Job that you do not like?'),
            'jobfieldlike' => 'Jobfieldlike',
            'jobfieldunlike' => 'Jobfieldunlike',
            'havepsikotest' => Yii::t('app', 'Have you ever done a psychological test?'),
            'expectsalary' => Yii::t('app', 'Expectation Salary'),
            'readyforwork' => Yii::t('app', 'When you ready for start work'),
            'bankid' => Yii::t('app', 'Bank Name'),
            'bankaccountnumber' => Yii::t('app', 'Bank Account Number'),
            'whenpsikotest' => Yii::t('app', 'When'),
            'purposepsikotest' => Yii::t('app', 'Purpose'),
            'infoofrecruitmentid' => Yii::t('app', 'Info of recruitment'),
            'passbook' => 'Passbook (Buku Tabungan)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
    public function getBankname()
    {
        return $this->hasOne(Masterbank::className(), ['id' => 'bankid']);
    }
    public function getMasterinforec()
    {
        return $this->hasOne(Masterinfoofrecruitment::className(), ['id' => 'infoofrecruitmentid']);
    }
}
