<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consumers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Add Consumer'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'first_name',
            'last_name',
//            'auth_key',
            'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'role',
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
                        if ($model->status == Yii::$app->params['active_user'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Disable'), ['class' => 'fa fa-trash']), $url, [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', '\'Are you sure you want to disable this user?'),
                                ],
                            ]);
                    },
                    'activate' => function ($url, $model) {
                        if ($model->status == Yii::$app->params['inactive_user'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Activate'), ['class' => 'fa fa-thumbs-o-up']), $url, [
                                'class' => 'btn btn-default btn-xs',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => Yii::t('app', '\'Are you sure you want to activate this user?'),
                                ],
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
