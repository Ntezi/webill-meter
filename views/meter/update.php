<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Meter */

$this->title = Yii::t('app', 'Update Meter: ' . $model->getAddressName(), [
    'nameAttribute' => '' . $model->getAddressName(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="meter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addresses' => $addresses,
        'bill_infos' => $bill_infos,
    ]) ?>

</div>
