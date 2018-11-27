<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Lists');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'previous_reading',
            'current_reading',
            'total_amount',
            'deadline',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{download}',
                'buttons' => [
                    'download' => function ($url, $model) {
                        if ($model->paid_flag == Yii::$app->params['not_paid_bill_flag'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Download'), ['class' => 'fa fa-download']),
                                ['invoice/index', 'id' => $model->id], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to download this bill?'),
                                ],
                            ]);
                    },
                ],],
        ],
    ]); ?>
</div>
