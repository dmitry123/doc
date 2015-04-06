<?php

$cities = Yii::$app->getDb()->createCommand(<<<SQL
SELECT c.*, c2.name AS country_name, r.name AS region_name
FROM core.city AS c
JOIN core.country AS c2 ON c2.id = c.country_id
JOIN core.region AS r ON r.id = c.region_id
SQL
)->queryAll();

$countries = Yii::$app->getDb()->createCommand(<<<SQL
SELECT * FROM core.country
SQL
)->queryAll();

$regions = Yii::$app->getDb()->createCommand(<<<SQL
SELECT r.*, c.name as country_name
FROM core.region AS r
JOIN core.country AS c ON c.id = r.country_id
SQL
)->queryAll();

ob_start();
$sql = "INSERT INTO core.country (name) VALUES \r\n";
foreach ($countries as $r) {
	$sql .= "\t('{$r["name"]}'), \r\n";
}
print preg_replace("/\\, \\s$/", ";\r\n", $sql);
file_put_contents("cladr_country.sql", ob_get_clean());

ob_start();
$sql = "INSERT INTO core.region (country_id, name) VALUES \r\n";
foreach ($regions as $r) {
	$sql .= "\t((SELECT id FROM core.country WHERE name = '{$r["country_name"]}' LIMIT 1), '{$r["name"]}'), \r\n";
}
print preg_replace("/\\, \\s$/", ";\r\n", $sql);
file_put_contents("cladr_region.sql", ob_get_clean());

ob_start();
$sql = "INSERT INTO core.city (country_id, region_id, name) VALUES \r\n";
foreach ($cities as $r) {
	$sql .= "\t((SELECT id FROM core.country WHERE name = '{$r["country_name"]}' LIMIT 1), (SELECT id FROM core.region WHERE name = '{$r["region_name"]}' LIMIT 1), '{$r["name"]}'), \r\n";
}
print preg_replace("/\\, \\s$/", ";\r\n", $sql);
file_put_contents("cladr_city.sql", ob_get_clean());