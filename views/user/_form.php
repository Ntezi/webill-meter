<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'first_name')->textInput() ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'last_name')->textInput() ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'email')->textInput() ?>
        </div>
    </div>
    <?php if (!$model->isNewRecord): ?>
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <div class="col-md-4 col-lg-4">
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
