<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappinggrouprolepermission".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property int $grouprolepermissionid
 * @property int $roleid
 */
class Mappinggrouprolepermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappinggrouprolepermission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['grouprolepermissionid', 'roleid', 'active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grouprolepermissionid' => 'Grouprolepermissionid',
            'roleid' => 'Roleid',
            'active' => 'Status',
        ];
    }
    public function getRolename()
    {
        return $this->hasOne(Userrole::className(), ['id' => 'roleid']);
    }
}
