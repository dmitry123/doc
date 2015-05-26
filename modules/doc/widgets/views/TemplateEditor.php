<?php
/**
 * @var $this \yii\web\View
 * @var $content string
 * @var $self app\modules\doc\widgets\TemplateEditor
 * @var $file mixed
 * @var $macro mixed[]
 */
print \yii\helpers\Html::tag("div", $content, [
	"class" => "row no-margin doc-template-content-editor"
]);
foreach ($macro as $m) {
	$this->registerJs(<<< JS
	Doc_TemplateEditor_Widget.insertMacro($(".doc-template-content-editor > {$m['path']}"), "{$m['content']}", "{$m['id']}", "{$m['name']}");
JS
	);
}