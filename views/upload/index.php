<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Uploads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Upload Image'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'QR Code',
                'format'=>'html',
                'value' => function ($model) {

                    return Html::img($model->getImagePath(), ['width' => '60px']);
                },
            ],
//            'user_id',
            'previous_reading',
            'current_reading',
            //'image_path',
            //'bill_file_path',
            'total_amount',
//            'verified_by_user',
//            'verified_by_admin',
            'created_at',
            //'created_by',
            //'updated_by',
            //'updated_at',
            'deadline',
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getFlagLabel();
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {submit}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if ($model->verified_by_user == Yii::$app->params['verified_no'] || $model->paid_flag == Yii::$app->params['rejected_bill_flag'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Update'), ['class' => 'fa fa-edit']), $url,
                                ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                        if ($model->verified_by_user == Yii::$app->params['verified_no'] || $model->paid_flag == Yii::$app->params['rejected_bill_flag'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Delete'), ['class' => 'fa fa-trash']), $url, [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ]);
                    },
                    'submit' => function ($url, $model) {
                        if ($model->verified_by_user == Yii::$app->params['verified_no'] || $model->paid_flag == Yii::$app->params['rejected_bill_flag'])
                            return Html::a(Html::tag('i', Yii::t('app', ' Submit'), ['class' => 'fa fa-thumbs-up']), $url, [
                                'class' => 'btn btn-success btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to submit this information?'),
                                    'method' => 'post',
                                ],
                            ]);
                    },
                ],],
        ],
    ]); ?>
</div>
