<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\AppointmentService;
use common\models\AppointmentServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Appointment;

/**
 * AppointmentServiceController implements the CRUD actions for AppointmentService model.
 */
class AppointmentServiceController extends Controller {

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
     * Lists all AppointmentService models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppointmentServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppointmentService model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /*
     * Add services.
     */

    public function actionAdd($id, $prfrma_id = NULL) {
        $services = AppointmentService::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        if (!isset($prfrma_id)) {
            $model = new AppointmentService();
        } else {
            $model = $this->findModel($prfrma_id);
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
                return $this->redirect(['add', 'id' => $id]);
            }
        }
        return $this->render('add', [
                    'model' => $model,
                    'services' => $services,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

    /**
     * Creates a new AppointmentService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AppointmentService();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppointmentService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AppointmentService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AppointmentService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppointmentService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AppointmentService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

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
     * This function delete services based on the esimate id
     */

    public function actionDeletePerforma($id) {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    /*
     * This function generate quotation
     */

    public function actionQuotation($id) {
        $apointment = Appointment::findOne($id);
        $services = AppointmentService::find()->where(['appointment_id'=>$id])->all();
        echo $this->renderPartial('report', [
            'apointment' => $apointment,
            'services' => $services,
        ]);
        exit;
    }

}
