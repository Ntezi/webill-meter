<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/16/18
 * Time: 4:30 PM
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="row">
    <div class="col-lg-12">
        <h3>Pending Submissions</h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'label' => 'QR Code',
                    'format' => 'html',
                    'value' => function ($model) {

                        return Html::img($model->getImagePath(), ['width' => '60px']);
                    },
                ],
                [
                    'label' => 'Consumer',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->getConsumerEmail(), ['consumer/view', 'id' => $model->user_id]);
                    },
                ],
//            'bill_info_id',
                'previous_reading',
                'current_reading',
                //'image_path',
                //'bill_file_path',
                'total_amount',
//            'verified_by_user',
//            'verified_by_admin',
//                'created_at',
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
                    'template' => '{check} {approve} {reject}',
                    'buttons' => [

                        'check' => function ($url, $model) {
                            return Html::a(Html::tag('i', Yii::t('app', ' Check'), ['class' => 'fa fa-eye']), ['bill/index', 'id' => $model->id],
                                ['class' => 'btn btn-primary btn-xs']);
                        },
                        'approve' => function ($url, $model) {
                            return Html::a(Html::tag('i', Yii::t('app', ' Approve'), ['class' => 'fa fa-thumbs-up']), ['bill/approve', 'id' => $model->id], [
                                'class' => 'btn btn-success btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to approve this bill information?'),
                                    'method' => 'post',
                                ],
                            ]);
                        },
                        'reject' => function ($url, $model) {
                            return Html::a(Html::tag('i', Yii::t('app', ' Reject'), ['class' => 'fa fa-trash']), ['bill/reject', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => Yii::t('app', '\'Are you sure you want to reject this bill?'),
                                    'method' => 'post',
                                ],
                            ]);
                        },

                    ],
                ],
            ],
        ]); ?>
    </div>
</div>

