<?php

use yii\db\Schema;
use yii\db\Migration;

class m150515_171611_doc_file_type extends Migration
{
    public function safeUp() {
        $this->execute("INSERT INTO doc.file_type (id, name, description) VALUES ('prepared', 'Подготовленный для загрузки', 'Автоматически сгенерированный файл при выгрузке документа или файла')");
        $this->execute("INSERT INTO doc.file_status (id, name) VALUES ('prepared', 'Подгтовлен')");
    }
    
    public function safeDown() {
        $this->execute("DELETE FROM doc.file_type WHERE id = 'prepared'");
        $this->execute("DELETE FROM doc.file_status  WHERE id = 'prepared'");
    }
}
