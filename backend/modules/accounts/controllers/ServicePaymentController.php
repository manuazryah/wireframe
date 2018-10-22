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
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

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
                if ($this->SaveServiceDetails($data, $appointment) && $this->SaveMultipleChequeDetails($data, $appointment) && $this->SaveOneTimeChequeDetails($data, $appointment) && $this->SecurityChequeDetails($data, $appointment)) {
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

    public function actionServicePaymentUpdate($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $security_cheque = \common\models\SecurityCheque::find()->where(['appointment_id' => $id])->one();
        $services_ontime_amount = AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 2])->sum('total');
        $appointment = Appointment::findOne($id);
        $multiple_cheque_details = \common\models\ServiceChequeDetails::findAll(['appointment_id' => $id, 'type' => 1]);
        $multiple_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 1])->sum('amount');
        $onetime_cheque_details = \common\models\ServiceChequeDetails::findAll(['appointment_id' => $id, 'type' => 2]);
        $onetime_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $update = $data['update'];
            $arr = [];
            $i = 0;
            foreach ($update as $key => $val) {
                $arr[$key]['cheque_num'] = $val['cheque_num'][0];
                $arr[$key]['cheque_date'] = $val['cheque_date'][0];
                $arr[$key]['amount'] = $val['amount'][0];
                $i++;
            }
            foreach ($arr as $key => $value) {
                $aditional = \common\models\ServiceChequeDetails::findOne($key);
                $aditional->cheque_number = $value['cheque_num'];
                $aditional->cheque_date = $value['cheque_date'];
                $aditional->amount = $value['amount'];
                $aditional->save(FALSE);
            }
            $createsecurity = $data['Security'];
            if (isset($createsecurity) && $createsecurity != '') {
                if ($createsecurity['amount'] > 0) {
                    $security_cheque->cheque_no = $createsecurity['cheque_num'];
                    $security_cheque->cheque_date = $createsecurity['cheque_date'];
                    $security_cheque->amount = $createsecurity['amount'];
                    Yii::$app->SetValues->Attributes($security_cheque);
                    $security_cheque->save();
                }
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('update', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
                    'multiple_cheque_details' => $multiple_cheque_details,
                    'onetime_cheque_details' => $onetime_cheque_details,
                    'multiple_total' => $multiple_total,
                    'onetime_total' => $onetime_total,
                    'services_ontime_amount' => $services_ontime_amount,
                    'security_cheque' => $security_cheque,
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
                            $flag = 1;
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
    public function SaveMultipleChequeDetails($data, $appointment) {
        $flag = 0;
        $creatematerial = $data['create'];
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

            if ($this->AddChequeDetails($arr, $appointment)) {
                $flag = 1;
            }
        } else {
            $flag = 1;
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
    public function SaveOneTimeChequeDetails($data, $appointment) {
        $flag = 0;
        $creatematerial = $data['createone'];
        if (isset($creatematerial) && $creatematerial != '') {
            if ($creatematerial['amount'] > 0) {
                $aditional = new \common\models\ServiceChequeDetails();
                $aditional->appointment_id = $appointment->id;
//            $aditional->appointment_service_id = $service->id;
//            $aditional->service_id = $service->service;
                $aditional->type = 2;
                $aditional->cheque_number = $creatematerial['cheque_num'];
                $aditional->cheque_date = $creatematerial['cheque_date'];
                $aditional->amount = $creatematerial['amount'];
                Yii::$app->SetValues->Attributes($aditional);
                if ($aditional->save()) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            } else {
                $flag = 1;
            }
        } else {
            $flag = 1;
        }

        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * To Save Security Cheque details
     */
    public function SecurityChequeDetails($data, $appointment) {
        $flag = 0;
        $createsecurity = $data['Security'];
        if (isset($createsecurity) && $createsecurity != '') {
            if ($createsecurity['amount'] > 0) {
                $aditional = new \common\models\SecurityCheque();
                $aditional->appointment_id = $appointment->id;
                $aditional->cheque_no = $createsecurity['cheque_num'];
                $aditional->cheque_date = $createsecurity['cheque_date'];
                $aditional->amount = $createsecurity['amount'];
                Yii::$app->SetValues->Attributes($aditional);
                if ($aditional->save()) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            } else {
                $flag = 1;
            }
        } else {
            $flag = 1;
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
    public function AddChequeDetails($arr, $appointment) {

        $flag = 0;
        foreach ($arr as $val) {
            if ($val['amount'] > 0) {
                $aditional = new \common\models\ServiceChequeDetails();
                $aditional->appointment_id = $appointment->id;
//            $aditional->appointment_service_id = $service->id;
//            $aditional->service_id = $service->service;
                $aditional->type = 1;
                $aditional->cheque_number = $val['cheque_num'];
                $aditional->cheque_date = $val['cheque_date'];
                $aditional->amount = $val['amount'];
                Yii::$app->SetValues->Attributes($aditional);
                if ($aditional->save()) {
                    $flag = 1;
                }
            } else {
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
            $appointment_service_data = AppointmentService::findOne(['id' => $service_id]);
            $type = $_POST['count'];
            $data = $this->renderPartial('_form_cheque', [
                'service_id' => $service_id,
                'type' => $type,
                'amount' => $appointment_service_data->amount,
            ]);
        }
        return $data;
    }

    /*
     * Service Payment
     */

    public function actionPayment($id) {
        $appointment = Appointment::findOne($id);
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $onetime_total = \common\models\AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 2])->sum('total');
        $onetime_cheque_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $total_cash_amount = $onetime_total - $onetime_cheque_total;
        $cash_paid = \common\models\PaymentDetails::find()->where(['appointment_id' => $id, 'payment_type' => 1])->sum('amount');
        $total_received = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('amount_paid');
        $total_balance = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('balance_amount');
//        $onetime_cash_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $this->ChangeChequeStatus($id);
        $cheque_dates = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->groupBy('cheque_date')->all();
        return $this->render('payment', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'cheque_dates' => $cheque_dates,
                    'total_cash_amount' => $total_cash_amount,
                    'cash_paid' => $cash_paid,
                    'total_received' => $total_received,
                    'total_balance' => $total_balance,
        ]);
    }

    public function ChangeChequeStatus($id) {
        $cheques = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['<', 'cheque_date', date("Y-m-d")])->andWhere(['status' => NULL])->all();
        if (!empty($cheques)) {
            foreach ($cheques as $cheque) {
                $cheque->status = 2;
                $cheque->save();
            }
        }
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

            $appointment_id = $_POST['appointment_id'];
            $onetime_total = \common\models\AppointmentService::find()->where(['appointment_id' => $appointment_id, 'payment_type' => 2])->sum('total');
            $onetime_cheque_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment_id, 'type' => 2])->sum('amount');
            $total_cash_amount = $onetime_total - $onetime_cheque_total;
            $cash_paid = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment_id, 'payment_type' => 1])->sum('amount');
            $balnce_to_pay = $total_cash_amount - $cash_paid;
            $data = $this->renderPartial('_form_pay', [
                'balnce_to_pay' => $balnce_to_pay,
                'appointment_id' => $appointment_id,
            ]);
        }
        return $data;
    }

    public function actionAjaxChequePayment() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            if (!empty($data['id'])) {
                $cheque_data = \common\models\ServiceChequeDetails::findOne(['id' => $data['id']]);
                if ($data['status'] == 1) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $payment_master = \common\models\PaymentMaster::find()->where(['appointment_id' => $cheque_data->appointment_id])->one();
                        if (empty($payment_master)) {
                            $total_amount = \common\models\AppointmentService::find()->where(['appointment_id' => $cheque_data->appointment_id])->sum('total');
                            $payment_master = new \common\models\PaymentMaster();
                            $payment_master->appointment_id = $cheque_data->appointment_id;
                            $payment_master->total_amount = $total_amount;
                            Yii::$app->SetValues->Attributes($payment_master);
                            $payment_master->save();
                        }
                        if (!empty($payment_master)) {
                            $payment_details = new \common\models\PaymentDetails();
                            $payment_details->appointment_id = $payment_master->appointment_id;
                            $payment_details->master_id = $payment_master->id;
                            $payment_details->amount = $cheque_data->amount;
                            $payment_details->cheque_no = $cheque_data->cheque_number;
                            $payment_details->cheque_date = $cheque_data->cheque_date;
                            $payment_details->payment_type = 2;
                            Yii::$app->SetValues->Attributes($payment_details);
                            $payment_master->amount_paid = $payment_master->amount_paid + $cheque_data->amount;
                            $payment_master->balance_amount = $payment_master->total_amount - $payment_master->amount_paid;
                            if ($payment_details->save() && $payment_master->save()) {
                                $transaction->commit();
                                $cheque_data->status = 1;
                                $cheque_data->update();
                                $result = 1;
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        $result = 0;
                    }
                } else {
                    $cheque_data->status = 2;
                    $cheque_data->update();
                    $result = 1;
                }
            } else {
                $result = 0;
            }
        }
    }

    public function actionAjaxPayment() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['appointment_id'];
            $amount = $_POST['amount'];
            $date = $_POST['transaction_date'];
            $comment = $_POST['comment'];
            if (!empty($id) && !empty($amount) && !empty($date)) {
                $appointment_model = Appointment::findOne(['id' => $id]);
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $payment_master = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->one();
                    if (empty($payment_master)) {
                        $total_amount = \common\models\AppointmentService::find()->where(['appointment_id' => $id])->sum('total');
                        $payment_master = new \common\models\PaymentMaster();
                        $payment_master->appointment_id = $id;
                        $payment_master->total_amount = $total_amount;
                        Yii::$app->SetValues->Attributes($payment_master);
                        $payment_master->save();
                    }
                    if (!empty($payment_master)) {
                        $payment_details = new \common\models\PaymentDetails();
                        $payment_details->appointment_id = $id;
                        $payment_details->master_id = $payment_master->id;
                        $payment_details->amount = $amount;
                        $payment_details->payment_type = 1;
                        $payment_details->comment = $comment;
                        Yii::$app->SetValues->Attributes($payment_details);
                        if (isset($date)) {
                            $payment_details->DOC = $date;
                        }
                        $payment_master->amount_paid = $payment_master->amount_paid + $amount;
                        $payment_master->balance_amount = $payment_master->total_amount - $payment_master->amount_paid;
                        if ($payment_details->save() && $payment_master->save()) {
                            $transaction->commit();
                            $result = 1;
                        }
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $result = 0;
                }
            } else {
                $result = 0;
            }
            return $result;
        }
    }

    public function actionPaymentHistory($id) {
        $payment_model = \common\models\PaymentDetails::find()->where(['appointment_id' => $id])->all();
        return $this->render('_payment_history', [
                    'payment_model' => $payment_model,
                    'id' => $id
        ]);
    }

    public function AddPayment($id) {

        if (!empty($id)) {
            $cheque_data = \common\models\ServiceChequeDetails::findOne(['id' => $id]);
            $model_appointment_service = AppointmentService::findOne(['id' => $cheque_data->appointment_service_id]);
            $appointment_model = Appointment::findOne(['id' => $model_appointment_service->appointment_id]);
            if (!empty($cheque_data) && !empty($model_appointment_service)) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new \common\models\ServicePayment();
                    $model->appointment_id = $model_appointment_service->appointment_id;
                    $model->transaction_type = 1;
                    $model->amount = $cheque_data->amount;
                    $model->cheque_no = $cheque_data->cheque_number;
                    $model->date = date('Y-m-d');
                    $model->CB = Yii::$app->user->identity->id;
                    $model->DOC = date('Y-m-d');
                    $model_appointment_service->due_amount = NULL;
                    $model_appointment_service->amount_paid = $model_appointment_service->amount_paid + $model->amount;
                    $appointment_model->paid_amount = $appointment_model->paid_amount + $model->amount;

                    if ($model->save() && $model_appointment_service->save() && $appointment_model->save()) {
                        $transaction->commit();
                        $result = 1;
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $result = 0;
                }
                return $result;
            }
        }
    }

    public function chequeBounce($id, $cheque_data) {

        if (!empty($id)) {
            $model_appointment_service = AppointmentService::findOne(['id' => $cheque_data->appointment_service_id]);

            $service_payment = \common\models\ServicePayment::find()->where(['cheque_no' => $cheque_data->cheque_number, 'appointment_id' => $cheque_data->appointment_id])->one();
            $appointment_model = Appointment::findOne(['id' => $model_appointment_service->appointment_id]);

            if (!empty($service_payment) || !empty($model_appointment_service) && !empty($cheque_data)) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model_appointment_service->due_amount = $cheque_data->amount;
                    $model_appointment_service->amount_paid = $model_appointment_service->amount_paid - $cheque_data->amount;
                    $appointment_model->paid_amount = $appointment_model->paid_amount - $cheque_data->amount;
                    if ($model_appointment_service->save() && $cheque_data->save() && $appointment_model->save()) {
                        if (!empty($service_payment))
                            $service_payment->delete();

                        $transaction->commit();
                    }
                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
        }
    }

    public function actionMultipleChequeDetails() {
        if (Yii::$app->request->isAjax) {
            $count = $_POST['count'];
            $total_amt = $_POST['total_amt'];
            $data = $this->renderPartial('_form_cheque_multiple', [
                'count' => $count,
                'total_amt' => $total_amt,
            ]);
        }
        return $data;
    }

    public function actionOneTimeChequeDetails() {
        if (Yii::$app->request->isAjax) {
            $total_amt = $_POST['total_amt'];
            $data = $this->renderPartial('_form_cheque_one_time', [
                'total_amt' => $total_amt,
            ]);
        }
        return $data;
    }

    public function actionGetSecurityChequeDetails() {
        if (Yii::$app->request->isAjax) {
            $data = $this->renderPartial('_form_security_cheque', [
            ]);
        }
        return $data;
    }

    /*
     * Accounts Report
     */

    public function actionAccountsReport($id) {
        $appointment = Appointment::findOne($id);
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $onetime_total = \common\models\AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 2])->sum('total');
        $onetime_cheque_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $total_cash_amount = $onetime_total - $onetime_cheque_total;
        $cash_paid = \common\models\PaymentDetails::find()->where(['appointment_id' => $id, 'payment_type' => 1])->sum('amount');
        $total_received = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('amount_paid');
        $total_balance = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('balance_amount');
//        $onetime_cash_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $cheque_dates = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->groupBy('cheque_date')->all();
        $data = $this->renderPartial('accounts_report', [
            'services' => $services,
            'appointment' => $appointment,
            'cheque_dates' => $cheque_dates,
            'total_cash_amount' => $total_cash_amount,
            'cash_paid' => $cash_paid,
            'total_received' => $total_received,
            'total_balance' => $total_balance,
        ]);
        echo $data;
        exit;
    }

}
