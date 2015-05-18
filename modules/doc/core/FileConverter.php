<?php

namespace app\modules\doc\core;

use yii\base\Exception;

class FileConverter {

    const WAIT_TIMEOUT = 5;

    public static function getDefaultConverter($ext) {
        return new FileConverter($ext);
    }

    public static function getHtmlConverter() {
        return new FileConverter("html");
    }

    public function convert($file) {
        if ($this->_ext == null) {
            throw new Exception("Not configured output extension type");
        }
        if (substr(php_uname(), 0, 7) == "Windows") {
            $py = "start python.exe";
        } else {
            $py = "python";
        }
        $cmd = "$py vendor/unoconv/unoconv -f ".$this->_ext." $file";
        $msg = system("$cmd", $r);
        if ($r !== 0) {
            throw new Exception("Converter returned code \"$r\" with error message \"$msg\" while executing command \"$cmd\"");
        } else {
            $this->_file = $file;
        }
        return $this;
    }

    public function ext($type) {
        $this->_ext = $type;
        return $this;
    }

    public function wait($file = null) {
        $limit = 0;
        if ($file == null) {
            $file = $this->_file;
        }
        while ($file != null && !file_exists($file.".".$this->_ext)) {
            if (++$limit == static::WAIT_TIMEOUT) {
                throw new Exception("Something gone wrong, we've spent over 10 seconds to wait filesystem changes for file \"$file\"");
            }
            sleep(1);
        }
        return $this;
    }

    public function path() {
        return $this->_file.".".$this->_ext;
    }

    public function rename($name) {
        if (!@rename($this->_file.".".$this->_ext, $name)) {
            throw new Exception("Can't rename file: \"". error_get_last()["message"] ."\"");
        } else {
            return $this;
        }
    }

    private function __construct($ext) {
        $this->_ext = $ext;
    }

    private $_file = null;
    private $_ext = null;
}