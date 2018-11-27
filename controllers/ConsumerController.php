<?php

namespace app\controllers;

use app\models\Address;
use app\models\Meter;
use app\models\UserHasMeter;
use app\components\AdminController;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * ConsumerController implements the CRUD actions for User model.
 */
class ConsumerController extends AdminController
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['role' => Yii::$app->params['consumer_role']]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $address = $model->getConsumerCurrentAddress($id);
        return $this->render('view', [
            'model' => $model,
            'address' => $address,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $address_model = new Address();
        $addresses = Address::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->username = $model->email;
            $password = Yii::$app->security->generateRandomString(6);
            $model->setPassword($password);
            $model->status = User::STATUS_ACTIVE;
            $model->role = Yii::$app->params['consumer_role'];
            if ($model->save()) {
                User::registeredMessage($model->email, $password, $model->role);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'addresses' => $addresses,
            'address_model' => $address_model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $current_address = $model->getConsumerCurrentAddress($model->id);

        $address_model = new Address();
        $addresses = Address::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = $model->getDb()->beginTransaction();
            try {

                if ($model->save()) {
                    $post = Yii::$app->request->post('Address');
                    if (!empty($post['address'])) {
                        $meter = Meter::getMeter($post);
                        Yii::warning("Get Meter: " . print_r($meter, true));

                        if (!empty($meter)) {
                            $user_has_meter = new UserHasMeter();
                            if ($user_has_meter->checkTakenMeter($meter->id, $model->id)) {
                                $user_has_meter->user_id = $model->id;
                                $user_has_meter->meter_id = $meter->id;
                                $user_has_meter->started_at = date("Y-m-d H:i:s");
                                $user_has_meter->save();

                                $error = $user_has_meter->getErrors();
                                Yii::error(print_r($error, true));
                            } else {
                                Yii::$app->session->setFlash("danger", Yii::t('app', 'This meter has already been taken'));
                            }
                        } else {
                            Yii::$app->session->setFlash("danger", Yii::t('app', 'No meter assigned to the address!'));
                        }
                    }

                    $transaction->commit();
                    //Yii::$app->session->setFlash("success", Yii::t('app', 'Successfully updated '));
                    return $this->redirect(['view', 'id' => $model->id]);
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
            'addresses' => $addresses,
            'address_model' => $address_model,
            'current_address' => $current_address,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_ACTIVE;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        $user_has_meter = UserHasMeter::findOne(['user_id' => $model->id, 'ended_at' => null]);
        $user_has_meter->status = Yii::$app->params['inactive_status'];
        $user_has_meter->ended_at = date("Y-m-d H:i:s");
        $user_has_meter->save();

        return $this->redirect(['view', 'id' => $model->id]);
    }
}
