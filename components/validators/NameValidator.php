<?php

namespace app\components\validators;
use yii\validators\RegularExpressionValidator;

/**
 * Валидатор для проверки корректности имени (фамилии, отчества)
 */
class NameValidator extends RegularExpressionValidator {
	/** @inheritdoc */
	public $pattern = '/^[а-яА-ЯёЁa-zA-Z\s]+$/u';
}