<?php

namespace app\controllers;

use app\models\Bill;
use Yii;
use app\components\ClientController;
use yii\web\NotFoundHttpException;

class InvoiceController extends ClientController
{
    public function actionIndex($id)
    {
        $model = $this->findModel($id);

        $pdf = Yii::$app->pdf;
        $pdf->content = $this->renderPartial('index', [
            'model' => $model,
        ]);
        return $pdf->render();
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
