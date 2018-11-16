<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;


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

    <div class="row">

        <div class="col-md-12 col-lg-12">
            <?php if (!$model->isNewRecord && !empty($address)) : ?>

                <div class="alert alert-info">
                    <strong>Meter Address:</strong>
                    <?php echo $address->building_name . " - " .
                        $address->street_number . " - " .
                        $address->district . " - " .
                        $address->town . " - " .
                        $address->ward . " - " .
                        $address->city; ?>
                </div>

            <?php endif; ?>
            <?php if (empty($address)) : $addresses_ = array();
                foreach ($addresses as $address):
                    $address_ = $address->building_name . " # " .
                        $address->street_number . " # " .
                        $address->district . " # " .
                        $address->town . " # " .
                        $address->ward . " # " .
                        $address->city;
                    array_push($addresses_, $address_);
                endforeach;
                echo $form->field($address_model, 'address')->widget(Typeahead::classname(), [
                    'options' => ['placeholder' => 'Search address'],
                    'pluginOptions' => ['highlight' => true,],
                    'dataset' => [['local' => $addresses_, 'limit' => 10],]
                ]); endif; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
