<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class PhoneAsset extends AssetBundle {
	
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/phone.css',
    ];
    public $js = [
		'js/base_init.js',
		'js/contact_form.js',
		'js/input_indicator.js',
		'js/jquery.maskedinput.min.js',
    ];
    public $depends = [
	    JqueryAsset::class,
	    JqeryUiAsset::class,
    ];
}
