<?php

namespace app\controllers;

use app\components\AccessRule;
use app\components\ConsumerController;
use app\models\User;
use Yii;
use app\models\Bill;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Controller;

class UploadController extends ConsumerController
{

    /**
     * Lists all Bill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Bill::find()
                ->where(['user_id' => Yii::$app->user->identity->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bill model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
//        return $this->redirect(['index']);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Bill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bill();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = $model->getDb()->beginTransaction();
            try {

                Yii::warning('Before upload');
                $meter = User::getConsumerCurrentMeter(Yii::$app->user->identity->id);
                if (!empty($meter)) {
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->previous_reading = $meter->reading;
                    $model->verified_by_user = Yii::$app->params['verified_no'];
                    $model->verified_by_admin = Yii::$app->params['verified_no'];
                    $model->paid_flag = null;
                    if ($model->save()) {
                        $uploaded_file = UploadedFile::getInstance($model, 'image');
                        if ($uploaded_file) {
                            if ($model->uploadImage($uploaded_file)) {

                                $model->saveMeterReading();
                                Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully uploaded'));
                                $transaction->commit();
                                return $this->redirect(['update', 'id' => $model->id]);
                            } else {
                                Yii::$app->session->setFlash("warning", Yii::t('app', 'Problem occurred while uploading'));
                                $transaction->rollBack();
                            }
                        } else {
                            Yii::$app->session->setFlash("danger", Yii::t('app', 'Image file can not be empty'));
                            $transaction->rollBack();
                            return $this->redirect(['create']);
                        }

                    } else {
                        Yii::$app->session->setFlash("warning", Yii::t('app', 'There is a problem while uploading. Please contact the admin'));
                        $transaction->rollBack();
                        Yii::error(print_r($model->getErrors(), true));
                        return $this->redirect(['create']);
                    }

                } else {
                    Yii::$app->session->setFlash("danger", Yii::t('app', 'No meter assigned to you!'));
                    $transaction->rollBack();
                    return $this->redirect(['create']);
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $transaction = $model->getDb()->beginTransaction();
            try {

                Yii::warning('Before upload');
                $meter = User::getConsumerCurrentMeter(Yii::$app->user->identity->id);
                if (!empty($meter)) {
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->previous_reading = $meter->reading;
                    $model->verified_by_user = Yii::$app->params['verified_no'];
                    $model->verified_by_admin = Yii::$app->params['verified_no'];
                    $model->paid_flag = null;
                    $current_reading = $post['Bill']['current_reading'];
                    Yii::warning('$current_reading: ' . print_r($current_reading, true));
                    if (!$model->checkCurrentReading($current_reading)) {
                        Yii::warning('current_reading: ' . $model->current_reading);
                        Yii::$app->session->setFlash("danger", Yii::t('app', 'The previous reading is greater than the current reading!'));
                    } elseif ($model->save()) {
                        $uploaded_file = UploadedFile::getInstance($model, 'image');
                        if ($uploaded_file) {
                            if ($model->uploadImage($uploaded_file)) {
                                Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully uploaded'));
                                $model->saveMeterReading();
                            } else {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash("warning", Yii::t('app', 'Problem occurred while uploading'));
                            }
                        }
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("danger", Yii::t('app', 'There is a problem while uploading. Please contact the admin'));
                        Yii::error(print_r($model->getErrors(), true));
                        return $this->redirect(['update']);
                    }
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("warning", Yii::t('app', 'No meter assigned to you!'));
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

    public function actionSubmit($id)
    {
        $model = $this->findModel($id);
        $model->verified_by_user = Yii::$app->params['verified_yes'];
        $model->save();

        return $this->redirect(['index']);
    }
}
