<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uservaksin".
 *
 * @property int $id
 * @property string $userid
 * @property int $statusvaksin
 * @property int $alasan
 * @property string $tanggalvaksin1
 * @property string $lokasivaksin1
 * @property string $sertvaksin1
 * @property string $tanggalvaksin2
 * @property string $lokasivaksin2
 * @property string $sertvaksin2
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $updateby
 */
class Uservaksin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uservaksin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statusvaksin', 'alasan', 'createdby', 'updateby','userid'], 'integer'],
            [['tanggalvaksin1', 'tanggalvaksin2', 'createtime', 'updatetime'], 'safe'],
            [['statusvaksin','createtime', 'updatetime'], 'required'],
            [['lokasivaksin1', 'lokasivaksin2'], 'string', 'max' => 45],
            // [['sertvaksin1', 'sertvaksin2'], 'string', 'max' => 145],
            [['userid'], 'unique'],
            [['sertvaksin1', 'sertvaksin2'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 5072000, 'tooBig' => 'Limit is 5Mb', 'extensions' => 'png, jpg, jpeg, pdf'],

            [['alasan'], 'required', 'when' => function ($model) {
                  return $model->statusvaksin == 1;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#statusvaksin').val() == '1';
                }
            "), 'on'=>['create','update']],
            [['tanggalvaksin1', 'lokasivaksin1','sertvaksin1'], 'required', 'when' => function ($model) {
                  return $model->statusvaksin == 2;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#statusvaksin').val() == '2';
                }
            "), 'on'=>['create']],
            [['tanggalvaksin1', 'lokasivaksin1','sertvaksin1','tanggalvaksin2', 'lokasivaksin2','sertvaksin2'], 'required', 'when' => function ($model) {
                  return $model->statusvaksin == 3;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#statusvaksin').val() == '3';
                }
            "), 'on'=>['create']],
            [['tanggalvaksin1', 'lokasivaksin1'], 'required', 'when' => function ($model) {
                  return $model->statusvaksin == 2;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#statusvaksin').val() == '2';
                }
            "), 'on'=>['update']],
            [['tanggalvaksin1', 'lokasivaksin1','tanggalvaksin2', 'lokasivaksin2'], 'required', 'when' => function ($model) {
                  return $model->statusvaksin == 3;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#statusvaksin').val() == '3';
                }
            "), 'on'=>['update']],
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
            'statusvaksin' => 'Status vaksin',
            'alasan' => 'Alasan',
            'tanggalvaksin1' => 'Tanggal vaksin 1',
            'lokasivaksin1' => 'Lokasi vaksin 1',
            'sertvaksin1' => 'Serttifikat vaksin 1',
            'tanggalvaksin2' => 'Tanggal vaksin 2',
            'lokasivaksin2' => 'Lokasi vaksin 2',
            'sertvaksin2' => 'Sertifikat vaksin 2',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'createdby' => 'Createdby',
            'updateby' => 'Updateby',
        ];
    }
    public function getAlasanvaksin()
    {
        return $this->hasOne(Masteralasanvaksin::className(), ['id' => 'alasan']);
    }
}
