<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Update Consumer: ' . $model->username, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consumers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addresses' => $addresses,
        'address_model' => $address_model,
        'address' => $address,
    ]) ?>
    <?php if (!empty($address)) : ?>
    <?php echo Html::a(Yii::t('app', 'Remove Meter'), ['remove', 'id' => $model->id], [
        'class' => 'btn btn-info',
        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to remove the meter?'),
            'method' => 'post',
        ],
    ]) ?>
    <?php endif; ?>

</div>
