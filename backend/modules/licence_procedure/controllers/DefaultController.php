<?php

namespace backend\modules\licence_procedure\controllers;

use yii\web\Controller;

/**
 * Default controller for the `licence_procedure` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
