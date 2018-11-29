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

    public static function sendBillNotification($to_id, $from_id, $bill_id, $status)
    {
        $notification = new self();
        $notification->to_id = $to_id;
        $notification->from_id = $from_id;
        $notification->bill_id = $bill_id;

        if ($status == 'approved') {
            $notification->subject = 'Bill Approved';
            $notification->message = self::getApprovedMessage();
            if ($notification->save()) {
                self::sendBillEmailNotification($notification->to_id, $notification->subject, $notification->message);
            }
        } elseif ($status == 'rejected') {
            $notification->subject = 'Bill Rejected';
            $notification->message = self::getRejectedMessage();
            if ($notification->save()) {
                self::sendBillEmailNotification($notification->to_id, $notification->subject, $notification->message);
            }
        }

    }

    public static function getApprovedMessage()
    {
        $message = "Your bill was approved <br/>";
        $message .= "Please download it.";
        return $message;
    }

    public static function getRejectedMessage()
    {
        $message = "Your bill was rejected <br/>";
        $message .= "Please upload the image again.";
        return $message;
    }

    public static function sendBillEmailNotification($to_id, $subject, $body)
    {
        $current_user = User::findOne($to_id);
        if (!empty($current_user)) {
            EmailHelper::sendEmail($current_user->email, $subject, $body);
        }
    }
}