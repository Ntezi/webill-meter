<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property int $id
 * @property int $user_id
 * @property int $bill_info_id
 * @property double $previous_reading
 * @property string $current_reading
 * @property string $image_file
 * @property string $bill_file_path
 * @property double $total_amount
 * @property int $verified_by_user 0:no; 1:yes
 * @property int $verified_by_admin 0:no; 1:yes
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $deadline
 * @property int $paid_flag
 *
 * @property User $user
 * @property BillInfo $billInfo
 * @property Notification[] $notifications
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'image_file'], 'required'],
            [['user_id', 'bill_info_id', 'verified_by_user', 'verified_by_admin', 'created_by', 'updated_by', 'paid_flag'], 'integer'],
            [['previous_reading', 'total_amount'], 'number'],
            [['created_at', 'updated_at', 'deadline'], 'safe'],
            [['current_reading', 'image_file', 'bill_file_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['bill_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => BillInfo::className(), 'targetAttribute' => ['bill_info_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'bill_info_id' => Yii::t('app', 'Bill Info ID'),
            'previous_reading' => Yii::t('app', 'Previous Reading'),
            'current_reading' => Yii::t('app', 'Current Reading'),
            'image_file' => Yii::t('app', 'Image File'),
            'bill_file_path' => Yii::t('app', 'Bill File Path'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'verified_by_user' => Yii::t('app', 'Verified By User'),
            'verified_by_admin' => Yii::t('app', 'Verified By Admin'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deadline' => Yii::t('app', 'Deadline'),
            'paid_flag' => Yii::t('app', 'Paid Flag'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillInfo()
    {
        return $this->hasOne(BillInfo::className(), ['id' => 'bill_info_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['bill_id' => 'id']);
    }
}
