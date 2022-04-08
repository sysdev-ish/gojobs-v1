<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $fullname
 * @property string $nickname
 * @property string $gender
 * @property string $birthdate
 * @property string $birthplace
 * @property string $address
 * @property string $postalcode
 * @property string $phone
 * @property string $domicilestatus
 * @property string $domicilestatusdescription
 * @property string $addressktp
 * @property string $nationality
 * @property string $religion
 * @property string $maritalstatus
 * @property string $weddingdate
 * @property string $bloodtype
 * @property string $identitynumber
 * @property string $jamsosteknumber
 * @property string $npwpnumber
 * @property string $drivinglicencecarnumber
 * @property string $drivinglicencemotorcyclenumber
 */
class Userprofile extends \yii\db\ActiveRecord
{
  public $cityname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createtime', 'updatetime', 'fullname', 'gender', 'birthdate', 'birthplace', 'address', 'postalcode', 'postalcodektp','phone', 'addressktp', 'nationality','maritalstatus', 'religion', 'bloodtype','cityid','provinceid','cityidktp','provinceidktp','identitynumber','tinggibadan','beratbadan', 'lokasikerja','jenispekerjaan'
            // , 'jobfamilyid', 'subjobfamilyid'
            ], 'required'],
            [['userid','havejamsostek','havenpwp','havebpjs', 'npwpnumber','bpjsnumber','postalcode','postalcodektp','identitynumber','kknumber'], 'integer'],
            [['postalcode','postalcodektp'], 'string', 'min'=> 5, 'max'=> 5 ],
            [['identitynumber','kknumber'], 'string', 'min'=> 16, 'max'=> 16 ],
            [['npwpnumber'], 'string', 'min'=> 15, 'max'=> 15],
            [['jamsosteknumber','bpjsnumber'], 'string', 'min'=> 11, 'max'=> 11],
            [['createtime', 'updatetime', 'birthdate', 'weddingdate'], 'safe'],
            [['tinggibadan', 'beratbadan'], 'number'],
            [['gender', 'address', 'domicilestatus', 'domicilestatusdescription', 'addressktp', 'religion', 'maritalstatus', 'bloodtype'], 'string'],
            [['fullname', 'nickname', 'birthplace','nokitas','lokasikerja','jenispekerjaan'], 'string', 'max' => 255],
            [['phone', 'nationality', 'drivinglicencecarnumber', 'drivinglicencemotorcyclenumber'], 'string', 'max' => 75],

            [['photo','cvupload'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 5072000, 'tooBig' => 'Limit is 5Mb', 'extensions' => 'png, jpg, jpeg'],
            [['identitynumber'], 'unique'],
            ['bpjsnumber', 'required', 'when' => function ($model) {
                  return $model->havebpjs;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                    return $('#userprofile-havebpjs').is(':checked');
                }
            ")],


            ['jamsosteknumber', 'required', 'when' => function ($model) {
                  return $model->jamsosteknumber;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                    return $('#userprofile-havejamsostek').is(':checked');
                }
            ")],
            ['npwpnumber', 'required', 'when' => function ($model) {
                  return $model->npwpnumber;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                    return $('#userprofile-havenpwp').is(':checked');
                }
            ")],

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
            // 'fullname' => 'Full name',
            // 'nickname' => 'Nick name',
            // 'gender' => 'Gender',
            // 'birthdate' => 'Birth date',
            // 'birthplace' => 'Birth place',
            // 'address' => 'Domicile Address',
            // 'postalcode' => 'Postalcode',
            // 'postalcodektp' => 'Postalcode',
            // 'phone' => 'Phone',
            // 'domicilestatus' => 'Domicilestatus',
            // 'domicilestatusdescription' => 'Domicile status description',
            // 'addressktp' => 'Address By ID',
            // 'nationality' => 'Nationality',
            // 'religion' => 'Religion',
            // 'maritalstatus' => 'Marital status',
            // 'weddingdate' => 'Wedding date',
            // 'bloodtype' => 'Blood type',
            // 'identitynumber' => 'Identity number',
            // 'jamsosteknumber' => 'Jamsostek number',
            // 'havejamsostek' => 'Yes',
            // 'bpjsnumber' => 'BPJS number',
            // 'havebpjs' => 'Yes',
            // 'npwpnumber' => 'NPWP number',
            // 'havenpwp' => 'Yes',
            // 'drivinglicencecarnumber' => 'Driving licence car number',
            // 'drivinglicencemotorcyclenumber' => 'Driving licence motorcycle number',
            // 'cityid' => 'City',
            // 'provinceid' => 'Province',
            // 'cityidktp' => 'City',
            // 'provinceidktp' => 'Province',
            // 'photo' => 'Photo',
            // 'cityname' => 'City',
            // 'kknumber' => 'Family Card (Kartu Keluarga) Number',
            // 'tinggibadan' => 'Height',
            // 'beratbadan' => 'Weight',
            // 'nokitas' => 'KITAS Number',
            // 'lokasikerja' => 'Work Location',
            // 'cvupload' => 'Curriculum Vitae',
            // 'jenispekerjaan' => 'Working type',
        // ];
		
		return [
            'id' => 'ID',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'fullname' => Yii::t('app', 'Full name'),
            'nickname' => Yii::t('app', 'Nick name'),
            'gender' => Yii::t('app', 'Gender'),
            'birthdate' => Yii::t('app', 'Birth date'),
            'birthplace' => Yii::t('app', 'Birth place'),
            'address' => Yii::t('app', 'Domicile Address'),
            'postalcode' => Yii::t('app', 'Postalcode'),
            'postalcodektp' => Yii::t('app', 'Postalcode'),
            'phone' => Yii::t('app', 'Phone'),
            'domicilestatus' => Yii::t('app', 'Domicilestatus'),
            'domicilestatusdescription' => 'Domicile status description',
            'addressktp' => Yii::t('app', 'Address By ID'),
            'nationality' => Yii::t('app', 'Nationality'),
            'religion' => Yii::t('app', 'Religion'),
            'maritalstatus' => Yii::t('app', 'Marital status'),
            'weddingdate' => Yii::t('app', 'Wedding date'),
            'bloodtype' => Yii::t('app', 'Blood type'),
            'identitynumber' => Yii::t('app', 'Identity number'),
            'jamsosteknumber' => Yii::t('app', 'Jamsostek number'),
            'havejamsostek' => 'Yes',
            'bpjsnumber' => Yii::t('app', 'BPJS number'),
            'havebpjs' => 'Yes',
            'npwpnumber' => Yii::t('app', 'NPWP number'),
            'havenpwp' => 'Yes',
            'drivinglicencecarnumber' => Yii::t('app', 'Driving licence car number'),
            'drivinglicencemotorcyclenumber' => Yii::t('app', 'Driving licence motorcycle number'),
            'cityid' => Yii::t('app', 'City'),
            'provinceid' => Yii::t('app', 'Province'),
            'cityidktp' => Yii::t('app', 'City'),
            'provinceidktp' => Yii::t('app', 'Province'),
            'photo' => 'Photo',
            'cityname' => Yii::t('app', 'City'),
            'kknumber' => 'Family Card (Kartu Keluarga) Number',
            'tinggibadan' => Yii::t('app', 'Height'),
            'beratbadan' => Yii::t('app', 'Weight'),
            'nokitas' => Yii::t('app', 'KITAS Number'),
            'lokasikerja' => Yii::t('app', 'Work Location'),
            'cvupload' => 'Curriculum Vitae',
            'jenispekerjaan' => Yii::t('app', 'Working type'),
            'lastposition' => Yii::t('app', 'Bidang Pekerjaan'),
            'jobfamily' => Yii::t('app', 'Job Family'),
        ];
    }
    public function getCity()
    {
        return $this->hasOne(Mastercity::className(), ['kotaid' => 'cityid']);
    }
    public function getProvince()
    {
        return $this->hasOne(Masterprovince::className(), ['provinsiid' => 'provinceid']);
    }
    public function getCityktp()
    {
        return $this->hasOne(Mastercity::className(), ['kotaid' => 'cityidktp']);
    }
    public function getProvincektp()
    {
        return $this->hasOne(Masterprovince::className(), ['provinsiid' => 'provinceidktp']);
    }
    public function getUabout()
    {
        return $this->hasOne(Userabout::className(), ['userid' => 'userid']);
    }
    public function getUserlogin()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'userid']);
    }
    public function getDatavaksin()
    {
        return $this->hasOne(Uservaksin::className(), ['userid' => 'userid']);
    }
    public function getMasterjobfamily()
    {
        return $this->hasOne(Masterjobfamily::className(), ['id' => 'jobfamilyid']);
    }
    public function getMastersubjobfamily()
    {
        return $this->hasOne(Mastersubjobfamily::className(), ['userid' => 'jobfamily_id']);
    }
    public function getUserworkexperience()
    {
        return $this->hasOne(Userworkexperience::className(), ['userid' => 'userid']);
    }
}
