<?php

namespace app\assets;

use yii\web\AssetBundle;

class MyAsset extends AssetBundle {
	
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/my.css',
        'css/my2.css',
    ];
    public $js = [
		'js/my.js',
		'js/jquery.maskedinput.min.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
