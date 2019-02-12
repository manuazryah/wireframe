<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
        'css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/_all-skins.min.css',
        'css/bootstrap3-wysihtml5.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        'css/custom.css',
    ];
    public $js = [
//        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/jquery.slimscroll.min.js',
        'js/Chart.js',
        'js/fastclick.js',
        'js/adminlte.min.js',
        'js/ckeditor.js',
        'js/bootstrap3-wysihtml5.all.min.js',
        'js/jquery.inputmask.js',
        'js/jquery.inputmask.date.extensions.js',
        'js/demo.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
