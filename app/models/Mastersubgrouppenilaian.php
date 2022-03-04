<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastersubgrouppenilaian".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $subgroup
 */
class Mastersubgrouppenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastersubgrouppenilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime', 'subgroup'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['subgroup'], 'string', 'max' => 145],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'subgroup' => 'Subgroup',
        ];
    }
}
