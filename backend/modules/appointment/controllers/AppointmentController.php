<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\Appointment;
use common\models\AppointmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\RealEstateDetails;
use common\models\RealEstateMaster;

/**
 * AppointmentController implements the CRUD actions for Appointment model.
 */
class AppointmentController extends Controller {

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

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Appointment models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andWhere(['status' => 1]);
        $dataProvider->pagination = ['pageSize' => '',];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Appointment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $services = \common\models\AppointmentService::findAll(['appointment_id' => $id]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'services' => $services,
        ]);
    }

    /**
     * Creates a new Appointment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Appointment();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->sales_employee_id = Yii::$app->user->identity->post_id;
            if (isset($model->plot) && $model->plot != '') {
                $model->plot = implode(',', $model->plot);
            }
            if (isset($model->space_for_license) && $model->space_for_license != '') {
                $model->space_for_license = implode(',', $model->space_for_license);
            }
            if ($model->save()) {
                $this->updateEstateManagement($model);
                if ($model->service_type == 2 || $model->service_type == 3) {
                    $this->addLicencingMaster($model);
                }
                $this->AddNotification($model);
                $this->SendNotificationMail($model);
                return $this->redirect(['/appointment/appointment-service/add', 'id' => $model->id]);
            }
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function updateEstateManagement($model) {
        if ($model->plot != '') {
            $plots = explode(',', $model->plot);
            if (!empty($plots)) {
                foreach ($plots as $plot) {
                    $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $plot])->one();
                    if (!empty($estate_details)) {
                        $estate_details->status = 0;
                        $estate_details->customer_id = $model->customer;
                        $estate_details->appointment_id = $model->id;
                        $estate_details->sponsor = $model->sponsor;
                        $estate_details->sales_person = $model->sales_man;
                        $estate_details->office_type = $model->service_type;
                        $estate_details->save(FALSE);
                    }
                }
            }
        }
        if ($model->space_for_license != '') {
            $space_for_license = explode(',', $model->space_for_license);
            if (!empty($space_for_license)) {
                foreach ($space_for_license as $license) {
                    $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $license])->one();
                    if (!empty($estate_details)) {
                        $estate_details->status = 0;
                        $estate_details->customer_id = $model->customer;
                        $estate_details->appointment_id = $model->id;
                        $estate_details->sponsor = $model->sponsor;
                        $estate_details->sales_person = $model->sales_man;
                        $estate_details->office_type = $model->service_type;
                        $estate_details->save(FALSE);
                    }
                }
            }
        }
    }

    public function addLicencingMaster($model) {
        $license_master = new \common\models\LicencingMaster();
        $license_master->appointment_id = $model->id;
        $license_master->appointment_no = $model->service_id;
        $license_master->customer_id = $model->customer;
        $license_master->sponsor = $model->sponsor;
        $license_master->plot = $model->plot;
        $license_master->space_for_licence = $model->space_for_license;
        $license_master->no_of_partners = 1;
        $license_master->status = 1;
        $license_master->stage = 'Trade name and intial approval';
        $license_master->comment = '';
        $license_master->CB = Yii::$app->user->identity->id;
        $license_master->DOC = date('Y-m-d');
        $license_master->save();
        return;
    }

    /**
     * Updates an existing Appointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
//        if ($model->status == 2) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
        $service_type = $model->service_type;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->sales_employee_id = Yii::$app->user->identity->post_id;
            if (isset($model->plot) && $model->plot != '') {
                $model->plot = implode(',', $model->plot);
            }
            if (isset($model->space_for_license) && $model->space_for_license != '') {
                $model->space_for_license = implode(',', $model->space_for_license);
            }
            if ($model->save()) {
                if ($model->service_type != $service_type) {
                    $this->removeService($model);
                }
                $this->removeEstateDetails($model);
                $this->updateEstateManagement($model);
                Yii::$app->session->setFlash('success', "Appointment Updated Successfully");
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function removeEstateDetails($model) {
        if ($model->plot != '') {
            $plots = explode(',', $model->plot);
            if (!empty($plots)) {
                foreach ($plots as $plot) {
                    $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $plot])->one();
                    if (!empty($estate_details)) {
                        $estate_details->status = 1;
                        $estate_details->customer_id = '';
                        $estate_details->appointment_id = '';
                        $estate_details->sponsor = '';
                        $estate_details->sales_person = '';
                        $estate_details->office_type = '';
                        $estate_details->save(FALSE);
                    }
                }
            }
        }
        if ($model->space_for_license != '') {
            $space_for_license = explode(',', $model->space_for_license);
            if (!empty($space_for_license)) {
                foreach ($space_for_license as $license) {
                    $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $license])->one();
                    if (!empty($estate_details)) {
                        $estate_details->status = 1;
                        $estate_details->customer_id = '';
                        $estate_details->appointment_id = '';
                        $estate_details->sponsor = '';
                        $estate_details->sales_person = '';
                        $estate_details->office_type = '';
                        $estate_details->save(FALSE);
                    }
                }
            }
        }
        return;
    }

    /**
     * Remove Appointment service when change the service type
     */
    public function removeService($model) {
        $services = \common\models\AppointmentService::find()->where(['appointment_id' => $model->id])->all();
        if (!empty($services)) {
            foreach ($services as $service) {
                if (!empty($service)) {
                    $service->delete();
                }
            }
        }
        return;
    }

    /**
     * Generate item code
     */
    public function generateServiceNo() {
        $last_appointment = Appointment::find()->orderBy(['id' => SORT_DESC])->one();
        if (empty($last_appointment)) {
            $code = 'UBLSR-' . date('y') . '-0001';
        } else {
            $last = $last_appointment->id + 1;
            $code = 'UBLSR-' . date('y') . '-' . sprintf('%04d', ++$last);
        }
        return $code;
    }

    /**
     * Generate reference code
     */
    public function generateReferenceCode() {
        $last_debtor = \common\models\Debtor::find()->orderBy(['id' => SORT_DESC])->one();
        if (empty($last_debtor)) {
            $code = 'UBLDR-' . '0001';
        } else {
            $last = $last_debtor->id + 1;
            $code = 'UBLDR-' . sprintf('%04d', ++$last);
        }
        return $code;
    }

    /**
     * Deletes an existing Appointment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Appointment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Add new Customer
     */

    public function actionAddCustomer() {
        $model = new \common\models\Debtor();
        if (Yii::$app->request->post()) {
            $model->company_name = Yii::$app->request->post()['company_name'];
            $model->email = Yii::$app->request->post()['email'];
            $model->phone_number = Yii::$app->request->post()['phone_number'];
            $model->contact_person = Yii::$app->request->post()['contact_person'];
            $model->TRN = Yii::$app->request->post()['TRN'];
            $model->reference_code = Yii::$app->request->post()['reference_code'];
            $model->address = Yii::$app->request->post()['address'];
            $model->contact_person_email = Yii::$app->request->post()['contact_person_email'];
            $model->contact_person_phone = Yii::$app->request->post()['contact_person_phone'];
            $model->nationality = Yii::$app->request->post()['nationality'];
            $model->comment = Yii::$app->request->post()['comment'];
            Yii::$app->SetValues->Attributes($model);
            if ($model->validate() && $model->save()) {
                echo json_encode(array("con" => "1", 'id' => $model->id, 'name' => $model->company_name)); //Success
                exit;
            } else {
                $array = $model->getErrors();
                $error = isset($array['name']['0']) ? $array['name']['0'] : 'Internal error';
                echo json_encode(array("con" => "2", 'error' => $error));
                exit;
            }
        }
        return $this->renderAjax('_form_debtor', [
                    'model' => $model,
        ]);
    }

    public function actionValidation() {
        $model = new \common\models\Debtor();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }
    }

    /*
     * This function select supplier based on real estate space
     * return result to the view
     */

    public function actionGetSupplier() {
        if (Yii::$app->request->isAjax) {
            $space = $_POST['space'];
            $arr = [];
            $sponsor = '';
            if (!empty($space)) {
                foreach ($space as $value) {
                    if ($value != '') {
                        $realestate_details = RealEstateDetails::find()->where(['id' => $value])->one();
                        $arr[] = $realestate_details->master_id;
                    }
                }
            }
            if (!empty($arr)) {
                if (count(array_unique($arr)) === 1) {
                    $realestate_master = RealEstateMaster::find()->where(['id' => array_shift(array_values($arr))])->one();
                    if (!empty($realestate_master)) {
                        $sponsor = $realestate_master->sponsor;
                    }
                }
            }
            echo $sponsor;
            exit;
        }
    }

    /*
     * This function select ports based on service_type
     * return result to the view
     */

    public function actionGetPlots() {
        if (Yii::$app->request->isAjax) {
            $type = $_POST['type'];
            $id = $_POST['id'];
            $plots = [];
            $licenses = [];
            $model = Appointment::find()->where(['id' => $id])->one();
            if (empty($model)) {
                if ($type != 5) {
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                    $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                } else {
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                    $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 1])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                }
            } else {
                if ($type != 5) {
                    if ($model->plot == '') {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 0])->orWhere(['in', 'id', explode(',', $model->plot)])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                    if ($model->space_for_license == '') {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 0])->orWhere(['in', 'id', explode(',', $model->space_for_license)])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                } else {
                    if ($model->plot == '') {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2])->orWhere(['in', 'id', explode(',', $model->plot)])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                    if ($model->space_for_license == '') {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 1])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 1])->orWhere(['in', 'id', explode(',', $model->space_for_license)])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                }
            }
            $options = '';
            if (!empty($plots)) {
                foreach ($plots as $key => $value) {
                    $options .= "<option value='" . $key . "'>" . $value . "</option>";
                }
            }
            $options1 = '';
            if (!empty($licenses)) {
                foreach ($licenses as $key => $value) {
                    $options1 .= "<option value='" . $key . "'>" . $value . "</option>";
                }
            }
            $arr_variable1 = array('plots' => $options, 'license' => $options1);
            $data['result'] = $arr_variable1;
            return json_encode($data);
        }
    }

    public function AddNotification($model) {
        $notification = new \common\models\Notifications();
        $notification->master_id = $model->id;
        $notification->notification_type = 3;
        $notification->notification_content = 'A New appointment created';
        $notification->date = $model->DOC;
        $notification->doc = date('Y-m-d');
        $notification->save();
        return;
    }

    public function SendNotificationMail($model) {
        if ($model->service_type == 2 || $model->service_type == 3) {
            $users = \common\models\AdminUsers::find()->where(['status' => 1])->andWhere(['or', ['post_id' => 1], ['post_id' => 3], ['post_id' => 4],])->all();
        } else {
            $users = \common\models\AdminUsers::find()->where(['status' => 1])->andWhere(['or', ['post_id' => 1], ['post_id' => 3],])->all();
        }
        if (!empty($users)) {
            foreach ($users as $user) {
                if ($user->email != '') {
                    $this->sendMail($user, $model);
                }
            }
        }
        return;
    }

    public function sendMail($user, $model) {
        $to = $user->email;
        $subject = 'New Appointment';
        $message = $this->render('notification_mail', ['model' => $model, 'user' => $user]);
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'noreplay@ublcsp.com";
        mail($to, $subject, $message, $headers);
        return;
    }

    public function actionRemove($id) {
        $appointment = Appointment::findOne($id);
        if (!empty($appointment)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->RemoveAppointmentServices($appointment) && $this->RemoveRealestate($appointment) && $this->RemoveChequeDetails($appointment) && $this->RemovePayment($appointment) && $this->RemoveLicenseDetails($appointment) && $appointment->delete()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Appointment removed successfully");
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "There was a problem removing appointment. Please try again.");
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem removing appointment. Please try again.");
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->redirect(['index']);
    }

    /*
     * Remove appointment services when deleting the appointment
     */

    public function RemoveAppointmentServices($appointment) {
        $flag = 0;
        $appointment_services = \common\models\AppointmentService::find()->where(['appointment_id' => $appointment->id])->all();
        if (empty($appointment_services)) {
            $flag = 1;
        } else {
            foreach ($appointment_services as $appointment_service) {
                if ($appointment_service->delete()) {
                    $flag = 1;
                } else {
                    $flag = 0;
                    break;
                }
            }
        }
        if ($flag == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function RemoveRealestate($appointment) {
        $plots = '';
        $licenses = '';
        $estate_arr = [];
        if ($appointment->plot != '') {
            $plots = explode(',', $appointment->plot);
            if (!empty($plots) && $plots != '') {
                foreach ($plots as $plot) {
                    $estate_arr[] = $plot;
                }
            }
        }
        if ($appointment->space_for_license != '') {
            $licenses = explode(',', $appointment->space_for_license);
            if (!empty($licenses) && $licenses != '') {
                foreach ($licenses as $license) {
                    $estate_arr[] = $license;
                }
            }
        }
        $realestate_details = RealEstateDetails::find()->where(['id' => $estate_arr])->all();
        if (!empty($realestate_details)) {
            foreach ($realestate_details as $realestate_detail) {
                $realestate_detail->availability = 1;
                $realestate_detail->status = 1;
                $realestate_detail->customer_id = '';
                $realestate_detail->appointment_id = '';
                $realestate_detail->sponsor = '';
                $realestate_detail->sales_person = '';
                $realestate_detail->office_type = '';
                $realestate_detail->status = 1;

                $realestate_detail->update();
            }
        }
        return TRUE;
    }

    public function RemoveChequeDetails($appointment) {
        $flag = 0;
        $service_cheque_details = \common\models\ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (!empty($service_cheque_details)) {
            foreach ($service_cheque_details as $service_cheque_detail) {
                if ($service_cheque_detail->delete()) {
                    $flag = 1;
                } else {
                    $flag = 0;
                    break;
                }
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

    public function RemovePayment($appointment) {
        $flag = 0;
        $payment_master = \common\models\PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
        $payment_details = \common\models\PaymentDetails::find()->where(['appointment_id' => $appointment->id])->all();
        if (!empty($payment_master)) {
            if ($payment_master->delete()) {
                if (!empty($payment_details)) {
                    foreach ($payment_details as $payment_detail) {
                        if ($payment_detail->delete()) {
                            $flag = 1;
                        } else {
                            $flag = 0;
                            break;
                        }
                    }
                } else {
                    $flag = 1;
                }
            } else {
                $flag = 0;
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

    public function RemoveLicenseDetails($appointment) {
        $flag = 0;
        $licencing_master = \common\models\LicencingMaster::find()->where(['appointment_id' => $appointment->id])->one();
        if (!empty($licencing_master)) {
            $lice_trdname_intlapro = \common\models\LiceTrdnameIntlapro::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $moa = \common\models\Moa::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $municipality_approval = \common\models\MunicipalityApproval::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $new_stamp = \common\models\NewStamp::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $others = \common\models\Others::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $payment_voucher = \common\models\PaymentVoucher::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $police_noc = \common\models\PoliceNoc::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $rta = \common\models\Rta::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $company_establishment_card = \common\models\CompanyEstablishmentCard::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $dps = \common\models\Dps::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            $licence = \common\models\Licence::find()->where(['licensing_master_id' => $licencing_master->id])->one();
            if ($licencing_master->delete()) {
                $flag = 1;
                $this->DeleteLicenseDatas($lice_trdname_intlapro, $moa, $municipality_approval, $new_stamp, $others, $payment_voucher, $police_noc, $rta, $company_establishment_card, $dps, $licence);
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

    public function DeleteLicenseDatas($lice_trdname_intlapro, $moa, $municipality_approval, $new_stamp, $others, $payment_voucher, $police_noc, $rta, $company_establishment_card, $dps, $licence) {
        if (!empty($lice_trdname_intlapro)) {
            $lice_trdname_intlapro->delete();
        }
        if (!empty($moa)) {
            $moa->delete();
        }
        if (!empty($municipality_approval)) {
            $municipality_approval->delete();
        }
        if (!empty($new_stamp)) {
            $new_stamp->delete();
        }
        if (!empty($others)) {
            $others->delete();
        }
        if (!empty($payment_voucher)) {
            $payment_voucher->delete();
        }
        if (!empty($police_noc)) {
            $police_noc->delete();
        }
        if (!empty($rta)) {
            $rta->delete();
        }
        if (!empty($company_establishment_card)) {
            $company_establishment_card->delete();
        }
        if (!empty($dps)) {
            $dps->delete();
        }
        if (!empty($licence)) {
            $licence->delete();
        }
        return TRUE;
    }

}
