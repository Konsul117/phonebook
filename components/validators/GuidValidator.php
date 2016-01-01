<?php
namespace app\components\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Валидатор для проверки значения на формат GUID.
 */
class GuidValidator extends RegularExpressionValidator {
	/** @inheritdoc */
	public $pattern = '/[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}/';
}