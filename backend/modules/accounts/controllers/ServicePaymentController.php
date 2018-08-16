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
        $arr = [2, 3];
        $dataProvider->query->andWhere(['status' => $arr]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionServicePayment($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->SaveServiceDetails($data, $appointment)) {
                    $transaction->commit();
                    $appointment->status = 3;
                    $appointment->save(FALSE);
                    Yii::$app->session->setFlash('success', "Payment Details Added successfully");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem adding payment details. Please try again.");
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem creating adding payment details. Please try again.");
            }
            return $this->redirect(['index']);
        }
        return $this->render('add', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

    /*
     * Update Appointment service
     */

    public function SaveServiceDetails($data, $appointment) {
        $flag = 0;
        if (!empty($data['updatee'])) {
            foreach ($data['updatee'] as $key => $update) {
                if (!empty($update['payment_type'])) {
                    $service = AppointmentService::find()->where(['id' => $key])->one();
                    if (!empty($service)) {
                        $service->payment_type = $update['payment_type'];
                        if ($service->save()) {
                            if ($service->payment_type == 5) {
                                $flag = 1;
                            } else {
                                if ($this->SaveChequeDetails($service, $data, $key, $appointment)) {
                                    $flag = 1;
                                } else {
                                    $flag = 0;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * To set cheque details into an array.
     */
    public function SaveChequeDetails($service, $data, $key, $appointment) {
        $flag = 0;
        $creatematerial = $data['create'][$key];
        if (isset($creatematerial) && $creatematerial != '') {
            $arr = [];
            $i = 0;
            if (!empty($creatematerial['cheque_num'])) {
                foreach ($creatematerial['cheque_num'] as $val) {
                    $arr[$i]['cheque_num'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['cheque_date'])) {
                foreach ($creatematerial['cheque_date'] as $val) {
                    $arr[$i]['cheque_date'] = $val;
                    $i++;
                }
            }
            $i = 0;
            if (!empty($creatematerial['amount'])) {
                foreach ($creatematerial['amount'] as $val) {
                    $arr[$i]['amount'] = $val;
                    $i++;
                }
            }
            if ($this->AddChequeDetails($service, $arr, $appointment)) {
                $flag = 1;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * This function save service cheque details.
     */
    public function AddChequeDetails($service, $arr, $appointment) {
        $flag = 0;
        foreach ($arr as $val) {
            $aditional = new \common\models\ServiceChequeDetails();
            $aditional->appointment_id = $appointment->id;
            $aditional->service_id = $service->id;
            $aditional->cheque_number = $val['cheque_num'];
            $aditional->cheque_date = $val['cheque_date'];
            $aditional->amount = $val['amount'];
            Yii::$app->SetValues->Attributes($aditional);
            if ($aditional->save()) {
                $flag = 1;
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function actionAddChequeDetails() {
        if (Yii::$app->request->isAjax) {
            $service_id = $_POST['service_id'];
            $type = $_POST['count'];
            $data = $this->renderPartial('_form_cheque', [
                'service_id' => $service_id,
                'type' => $type,
            ]);
        }
        return $data;
    }

    /*
     * Service Payment
     */

    public function actionPayment($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $one_time_payments = AppointmentService::findAll(['appointment_id' => $id, 'payment_type' => 5]);
        $appointment = Appointment::findOne($id);
        $cheque_dates = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->groupBy('cheque_date')->all();
        return $this->render('payment', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'one_time_payments' => $one_time_payments,
                    'cheque_dates' => $cheque_dates,
                    'id' => $id,
        ]);
    }

    public function actionPayAmount() {
        if (Yii::$app->request->post()) {
            
        }
        return $this->renderAjax('_form_pay', [
                    'model' => $model,
        ]);
    }

    public function actionGetPayment() {
        $data = '';
        if (Yii::$app->request->post()) {
            $type = $_POST['type'];
            $service = $_POST['service_id'];
            $data = $this->renderPartial('_form_pay', [
                'type' => $type,
                'service' => $service,
            ]);
        }
        return $data;
    }

}
