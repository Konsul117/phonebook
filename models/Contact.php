<?php

namespace app\models;

use app\components\TimestampUTCBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "contact".
 *
 * @property integer     $id            Уникальный идентификатор контакта
 * @property integer     $author_id     Автор
 * @property string      $name          Имя
 * @property string      $surname       Фамилия
 * @property string      $phone         Телефон
 * @property string      $city_guid     Guid города по ФИАС
 * @property string      $street_guid   Guid улицы по ФИАС
 * @property integer     $created_at    Дата-время создания записи
 * @property integer     $updated_at    Дата-время обновления записи
 *
 * @property User        $author
 * @property string      $authorName
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
			[['name', 'phone'], 'required', 'message' => 'Поле не заполнено'],
			['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{4}$/', 'message' => 'Телефон должен быть в формате +7 (xxx) xxx-xxxx'],
		];
	}

	public function scenarios() {
		return [
			static::SCENARIO_ADD_CONTACT => ['name', 'surname', 'phone', 'city_guid', 'street_guid'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'author_id'   => 'Владелец',
			'name'        => 'Имя',
			'surname'     => 'Фамилия',
			'phone'       => 'Телефон',
			'cityTitle'   => 'Город',
			'streetTitle' => 'Улица',
			'created'     => 'Создано',
			'updated'     => 'Обновлено',
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

	public function getAuthor() {
		return $this->hasOne(User::class, ['id' => 'author_id']);
	}

	public function getAuthorName() {
		return $this->author->username;
	}

	/**
	 * @return ActiveQuery
	 */
	public function getCity() {
		return $this->hasOne(FiasAddrobj::class, ['aoguid' => 'city_guid']);
	}

	public function getCityTitle() {
		$cityModel = $this->city;

		if ($cityModel !== null) {
			return $cityModel->formalname;
		}

		return '';
	}

	public function getStreet() {
		return $this->hasOne(FiasAddrobj::class, ['aoguid' => 'street_guid']);
	}

	public function getStreetTitle() {
		$streetModel = $this->street;

		if ($streetModel !== null) {
			return $streetModel->formalname;
		}

		return '';
	}

}
