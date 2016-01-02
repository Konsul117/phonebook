<?php

namespace app\components;

use Yii;

/**
 * Переопределение класса виджетов для получения свеого пути к каталогу с шаблонами для виджетов
 */
class Widget extends \yii\base\Widget {

	/**
	 * @inheritdoc
	 */
	public function getViewPath() {
		return Yii::getAlias('@app/views/widgets');
	}
}