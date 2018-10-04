<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Expression;

class CroneNotificationConroller extends Controller {

	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index');
	}

}
