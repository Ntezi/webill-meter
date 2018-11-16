<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@app/dist/sb-admin-2';
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'vendor/font-awesome/css/font-awesome.min.css',
        'dist/css/sb-admin-2.css',
    ];
    public $js = [
        'vendor/jquery/jquery.min.js',
        'vendor/bootstrap/js/bootstrap.min.js',
        'vendor/metisMenu/metisMenu.min.js',
        'dist/js/sb-admin-2.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
