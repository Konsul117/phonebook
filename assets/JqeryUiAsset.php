<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset для плагина jquery-ui
 */
class JqeryUiAsset extends AssetBundle {

	public $sourcePath = '@bower/jquery-ui';

	public $js = [
		'jquery-ui.js',
	];

	public $css = [
		'themes/base/all.css',
	];

}