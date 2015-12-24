<?php

namespace app\models;

use app\components\TimestampUTCBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string  $name
 * @property string  $surname
 * @property string  $phone
 * @property string  $address
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User    $author
 * @property string  $authorName
 */
class Contact extends \yii\db\ActiveRecord {
	
	var $username;

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
			[['name', 'surname', 'address'], 'string', 'max' => 100, 'message' => 'Длина не более 100 символов'],
			[['name', 'address', 'phone'], 'required', 'message' => 'Поле не заполнено'],
			['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{4}$/', 'message' => 'Телефон должен быть в формате +7 (xxx) xxx-xxxx'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'username'	 => 'Владелец',
			'name'		 => 'Имя',
			'surname'	 => 'Фамилия',
			'phone'		 => 'Телефон',
			'address'	 => 'Адрес',
			'created'	 => 'Создано',
			'updated'	 => 'Обновлено',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			[
				'class'				 => TimestampUTCBehavior::className(),
				'createdAtAttribute' => 'create_stamp',
				'updatedAtAttribute' => 'update_stamp',
			],
			[
				'class'				 => BlameableBehavior::className(),
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

}
