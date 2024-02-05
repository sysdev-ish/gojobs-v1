<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chagerequestjo".
 *
 * @property int $id
 * @property int $recruitreqid
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property int $createdby
 * @property int $updatedby
 * @property int $approvedby
 * @property int $status
 * @property string $remarks
 * @property int $oldjumlah
 * @property int $jumlah
 * @property string $documentevidence
 */
class Chagerequestjo extends \yii\db\ActiveRecord
{
    public $counthiredtype1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chagerequestjo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlahstop', 'documentevidence', 'reason'], 'required', 'on' => "create"],
            [['status'], 'required', 'on' => "approve"],
            [['recruitreqid', 'createdby', 'updatedby', 'approvedby', 'status', 'oldjumlah', 'reason', 'jumlahstop', 'counthiredtype1'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime'], 'safe'],
            [['remarks'], 'string', 'max' => 445],
            [['documentevidence'], 'string', 'max' => 345],
            ['jumlahstop', 'integer', 'max' => $this->oldjumlah, 'on' => "create"],
            ['jumlahstop', 'integer', 'max' => $this->counthiredtype1, 'on' => "create"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recruitreqid' => 'No Job Order',
            'createtime' => 'Created at',
            'updatetime' => 'Updated at',
            'approvedtime' => 'Approved at',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
            'approvedby' => 'Approvedby',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'oldjumlah' => 'Jumlah Kebutuhan Sebelumnya',
            'jumlah' => 'Jumlah Kebutuhan',
            'jumlahstop' => 'Jumlah Stop Pemenuhan Pekerja',
            'documentevidence' => 'Document evidence',
            'reason' => 'Alasan stop',
        ];
    }
    public function getCreatedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'createdby']);
    }

    public function getUpdatedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'updatedby']);
    }
    public function getApprovedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'approvedby']);
    }
    public function getJo()
    {
        return $this->hasOne(Transrincian::className(), ['id' => 'recruitreqid']);
    }
}
