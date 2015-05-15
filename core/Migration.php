<?php

namespace app\core;

abstract class Migration extends \yii\db\Migration {

    public abstract function upgrade();

    public abstract function downgrade();

    public final function safeUp() {
        $this->execute($this->upgrade());
    }

    public final function safeDown() {
        $this->execute($this->downgrade());
    }

    public final function up() {
        $this->safeUp();
    }

    public final function down() {
        $this->safeDown();
    }

    public function execute($sql, $params = []) {
        if (empty($sql)) {
            return;
        }
        foreach (explode(";", $sql) as $s) {
            $s = preg_replace('/\s+/', " ", trim($s));
            if (empty($s)) {
                continue;
            }
            parent::execute($s);
        }
    }
}