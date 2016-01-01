<?php
use app\rbac\DbManager;

return [
	'bootstrap' => ['log', 'authManager'],
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => require(__DIR__ . '/db.php'),
		'authManager' => [
			'class'           => DbManager::class,
			//	        'class'           => 'qwe\asd',
			'itemTable'       => 'acl_role',
			'itemChildTable'  => 'acl_role_child',
			'assignmentTable' => 'acl_assignment',
			'ruleTable'       => 'acl_rule',
		],
	]
];