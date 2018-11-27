<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BillInfo */

$this->title = Yii::t('app', 'Create Bill Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bill Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
