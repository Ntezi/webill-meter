<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php if (!empty($address)) : ?>
        <?php echo Html::a(Yii::t('app', 'Remove Meter'), ['remove', 'id' => $model->id], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to remove the meter?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php endif; ?>

        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'role',
        ],
    ]) ?>

</div>
