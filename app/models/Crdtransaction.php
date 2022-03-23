<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crdtransaction".
 *
 * @property int $id
 * @property int $crdid
 * @property string $oldvalue
 * @property string $newvalue
 * @property int $status
 * @property string $olddoc
 * @property string $newdoc
 */
class Crdtransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crdtransaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['newvalue'], 'required', 'on' => ['npwp_1', 'jamsostek_1','bpjs_1']],
            [['newvalue','newdoc'], 'required', 'on' => ['npwp_2', 'jamsostek_2','bpjs_2']],

            [['newvalue'], 'integer', 'on' => ['npwp_2', 'jamsostek_2','bpjs_2']],

            [['newvalue','newvalue2','bankreasonid'], 'required', 'on' => ['bankaccount_1']],
            [['newvalue','newvalue2','newdoc','bankreasonid'], 'required', 'on' => ['bankaccount_2']],

            [['newvalue2'], 'integer', 'on' => ['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 8, 'max'=> 10, 'when' => function ($model) {
                  return $model->newvalue == 1;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '1';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 10, 'max'=> 10, 'when' => function ($model) {
                  return $model->newvalue == 10;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '10';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 13, 'max'=> 13, 'when' => function ($model) {
                  return $model->newvalue == 4;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '4';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 15, 'max'=> 15, 'when' => function ($model) {
                  return $model->newvalue == 2;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '2';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 12, 'max'=> 13, 'when' => function ($model) {
                  return $model->newvalue == 11;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '11';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],
            [['newvalue2'], 'string', 'min'=> 16, 'max'=> 16, 'when' => function ($model) {
                  return $model->newvalue == 3;
              }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                  return $('#crdtransaction-newvalue').val() == '3';
                }
            "), 'on'=>['bankaccount_1','bankaccount_2']],

            [['newvalue'], 'string', 'min'=> 15, 'max'=> 15, 'on' => ['npwp_1', 'npwp_2']],
            [['newvalue'], 'string', 'min'=> 11, 'max'=> 11, 'on' => ['jamsostek_1','jamsostek_2']],
            [['newvalue'], 'string', 'min'=> 11, 'max'=> 11, 'on' => ['bpjs_1','bpjs_2']],
            [['crdid', 'status'], 'integer'],
            [['bankreasonid', 'status'], 'integer'],
            [['oldvalue', 'newvalue'], 'string', 'max' => 445],
            [['olddoc', 'newdoc'], 'string', 'max' => 145],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crdid' => 'Crdid',
            'oldvalue' => 'Oldvalue',
            'newvalue' => 'Value',
            'newvalue2' => 'Value',
            'status' => 'Status',
            'olddoc' => 'Olddoc',
            'newdoc' => 'File',
            'bankreasonid' => 'Reason',
        ];
    }
    public function getBankname()
    {
        return $this->hasOne(Masterbank::className(), ['id' => 'newvalue']);
    }
    public function getOldbankname()
    {
        return $this->hasOne(Masterbank::className(), ['id' => 'oldvalue']);
    }
}
