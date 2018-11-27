<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */

$this->title = Yii::t('app', 'Bill No. ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->verified_by_admin == Yii::$app->params['verified_no']) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Reject'), ['reject', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to reject this bill?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('app', ' Approve'), ['approve', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => Yii::t('app', '\'Are you sure you want to approve this information?'),
                    'method' => 'post',
                ],
            ]); ?>
        </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'image_file',
                'format'=>'html',
                'value' => function ($model) {

                    return Html::img($model->getImagePath(), ['width' => '100px']);
                },
            ],
            'previous_reading',
            'current_reading',
            'total_amount',
            'verified_by_user',
            'verified_by_admin',
            'created_at',
            'created_by',
            'updated_by',
            'updated_at',
            'deadline',
            'paid_flag',
        ],
    ]) ?>
</div>
