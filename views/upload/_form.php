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
    </div>
</div>
