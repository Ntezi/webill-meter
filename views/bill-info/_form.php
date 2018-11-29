<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BillInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-info-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
        <div class="col-md-3 col-lg-3">
            <?= $form->field($model, 'unit_price')->textInput() ?>
        </div>
        <div class="col-md-3 col-lg-3">
            <?= $form->field($model, 'discount')->textInput() ?>
        </div>
        <div class="col-md-3 col-lg-3">
            <?= $form->field($model, 'processing_fee')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
