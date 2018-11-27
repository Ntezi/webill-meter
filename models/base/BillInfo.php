<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "bill_info".
 *
 * @property int $id
 * @property string $title
 * @property double $unit_price per kilowatt
 * @property double $tax
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
 * @property Meter[] $meters
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
            [['title', 'tax'], 'required'],
            [['unit_price', 'tax', 'discount', 'processing_fee'], 'number'],
            [['submission_start', 'submission_end', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'unit_price' => Yii::t('app', 'Unit Price'),
            'tax' => Yii::t('app', 'Tax'),
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
    public function getMeters()
    {
        return $this->hasMany(Meter::className(), ['bill_info_id' => 'id']);
    }
}
