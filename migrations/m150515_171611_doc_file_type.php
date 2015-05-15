<?php

use yii\db\Schema;
use yii\db\Migration;

class m150515_171611_doc_file_type extends Migration
{
    public function safeUp() {
        $this->execute("INSERT INTO doc.file_type (id, name, description) VALUES ('cached', 'Кэшированный файл', 'Файл генерируется автоматически на уровне системы, используется для кэширования активных файлов')");
        $this->execute("INSERT INTO doc.file_status (id, name) VALUES ('cached', 'Кэширован')");
    }
    
    public function safeDown() {
        $this->execute("DELETE FROM doc.file_type WHERE id = 'cached'");
        $this->execute("DELETE FROM doc.file_status  WHERE id = 'cached'");
    }
}
