<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms".
 *
 * @property int $id
 * @property int $type_content
 * @property string $title
 * @property string $content
 * @property int $status
 * @property string $createtime
 * @property string $updatetime
 */
class Cms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_content', 'title'], 'required'],
            [['type_content', 'status'], 'integer'],
            [['content'], 'string'],
            [['createtime', 'updatetime'], 'safe'],
            [['title', 'assets_path'], 'string', 'max' => 255],
            [['assets_path'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 5072000, 'tooBig' => 'Limit is 5Mb', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_content' => 'Type Content',
            'title' => 'Title',
            'content' => 'Content',
            'assets_path' => 'Assets Path',
            'status' => 'Status',
            'created_time' => 'Create Time',
            'updated_time' => 'Update Time',
        ];
    }
}
