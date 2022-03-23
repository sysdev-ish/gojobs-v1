<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logactivity".
 *
 * @property int $id
 * @property string $userid
 * @property int $actiitytype
 * @property int $roleid
 * @property int $divisionid
 * @property string $division
 * @property string $firstlogin
 * @property string $lastlogin
 * @property int $counter
 */
class Logactivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logactivity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date','userid', 'actiitytype', 'roleid',  'firstlogin', 'lastlogin', 'counter'], 'required'],
            [['actiitytype', 'roleid', 'divisionid', 'counter'], 'integer'],
            [['date','firstlogin', 'lastlogin'], 'safe'],
            [['userid'], 'string', 'max' => 45],
            [['division'], 'string', 'max' => 445],
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
            'actiitytype' => 'Actiitytype',
            'roleid' => 'Roleid',
            'divisionid' => 'Divisionid',
            'division' => 'Division',
            'firstlogin' => 'Firstlogin',
            'lastlogin' => 'Lastlogin',
            'counter' => 'Counter',
        ];
    }
}
