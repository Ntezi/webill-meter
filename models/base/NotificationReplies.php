<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "notification_replies".
 *
 * @property int $id
 * @property int $notification_id
 * @property int $admin_id
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 * @property string $flag
 *
 * @property Notification $notification
 */
class NotificationReplies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification_replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_id', 'admin_id', 'message'], 'required'],
            [['notification_id', 'admin_id'], 'integer'],
            [['message', 'flag'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notification::className(), 'targetAttribute' => ['notification_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notification_id' => Yii::t('app', 'Notification ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'flag' => Yii::t('app', 'Flag'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id' => 'notification_id']);
    }
}
