<?php

namespace app\controllers;

use app\models\Bill;
use app\models\Meter;
use app\models\Notification;
use app\models\User;
use app\helpers\UploadHelper;
use Yii;
use app\components\AdminController;
use yii\web\NotFoundHttpException;

class BillController extends AdminController
{
    public function actionIndex($id)
    {
        $model = $this->findModel($id);
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionApprove($id)
    {
        $bill = $this->findModel($id);

        if (!empty($bill)) {
            $meter = User::getConsumerCurrentMeter($bill->user_id);
            if (!empty($meter)) {

                $bill->previous_reading = $meter->reading;
                $bill->verified_by_admin = Yii::$app->params['verified_yes'];
                $bill->total_amount = $bill->calculateBill($meter->bill_info_id);
                $bill->paid_flag = Yii::$app->params['not_paid_bill_flag'];
                $bill->deadline = date('Y-m-d', strtotime('+1 month'));

                if ($bill->save()) {
                    $meter->reading = $bill->current_reading;
                    if ($meter->save()) {
                        Notification::sendBillNotification($bill->user_id, Yii::$app->user->identity->getId(), $bill->id, 'approved');
                        Yii::$app->session->setFlash("success", Yii::t('app', 'Bill approved'));
                    }

                }
            }

            return $this->redirect(['site/index']);

        }
    }

    public function actionReject($id)
    {
        $bill = $this->findModel($id);

        if (!empty($bill)) {
            $meter = User::getConsumerCurrentMeter($bill->user_id);
            if (!empty($meter)) {
                $bill->paid_flag = Yii::$app->params['rejected_bill_flag'];
                if ($bill->save()) {
                    Notification::sendBillNotification($bill->user_id, Yii::$app->user->identity->getId(), $bill->id,'rejected');
                    Yii::$app->session->setFlash("success", Yii::t('app', 'Bill rejected'));
                }
            }

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
