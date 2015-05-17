<?php

namespace app\core;

class TableLocalization {

    public static $localizes = [

        /* Core */

        "core.city" => "Города",
        "core.country" => "Страны",
        "core.department" => "Кафедры",
        "core.employee" => "Сотрудники",
        "core.institute" => "Институты",
        "core.phone" => "Телефоны",
        "core.privilege" => "Привилегии",
        "core.region" => "Регионы",
        "core.role" => "Роли",
        "core.security_key" => "Ключи безопасности",
        "core.user" => "Пользователи",
        "core.about_employee" => "Сотрудникики (Расширенная)",
        "core.admin" => "Администраторы",
        "core.director" => "Директора",
        "core.implementer" => "Внедренцы",
        "core.manager" => "Заведующие кафедр",
        "core.student" => "Студенты",
        "core.super" => "Супервайзеры",
        "core.teacher" => "Преподаватели",
        "core.tester" => "Тестировщики",

        /* Doc */

        "doc.file" => "Файлы",
        "doc.file_access" => "Доступы к файлам",
        "doc.file_category" => "Категории файлов",
        "doc.file_ext" => "Расширения файлов",
        "doc.file_status" => "Статусы файлов",
        "doc.file_template_element" => "Элементы шаблонов",
        "doc.file_type" => "Типы файлов",
        "doc.macro" => "Макросы шаблонов",
        "doc.document" => "Файлы документов",
        "doc.image" => "Файлы изображений",
        "doc.table" => "Файлы таблиц",
        "doc.template" => "Шаблоны",
    ];

    public static function localize($name) {
        if (isset(static::$localizes[$name])) {
            return static::$localizes[$name];
        } else {
            return $name;
        }
    }
}