<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $to_id
 * @property int $from_id
 * @property string $subject
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $flag
 * @property int $bill_id
 *
 * @property Bill $bill
 * @property NotificationReplies[] $notificationReplies
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'to_id', 'from_id', 'subject', 'message', 'bill_id'], 'required'],
            [['id', 'to_id', 'from_id', 'created_by', 'updated_by', 'bill_id'], 'integer'],
            [['message', 'flag'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 125],
            [['id'], 'unique'],
            [['bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bill::className(), 'targetAttribute' => ['bill_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'to_id' => Yii::t('app', 'To ID'),
            'from_id' => Yii::t('app', 'From ID'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'flag' => Yii::t('app', 'Flag'),
            'bill_id' => Yii::t('app', 'Bill ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationReplies()
    {
        return $this->hasMany(NotificationReplies::className(), ['notification_id' => 'id']);
    }
}
