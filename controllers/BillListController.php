<?php

namespace app\controllers;

use app\models\Bill;
use Yii;
use app\components\ConsumerController;
use yii\data\ActiveDataProvider;

class BillListController extends ConsumerController
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Bill::find()
                ->where(['user_id' => Yii::$app->user->identity->getId(), 'paid_flag' => Yii::$app->params['not_paid_bill_flag']])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
