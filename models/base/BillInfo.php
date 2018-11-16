<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "bill_info".
 *
 * @property int $id
 * @property double $unit_price per kilowatt
 * @property double $discount
 * @property double $processing_fee
 * @property string $submission_start
 * @property string $submission_end
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $status 0:inactive; 1:active
 *
 * @property Bill[] $bills
 */
class BillInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_price', 'discount', 'processing_fee'], 'number'],
            [['submission_start', 'submission_end', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'discount' => Yii::t('app', 'Discount'),
            'processing_fee' => Yii::t('app', 'Processing Fee'),
            'submission_start' => Yii::t('app', 'Submission Start'),
            'submission_end' => Yii::t('app', 'Submission End'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['bill_info_id' => 'id']);
    }
}
