<?php

namespace backend\modules\accounts\controllers;

use Yii;
use common\models\AppointmentSearch;
use common\models\Appointment;
use common\models\AppointmentService;

class ServicePaymentController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => 2]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionServicePayment($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        return $this->render('add', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

}
