<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Meters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Add Meter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Address',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getAddressName();
                },
            ],
            [
                'label' => 'bill info',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getBillInfoTitle();
                },
            ],
            'latitude',
            'longitude',
            'reading',
            //'created_at',
            //'update_at',
            //'created_by',
            //'updated_by',
            //'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [

                    'view' => function ($url, $model) {
                        return Html::a(Html::tag('i', '', ['class' => 'fa fa-eye']), $url,
                            ['class' => 'btn btn-success btn-xs']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']), $url,
                            ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']), $url, [
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
