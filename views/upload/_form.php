<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-form">

    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-4 col-lg-4">
            <div class="row">
                <?php echo $form->field($model, 'image')
                    ->fileInput([
                        'accept' => 'image/*',
                        'placeholder' => Yii::t('app', 'Image File')
                    ])->label(Yii::t('app', 'Image File')); ?>
            </div>
            <?php if (!$model->isNewRecord): ?>
                <div class="row">
                    <?= Html::img($model->getImagePath(), ['width' => '200px']) ?>
                </div>
                <div class="row">
                    <?= $form->field($model, 'current_reading')->textInput() ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <?php if (!$model->isNewRecord && !empty($check_bill)): //print_r($check_bill)?>

            <div class="col-md-4 col-lg-4" style="margin: 50px;">
                <ul class="list-group">
                    <li class="list-group-item">
                    <span class="badge">
                        <?= $check_bill['qr_code_check'] ?>
                    </span>
                        <?= Yii::t('app', 'QR Code Check') ?>
                    </li>
                    <li class="list-group-item">
                    <span class="badge">
                        <?= $check_bill['location_check'] ?>
                    </span>
                        <?= Yii::t('app', 'Location Check') ?>
                    </li>
                    <li class="list-group-item">
                    <span class="badge">
                        <i class="fa fa-thumbs-down"></i>
                    </span>
                        Item 3
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
