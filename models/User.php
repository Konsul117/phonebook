<?php

namespace app\models;

use app\components\TimestampUTCBehavior;
use app\events\UserEvent;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель пользователей
 *
 * @property string $id               Уникальный идентификатор пользователя
 * @property string $username         Имя (логин) пользователя
 * @property string $password         Пароль
 * @property string $email            Email
 * @property string $auth_key         Ключ безопасности
 * @property string $create_stamp     Дата-врем создания записи
 * @property string $update_stamp     Дата-врем обновления записи
 */
class User extends ActiveRecord implements IdentityInterface {

	/** @var string Событие удаления пользователя */
	const EVENT_USER_DELETE = 'eventUserDelete';

	public $password_repeat;

	public function rules() {
		return [
			[['username', 'password', 'email'], 'required'],
			[['email'], 'email'],
		];
	}

	/**
	 * @return array
	 */
	public function behaviors() {
		return [
			[
				'class'				 => TimestampUTCBehavior::className(),
				'createdAtAttribute' => 'create_stamp',
				'updatedAtAttribute' => 'update_stamp',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne(['id' => $id/* , 'status' => self::STATUS_ACTIVE */]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		//@TODO: реализовать идентификацию по токену
//		foreach (self::$users as $user) {
//			if ($user['accessToken'] === $token) {
//				return new static($user);
//			}
//		}

		return null;
	}

	public static function findByUsername($username) {
		return static::findOne(['username' => $username]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->auth_key === $authKey;
	}

	public function generateAuthKey() {
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Validates password
	 *
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		return Yii::$app->security->validatePassword($password, $this->password);
	}

	public function setPassword($password) {
		$this->password = Yii::$app->security->generatePasswordHash($password);
	}

	public function beforeDelete() {
		if (parent::beforeDelete()) {

			//при удалении пользователя вызываем событие

			$this->trigger(static::EVENT_USER_DELETE, (new UserEvent(['user' => $this])));

			return true;
		}

		return false;
	}

}
