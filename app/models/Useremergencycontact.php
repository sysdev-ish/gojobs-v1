<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "useremergencycontact".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $fullname
 * @property string $address
 * @property string $phone
 * @property string $relationship
 *
 * @property User $user
 */
class Useremergencycontact extends \yii\db\ActiveRecord
{
  public $model_id2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'useremergencycontact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'fullname', 'address', 'phone', 'relationship','cityid','provinceid','postalcode'], 'required'],
            [['userid','cityid','provinceid','postalcode'], 'integer'],
            [['postalcode'], 'string', 'min'=> 5,'max'=> 5 ],
            [['createtime', 'updatetime'], 'safe'],
            [['fullname', 'address'], 'string', 'max' => 255],
            [['phone', 'relationship'], 'string', 'max' => 45],
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
            'fullname' => 'Fullname',
            'address' => 'Address',
            'phone' => 'Phone',
            'relationship' => 'Relationship',
            'cityid' => 'City',
            'provinceid' => 'Province',
            'postalcode' => 'Postal Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
    public function getCity()
    {
        return $this->hasOne(Mastercity::className(), ['kotaid' => 'cityid']);
    }
    public function getProvince()
    {
        return $this->hasOne(Masterprovince::className(), ['provinsiid' => 'provinceid']);
    }
}
