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
						} else {
							echo 'jkdfhg';
							exit;
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
			$aditional->appointment_service_id = $service->id;
			$aditional->service_id = $service->service;
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
		$services = AppointmentService::findAll(['appointment_id' => $id]);
		$one_time_payments = AppointmentService::findAll(['appointment_id' => $id, 'payment_type' => 5]);
		$onetime_amopunt = AppointmentService::find()->where(['appointment_id' => $id, 'payment_type' => 5])->sum('amount');
		$cheque_amounts = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['<', 'cheque_date', date("Y-m-d")])->groupBy('cheque_date')->sum('amount');
		$paid_future_cheques = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id, 'status' => 1])->andWhere(['>', 'cheque_date', date("Y-m-d")])->sum('amount');
		$total_amount = $cheque_amounts + $onetime_amopunt + $paid_future_cheques;
		$payed_amount = \common\models\ServicePayment::find()->where(['appointment_id' => $id])->sum('amount');
		$balance = $total_amount - $payed_amount;
		$appointment = Appointment::findOne($id);
		$this->ChangeChequeStatus($id);

		$cleared_cheques = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['>=', 'cheque_date', date("Y-m-d")])->andWhere(['status' => 1])->all();
		$bounced_cheque = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['>=', 'cheque_date', date("Y-m-d")])->andWhere(['status' => 2])->all();
		$cheque_dates = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['>=', 'cheque_date', date("Y-m-d")])->andWhere(['status' => NULL])->groupBy('cheque_date')->all();

		$previous_cheques = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['<', 'cheque_date', date("Y-m-d")])->groupBy('cheque_date')->all();
		return $this->render('payment', [
			    'services' => $services,
			    'appointment' => $appointment,
			    'one_time_payments' => $one_time_payments,
			    'cheque_dates' => $cheque_dates,
			    'previous_cheques' => $previous_cheques,
			    'id' => $id,
			    'total_amount' => $total_amount,
			    'payed_amount' => $payed_amount,
			    'balance' => $balance,
			    'cleared_cheques' => $cleared_cheques,
			    'bounced_cheque' => $bounced_cheque,
		]);
	}

	public function ChangeChequeStatus($id) {
		$cheques = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $id])->andWhere(['<', 'cheque_date', date("Y-m-d")])->andWhere(['status' => NULL])->all();
		foreach ($cheques as $cheque) {
			$model_appointmnet_service = AppointmentService::findOne(['id' => $cheque->appointment_service_id]);
			$model_appointmnet_service->due_amount = $cheque->amount;
			$model_appointmnet_service->save();
			$cheque->status = 2;
			$cheque->save();
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

			$type = $_POST['type'];
			$appointment_id = $_POST['appointment_id'];
			$one_time_payment_total = AppointmentService::find()->where(['appointment_id' => $appointment_id, 'payment_type' => 5])->sum('amount');
			$one_time_payed = \common\models\ServicePayment::find()->where(['appointment_id' => $appointment_id, 'transaction_type' => 2])->sum('amount');
			$balnce_to_pay = $one_time_payment_total - $one_time_payed;
			$data = $this->renderPartial('_form_pay', [
			    'type' => $type,
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
				$cheque_data->status = $data['status'];

				if ($cheque_data->status == 1) {

					$result = $this->AddPayment($data['id']);
				} elseif ($cheque_data->status == 2) {
					$this->chequeBounce($data['id'], $cheque_data);
				}

				if ($result == 1) {
					$cheque_data->save();
				}
			} else {
				echo'fddfhfdh';
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
				if ($amount <= $_POST['due_amount']) {

					try {
						$service_payment_model = new \common\models\ServicePayment();
						$service_payment_model->appointment_id = $id;
						$service_payment_model->transaction_type = 2;
						$service_payment_model->amount = $amount;
						$service_payment_model->date = $date;
						$service_payment_model->CB = Yii::$app->user->identity->id;
						$service_payment_model->DOC = date('Y-m-d');
						$appointment_model->paid_amount = $appointment_model->paid_amount + $amount;
						if ($service_payment_model->save() && $appointment_model->save()) {
							$transaction->commit();
							$result = 1;
						}
					} catch (Exception $e) {
						$transaction->rollBack();
						$result = 0;
					}
				}
			} else {
				$result = 0;
			}
			return $result;
		}
	}

	public function actionPaymentHistory($id) {
		$payment_model = \common\models\ServicePayment::find()->where(['appointment_id' => $id])->all();
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

}
