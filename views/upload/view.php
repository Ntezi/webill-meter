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

    <?php if ($model->verified_by_user == Yii::$app->params['verified_no']) : ?>
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('app', ' Submit'), ['submit', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => Yii::t('app', '\'Are you sure you want to submit this information?'),
                    'method' => 'post',
                ],
            ]); ?>
        </p>
    <?php endif; ?>

    <div class="col-md-8 col-lg-8">
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
    <?php if (!$model->isNewRecord && !empty($check_bill)): ?>

        <div class="col-md-4 col-lg-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <span class="badge">
                        <?php echo ($check_bill['qr_code_check'] === 'ok') ? '<i class="fa fa-thumbs-up"></i>' : '<i class="fa fa-thumbs-down"></i>'; ?>
                    </span>
                    <?= Yii::t('app', 'QR Code Check') ?>
                </li>
                <li class="list-group-item">
                    <span class="badge">
                        <?php echo ($check_bill['location_check'] === 'ok') ? '<i class="fa fa-thumbs-up"></i>' : '<i class="fa fa-thumbs-down"></i>'; ?>
                    </span>
                    <?= Yii::t('app', 'Location Check') ?>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>
