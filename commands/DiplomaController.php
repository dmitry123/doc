<?php

namespace app\commands;

use ReflectionMethod;
use yii\console\Controller;

class DiplomaController extends Controller {

    public function actionGenerate() {
        $path = substr(__DIR__, 0, strrpos(__DIR__, '\\')).DIRECTORY_SEPARATOR;
        ob_start();
        foreach (static::$dirs as $dir) {
            foreach ($this->listFiles($path.$dir) as $d) {
                $this->printClass($d, 'app\\'.$dir.'\\'.basename($d, '.php'));
            }
        }
        file_put_contents('text.txt', ob_get_clean());
    }

    private function printClass($path, $class) {
        try {
            $parent = get_parent_class($class);
        } catch (\Exception $e) {
            return ;
        }
        $name = basename($path, '.php');
        print "Класс {$name}\r\n";
        print "Класс объявлен в файле «{$name}.php». Класс является наследником класса {$parent}.\r\n";
        $ref = new \ReflectionClass($class);
        $list = [
            ReflectionMethod::IS_PUBLIC => 'Public',
            ReflectionMethod::IS_PRIVATE => 'Private',
            ReflectionMethod::IS_PROTECTED => 'Protected',
        ];
        foreach ($list as $t => $n) {
            $m = '';
            foreach ($ref->getMethods($t) as $method) {
                if (preg_match('/__.*/', $method->getName())) {
                    continue;
                }
                if ($method->class != $ref->getName()) {
                    continue;
                }
                $m .= $method->getName()."\r\n";
            }
            if (strlen($m) > 0) {
                print "$n-методы класса:\r\n";
                print $m;
            }
        }
    }

    private function listFiles($from = '.', $ext = 'php')  {
        $files = [];
        if (!is_dir($from)) {
            return [];
        }
        if (!($dh = opendir($from))) {
            return $files;
        }
        while (false !== ($file = readdir($dh))) {
            if($file == '.' || $file == '..') {
                continue;
            }
            $path = $from . '/' . $file;
            if (is_dir($path)) {
                $files += $this->listFiles($path);
            } else if (substr($path, strrpos($path, '.') + 1) == $ext) {
                $files[] = $path;
            }
        }
        closedir($dh);
        return $files;
    }

    private static $dirs = [
        'assets',
        'controllers',
        'core',
        'filters',
        'forms',
        'grids',
        'models',
        'validators',
        'widgets',
    ];
}