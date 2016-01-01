<?php

namespace app\components;

use app\models\User as UserModel;

class User extends \yii\web\User implements \yii\web\IdentityInterface {
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return UserModel::findOne(['id' => $id/*, 'status' => self::STATUS_ACTIVE*/]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		//@TODO: сделать идентификацию по токену
//		foreach (self::$users as $user) {
//			if ($user['accessToken'] === $token) {
//				return new UserModel($user);
//			}
//		}

		return null;
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
		return $this->authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->authKey === $authKey;
	}
}
