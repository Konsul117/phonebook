<?php

namespace app\components;

use yii\base\InvalidParamException;
use yii\rbac\ManagerInterface;
use yii\rbac\Role;

/**
 * Хелпер для работы с ACL RBAC
 */
class AclHelper {

	const ROLE_ADMIN  = 'admin';
	const ROLE_AUTHOR = 'author';

	const PERMISSION_CREATE_POST     = 'createPost';
	const PERMISSION_UPDATE_POST     = 'updatePost';
	const PERMISSION_DELETE_POST     = 'deletePost';
	const PERMISSION_VIEW_POST       = 'viewPost';
	const PERMISSION_UPDATE_OWN_POST = 'updateOwnPost';
	const PERMISSION_DELETE_OWN_POST = 'deleteOwnPost';
	const PERMISSION_VIEW_OWN_POST   = 'viewOwnPost';

	/**
	 * Получить объект роли
	 *
	 * @param string $roleId Идентификатор роли
	 * @return Role Объект роли
	 * @throws InvalidParamException
	 */
	public function getRole($roleId) {
		/** @var ManagerInterface $authManager */
		$authManager = Yii::$app->authManager;

		$role = $authManager->getRole($roleId);

		if ($role === null) {
			throw new InvalidParamException('Роль для ' . $roleId . ' не удалось инициализировать');
		}

		return $role;
	}

}