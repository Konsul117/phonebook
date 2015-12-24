<?php

namespace app\models;

use app\components\AclHelper;
use Yii;
use yii\base\Model;
use app\models\User;

class RegisterForm extends Model {
	
	public $username;
	public $password;
	public $password_repeat;
	public $email;

	public function rules() {
		return [
			[['username', 'password', 'password_repeat', 'email'], 'required'],
			[['email', 'username'], 'unique', 'targetClass' => User::className()],
			['password', 'compare'],
			['email', 'email'],
			[['username', 'password'], 'required'],
		];
	}

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
