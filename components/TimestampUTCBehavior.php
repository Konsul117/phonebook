<?php

namespace app\components;

use \DateTime;
use \DateTimeZone;
use yii\behaviors\TimestampBehavior;

/**
 * Поведение моделей для автоматического указания stamp создания/обновления записи. Все даты-время пишутся в таймзоне UTC
 */
class TimestampUTCBehavior extends TimestampBehavior {

	/**
	 * @inheritdoc
	 */
	protected function getValue($event) {
		$datetime = new DateTime('now', new DateTimeZone('UTC'));
		return $datetime->format('Y-m-d H:i:s');
	}
}