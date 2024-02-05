<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterlevel".
 *
 * @property int $id
 * @property string $level_name
 * @property string $is_active
 */
class Masterlevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterlevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['level_name', 'is_active'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_name' => 'Level Name',
            'is_active' => 'Is Active',
        ];
    }
}
