<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset для плагина Jquery.inputmask
 */
class JqueryInputMaskAsset extends AssetBundle {

	public $sourcePath = '@bower/jquery.inputmask';

	public $js = [
		'dist/jquery.inputmask.bundle.min.js',
	];

}