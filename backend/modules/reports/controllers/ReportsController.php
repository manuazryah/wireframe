<?php

namespace backend\modules\reports\controllers;

class ReportsController extends \yii\web\Controller {

        public function actionIndex() {
                $companys = \common\models\CompanyManagement::find()->where(['status' => 1])->all();
                return $this->render('index', ['companys' => $companys]);
        }

}
