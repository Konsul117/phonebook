<?php

namespace app\events;

use app\models\User;
use yii\base\Event;

class UserEvent extends Event {

	/**
	 * @var User
	 */
	public $user;
}