<?php

namespace app\components;

use \DateTime;

class Formatter extends \yii\i18n\Formatter {

	/**
	 * Вывод даты, времени в локальном формате
	 * @param      $value
	 * @param null $format
	 * @return string
	 */
	public function asLocalDateTime($value, $format = null) {
		if ($format === null) {
			$format = $this->dateFormat;
		}

		if ($value === null) {
			return '';
		}

		return (new DateTime($value, new DateTimeZone('UTC')))
			->setTimezone(DateTimeZone::getTimezoneByUtcOffset(10))
			->format($format);
	}

	/**
	 * Вывод даты в локальном формате
	 * @param      $value
	 * @param null $format
	 * @return string
	 */
	public function asLocalDate($value, $format = null) {
		if ($format === null) {
			$format = 'd.m.Y';
		}

		if ($value === null) {
			return '';
		}

		return (new DateTime($value, new DateTimeZone('UTC')))
			->setTimezone(DateTimeZone::getTimezoneByUtcOffset(10))
			->format($format);
	}

	/**
	 * Вывод номера телефона в удобочитаемом виде
	 * @param string $value номер телефона
	 * @return string
	 */
	public function asPhoneVisual($value) {
		return PhoneNumberHelper::formatPhoneFrontend($value);
	}

}