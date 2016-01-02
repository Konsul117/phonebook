<?php

namespace app\widgets;

use app\assets\BirthDateWidgetAsset;
use app\components\Widget;
use DateTime;
use IntlDateFormatter;
use Yii;
use yii\widgets\ActiveField;

/**
 * Виджет для даты рождения
 */
class BirthDateWidget extends Widget {

	/**
	 * Id элемента, к которому относится виджет
	 * @var string
	 */
	public $id;

	/**
	 * Поле даты рождения
	 * @var ActiveField
	 */
	public $field;

	/**
	 * Минимальный год рождения
	 * @var int
	 */
	public $minYear = 1900;

	/**
	 * @inheritdoc
	 */
	public function run() {
		$id = $this->id;

		$view = $this->getView();

		//регистрируем asset
		BirthDateWidgetAsset::register($view);
		$view->registerJs("jQuery('#$id').birthDateWidget();");

		$currYear = (int) date('Y');

		//вычисляем наборы годов, месяцев, дней
		$years = [];

		for($iYear = $this->minYear; $iYear <= $currYear; $iYear++) {
			$years[$iYear] = $iYear;
		}

		$date = new DateTime('now');

		$formatter = new IntlDateFormatter("ru_RU", IntlDateFormatter::FULL, IntlDateFormatter::FULL);
		$formatter->setPattern('MMMM');

		$months = [];

		for($i = 1; $i <= 12; $i++) {
			$months[$i] = $formatter->format($date->setDate($currYear, $i, 1));
		}

		$days = [];

		for($i = 1; $i <= 31; $i++) {
			$days[$i] = $i;
		}

		//получаем текущую дату и делим её на элементы
		$currentDate = $this->field->model->{$this->field->attribute};

		$elCurrentDate = explode('-', $currentDate);

		$currentYear  = 0;
		$currentMonth = 0;
		$currentDay   = 0;

		if (count($elCurrentDate) >= 3) {
			$currentYear  = $elCurrentDate[0];
			$currentMonth = $elCurrentDate[1];
			$currentDay   = $elCurrentDate[2];
		}

		return $this->render('birth-date-widget', [
			'id'           => $id,
			'field'        => $this->field,
			'years'        => $years,
			'months'       => $months,
			'days'         => $days,
			'currentYear'  => (int) $currentYear,
			'currentMonth' => (int) $currentMonth,
			'currentDay'   => (int) $currentDay,
		]);
	}

}