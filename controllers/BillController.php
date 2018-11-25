<?php

namespace app\controllers;

use app\models\Bill;
use app\models\Meter;
use app\models\User;
use app\helpers\UploadHelper;
use Yii;
use app\components\AdminController;
use yii\web\NotFoundHttpException;

class BillController extends AdminController
{
    public function actionIndex($id)
    {
        $bill = $this->findModel($id);

        if (!empty($bill)) {

            //Read QR Code
            $bill_qr = $bill->readBillQRCode();

            //Read image with OCR
            $current_reading = $bill->getMeterCurrentReading();

            if ($bill_qr != null) {
                Yii::$app->session->setFlash("success", Yii::t('app', 'QR Code: ' . $current_reading));
            }


//            $meter = User::getConsumerCurrentMeter($bill->user_id);
//            if (!empty($meter)) {
//
//                $bill_qr = $bill->readBillQRCode();
//                $meter_qr = $meter->readMeterQRCode();
//
//                if ($meter_qr != null && $bill_qr != null) {
//                    if ($meter_qr == $bill_qr) {
//
//                        $bill->previous_reading = $meter->reading;
////                        $bill->verified_by_admin = Yii::$app->params['verified_yes'];
//                        $bill->total_amount = $bill->calculateBill();
//                        $bill->paid_flag = Yii::$app->params['pending_bill_flag'];
//                        $bill->deadline = date('Y-m-di', strtotime('+1 month'));
//                        $bill->save();
//
//
//
//                        // Update the meter
//
//                        Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully Matched '));
//                    } else {
//                        Yii::$app->session->setFlash("warning", Yii::t('app', 'Not Matched '));
//                    }
//                }
//            }

            return $this->redirect(['site/index']);
        }

    }

    /**
     * Finds the Bill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bill::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
