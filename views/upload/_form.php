<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Bill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bill-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-4 col-lg-4">
            <?php echo $form->field($model, 'image')
                ->fileInput([
                    'accept' => 'image/*',
                    'placeholder' => Yii::t('app', 'Image File')
                ])->label(Yii::t('app', 'Image File')); ?>
        </div>
        <?php if (!$model->isNewRecord): ?>
            <div class="col-md-4 col-lg-4">
                <?= Html::img($model->getImagePath(), ['width' => '200px']) ?>
            </div>
            <div class="col-md-4 col-lg-4">
                <?= $form->field($model, 'current_reading')->textInput() ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
