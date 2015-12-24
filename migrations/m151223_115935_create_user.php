<?php

use yii\db\Schema;
use yii\db\Migration;

class m151223_115935_create_user extends Migration {

	var $tableName = 'user';

	public function safeUp() {
		$this->createTable($this->tableName, [
			'id'           => $this->primaryKey() . ' COMMENT "Уникальный идентификатор пользователя"',
			'username'     => Schema::TYPE_STRING . '(255) NOT NULL COMMENT "Имя (логин) пользователя"',
			'password'     => Schema::TYPE_STRING . '(60) NOT NULL COMMENT "Пароль"',
			'email'        => Schema::TYPE_STRING . '(255) NOT NULL COMMENT "Email"',
			'auth_key'     => Schema::TYPE_STRING . '(50) NOT NULL COMMENT "Ключ безопасности"',
			'create_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-врем создания записи"',
			'update_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-врем обновления записи"',
		], 'COMMENT "Пользователи"');

		$this->createIndex('ix-' . $this->tableName . '[create_stamp]', $this->tableName, ['create_stamp']);
		$this->createIndex('ux-' . $this->tableName . '[email]', $this->tableName, ['email'], true);
	}

	public function safeDown() {
		$this->dropTable($this->tableName);
	}
}
