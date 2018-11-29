<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'to_id',
            'from_id',
            'subject',
            'bill_id',
//            'message:ntext',
            'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'flag',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [

                    'view' => function ($url, $model) {
                        return Html::a(Html::tag('i', Yii::t('app', ' View'), ['class' => 'fa fa-eye']), $url,
                            ['class' => 'btn btn-primary btn-xs']);
                    },

                ],
            ],
        ],
    ]); ?>
</div>
