<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 5:53 PM
 */

?>

<?php if (Yii::$app->session->getFlash("warning")): ?>
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Warning!</strong>
        <?php echo Yii::$app->session->getFlash("warning"); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->getFlash("success")): ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success!</strong>
        <?php echo Yii::$app->session->getFlash("success"); ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->getFlash("danger")): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error!</strong>
        <?php echo Yii::$app->session->getFlash("danger"); ?>
    </div>
<?php endif; ?>
