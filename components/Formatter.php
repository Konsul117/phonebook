<?php

namespace app\components;

use \DateTime;

class Formatter extends \yii\i18n\Formatter {

	public function aslocalDate($value, $format = null) {
		if ($format === null) {
			$format = $this->dateFormat;
		}

		return (new DateTime($value, new DateTimeZone('UTC')))
			->setTimezone(DateTimeZone::getTimezoneByUtcOffset(10))
			->format($format);
	}

}