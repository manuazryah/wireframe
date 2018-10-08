<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\Appointment;
use common\models\AppointmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppointmentController implements the CRUD actions for Appointment model.
 */
class AppointmentController extends Controller {

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
        $dataProvider->query->andWhere(['status' => 1]);

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
        return $this->render('view', [
                    'model' => $this->findModel($id),
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
            if ($model->save()) {
                // Yii::$app->session->setFlash('success', "Appointment Created Successfully");
                $this->updateEstateManagement($model);
                if ($model->service_type == 2 || $model->service_type == 3) {
                    $this->addLicencingMaster($model);
                }
                return $this->redirect(['/appointment/appointment-service/add', 'id' => $model->id]);
            }
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function updateEstateManagement($model) {
        if ($model->plot != '') {
            $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $model->plot])->one();
            $estate_details->availability = 0;
            $estate_details->update();
        }
        if ($model->space_for_license != '') {
            $estate_details = \common\models\RealEstateDetails::find()->where(['id' => $model->space_for_license])->one();
            $estate_details->availability = 0;
            $estate_details->update();
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

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->save()) {
            $model->sales_employee_id = Yii::$app->user->identity->post_id;
            if ($model->save()) {
                //   Yii::$app->session->setFlash('success', "Appointment Updated Successfully");
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } return $this->render('update', [
                    'model' => $model,
        ]);
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

}
