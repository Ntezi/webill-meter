<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $address app\models\Address */
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

    <div class="row">

        <div class="col-md-12 col-lg-12">
            <?php if (!$model->isNewRecord) :
                if ($current_address != null) : ?>
                    <div class="alert alert-info">
                        <strong>Meter Address:</strong>
                        <?php echo $current_address ?>
                    </div>
                <?php endif; ?>
                <?php if ($current_address == null) :
                $addresses_ = array();

                if (!empty($addresses)) {
                    foreach ($addresses as $address):
                        $address_ = $address->full_address;
                        array_push($addresses_, $address_);
                    endforeach;
                }

                echo $form->field($address_model, 'address')->widget(Typeahead::classname(), [
                    'options' => ['placeholder' => 'Search address'],
                    'pluginOptions' => ['highlight' => true,],
                    'dataset' => [['local' => $addresses_, 'limit' => 10],]
                ]);endif;
            endif; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
