<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterpic".
 *
 * @property int $id
 * @property int $masterofficeid
 * @property string $createtime
 * @property string $updatetime
 * @property int $userid
 */
class Masterpic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterpic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['masterofficeid', 'createtime', 'updatetime'], 'required'],
            [['masterofficeid', 'userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'masterofficeid' => 'Office',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'userid' => 'PIC',
        ];
    }
    public function getMasteroffice()
    {
        return $this->hasOne(Masteroffice::className(), ['id' => 'masterofficeid']);
    }
    public function getUserlogin()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'userid']);
    }
}
