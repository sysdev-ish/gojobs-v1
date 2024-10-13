<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_answers".
 *
 * @property int $id
 * @property int $workorder_id
 * @property int $candidate_id
 * @property string $label
 * @property string $type
 * @property string $answer
 */
class JobAdAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id', 'candidate_id'], 'integer'],
            [['label', 'type'], 'string', 'max' => 255],
            [['answer'], 'string', 'max' => 455],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workorder_id' => 'Workorder ID',
            'candidate_id' => 'Candidate ID',
            'label' => 'Label',
            'type' => 'Type',
            'answer' => 'Answer',
        ];
    }
}
