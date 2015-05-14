<?php

namespace app\core;

use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;

class ErrorAction extends \yii\web\ErrorAction {

	public function run() {
		if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
			return '';
		}
		if ($exception instanceof HttpException) {
			$code = $exception->statusCode;
		} else {
			$code = $exception->getCode();
		}
		if ($exception instanceof Exception) {
			$name = $exception->getName();
		} else {
			$name = $this->defaultName ?: Yii::t('yii', 'Error');
		}
		if ($code) {
			$name .= " (#$code)";
		}
		if ($exception instanceof UserException) {
			$message = $exception->getMessage();
		} else {
			$message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
		}
		if (Yii::$app->getRequest()->getIsAjax()) {
			return "$name: $message";
		} else {
			$this->controller->layout = "block";
			ob_start();
			print $this->controller->render("error", [
				'message' => $message,
				'name' => $name,
				'exception' => $exception,
			]);
			return ob_get_clean();
		}
	}
}