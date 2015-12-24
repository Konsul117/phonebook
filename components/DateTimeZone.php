<?php

namespace app\components;

use DateTime;
use yii\base\InvalidParamException;

/**
 * Расширение стандартного класса временных зон DateTimeZone
 */
class DateTimeZone extends \DateTimeZone {

	/**
	 * Получение объекта временной зоны DateTimeZone по смещению gmt
	 *
	 * @param int    $utcOffset            смещение временной зоны от UTC
	 * @param string $countryIsoCode ISO код страны
	 *
	 * @return DateTimeZone
	 * @throws InvalidParamException
	 */
	public static function getTimezoneByUtcOffset($utcOffset, $countryIsoCode = 'RU') {
		$utcOffset = (int) $utcOffset;
		if (0 === $utcOffset) {
			return new DateTimeZone('UTC');
		}

		if ($countryIsoCode !== null) {
			$timezoneIdentifiers = timezone_identifiers_list(DateTimeZone::PER_COUNTRY, 'RU');
		}
		else {
			$timezoneIdentifiers = timezone_identifiers_list();
		}

		foreach ($timezoneIdentifiers as $timezoneIdentifier) {
			$dateTimeZone = new static($timezoneIdentifier);
			$dateTime     = new DateTime('now', $dateTimeZone);

			if ($dateTimeZone->getOffset($dateTime) === $utcOffset * 3600) {
				return $dateTimeZone;
			}
		}

		throw new InvalidParamException('Не удалось найти временную зону по gmt = ' . $utcOffset);
	}

}