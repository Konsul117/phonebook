<?php

use yii\db\Schema;
use yii\db\Migration;

class m160102_134007_alter_contact extends Migration {

	var $tableName = 'contact';

	public function safeUp() {
		$this->addColumn($this->tableName, 'middle_name', Schema::TYPE_STRING . '(255) NOT NULL DEFAULT "" COMMENT "Отчество" AFTER `surname`');
		$this->addColumn($this->tableName, 'birth_date', Schema::TYPE_DATE . ' NULL COMMENT "Дата рождения" AFTER `middle_name`');
	}

	public function safeDown() {
		$this->dropColumn($this->tableName, 'middle_name');
		$this->dropColumn($this->tableName, 'birth_date');
	}
}
