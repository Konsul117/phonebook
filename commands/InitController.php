<?php

namespace app\commands;

use app\components\AclHelper;
use app\models\User;
use app\rbac\AuthorRule;
use Yii;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\db\Migration;
use yii\helpers\Console;
use yii\rbac\ManagerInterface;

/**
 * Первичная установка приложения
 */
class InitController extends Controller {

	protected $rbacMigrationPath  = '@yii/rbac/migrations/';
	protected $rbacMigrationClass = 'm140506_102106_rbac_init';

	protected $appMigrations = [
		'm151223_114802_create_contact',
		'm151223_115935_create_user',
	];

	/**
	 * Установка
	 */
	public function actionInstall() {
		$this->stdout('Создаём структуру таблц приложения' . PHP_EOL, Console::FG_GREEN);

		foreach ($this->appMigrations as $mItem) {
			$this->getMigration('@app/migrations/', $mItem)->up();
		}

		$this->stdout('Создаём структуру таблц ACL' . PHP_EOL, Console::FG_GREEN);
		$this->getMigration($this->rbacMigrationPath, $this->rbacMigrationClass)->up();

		$this->stdout('Инициализируем ACL' . PHP_EOL, Console::FG_GREEN);
		$this->aclInit();

	}

	/**
	 * Удаление
	 */
	public function actionUninstall() {
		$this->stdout('Удаляем структуру таблц приложения' . PHP_EOL, Console::FG_GREEN);

		foreach ($this->appMigrations as $mItem) {
			$this->getMigration('@app/migrations/', $mItem)->down();
		}

		$this->stdout('Удаляем структуру таблц ACL' . PHP_EOL, Console::FG_GREEN);
		$this->getMigration($this->rbacMigrationPath, $this->rbacMigrationClass)->down();
	}

	/**
	 * Инициализация acl-данных
	 */
	protected function aclInit() {
		/** @var ManagerInterface $auth */
		$auth = Yii::$app->authManager;

		//Создание прав
		$createPostPermission              = $auth->createPermission(AclHelper::PERMISSION_CREATE_POST);
		$createPostPermission->description = 'Создание контакта';
		$auth->add($createPostPermission);

		$updatePostPermission              = $auth->createPermission(AclHelper::PERMISSION_UPDATE_POST);
		$updatePostPermission->description = 'Обновление контакта';
		$auth->add($updatePostPermission);

		$deletePostPermission              = $auth->createPermission(AclHelper::PERMISSION_DELETE_POST);
		$deletePostPermission->description = 'Удаление контакта';
		$auth->add($deletePostPermission);

		$viewPostPermission              = $auth->createPermission(AclHelper::PERMISSION_VIEW_POST);
		$viewPostPermission->description = 'Просмотр контакта';
		$auth->add($viewPostPermission);

		$authorRole = $auth->createRole(AclHelper::ROLE_AUTHOR);
//		$authorRole->name = 'Автор';
		$auth->add($authorRole);
		$auth->addChild($authorRole, $createPostPermission);
		// add "admin" role and give this role the "updatePost" permission
		// as well as the permissions of the "author" role
		$adminRole = $auth->createRole(AclHelper::ROLE_ADMIN);
//		$adminRole->name = 'Админ';
		$auth->add($adminRole);
		$auth->addChild($adminRole, $viewPostPermission);
		$auth->addChild($adminRole, $updatePostPermission);
		$auth->addChild($adminRole, $deletePostPermission);
		$auth->addChild($adminRole, $authorRole);

		// Assign roles to users. 1 and 2 are IDs returned byIdentityInterface::getId()
		// usually implemented in your User model.
//		$auth->assign($authorRole, 2);
//		$auth->assign($adminRole, 1);

		//		$authorRole = $auth->getRole('author');
		//		$auth->assign($authorRole, Yii::$app->get('user', false)->id);
		//		$user = User::findIdentity(101);
		// add the rule
		$rule = new AuthorRule;
		$auth->add($rule);
		// add the "updateOwnPost" permission and associate the rule with it.
		$updateOwnPostPermission              = $auth->createPermission(AclHelper::PERMISSION_UPDATE_OWN_POST);
		$updateOwnPostPermission->description = 'Обновление своей записи';
		$updateOwnPostPermission->ruleName    = $rule->name;
		$auth->add($updateOwnPostPermission);

		$auth->addChild($updateOwnPostPermission, $updatePostPermission);
		//разрешить автору редактировать свои записи
		$auth->addChild($authorRole, $updateOwnPostPermission);

		$deleteOwnPostPermission              = $auth->createPermission(AclHelper::PERMISSION_DELETE_OWN_POST);
		$deleteOwnPostPermission->description = 'Удаление своей записи';
		$deleteOwnPostPermission->ruleName    = $rule->name;
		$auth->add($deleteOwnPostPermission);

		$auth->addChild($deleteOwnPostPermission, $deletePostPermission);
		//разрешить автору удалять свои записи
		$auth->addChild($authorRole, $deleteOwnPostPermission);

		$viewOwnPostPermission              = $auth->createPermission(AclHelper::PERMISSION_VIEW_OWN_POST);
		$viewOwnPostPermission->description = 'Просмотр своей записи';
		$viewOwnPostPermission->ruleName    = $rule->name;
		$auth->add($viewOwnPostPermission);

		$auth->addChild($viewOwnPostPermission, $viewPostPermission);
		//разрешить автору просматривать свои записи
		$auth->addChild($authorRole, $viewOwnPostPermission);
	}

	/**
	 * Создание учётной записи администратора
	 */
	public function actionCreateAdmin() {
		$this->stdout('Добавление администратора' . PHP_EOL);

		$this->stdout('Логин: ' . PHP_EOL);

		$username = Console::stdin();

		$this->stdout('E-mail: ' . PHP_EOL);

		$email = Console::stdin();

		$this->stdout('Пароль: ' . PHP_EOL);

		$password = Console::stdin();

		$user           = new User();
		$user->username = $username;
		$user->email    = $email;
		$user->setPassword($password);
		$user->generateAuthKey();

		if ($user->validate() === false) {
			$this->stdout('Ошибки при вводе данных: ' . print_r($user->getErrors(), true));

			return ;
		}

		if ($user->save()) {
			$this->stdout('Пользователь добавле' . PHP_EOL, Console::FG_GREEN);
			/** @var ManagerInterface $auth */
			$auth = Yii::$app->authManager;
			$authorRole = $auth->getRole(AclHelper::ROLE_ADMIN);
			$auth->assign($authorRole, $user->id);

			$this->stdout('Права пользователя добавлены' . PHP_EOL, Console::FG_GREEN);
		}
	}

	/**
	 * Получить объект миграции
	 *
	 * @param string $path  Путь к файлу миграции
	 * @param string $class Имя класса
	 * @return Migration объект миграции
	 */
	protected function getMigration($path, $class) {
		$file = Yii::getAlias($path . $class . '.php');

		if (file_exists($file) === false) {
			throw new InvalidParamException('Файл миграцим ' . $file . ' (путь: ' . $path . ') не существует');
		}

		require_once($file);

		if (class_exists($class) === false) {
			throw new InvalidParamException('Миграция ' . $class . ' (путь: ' . $path . ') не существует');
		}

		/** @var Migration $mirgation */
		$mirgation = new $class();

		return $mirgation;
	}

}