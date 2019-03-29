<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppointmentWidget
 *
 * @author
 * JIthin Wails
 */

namespace common\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class ExpenseWidget extends Widget {

    public $id;

    public function init() {
        parent::init();
        if ($this->id === null) {
            return '';
        }
    }

    public function run() {
        $appointment = \common\models\Appointment::find()->where(['id' => $this->id])->one();
        $paymentmaster = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $services = \common\models\AppointmentService::findAll(['appointment_id' => $appointment->id]);
        $projection_amount = 0;
        if (!empty($services)) {
            foreach ($services as $service) {
                if (!empty($service)) {
                    $projection_amount += $service->total;
                }
            }
        }
        return $this->render('expense_view', [
                    'appointment' => $appointment,
                    'paymentmaster' => $paymentmaster,
                    'projection_amount' => $projection_amount,
        ]);
    }

}
?>
