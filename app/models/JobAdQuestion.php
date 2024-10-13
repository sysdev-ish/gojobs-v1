<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_questions".
 *
 * @property int $id
 * @property int $job_id
 * @property int $order_number
 * @property string $question
 * @property string $question_type
 * @property string $answer_option
 */
class JobAdQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'order_number'], 'integer'],
            [['question', 'question_type', 'answer_option'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'order_number' => 'Order Number',
            'question' => 'Question',
            'question_type' => 'Question Type',
            'answer_option' => 'Answer Option',
        ];
    }
}
