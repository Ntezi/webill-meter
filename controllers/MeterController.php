<?php

namespace app\controllers;

use app\models\Address;
use app\components\AdminController;
use Yii;
use app\models\Meter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * MeterController implements the CRUD actions for Meter model.
 */
class MeterController extends AdminController
{

    /**
     * Lists all Meter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Meter::find()->where(['status' => Yii::$app->params['active_status']]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Meter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Meter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Meter();
//        $model->scenario = 'create';

        $addresses = ArrayHelper::map(Address::find()
            ->orderBy('building_name')
            ->all(), 'id', 'building_name');


        if ($model->load(Yii::$app->request->post())) {
            $uploaded_file = UploadedFile::getInstance($model, 'qr_code_image');

            if ($model->uploadQRCode($uploaded_file)) {
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            Yii::error(print_r($model->getErrors(), true));
        }

        return $this->render('create', [
            'model' => $model,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Updates an existing Meter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $addresses = ArrayHelper::map(Address::find()
            ->orderBy('building_name')
            ->all(), 'id', 'building_name');

        if ($model->load(Yii::$app->request->post())) {
            $uploaded_file = UploadedFile::getInstance($model, 'qr_code_image');

            if ($model->uploadQRCode($uploaded_file)) {
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            Yii::error(print_r($model->getErrors(), true));
        }
        return $this->render('update', [
            'model' => $model,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Deletes an existing Meter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Yii::$app->params['inactive_status'];
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Meter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Meter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Meter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
