<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Add Consumer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consumers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addresses' => $addresses,
        'address_model' => $address_model,
    ]) ?>

</div>
