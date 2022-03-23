<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_rincian_logupdate".
 *
 * @property int $id
 * @property int $idpktable
 * @property int $typejo
 * @property string $upd
 * @property string $lup
 * @property string $nojo
 * @property string $statusupdate
 * @property string $perner
 * @property string $updatetime
 * @property int $updatecount
 */
class Transrincianlogupdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_rincian_logupdate';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbjo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpktable', 'typejo', 'upd', 'lup', 'nojo', 'statusupdate'], 'required'],
            [['idpktable', 'typejo', 'updatecount'], 'integer'],
            [['lup', 'updatetime'], 'safe'],
            [['upd', 'nojo'], 'string', 'max' => 145],
            [['statusupdate', 'perner'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idpktable' => 'Idpktable',
            'typejo' => 'Typejo',
            'upd' => 'Upd',
            'lup' => 'Lup',
            'nojo' => 'Nojo',
            'statusupdate' => 'Statusupdate',
            'perner' => 'Perner',
            'updatetime' => 'Updatetime',
            'updatecount' => 'Updatecount',
        ];
    }
}
