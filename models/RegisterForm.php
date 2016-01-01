<?php

namespace app\models;

use app\components\AclHelper;
use Yii;
use yii\base\Model;

/**
 * Модель формы регистрации пользователя
 */
class RegisterForm extends Model {

	/**
	 * Имя пользователя
	 * @var string
	 */
	public $username;

	/**
	 * Пароль
	 * @var string
	 */
	public $password;

	/**
	 * Подтверждение пароля
	 * @var string
	 */
	public $passwordRepeat;

	/**
	 * E-mail
	 * @var string
	 */
	public $email;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['username', 'password', 'passwordRepeat', 'email'], 'required'],
			[['email', 'username'], 'unique', 'targetClass' => User::className()],
			['password', 'compare', 'compareAttribute' => 'passwordRepeat', 'message' => 'Пароль и подтверждение должны совпадать'],
			['email', 'email'],
			[['username', 'password'], 'required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'username'       => 'Имя пользователя',
			'password'       => 'Пароль',
			'passwordRepeat' => 'Подтверждение пароля',
			'email'          => 'E-mail',
		];
	}

	/**
	 * Регистрация пользователя
	 * @return User|bool
	 */
	public function register() {
		if ($this->validate()) {
			$user = new User();
			$user->username	 = $this->username;
			$user->email	 = $this->email;
			$user->setPassword($this->password);
			$user->generateAuthKey();
			
			if ($user->save()) {
				$auth					 = Yii::$app->authManager;
				$authorRole = $auth->getRole(AclHelper::ROLE_AUTHOR);
				$auth->assign($authorRole, $user->id);
				
				return $user;
			}
			
		}
		
		return false;
	}
	
}
