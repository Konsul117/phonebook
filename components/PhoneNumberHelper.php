<?php

namespace app\components;

use app\components\validators\PhoneValidator;

/**
 * Хелпер для работы с номерами телефонов
 */
class PhoneNumberHelper {

	/**
	 * Форматирование номера телефона для вывода во фронтэнд
	 * @param string $phoneNumber
	 * @return string
	 */
	public static function formatPhoneFrontend($phoneNumber) {
		if ((new PhoneValidator())->validateValue($phoneNumber) !== null) {
			return '';
		}

		return '+' . mb_substr($phoneNumber, 0, 1) . ' (' . mb_substr($phoneNumber, 1, 3) . ') ' . mb_substr($phoneNumber, 4, 3) . ' ' . mb_substr($phoneNumber, 7, 4);
	}

	/**
	 * Очистка номера телефона от нечисловых символов для хранения в БД и пр.
	 * @param $phoneNumber
	 * @return mixed
	 */
	public static function stripPhoneNumber($phoneNumber) {
		return preg_replace('/[^0-9]/', '', $phoneNumber);
	}

}