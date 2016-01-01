<?php

namespace app\components;

class AjaxResponse {

	/**
	 * Данные
	 * @var array
	 */
	public $data;

	/**
	 * Успешность запроса
	 * @var boolean
	 */
	public $success;

	/**
	 * Ошибки
	 * @var string[]
	 */
	public $errors = [];

	/**
	 * Html-контент
	 * @var string
	 */
	public $html;


}