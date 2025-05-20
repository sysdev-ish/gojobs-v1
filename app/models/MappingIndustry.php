<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mapping_industry".
 *
 * @property int $id
 * @property string $company_name
 * @property string $client_name
 * @property string $category_segment
 * @property int $category_company
 * @property string|null $description
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class MappingIndustry extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'mapping_industry';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['company_name', 'client_name', 'category_segment', 'category_company', 'created_by', 'updated_by'], 'required'],
      [['category_company', 'status', 'created_by', 'updated_by'], 'integer'],
      [['description'], 'string'],
      [['created_at', 'updated_at'], 'safe'],
      [['company_name', 'client_name'], 'string', 'max' => 255],
      [['category_segment'], 'string', 'max' => 50], // Adjust max length as needed
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'company_name' => 'Company Name',
      'client_name' => 'Client Name',
      'category_segment' => 'Category Segment',
      'category_company' => 'Category Company',
      'description' => 'Description',
      'status' => 'Status',
      'created_by' => 'Created By',
      'updated_by' => 'Updated By',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  public function published()
  {
    return $this->andWhere(['status' => 1]);
  }

  public function getCategoryindustry()
  {
    return $this->hasOne(Masterindustry::className(), ['id' => 'category_company']);
  }
}
