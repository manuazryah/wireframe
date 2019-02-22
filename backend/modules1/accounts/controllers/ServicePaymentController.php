<?php

namespace backend\modules\accounts\controllers;

use Yii;
use common\models\AppointmentSearch;
use common\models\Appointment;
use common\models\AppointmentService;
use kartik\mpdf\Pdf;

class ServicePaymentController extends \yii\web\Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        return true;
    }

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

    public function actionServicePayment($id, $prfrma_id = NULL) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        if (!isset($prfrma_id)) {
            $model = new AppointmentService();
        } else {
            $model = AppointmentService::findOne($prfrma_id);
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->appointment_id = $id;
            $tax_amount = 0;
            if ($model->tax != '') {
                $tax_data = \common\models\Tax::find()->where(['id' => $model->tax])->one();
                $model->tax_percentage = $tax_data->value;
                if ($model->amount > 0) {
                    if ($tax_data->value != '' && $tax_data->value > 0) {
                        $tax_amount = ($model->amount * $tax_data->value) / 100;
                    }
                }
                $model->tax_amount = $tax_amount;
            }
            $model->total = $model->amount + $tax_amount;
            if ($model->save()) {
                Yii::$app->SetValues->updateAppointment($appointment->id);
                Yii::$app->session->setFlash('success', "Services Updated Successfully");
                return $this->redirect(['service-payment', 'id' => $id]);
            }
            if ($appointment->sub_status > 0) {
                $this->RemoveAccountsData($appointment);
            }
        }
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        return $this->render('add', [
                    'model' => $model,
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

    public function RemoveAccountsData($appointment) {
        $cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->all();
        $master_payment = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $payment_details = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (!empty($cheque_details)) {
            foreach ($cheque_details as $cheque_detail) {
                $cheque_detail->delete();
            }
        }
        if (!empty($master_payment)) {
            $master_payment->delete();
        }
        if (!empty($payment_details)) {
            foreach ($payment_details as $payment_detail) {
                $payment_detail->delete();
            }
        }
        $cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->all();
        $master_payment = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $payment_details = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (empty($cheque_details) && empty($master_payment) && empty($payment_details)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function actionServicePaymentUpdate($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        if ($appointment->sub_status == 2) {
            return $this->redirect(['service-payment-details', 'id' => $id]);
        }
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->SaveMultipleChequeDetails($data, $appointment) && $this->SaveOneTimeChequeDetails($data, $appointment) && $this->SecurityChequeDetails($data, $appointment) && $this->AppointmentUpdate($data, $appointment)) {
                    $transaction->commit();
                    $appointment->sub_status = 2;
                    $appointment->save(FALSE);
                    Yii::$app->session->setFlash('success', "Payment Details Added successfully");
                    return $this->redirect(['payment', 'id' => $id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem adding payment details. Please try again.");
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem creating adding payment details. Please try again.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->redirect(['index']);
        }
        return $this->render('update', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

    public function actionServicePaymentDetails($id) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $security_cheque = \common\models\SecurityCheque::find()->where(['appointment_id' => $id])->one();
        $services_ontime_amount = AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 2])->sum('total');
        $appointment = Appointment::findOne($id);
        $multiple_cheque_details = \common\models\ServiceChequeDetails::findAll(['appointment_id' => $id, 'type' => 1]);
        $multiple_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 1])->sum('amount');
        $onetime_cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->one();
        $onetime_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->RemovePrevData($appointment) && $this->SaveMultipleChequeDetails($data, $appointment) && $this->SaveOneTimeChequeDetails($data, $appointment) && $this->UpdateSecurityChequeDetails($data, $security_cheque, $appointment) && $this->AppointmentUpdate($data, $appointment)) {
                    $transaction->commit();
                    $appointment->sub_status = 2;
                    $appointment->save(FALSE);
                    Yii::$app->session->setFlash('success', "Payment Details Added successfully");
                    return $this->redirect(['payment', 'id' => $id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem adding payment details. Please try again.");
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem creating adding payment details. Please try again.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('payment_details', [
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

    public function UpdateSecurityChequeDetails($data, $security_cheque, $appointment) {
        if (isset($data['Security']) && $data['Security'] != '') {
            $createsecurity = $data['Security'];
            if ($createsecurity['amount'] > 0) {
                if (empty($security_cheque)) {
                    $security_cheque = new \common\models\SecurityCheque();
                    $security_cheque->appointment_id = $appointment->id;
                }
                $security_cheque->cheque_no = $createsecurity['cheque_num'];
                $security_cheque->cheque_date = $this->ChangeDateFormate($createsecurity['cheque_date']);
                $security_cheque->amount = $createsecurity['amount'];
                Yii::$app->SetValues->Attributes($security_cheque);
                $security_cheque->save();
            }
        }
        return TRUE;
    }

    public function RemovePrevData($appointment) {
        $cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->all();
        $master_payment = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $payment_details = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (!empty($cheque_details)) {
            foreach ($cheque_details as $cheque_detail) {
                $cheque_detail->delete();
            }
        }
        if (!empty($master_payment)) {
            $master_payment->delete();
        }
        if (!empty($payment_details)) {
            foreach ($payment_details as $payment_detail) {
                $payment_detail->delete();
            }
        }
        $cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->all();
        $master_payment = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $payment_details = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (empty($cheque_details) && empty($master_payment) && empty($payment_details)) {
            return TRUE;
        } else {
            return FALSE;
        }
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
        if (isset($data['create']) && $data['create'] != '') {
            $creatematerial = $data['create'];
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
                    $arr[$i]['cheque_date'] = $this->ChangeDateFormate($val);
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
        if (isset($data['createone']) && $data['createone'] != '') {
            $creatematerial = $data['createone'];
            if ($creatematerial['amount'] > 0) {
                $aditional = new \common\models\ServiceChequeDetails();
                $aditional->appointment_id = $appointment->id;
                $aditional->type = 2;
                $aditional->cheque_number = $creatematerial['cheque_num'];
                $aditional->cheque_date = $this->ChangeDateFormate($creatematerial['cheque_date']);
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
        if (isset($data['Security']) && $data['Security'] != '') {
            $createsecurity = $data['Security'];
            if ($createsecurity['amount'] > 0) {
                $aditional = new \common\models\SecurityCheque();
                $aditional->appointment_id = $appointment->id;
                $aditional->cheque_no = $createsecurity['cheque_num'];
                $aditional->cheque_date = $this->ChangeDateFormate($createsecurity['cheque_date']);
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
     * To Save Security Cheque details
     */
    public function AppointmentUpdate($data, $appointment) {
        if (isset($data['Appointment']) && $data['Appointment'] != '') {
            $updateappointment = $data['Appointment'];
            $appointment->license_expiry_date = $this->ChangeDateFormate($updateappointment['license_expiry_date']);
            $appointment->contract_start_date = $this->ChangeDateFormate($updateappointment['contract_start_date']);
            $appointment->contract_end_date = $this->ChangeDateFormate($updateappointment['contract_end_date']);
            $appointment->multiple_total = $data['multiple_total'];
            $appointment->one_time_total = $data['one_time_total'];
            $appointment->save(FALSE);
        }
        return TRUE;
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
        $security_cheque = \common\models\SecurityCheque::find()->where(['appointment_id' => $id])->one();
        $onetime_total = \common\models\AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 2])->sum('total');
        $mul_tax_total = \common\models\AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 1])->sum('tax_amount');
        $onetime_cheque_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $total_cash_amount = $onetime_total - $onetime_cheque_total;
        if ($appointment->tax_to_onetime == 1) {
            $total_cash_amount += $mul_tax_total;
        }
        $cash_paid = \common\models\PaymentDetails::find()->where(['appointment_id' => $id, 'payment_type' => 1])->sum('amount');
        $total_received = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('amount_paid');
        $total_balance = \common\models\PaymentMaster::find()->where(['appointment_id' => $id])->sum('balance_amount');
//        $onetime_cash_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'type' => 2])->sum('amount');
        $this->ChangeChequeStatus($id);
        $cheque_dates = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->groupBy('cheque_date')->all();
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $createsecurity = $data['Security'];
            if (isset($createsecurity) && $createsecurity != '') {
                if ($createsecurity['amount'] > 0) {
                    $security_cheque->cheque_no = $createsecurity['cheque_num'];
                    $security_cheque->cheque_date = $this->ChangeDateFormate($createsecurity['cheque_date']);
                    $security_cheque->amount = $createsecurity['amount'];
                    Yii::$app->SetValues->Attributes($security_cheque);
                    $security_cheque->save();
                }
            }
            $this->AppointmentUpdate($data, $appointment);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('payment', [
                    'services' => $services,
                    'appointment' => $appointment,
                    'cheque_dates' => $cheque_dates,
                    'total_cash_amount' => $total_cash_amount,
                    'cash_paid' => $cash_paid,
                    'total_received' => $total_received,
                    'total_balance' => $total_balance,
                    'id' => $id,
                    'security_cheque' => $security_cheque,
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
            $appointment = Appointment::findOne($appointment_id);
            $onetime_total = \common\models\AppointmentService::find()->where(['appointment_id' => $appointment_id, 'payment_type' => 2])->sum('total');
            $onetime_cheque_total = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment_id, 'type' => 2])->sum('amount');
            $total_cash_amount = $onetime_total - $onetime_cheque_total;
            $mul_tax_total = \common\models\AppointmentService::find()->where(['appointment_id' => $appointment_id, 'payment_type' => 1])->sum('tax_amount');
            if ($appointment->tax_to_onetime == 1) {
                $total_cash_amount += $mul_tax_total;
            }
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
                        if ($payment_details->save() && $payment_master->save() && $this->AddNotification($payment_details)) {
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

    public function AddNotification($payment_details) {
        $apointment = Appointment::findOne($payment_details->appointment_id);
        $notification = new \common\models\Notifications();
        $notification->master_id = $payment_details->id;
        $notification->notification_type = 5;
        $notification->notification_content = 'Amount ' . $payment_details->amount . ' against appointment ' . $apointment->service_id . ' has to been paid on ' . date('d-m-Y');
        $notification->date = date('Y-m-d');
        $notification->doc = date('Y-m-d');
        if ($notification->save()) {
            return TRUE;
        } else {
            return FALSE;
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
            $prev_count = $_POST['prev_count'];
            $count_diff = $count - $prev_count;
            $data = $this->renderPartial('_form_cheque_multiple', [
                'count' => $count,
                'prev_count' => $prev_count,
                'count_diff' => $count_diff,
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

    public function actionChangeServiceTotal() {
        if (Yii::$app->request->isAjax) {
            $total_amt = $_POST['amt_val'];
            $service_id = $_POST['service_id'];
            $services = AppointmentService::find()->where(['id' => $service_id])->one();
            if (!empty($services)) {
                $services->total = $total_amt;
                $services->update();
            }
        }
        return 1;
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

    /*
     * This function delete services based on the esimate id
     */

    public function actionDeletePerforma($id) {
        $model = AppointmentService::findOne($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', "Service Removed Successfully");
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
     * This function get tax details
     */

    public function actionGetTax() {
        $data = '';
        if (Yii::$app->request->isAjax) {
            $tax_id = $_POST['tax'];
            $tax_data = \common\models\Tax::find()->where(['id' => $tax_id])->one();
            if (!empty($tax_data)) {
                $data = $tax_data->value;
            }
        }
        return $data;
    }

    /*
     * This function will edit the close estimate text field on double click
     * and also save changes to the database
     */

    public function actionEditService() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $value = $_POST['valuee'];
            $service = AppointmentService::find()->where(['id' => $id])->one();
            $appointment = Appointment::find()->where(['id' => $service->appointment_id])->one();
            if ($value != '') {
                $service->$name = $value;
                $service->UB = Yii::$app->user->identity->id;
                if ($name == 'amount') {
                    $tax_amount = 0;
                    if ($service->amount != '' && $service->amount > 0) {
                        $tax_val = $service->tax != '' ? \common\models\Tax::findOne($service->tax)->value : '';
                        if ($tax_val != '' && $tax_val > 0) {
                            $tax_amount = ($service->amount * $tax_val) / 100;
                        }
                        $service->tax_amount = $tax_amount;
                        $service->tax_percentage = $tax_val;
                        $tot = $service->amount + $tax_amount;
                        $service->total = $tot;
                    }
                }
                if ($service->save()) {
                    if ($appointment->sub_status > 0) {
                        $this->RemoveAccountsData($appointment);
                    }
                    Yii::$app->SetValues->updateAppointment($appointment->id);
                    Yii::$app->session->set('account_step1', '1');
                    return $service->total;
                }
            }
        }
    }

    public function actionEditServiceTax() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $value = $_POST['valuee'];
            $service = AppointmentService::find()->where(['id' => $id])->one();
            if ($value != '') {
                $appointment = Appointment::find()->where(['id' => $service->appointment_id])->one();
                $service->$name = $value;
                $service->UB = Yii::$app->user->identity->id;
                $tax_amount = 0;
                if ($service->amount != '' && $service->amount > 0) {
                    $tax_val = $value != '' ? \common\models\Tax::findOne($value)->value : '';
                    if ($tax_val != '' && $tax_val > 0) {
                        $tax_amount = ($service->amount * $tax_val) / 100;
                    }
                    $service->tax_amount = $tax_amount;
                    $service->tax_percentage = $tax_val;
                    $tot = $service->amount + $tax_amount;
                    $service->total = $tot;
                }
                if ($service->save()) {
                    if ($appointment->sub_status > 0) {
                        $this->RemoveAccountsData($appointment);
                    }
                    Yii::$app->SetValues->updateAppointment($appointment->id);
                    Yii::$app->session->set('account_step1', '1');
                    return $service->total;
                }
            }
        }
    }

    public function actionEditPaymentType() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $value = $_POST['valuee'];
            $service = AppointmentService::find()->where(['id' => $id])->one();
            if ($value != '') {
                $appointment = Appointment::find()->where(['id' => $service->appointment_id])->one();
                $service->payment_type = $value;
                $service->UB = Yii::$app->user->identity->id;
                if ($service->save()) {
                    if ($appointment->sub_status > 0) {
                        $this->RemoveAccountsData($appointment);
                    }
                    Yii::$app->SetValues->updateAppointment($appointment->id);
                    Yii::$app->session->set('account_step1', '1');
                    return $service->payment_type;
                }
            }
        }
    }

    public function actionServiceComplete($id) {
        $apointment = Appointment::findOne($id);
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        if (!empty($services)) {
            if (!empty($apointment)) {
                $apointment->sub_status = 1; //appointmrnt complete
                if ($apointment->save(FALSE)) {
                    if ($apointment->sub_status == 1) {
                        if ($this->AddSponsorPayment($apointment)) {
                            Yii::$app->session->setFlash('success', "Services Completed");
                            return $this->redirect(['service-payment-details', 'id' => $id]);
                        } else {
                            $apointment->sub_status = 0;
                            $apointment->save(FALSE);
                            Yii::$app->session->setFlash('error', "Something went wrong.Please try again.");
                            return $this->redirect(Yii::$app->request->referrer);
                        }
                    } else {
                        Yii::$app->session->setFlash('error', "Something went wrong.Please try again.");
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        } else {
            Yii::$app->session->setFlash('success', "Services not completed");
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(['service-payment/index']);
    }

    public function actionServiceDetailsComplete($id) {
        $apointment = Appointment::findOne($id);
        if (!empty($apointment)) {
            $service_cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'cheque_number' => ''])->all();
            if (empty($service_cheque_details)) {
                $apointment->sub_status = 3; //appointmrnt complete
                if ($apointment->save(FALSE)) {
                    if ($apointment->sub_status == 3) {
                        Yii::$app->session->setFlash('success', "Services Completed");
                        return $this->redirect(['payment', 'id' => $id]);
                    } else {
                        Yii::$app->session->setFlash('error', "Something went wrong.Please try again.");
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', "Cheque Details Not complete.Please fill the cheque nunber");
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->redirect(['service-payment-details/index']);
    }

    public function AddSponsorPayment($apointment) {
        $flag = 0;
        if ($apointment->sponsor != '') {
            $sponsor = \common\models\Sponsor::find()->where(['id' => $apointment->sponsor])->one();
            if (!empty($sponsor) && $sponsor->yearly_charge != '' && $sponsor->yearly_charge >= 1) {
                $sponsor_payment = \common\models\SponsorPayment::find()->where(['sponsor_id' => $sponsor->id])->orderBy(['id' => SORT_DESC])->one();
                if (empty($sponsor_payment)) {
                    $balance = $sponsor->yearly_charge;
                } else {
                    $balance = $sponsor->yearly_charge + $sponsor_payment->balance;
                }
                $model = new \common\models\SponsorPayment();
                $model->sponsor_id = $sponsor->id;
                $model->appointment_id = $apointment->id;
                $model->customer_id = $apointment->customer;
                $model->type = 1;
                $model->amount = $sponsor->yearly_charge;
                $model->balance = $balance;
                Yii::$app->SetValues->Attributes($model);
                if ($model->save()) {
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

    public function actionReport($id) {
        $model = \common\models\PaymentDetails::find()->where(['id' => $id])->one();
        $content = $this->renderPartial('report', [
            'model' => $model
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/custom.css',
            'methods' => [
                'SetHeader' => ['Generated By: Universal Business Links||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionSideAgreement() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = \common\models\SideAgreement::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SideAgreement();
            }
            $content = $this->renderPartial('side_agreement_form', [
                'model' => $model,
                'id' => $id
            ]);
            return $content;
        }
    }

    public function actionSaveSideAgreement() {

        if (Yii::$app->request->post()) {
            $url = '';
            $id = Yii::$app->request->post()['SideAgreement']['appointment_id'];
            $model = \common\models\SideAgreement::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SideAgreement();
                $model->appointment_id = $id;
            }
            $model->company_name = Yii::$app->request->post()['SideAgreement']['company_name'];
            $model->represented_by = Yii::$app->request->post()['SideAgreement']['represented_by'];
            $model->date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreement']['date']));
            $model->office_start_date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreement']['office_start_date']));
            $model->office_end_date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreement']['office_end_date']));
            $model->office_no = Yii::$app->request->post()['SideAgreement']['office_no'];
            $model->offfice_address = Yii::$app->request->post()['SideAgreement']['offfice_address'];
            $model->activity = Yii::$app->request->post()['SideAgreement']['activity'];
            $model->payment = Yii::$app->request->post()['SideAgreement']['payment'];
            $model->sponsor_amount = Yii::$app->request->post()['SideAgreement']['sponsor_amount'];
            $model->payment_details = Yii::$app->request->post()['SideAgreement']['payment_details'];
            Yii::$app->SetValues->Attributes($model);
            if ($model->save()) {
                $url = Yii::$app->homeUrl . 'accounts/service-payment/view-side-agreement?id=' . $model->id;
            }
            return $url;
        }
    }

    public function actionViewSideAgreement($id) {
        $model = \common\models\SideAgreement::find()->where(['id' => $id])->one();
        $content = $this->renderPartial('side_agreement', [
            'model' => $model
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/custom.css',
            'methods' => [
                'SetHeader' => ['Generated By: Universal Business Links||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionSideAgreementAdding() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = \common\models\SideAgreementAdding::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SideAgreementAdding();
            }
            $content = $this->renderPartial('side_agreement_adding_form', [
                'model' => $model,
                'id' => $id
            ]);
            return $content;
        }
    }

    public function actionSaveSideAgreementAdding() {

        if (Yii::$app->request->post()) {
            $url = '';
            $id = Yii::$app->request->post()['SideAgreementAdding']['appointment_id'];
            $model = \common\models\SideAgreementAdding::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SideAgreementAdding();
                $model->appointment_id = $id;
            }
            $model->second_party_name = Yii::$app->request->post()['SideAgreementAdding']['second_party_name'];
            $model->represented_by = Yii::$app->request->post()['SideAgreementAdding']['represented_by'];
            $model->date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreementAdding']['date']));
            $model->ejari_start_date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreementAdding']['ejari_start_date']));
            $model->ejari_end_date = date("Y-m-d", strtotime(Yii::$app->request->post()['SideAgreementAdding']['ejari_end_date']));
            $model->office_no = Yii::$app->request->post()['SideAgreementAdding']['office_no'];
            $model->office_address = Yii::$app->request->post()['SideAgreementAdding']['office_address'];
            $model->location = Yii::$app->request->post()['SideAgreementAdding']['location'];
            $model->activity = Yii::$app->request->post()['SideAgreementAdding']['activity'];
            $model->amount = Yii::$app->request->post()['SideAgreementAdding']['amount'];
            $model->sponsor_amount = Yii::$app->request->post()['SideAgreementAdding']['sponsor_amount'];
            $model->payment_details = Yii::$app->request->post()['SideAgreementAdding']['payment_details'];
            Yii::$app->SetValues->Attributes($model);
            if ($model->save()) {
                $url = Yii::$app->homeUrl . 'accounts/service-payment/view-side-agreement-adding?id=' . $model->id;
            }
            return $url;
        }
    }

    public function actionViewSideAgreementAdding($id) {
        $model = \common\models\SideAgreementAdding::find()->where(['id' => $id])->one();
        $content = $this->renderPartial('side_agreement_adding', [
            'model' => $model
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/custom.css',
            'methods' => [
                'SetHeader' => ['Generated By: Universal Business Links||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function actionSittingAgreement() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $model = \common\models\SittingAgreement::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SittingAgreement();
            }
            $content = $this->renderPartial('sitting_agreement_form', [
                'model' => $model,
                'id' => $id
            ]);
            return $content;
        }
    }

    public function actionSaveSittingAgreement() {

        if (Yii::$app->request->post()) {
            $url = '';
            $id = Yii::$app->request->post()['SittingAgreement']['appointment_id'];
            $model = \common\models\SittingAgreement::find()->where(['appointment_id' => $id])->one();
            if (empty($model)) {
                $model = new \common\models\SittingAgreement();
                $model->appointment_id = $id;
            }
            $model->company_name = Yii::$app->request->post()['SittingAgreement']['company_name'];
            $model->represented_by = Yii::$app->request->post()['SittingAgreement']['represented_by'];
            $model->date = date("Y-m-d", strtotime(Yii::$app->request->post()['SittingAgreement']['date']));
            $model->office_no = Yii::$app->request->post()['SittingAgreement']['office_no'];
            $model->office_address = Yii::$app->request->post()['SittingAgreement']['office_address'];
            $model->location = Yii::$app->request->post()['SittingAgreement']['location'];
            $model->activity = Yii::$app->request->post()['SittingAgreement']['activity'];
            Yii::$app->SetValues->Attributes($model);
            if ($model->save()) {
                $url = Yii::$app->homeUrl . 'accounts/service-payment/view-sitting-agreement?id=' . $model->id;
            }
            return $url;
        }
    }

    public function actionViewSittingAgreement($id) {
        $model = \common\models\SittingAgreement::find()->where(['id' => $id])->one();
        $content = $this->renderPartial('sitting_agreement', [
            'model' => $model
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/custom.css',
            'methods' => [
                'SetHeader' => ['Generated By: Universal Business Links||Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

    public function ChangeDateFormate($date) {
        $res = '';
        if ($date != '') {
            $myArray = explode('/', $date);
            $res = $myArray[2] . '-' . $myArray[1] . '-' . $myArray[0];
        }
        return $res;
    }

}
