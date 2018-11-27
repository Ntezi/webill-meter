<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bill Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bill Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'unit_price',
            'discount',
            'processing_fee',
            'submission_start',
            //'submission_end',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {activate}',
                'buttons' => [

                    'view' => function ($url, $model) {
                        return Html::a(Html::tag('i', Yii::t('app', ' View'), ['class' => 'fa fa-eye']), $url,
                            ['class' => 'btn btn-success btn-xs']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(Html::tag('i', Yii::t('app', ' Update'), ['class' => 'fa fa-edit']), $url,
                            ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                            return Html::a(Html::tag('i', Yii::t('app', ' Disable'), ['class' => 'fa fa-trash']), $url, [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', '\'Are you sure you want to delete this item?'),
                                ],
                            ]);
                    },

                ],
            ],
        ],
    ]); ?>
</div>
