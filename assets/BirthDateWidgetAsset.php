<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset для виджета даты рождения
 */
class BirthDateWidgetAsset extends AssetBundle {

	public $basePath = '@webroot';

	public $baseUrl = '@web';

	public $js = [
		'js/widgets/birth-date-widget.js',
	];

}