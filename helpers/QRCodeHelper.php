<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/6/18
 * Time: 11:50 AM
 */

namespace app\helpers;
ini_set('memory_limit', '2G');
ini_set('max_execution_time', '180');

use Yii;
use Zxing\QrReader;
use yii\base\ErrorException;

class QRCodeHelper
{
    public static function ReadQRCode($path)
    {
        try {
            $qrcode = new QrReader($path);
            $text = $qrcode->text(); //return decoded text from QR Code
            Yii::warning('qrcode text: ' . $text);
            return $text;
        } catch (ErrorException $e) {
            Yii::$app->session->setFlash("danger", Yii::t('app', $e));
        }

    }
}