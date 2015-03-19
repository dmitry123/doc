<?php

use yii\db\Migration;

class m150309_213212_user_access_token extends Migration {

    public function safeUp() {
		$this->execute("ALTER TABLE \"core\".\"user\" ADD access_token VARCHAR(50) DEFAULT NULL");
    }
    
    public function safeDown() {
		$this->execute("ALTER TABLE \"core\".\"user\" DROP access_token");
    }
}
