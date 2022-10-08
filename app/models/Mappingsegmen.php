<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingsegmen".
 *
 * @property int $id
 * @property string $divisi
 */
class Mappingsegmen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappingsegmen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['divisi'], 'string'],
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
            'divisi' => 'Divisi',
        ];
    }
}
