<?php

use yii\db\Schema;
use yii\db\Migration;

class m151223_114802_create_contact extends Migration {

	var $tableName = 'contact';

	public function safeUp() {
		$this->createTable($this->tableName, [
			'id'           => $this->primaryKey() . ' COMMENT "Уникальный идентификатор контакта"',
			'author_id'    => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Автор"',
			'name'         => Schema::TYPE_STRING . ' NOT NULL COMMENT "Имя"',
			'surname'      => Schema::TYPE_STRING . ' NOT NULL COMMENT "Фамилия"',
			'phone'        => Schema::TYPE_STRING . '(20) NOT NULL COMMENT "Телефон"',
			'city_guid'    => Schema::TYPE_STRING . ' NOT NULL COMMENT "Guid города по ФИАС"',
			'street_guid'  => Schema::TYPE_STRING . ' NOT NULL COMMENT "Guid улицы по ФИАС"',
			'create_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время создания записи"',
			'update_stamp' => Schema::TYPE_DATETIME . ' NOT NULL COMMENT "Дата-время обновления записи"',
		], 'COMMENT "Контакты"');

		$this->createIndex('ix-' . $this->tableName . '[author_id]', $this->tableName, ['author_id']);
		$this->createIndex('ix-' . $this->tableName . '[create_stamp]', $this->tableName, ['create_stamp']);
	}

	public function safeDown() {
		$this->dropTable($this->tableName);
	}
}
