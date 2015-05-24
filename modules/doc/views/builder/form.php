<?php
use app\models\doc\File;
use app\models\doc\Macro;
/**
 * @var $file File
 * @var $content string
 * @var $macro array
 */

//require "vendor/simplehtmldom/simple_html_dom.php";
//require "vendor/selector/selector.php";
//require "vendor/querypath/src/qp.php";
require "vendor/cdom/CDom.php";

//$html = str_get_html($content

$html = CDom::fromString($content);

foreach ($macro as $m) {
	$a = $html->find("p:eq(44)");
	if (!count($a)) {
		continue;
	}
	$element = $a[0];
	print $element->html();
}

//foreach ($html->find("p") as $element) {
	/* @var $element simple_html_dom_node */
//	print_r($element->{"plaintext"});
//}