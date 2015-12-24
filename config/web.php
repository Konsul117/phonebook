<?php

use yii\rbac\DbManager;

$params = require(__DIR__ . '/params.php');

$config = [
	'id'			 => 'basic',
	'basePath'		 => dirname(__DIR__),
	'bootstrap'		 => ['log'],
	'components'	 => [
		'request'		 => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'sdfsdfgdghfh',
		],
//		'cache'			 => [
//			'class' => 'yii\caching\FileCache',
//		],
		'user'			 => [
			'identityClass'		 => 'app\models\User',
			'enableAutoLogin'	 => true,
			'loginUrl'			 => ['user/login'],
		],
		'errorHandler'	 => [
			'errorAction' => 'site/error',
		],
		'mailer'		 => [
			'class'				 => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport'	 => true,
		],
		'log'			 => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'	 => [
				[
					'class'	 => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db'			 => require(__DIR__ . '/db.php'),
		'urlManager'	 => [
			'enablePrettyUrl'	 => true,
			'showScriptName'	 => false,
			'rules'				 => [
				'login'													 => 'user/login',
				'<controller>/<id:\d+>/<action:(create|update|delete)>'	 => '<controller>/<action>',
				'<controller>/<id:\d+>'									 => '<controller>/view',
				'<controller>'											 => '<controller>/index',
			],
		],
		'authManager' => [
			'class'           => DbManager::class,
			'itemTable'       => 'acl_role',
			'itemChildTable'  => 'acl_role_child',
			'assignmentTable' => 'acl_assignment',
			'ruleTable'       => 'acl_rule',
		],
		'assetManager'	 => [
			'bundles' => require(__DIR__ . '/' . (YII_ENV_PROD ? 'assets-prod.php' : 'assets-dev.php')),
		],
	],
	'params'		 => $params,
	'defaultRoute'	 => 'contact/index',
	'language'		 => 'ru-RU', // <- here!
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][]		 = 'debug';
	$config['modules']['debug']	 = 'yii\debug\Module';

	$config['bootstrap'][]		 = 'gii';
	$config['modules']['gii']	 = 'yii\gii\Module';
}

return $config;
