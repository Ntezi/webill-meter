<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/25/18
 * Time: 3:53 PM
 */

namespace app\models;

use app\helpers\EmailHelper;
use app\models\base\Notification as BaseNotification;
use yii\behaviors\BlameableBehavior;

class Notification extends BaseNotification
{
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['to_id', 'from_id', 'subject', 'message', 'bill_id'], 'required'],
            [['to_id', 'from_id', 'created_by', 'updated_by', 'flag', 'bill_id'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['subject'], 'string', 'max' => 125],
            [['bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bill::className(), 'targetAttribute' => ['bill_id' => 'id']],
        ];
    }

    public static function sendBillApprovalNotification($to_id, $from_id, $bill_id)
    {
        $notification = new self();
        $notification->to_id = $to_id;
        $notification->from_id = $from_id;
        $notification->subject = 'Bill Approved';
        $notification->bill_id = $bill_id;
        $notification->message = self::getMessage();
        if ($notification->save()) {
            self::sendBillApprovalEmail($notification->to_id, $notification->subject);
        }

    }

    public static function getMessage()
    {
        $message = "Your bill was successfully approved <br/>";
        $message .= "Please use this download it.";
        return $message;
    }

    public static function sendBillApprovalEmail($to_id, $subject)
    {
        $current_user = User::findOne($to_id);
        if (!empty($current_user)) {
            EmailHelper::sendEmail($current_user->email, $subject, self::getMessage());
        }
    }
}