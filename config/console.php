<?php

use yii\rbac\DbManager;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
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
        'db' => $db,
        'authManager' => [
	        'class'           => DbManager::class,
	        'itemTable'       => 'acl_role',
	        'itemChildTable'  => 'acl_role_child',
	        'assignmentTable' => 'acl_assignment',
	        'ruleTable'       => 'acl_rule',
        ],
    ],
    'params' => $params,
];
