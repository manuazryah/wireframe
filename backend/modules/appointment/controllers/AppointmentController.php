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
            $plot_arr = [];
            $licence_arr = [];
            $model = Appointment::find()->where(['id' => $id])->one();
            if (empty($model)) {
                if ($model->service_type != 5) {
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                } else {
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1, 'type' => 1])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                }
            } else {
                if ($model->service_type != 5) {
                    if ($model->plot == '') {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 0])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 0])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 0])->orWhere(['in', 'id', explode(',', $model->plot)])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1, 'type' => 1])->all(), 'id', function($model) {
                                    return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                    if ($model->space_for_license == '') {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 0])->all(), 'id', function($model) {
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
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 1])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                    $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 1])->all(), 'id', function($model) {
                                return RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
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
            echo json_encode($data);
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

}
