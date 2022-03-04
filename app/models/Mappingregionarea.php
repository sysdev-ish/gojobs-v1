<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingregionarea".
 *
 * @property int $id
 * @property int $areaishid
 * @property string $regionid
 * @property string $areaid
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $updatedby
 */
class Mappingregionarea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappingregionarea';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['areaishid', 'regionid', 'areaid', 'createtime', 'updatetime', 'createdby', 'updatedby'], 'required'],
            [['areaishid', 'createdby', 'updatedby'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['regionid', 'areaid'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaishid' => 'Area-ISH',
            'regionid' => 'Region',
            'areaid' => 'Area SAP',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
        ];
    }
    public function getMasterareaish()
    {
        return $this->hasOne(Masterareaish::className(), ['id' => 'areaishid']);
    }
    public function getMasterregion()
    {
        return $this->hasOne(Masterregion::className(), ['id' => 'regionid']);
    }
    public function getMasterarea()
    {
        return $this->hasOne(Saparea::className(), ['value1' => 'areaid']);
    }
}
