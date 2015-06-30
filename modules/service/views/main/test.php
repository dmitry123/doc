<?php
/**
 * @var $this yii\web\View
 */

$panel = \app\widgets\Panel::begin();
$panel->beginHeader();
print 'Hello, Title';
$panel->endHeader();
$panel->beginBody();
print 'Hello, Body';
$panel->endBody();
$panel->beginFooter();
print 'Hello, Footer';
$panel->endFooter();
$panel->end();

print '<hr>';

$panel = \app\widgets\Panel::begin([
	'title' => 'Hello, Title',
	'footer' => 'Hello, Footer',
]);
print 'Hello, Body';
$panel->end();

print '<hr>';

$panel = \app\widgets\Panel::begin([
	'title' => 'Hello, Title',
	'body' => 'Hello, Body',
	'footer' => 'Hello, Footer',
]);
$panel->end();