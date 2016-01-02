<?php

namespace app\models;

use app\components\PhoneNumberHelper;
use app\components\TimestampUTCBehavior;
use app\components\validators\GuidValidator;
use app\components\validators\NameValidator;
use app\components\validators\PhoneValidator;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id              Уникальный идентификатор контакта
 * @property integer $author_id       Автор
 * @property string  $name            Имя
 * @property string  $surname         Фамилия
 * @property string  $middle_name     Отчество
 * @property string  $birth_date      Дата рождения
 * @property string  $phone           Телефон
 * @property string  $email           E-mail
 * @property string  $city_guid       Guid города по ФИАС
 * @property string  $street_guid     Guid улицы по ФИАС
 * @property string  $house           Номер дома
 * @property string  $appartment       Квартира
 * @property integer $create_stamp    Дата-время создания записи
 * @property integer $update_stamp    Дата-время обновления записи
 *
 * @property User        $author
 * @property string      $authorName
 * @property string      $phoneFront
 *
 * Отношения:
 * @property FiasAddrobj $city          Город
 * @property string      $cityTitle     Название города
 * @property FiasAddrobj $street        Улица
 * @property string      $streetTitle   Название улицы
 */
class Contact extends \yii\db\ActiveRecord {

	var $username;

	const SCENARIO_ADD_CONTACT = 'addContact';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'contact';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['author_id'], 'integer'],
			[['name', 'surname'], 'string', 'max' => 100, 'message' => 'Длина не более 100 символов'],
			[['name', 'surname', 'middle_name'], NameValidator::class, 'message' => 'Некорректное символы'],
			[['name', 'phone'], 'required', 'message' => 'Поле не заполнено'],
			['phone', PhoneValidator::class],
			['email', 'email'],
//			['birth_date', 'date', 'format' => 'yyyy-mm-dd'],
			['birth_date', 'validateDate'],
			[['city_guid', 'street_guid'], GuidValidator::class],
		];
	}

	public function validateDate($attribute) {
		$dateEl = explode('-', $this->$attribute);

		if (count($dateEl) < 3) {
			$this->addError($attribute, 'Дата не заполнена.');
			return ;
		}

		if (checkdate((int) $dateEl[1], (int) $dateEl[2], (int) $dateEl[0]) === false) {
			$this->addError($attribute, "Указанная дата не является корректной.");
		}
	}

	public function scenarios() {
		return [
			static::SCENARIO_ADD_CONTACT => ['name', 'surname', 'middle_name', 'birth_date', 'phoneFront', 'email', 'city_guid', 'street_guid', 'house', 'appartment'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'           => 'Номер записи',
			'authorName'   => 'Владелец',
			'name'         => 'Имя',
			'surname'      => 'Фамилия',
			'middle_name'  => 'Отчество',
			'birth_date'   => 'Дата рождения',
			'phone'        => 'Телефон',
			'phoneFront'   => 'Телефон',
			'email'        => 'E-mail',
			'cityTitle'    => 'Город',
			'streetTitle'  => 'Улица',
			'house'        => 'Дом',
			'appartment'   => 'Квартира',
			'create_stamp' => 'Создано',
			'update_stamp' => 'Обновлено',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			[
				'class'              => TimestampUTCBehavior::className(),
				'createdAtAttribute' => 'create_stamp',
				'updatedAtAttribute' => 'update_stamp',
			],
			[
				'class'              => BlameableBehavior::className(),
				'createdByAttribute' => 'author_id',
				'updatedByAttribute' => null,
			],
		];
	}

	/**
	 * Автор записи
	 * @return ActiveQuery
	 */
	public function getAuthor() {
		return $this->hasOne(User::class, ['id' => 'author_id']);
	}

	/**
	 * Имя автора записи
	 * @return string
	 */
	public function getAuthorName() {
		return $this->author->username;
	}

	/**
	 * Город
	 * @return ActiveQuery
	 */
	public function getCity() {
		return $this->hasOne(FiasAddrobj::class, ['aoguid' => 'city_guid']);
	}

	/**
	 * Название города
	 * @return string
	 */
	public function getCityTitle() {
		$cityModel = $this->city;

		if ($cityModel !== null) {
			return $cityModel->formalname;
		}

		return '';
	}

	/**
	 * Улица
	 * @return ActiveQuery
	 */
	public function getStreet() {
		return $this->hasOne(FiasAddrobj::class, ['aoguid' => 'street_guid']);
	}

	/**
	 * Название улицы
	 * @return string
	 */
	public function getStreetTitle() {
		$streetModel = $this->street;

		if ($streetModel !== null) {
			return $streetModel->formalname;
		}

		return '';
	}

	/**
	 * Установка значения номера телефона для фронэнда
	 * Метод нужен для работы с формой
	 * @param $phone
	 */
	public function setPhoneFront($phone) {
		$this->phone = PhoneNumberHelper::stripPhoneNumber($phone);
	}

	/**
	 * Получение номера телефона для фронтэнда
	 * Метод нужен для работы с формой
	 * @return string
	 */
	public function getPhoneFront() {
		return PhoneNumberHelper::formatPhoneFrontend($this->phone);
	}

}
