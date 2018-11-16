<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name . " - " . Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo Yii::$app->name; ?></h3>
            </div>
            <div class="panel-body">

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')
                    ->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Enter email')])->label(false); ?>

                <?= $form->field($model, 'password')
                    ->passwordInput(['placeholder' => Yii::t('app', 'Enter password')])->label(false); ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
