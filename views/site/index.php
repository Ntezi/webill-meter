<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo Yii::t('app', 'Dashboard') ?></h1>
    </div>
    <div class="col-lg-12">
        <?php if (Yii::$app->user->identity->role == Yii::$app->params['admin_role']): ?>
            <?= $this->render('_admin_dashboard', [
                'dataProvider' => $dataProvider,
            ]); ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->identity->role == Yii::$app->params['consumer_role']): ?>
            <?= $this->render('_consumer_dashboard', [
                'dataProvider' => $dataProvider,
            ]); ?>
        <?php endif; ?>
    </div>
</div>
