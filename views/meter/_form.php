<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Meter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meter-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-4 col-lg-4">
            <?php echo $form->field($model, 'address_id')->dropDownList($addresses, [
                'prompt' => Yii::t('app', 'Address'),
            ]);
            ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?php echo $form->field($model, 'bill_info_id')->dropDownList($bill_infos, [
                'prompt' => Yii::t('app', 'Bill info'),
            ]);
            ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?php
//            echo $form->field($model, 'qr_code_image')
//                ->fileInput([
//                    'accept' => 'image/*',
//                    'placeholder' => Yii::t('app', 'QRCode Image')
//                ])->label(Yii::t('app', 'QRCode Image'));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'latitude')->textInput() ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?= $form->field($model, 'reading')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
