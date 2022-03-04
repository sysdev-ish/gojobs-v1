<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterstatushiring".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $statusname
 */
class Masterformtype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterformtype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['formtype'], 'string', 'max' => 445],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'formtype' => 'formtype',
        ];
    }
}
