<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;

class UserController extends \yii\web\Controller {

	public function behaviors() {
		return [
			'access' => [
				'class'	 => AccessControl::className(),
				'only'	 => ['logout'],
				'rules'	 => [
					[
						'actions'	 => ['logout'],
						'allow'		 => true,
						'roles'		 => ['@'],
					],
				],
			],
			'verbs'	 => [
				'class'		 => VerbFilter::className(),
				'actions'	 => [
					'logout' => ['post'],
				],
			],
		];
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {
		$this->view->title = 'Вход';
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goHome();
		} else {
			return $this->render('login', [
						'model' => $model,
			]);
		}
	}
	
	public function actionRegister() {
		$this->view->title = 'Регистрация';
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		
		$model = new RegisterForm();
		
		if ($model->load(Yii::$app->request->post())) {
			if($user = $model->register()) {
				Yii::$app->user->login($user);
				
				return $this->goHome();
			}
		}
		
		return $this->render('register', [
			'model' => $model,
		]);
	}

	public function actionLogout() {
		if (!\Yii::$app->user->isGuest) {
			Yii::$app->user->logout();
		}

		return $this->goHome();
	}

}
