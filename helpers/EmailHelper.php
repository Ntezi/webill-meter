<?php
/**
 * Created by PhpStorm.
 * User: ntezi
 * Date: 06/12/2016
 * Time: 15:06
 */

namespace app\helpers;

use Yii;

class EmailHelper
{
    public static function sendEmail($to, $subject, $body)
    {
        $message = Yii::$app->mailer->compose();

        $message->setFrom([Yii::$app->params['adminEmail'] => 'WeBill'])
            ->setTo($to)// for production
            ->setCc(Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->setHtmlBody($body);
        if ($message->send()) {
            return true;
        } else {
            return false;
        }
    }
}