<?php
namespace app\components\validators;

use yii\validators\Validator;

/**
 * Валидатор для проверки корректности ввода номера телефона.
 */
class PhoneValidator extends Validator {

	/**
	 * @inheritdoc
	 */
	public function validateValue($value) {
		if (!preg_match('/^7[0-9]{10}$/', $value)) {
			return ['Поле "{attribute}" заполнено неверно.'];
		}

		return null;
	}
}