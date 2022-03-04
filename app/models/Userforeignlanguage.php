<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userforeignlanguage".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $language
 * @property int $speaking
 * @property int $writing
 * @property int $reading
 * @property int $understanding
 *
 * @property User $user
 */
class Userforeignlanguage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userforeignlanguage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language','speaking', 'writing', 'reading', 'understanding'], 'required'],
            [['userid', 'speaking', 'writing', 'reading', 'understanding'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['language'], 'string', 'max' => 75],
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
            'language' => 'Language',
            'speaking' => 'Speaking',
            'writing' => 'Writing',
            'reading' => 'Reading',
            'understanding' => 'Understanding',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
