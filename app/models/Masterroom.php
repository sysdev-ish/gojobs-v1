<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterroom".
 *
 * @property int $id
 * @property int $masterofficeid
 * @property string $createtime
 * @property string $updatetime
 * @property string $room
 * @property string $floor
 */
class Masterroom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterroom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['masterofficeid', 'room'], 'required'],
            [['masterofficeid','floor'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['room'], 'string', 'max' => 225],
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
            'room' => 'Room',
            'floor' => 'Floor',
        ];
    }
    public function getMasteroffice()
    {
        return $this->hasOne(Masteroffice::className(), ['id' => 'masterofficeid']);
    }
}
