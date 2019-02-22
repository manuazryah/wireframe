<?php

namespace backend\modules\reports\controllers;

use Yii;
use common\models\RealEstateDetailsSearch;
use common\models\Appointment;
use common\models\AppointmentService;
use common\models\PaymentMaster;

class ReportsController extends \yii\web\Controller {

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
        $searchModel = new RealEstateDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $contract_from = $contract_to = $total_from = $total_to = $paid_from = $paid_to = $balance_from = $balance_to = '';
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if (isset($data['contract_from']) && $data['contract_from'] != '') {
                $contract_from = $data['contract_from'];
                $result = $this->SearchContractFrom($this->changeDateFormate($contract_from));
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['contract_to']) && $data['contract_to'] != '') {
                $contract_to = $data['contract_to'];
                $result = $this->SearchContractTo($this->changeDateFormate($contract_to));
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['total_from']) && $data['total_from'] != '') {
                $total_from = $data['total_from'];
                $result = $this->SearchTotalFrom($total_from);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['total_to']) && $data['total_to'] != '') {
                $total_to = $data['total_to'];
                $result = $this->SearchTotalTo($total_to);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['paid_from']) && $data['paid_from'] != '') {
                $paid_from = $data['paid_from'];
                $result = $this->SearchPaidFrom($paid_from);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['paid_to']) && $data['paid_to'] != '') {
                $paid_to = $data['paid_to'];
                $result = $this->SearchPaidTo($paid_to);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['balance_from']) && $data['balance_from'] != '') {
                $balance_from = $data['balance_from'];
                $result = $this->SearchBalanceFrom($balance_from);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
            if (isset($data['balance_to']) && $data['balance_to'] != '') {
                $balance_to = $data['balance_to'];
                $result = $this->SearchBalanceTo($balance_to);
                $dataProvider->query->andWhere(['appointment_id' => $result]);
            }
        }
        $dataProvider->pagination = FALSE;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'contract_from' => $contract_from,
                    'contract_to' => $contract_to,
                    'total_from' => $total_from,
                    'total_to' => $total_to,
                    'paid_from' => $paid_from,
                    'paid_to' => $paid_to,
                    'balance_from' => $balance_from,
                    'balance_to' => $balance_to,
        ]);
    }

    public function changeDateFormate($value) {
        $myArray = explode('/', $value);
        $date = $myArray[2] . '-' . $myArray[1] . '-' . $myArray[0];
        return $date;
    }

    public function SearchContractFrom($from_date) {
        $app_ids = [];
        $appointments = \common\models\Appointment::find()->where(['>=', 'contract_start_date', $from_date])->all();
        if (!empty($appointments)) {
            foreach ($appointments as $appointment) {
                $app_ids[] = $appointment->id;
            }
        }
        return $app_ids;
    }

    public function SearchContractTo($to_date) {
        $app_ids = [];
        $appointments = \common\models\Appointment::find()->where(['<=', 'contract_end_date', $to_date])->all();
        if (!empty($appointments)) {
            foreach ($appointments as $appointment) {
                $app_ids[] = $appointment->id;
            }
        }
        return $app_ids;
    }

    public function SearchTotalFrom($from_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->total_amount >= $from_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        } else {
                            $tot = AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                            if ($tot > $from_total) {
                                $app_ids[] = $appointment->id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function SearchTotalTo($to_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->total_amount <= $to_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        } else {
                            $tot = AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                            if ($tot <= $to_total) {
                                $app_ids[] = $appointment->id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function SearchPaidFrom($from_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->amount_paid >= $from_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function SearchPaidTo($to_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->amount_paid <= $to_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function SearchBalanceFrom($from_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->balance_amount >= $from_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        } else {
                            $tot = AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                            if ($tot >= $from_total) {
                                $app_ids[] = $appointment->id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function SearchBalanceTo($to_total) {
        $app_ids = [];
        $realestate_details = \common\models\RealEstateDetails::find()->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                if ($realestate_detail->appointment_id != '') {
                    $appointment = Appointment::find()->where(['id' => $realestate_detail->appointment_id])->one();
                    if (!empty($appointment)) {
                        $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                        if (!empty($payment)) {
                            if ($payment->balance_amount <= $to_total) {
                                $app_ids[] = $payment->appointment_id;
                            }
                        } else {
                            $tot = AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                            if ($tot <= $to_total) {
                                $app_ids[] = $appointment->id;
                            }
                        }
                    }
                }
            }
        }
        return $app_ids;
    }

    public function actionPdcReport() {
        $searchModel = new \common\models\ServiceChequeDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['or', ['!=', 'status', 1], ['IS', 'status', NULL]]);
        $dataProvider->query->andWhere(['>=', 'cheque_date', date('Y-m-d')]);
        return $this->render('pdc_report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRealestateChequeReport() {
        $searchModel = new \common\models\ChequeDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['>=', 'due_date', date('Y-m-d')]);
        return $this->render('realestate-cheque-report', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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

}
