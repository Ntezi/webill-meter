<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bill */


$this->title = Yii::t('app', 'Invoice No. ') . $model->id;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="panel-body">
        <strong>Time:</strong> <?php echo date("Y-m-d H:i:s") ?><br>
        <strong>Previous reading:</strong> <?php echo $model->previous_reading ?> m3<br>
        <strong>Current reading:</strong> <?php echo $model->current_reading ?> m3<br>
        <strong>Total amount:</strong> <?php echo $model->total_amount ?> ¥ <br>
        <strong>Due Date:</strong> <?php echo $model->deadline ?><br>
    </div>
</div>