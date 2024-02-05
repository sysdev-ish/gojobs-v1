<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mastercontract".
 *
 * @property int $id
 * @property string $contract_name
 * @property string $ansvh
 * @property string $cttyp
 * @property int $is_active
 */
class Mastercontract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mastercontract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'is_active'], 'integer'],
            [['contract_name'], 'string', 'max' => 100],
            [['ansvh', 'cttyp'], 'string', 'max' => 10],
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
            'contract_name' => 'Contract Name',
            'ansvh' => 'Ansvh',
            'cttyp' => 'Cttyp',
            'is_active' => 'Is Active',
        ];
    }
}
