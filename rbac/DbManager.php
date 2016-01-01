<?php

namespace app\rbac;

use app\events\UserEvent;
use app\models\User;
use yii\base\Event;

class DbManager extends \yii\rbac\DbManager {

	public function init() {
		parent::init();

		//вешаем на событие удаления пользователя удаление всех его назначений в acl
		Event::on(User::class, User::EVENT_USER_DELETE, function(UserEvent $event) {
			return $this->revokeAll($event->user->id);
		});
	}

}