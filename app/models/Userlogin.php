<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $password_hash
 * @property int $status
 * @property string $verify_code
 * @property string $auth_key
 * @property string $role
 * @property int $verify_status
 *
 * @property Computerskill[] $computerskills
 * @property Englishskill[] $englishskills
 * @property Organizationactivity[] $organizationactivities
 * @property Userabout[] $userabouts
 * @property Useremergencycontact[] $useremergencycontacts
 * @property Userfamily[] $userfamilies
 * @property Userforeignlanguage[] $userforeignlanguages
 * @property Userformaleducation[] $userformaleducations
 * @property Userhealth[] $userhealths
 * @property Usernonformaleducation[] $usernonformaleducations
 * @property Userprofile[] $userprofiles
 * @property Userreference[] $userreferences
 * @property Userworkexperience[] $userworkexperiences
 */
class Userlogin extends \yii\db\ActiveRecord
{
    public $retype_password;
    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'mobile','role'], 'required'],
            [['password_hash'], 'required', 'on' => 'create'],
            [['created_at', 'updated_at','createdat','updatedat'], 'safe'],
            [['status', 'verify_status','requestforchangepassword','grouprolepermissionid'], 'integer'],
            [['username', 'email', 'mobile', 'verify_code'], 'string', 'max' => 75],
            [['name'], 'string', 'max' => 225],
            [['password_hash'], 'string', 'min' => 6],
            [['auth_key'], 'string', 'max' => 32],
            [['role','othersid'], 'string', 'max' => 45],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.', 'on' => 'create'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.', 'on' => 'create'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retype_password', 'required'],
            ['retype_password', 'string', 'min' => 6],
            ['retype_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'password_hash' => 'Password',
            'status' => 'Status',
            'verify_code' => 'Verify Code',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'verify_status' => 'Verify Status',
            'grouprolepermissionid' => 'Group Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComputerskills()
    {
        return $this->hasMany(Computerskill::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnglishskills()
    {
        return $this->hasMany(Englishskill::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationactivities()
    {
        return $this->hasMany(Organizationactivity::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserabouts()
    {
        return $this->hasMany(Userabout::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUseremergencycontacts()
    {
        return $this->hasMany(Useremergencycontact::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserfamilies()
    {
        return $this->hasMany(Userfamily::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserforeignlanguages()
    {
        return $this->hasMany(Userforeignlanguage::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserformaleducations()
    {
        return $this->hasMany(Userformaleducation::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserhealths()
    {
        return $this->hasMany(Userhealth::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsernonformaleducations()
    {
        return $this->hasMany(Usernonformaleducation::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserprofiles()
    {
        return $this->hasMany(Userprofile::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserreferences()
    {
        return $this->hasMany(Userreference::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserworkexperiences()
    {
        return $this->hasMany(Userworkexperience::className(), ['userid' => 'id']);
    }
    public function getRolename()
    {
        return $this->hasOne(Userrole::className(), ['id' => 'role']);
    }
    public function getGrouprolename()
    {
        return $this->hasOne(Grouprolepermission::className(), ['id' => 'grouprolepermissionid']);
    }
}
