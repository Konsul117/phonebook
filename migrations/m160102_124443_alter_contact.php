<?php

use yii\db\Schema;
use yii\db\Migration;

class m160102_124443_alter_contact extends Migration {

	var $tableName = 'contact';

	public function safeUp() {
		$this->addColumn($this->tableName, 'email', Schema::TYPE_STRING . '(255) NOT NULL DEFAULT "" COMMENT "Email" AFTER `phone`');
		$this->addColumn($this->tableName, 'house', Schema::TYPE_STRING . '(10) NOT NULL DEFAULT "" COMMENT "Дом" AFTER `street_guid`');
		$this->addColumn($this->tableName, 'appartment', Schema::TYPE_STRING . '(5) NOT NULL DEFAULT "" COMMENT "Квартира" AFTER `house`');

		$this->createIndex('ix-' . $this->tableName . '-[email]', $this->tableName, ['email']);
		$this->createIndex('ix-' . $this->tableName . '-[phone]', $this->tableName, ['phone']);
	}

	public function safeDown() {
		$this->dropColumn($this->tableName, 'email');
		$this->dropColumn($this->tableName, 'house');
		$this->dropColumn($this->tableName, 'appartment');

		$this->dropIndex('ix-' . $this->tableName . '-[phone]', $this->tableName);
	}
}
