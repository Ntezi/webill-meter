<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Bill */

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
        </p>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'user_id',
//            'bill_info_id',
            'previous_reading',
            'current_reading',
            'image_file',
            'bill_file_path',
            'total_amount',
            'verified_by_user',
            'verified_by_admin',
//            'created_at',
//            'created_by',
//            'updated_by',
//            'updated_at',
            'deadline',
            'paid_flag',
        ],
    ]) ?>

</div>
