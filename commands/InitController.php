<?php

namespace app\commands;

use app\components\AclHelper;
use app\models\User;
use app\rbac\AuthorRule;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\db\Migration;
use yii\helpers\Console;
use yii\rbac\ManagerInterface;
use yii\web\BadRequestHttpException;

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
			$this->stdout('Пользователь добавлен' . PHP_EOL, Console::FG_GREEN);
			/** @var ManagerInterface $auth */
			$auth = Yii::$app->authManager;
			$authorRole = $auth->getRole(AclHelper::ROLE_ADMIN);
			$auth->assign($authorRole, $user->id);

			$this->stdout('Права пользователя добавлены' . PHP_EOL, Console::FG_GREEN);
		}
	}

	/**
	 * Установка ФИАС
	 * @throws BadRequestHttpException
	 * @throws ErrorException
	 * @throws \yii\db\Exception
	 */
	public function actionFias() {
		ini_set('memory_limit', '512M');

		//конфиг скачиваемых файлов
		$downloadFiles = [
			[
				//url файла
				'url' => 'http://basicdata.ru/data/fias/fias_addrobj_table.sql.bz2',
				//имя файла
				'filename' => 'fias_addrobj_table.sql.bz2',
				//имя распокованного sql-файла
				'sqlFilename' => 'fias_addrobj_table.sql',
			],
			[
				'url' => 'http://basicdata.ru/data/fias/fias_addrobj_index.sql.bz2',
				'filename' => 'fias_addrobj_index.sql.bz2',
				'sqlFilename' => 'fias_addrobj_index.sql',
			],
			[
				'url' => 'http://basicdata.ru/data/fias/fias_addrobj_data.sql.bz2',
				'filename' => 'fias_addrobj_data.sql.bz2',
				'sqlFilename' => 'fias_addrobj_data.sql',
			],
		];

		$this->stdout('Сейчас будут загружены следующие файлы: ' . PHP_EOL);

		foreach($downloadFiles as $fileRow) {
			$this->stdout($fileRow['url'] . PHP_EOL, Console::FG_GREEN);
		}

		$this->stdout('Загрузить их? [Y/n] ');

		$downloadConfirm = mb_strtolower(Console::stdin());

		$this->stdout(PHP_EOL);

		if ($downloadConfirm !== '' && $downloadConfirm !== 'y') {
			$this->stdout('Завершаем выполнение' . PHP_EOL, Console::FG_RED);
			return ;
		}

		$downloadDir = $this->getDownloadDir('fias');

		$this->stdout('Удаляем таблицу, если она есть... ');
		Yii::$app->db->createCommand('DROP TABLE IF EXISTS `d_fias_addrobj`;')->execute();
		$this->stdout('готово' . PHP_EOL);

		foreach($downloadFiles as $fileRow) {
			$this->stdout('Загружаем файл ' . $fileRow['url'] . PHP_EOL);

			$this->stdout('Размер файла: ' . number_format($this->getDownloadFileSize($fileRow['url']), 0, '.', ' ') . ' байт' . PHP_EOL);

			$this->downloadFile($fileRow['url'], $fileRow['filename'], $downloadDir);
			$this->stdout('готово' . PHP_EOL);

			$this->stdout('Распаковываем файл ' . $fileRow['filename'] . '... ');
			$this->unpackFile($downloadDir . DIRECTORY_SEPARATOR . $fileRow['filename']);
			$this->stdout('готово' . PHP_EOL);

			$this->stdout('Загружаем файл в БД... ');
			$this->loadDb($downloadDir . DIRECTORY_SEPARATOR . $fileRow['sqlFilename']);
			$this->stdout('готово' . PHP_EOL);
		}

		$this->stdout('Добавляем нужные индексы...');
		Yii::$app->db->createCommand('ALTER TABLE `d_fias_addrobj`ADD INDEX `aolevel_actstatus_formalname` (`aolevel`, `actstatus`, `formalname`);')
			->execute();
		$this->stdout('готово' . PHP_EOL);

		$this->stdout('Удаляем временный каталог...');
		exec('rm -rf ' . $downloadDir, $output, $return);
		if ($return !== 0) {
			throw new ErrorException('Ошибка при удалении временного каталога');
		}

		$this->stdout('готово' . PHP_EOL);
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

	/**
	 * Получить размер скачиваемого файла
	 * @param string $url
	 * @return int
	 * @throws BadRequestHttpException
	 */
	protected function getDownloadFileSize($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,				$url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,	true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,	5);
		curl_setopt($curl, CURLOPT_TIMEOUT,			30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,	false);

		//проверяем размер файла
		curl_setopt($curl,	CURLOPT_NOBODY, true);
		curl_setopt($curl,	CURLOPT_HEADER, true);

		$result = curl_exec($curl);

		$errNo = curl_errno($curl);

		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		if ($errNo !== 0) {
			throw new BadRequestHttpException('Ошибка curl: ' . $errNo);
		}

		if($httpCode !== 200) {
			throw new BadRequestHttpException('Ошибка при загрузке файла ' . $url . ', http code: ' . $httpCode);
		}

		if(preg_match('/Content-Length: ([0-9]+)/im',$result, $vals)) {
			return (int)$vals[1];
		}

		throw new BadRequestHttpException('Не удалось определить размер файла');
	}

	/**
	 * Скачать файл
	 * @param string $url
	 * @param string $tmpFilename
	 * @param string $saveDir
	 * @return resource
	 * @throws BadRequestHttpException
	 */
	protected function downloadFile($url, $tmpFilename, $saveDir) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,				$url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,	true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,	5);
		curl_setopt($curl, CURLOPT_TIMEOUT,			600);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION,	false);

		$fp = fopen($saveDir . DIRECTORY_SEPARATOR . $tmpFilename, 'w+');

		curl_setopt($curl, CURLOPT_FILE, $fp);

		curl_exec($curl);

		$errNo = curl_errno($curl);

		curl_close($curl);

		fclose($fp);

		if ($errNo !== 0) {
			throw new BadRequestHttpException('Ошибка curl: ' . $errNo);
		}

//		file_put_contents($saveDir . DIRECTORY_SEPARATOR . $tmpFilename, $result);

		return $curl;
	}

	protected function unpackFile($filepath) {
		$result = exec('bunzip2 -f ' . $filepath, $output, $return);

		if ($return !== 0) {
			throw new ErrorException('Ошибка выполнения команды bunzip2', $return);
		}

		return $result;
	}

	/**
	 * Загрузка sql-файла в БД
	 * @param string $filepath
	 * @return string
	 * @throws ErrorException
	 */
	protected function loadDb($filepath) {

		if (file_exists($filepath) === false) {
			throw new InvalidParamException('SQL Файл для импорта ' . $filepath . ' не существует');
		}

		$dbUsername = Yii::$app->db->username;
		$dbPassword = Yii::$app->db->password;
		$dbDatabase = null;
		if (preg_match('/dbname=([0-9a-z_-]*)/i', Yii::$app->db->dsn, $result)) {
			$dbDatabase = $result[1];

		}

		if (empty($dbUsername)) {
			throw new ErrorException('Не удалось получить имя пользователя БД');
		}

		if (empty($dbPassword)) {
			throw new ErrorException('Не удалось получить пароль пользователя БД');
		}

		if (empty($dbDatabase)) {
			throw new ErrorException('Не удалось получить имя БД');
		}

		$result = exec('mysql -u' . $dbUsername . ' -p' . $dbPassword . ' ' . $dbDatabase . ' < ' . $filepath, $output, $return);

		if ($return !== 0) {
			throw new ErrorException('Ошибка выполнения команды mysql', $return);
		}

		return $result;
	}

	/**
	 * Получить путь к каталогу для загрузки
	 * @param string $catalog имя каталога
	 * @return string
	 * @throws InvalidParamException
	 */
	protected function getDownloadDir($catalog) {
		$path = Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . $catalog;
		if (file_exists($path) === false) {
			if (is_writable(Yii::getAlias('@runtime')) === false) {
				throw new InvalidParamException('Каталог ' . $path . ' недоступен для записи');
			}

			mkdir(Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . $catalog);
		}

		return $path;
	}

}