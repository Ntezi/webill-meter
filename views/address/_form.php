<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'prefecture')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'ward')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'town')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'street_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'building_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
