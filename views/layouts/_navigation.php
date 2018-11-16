<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 2/10/18
 * Time: 6:57 PM
 */

use yii\helpers\Url;

?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo Yii::$app->request->baseUrl; ?>/">

            <?php echo Yii::$app->name ?>
        </a>

    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo Yii::$app->user->identity->email ?>
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#">
                        <a href="<?php echo Url::to(['user/update', 'id' => Yii::$app->user->identity->id]); ?>">
                            <i class="fa fa-user fa-fw"></i> <?php echo Yii::t('app', 'Profile') ?> </a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo Yii::$app->request->baseUrl; ?>/site/logout" data-method="post">
                        <i class="fa fa-sign-out fa-fw"></i> <?php echo Yii::t('app', 'Logout') ?> </a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="<?php echo preg_match('/site/', $this->context->route, $matched) ? 'active' : '' ?>">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/"><i class="fa fa-dashboard fa-fw"></i>
                        <?php echo Yii::t('app', 'Dashboard') ?></a>
                </li>
                <?php if (Yii::$app->user->identity->role == Yii::$app->params['admin_role']): ?>

                    <li class="<?php echo preg_match('/consumer/', $this->context->route, $matched) ? 'active' : '' ?>">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/consumer/"><i class="fa fa-user fa-fw"></i>
                            <?php echo Yii::t('app', 'Consumers') ?></a>
                    </li>
                    <li class="<?php echo preg_match('/address/', $this->context->route, $matched) ? 'active' : '' ?>">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/address/"><i
                                    class="fa fa-location-arrow fa-fw"></i>
                            <?php echo Yii::t('app', 'Addresses') ?></a>
                    </li>
                    <li class="<?php echo preg_match('/meter/', $this->context->route, $matched) ? 'active' : '' ?>">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/meter/"><i class="fa fa-clock-o fa-fw"></i>
                            <?php echo Yii::t('app', 'Meters') ?></a>
                    </li>
                <?php endif; ?>

                <?php if (Yii::$app->user->identity->role == Yii::$app->params['consumer_role']): ?>
                    <li class="<?php echo preg_match('/upload/', $this->context->route, $matched) ? 'active' : '' ?>">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/upload"><i class="fa fa-upload fa-fw"></i>
                            <?php echo Yii::t('app', 'Upload') ?></a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
