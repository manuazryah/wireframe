<?php

namespace backend\modules\admin\controllers;

use Yii;
use common\models\AdminUsers;
use common\models\AdminUsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminUsersController implements the CRUD actions for AdminUsers model.
 */
class AdminUsersController extends Controller {

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
     * Lists all AdminUsers models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUsers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdminUsers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AdminUsers();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            if ($model->isNewRecord) {
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            }
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', "Admin Users Created Successfully");
                $model = new AdminUsers();
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdminUsers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate() && $model->save()) {
            Yii::$app->session->setFlash('success', "User Details Updated successfully.");
            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AdminUsers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $appointment = \common\models\Appointment::find()->where(['sales_man' => $id])->all();
        if (empty($appointment)) {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', "User removed successfully.");
        } else {
            Yii::$app->session->setFlash('error', "Can't remove. Because this user is used in appointmrnt");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AdminUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePassword($id) {
        $model = new \common\models\ChangePassword();
        $user = $this->findModel(Yii::$app->EncryptDecrypt->Encrypt('decrypt', $id));
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('success', 'Password changed successfully.');
            $model = new \common\models\ChangePassword();
        }
        return $this->render('change_password', [
                    'model' => $model,
                    'user' => $user,
        ]);
    }

    public function actionSalesPayment($id) {
        $salesman = $this->findModel($id);
        $contract_from = $contract_to = '';
        $qry = new yii\db\Query();
        $qry->select(['*'])
                ->from('appointment')
                ->where(['sales_man' => $id]);
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if (isset($data['contract_from']) && $data['contract_from'] != '') {
                $contract_from = $data['contract_from'];
                $new_from_date = $this->changeDateFormate($contract_from);
                if ($new_from_date != '') {
                    $qry->andWhere(['>=', 'contract_start_date', $new_from_date]);
                }
            }
            if (isset($data['contract_to']) && $data['contract_to'] != '') {
                $contract_to = $data['contract_to'];
                $new_to_date = $this->changeDateFormate($contract_to);
                if ($new_to_date != '') {
                    $qry->andWhere(['<=', 'contract_start_date', $new_to_date]);
                }
            }
        }
        $command = $qry->createCommand();
        $sales_appointments = $command->queryAll();
//        $sales_total = $qry->sum('sales_person_commission');
        $sales_total = \common\models\Appointment::find()->where(['sales_man' => $id])->sum('sales_person_commission');
        $sales_payment = \common\models\SalesPayment::find()->where(['salesman' => $id])->all();
//        $sales_appointments = \common\models\Appointment::find()->where(['sales_man' => $id])->all();
        $sales_balance = \common\models\SalesPayment::find()->where(['salesman' => $id])->orderBy(['id' => SORT_DESC])->one();
        $paid_total = \common\models\SalesPayment::find()->where(['salesman' => $id, 'type' => 2])->sum('amount');
        return $this->render('sales-payment', [
                    'salesman' => $salesman,
                    'sales_payment' => $sales_payment,
                    'sales_balance' => $sales_balance,
                    'paid_total' => $paid_total,
                    'sales_total' => $sales_total,
                    'sales_appointments' => $sales_appointments,
                    'contract_to' => $contract_to,
                    'contract_from' => $contract_from,
                    'id' => $id,
        ]);
    }

    public function changeDateFormate($date) {
        $newDate = '';
        if ($date != '') {
            $date_arr = explode('/', $date);
            $newDate = $date_arr[2] . '-' . $date_arr[1] . '-' . $date_arr[0];
        }
        return $newDate;
    }

    public function actionGetPayment() {

        $data = '';
        if (Yii::$app->request->post()) {

            $salesman = $_POST['salesman'];
            $sales_total = \common\models\Appointment::find()->where(['sales_man' => $salesman])->sum('sales_person_commission');
            $paid_total = \common\models\SalesPayment::find()->where(['salesman' => $salesman, 'type' => 2])->sum('amount');
            $payment = $sales_total - $paid_total;
            $data = $this->renderPartial('_form_pay', [
                'salesman' => $salesman,
                'payment' => $payment,
            ]);
        }
        return $data;
    }

    public function actionAjaxPayment() {
        if (Yii::$app->request->isAjax) {
            $salesman = $_POST['sponsor_id'];
            $balance_amount = $_POST['balance_amount'];
            $amount = $_POST['amount'];
            if (!empty($salesman) && !empty($amount)) {
                $model = new \common\models\SalesPayment();
                $model->salesman = $salesman;
                $model->amount = $amount;
                $model->balance = $balance_amount - $amount;
                $model->type = 2;
                Yii::$app->SetValues->Attributes($model);
                if ($model->save()) {
                    $result = 1;
                } else {
                    $result = 0;
                }
            } else {
                $result = 0;
            }
            return $result;
        }
    }

    /*
     * Save Sales person Commission
     */

    public function actionSaveCommission() {
        if (Yii::$app->request->isAjax) {
            $app_id = $_POST['appid'];
            $amount = $_POST['amount'];
            $result = 0;
            if ($app_id != '' && $amount != '') {
                $appointment = \common\models\Appointment::find()->where(['id' => $app_id])->one();
                if (!empty($appointment)) {
                    if ($amount >= 0) {
                        $appointment->sales_person_commission = $amount;
                        if ($appointment->save()) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    }
                }
            }
            return $result;
        }
    }

    public function actionSalesReport($id, $from = NULL, $to = NULL) {
        $salesman = $this->findModel($id);
        $contract_from = $contract_to = '';
        $qry = new yii\db\Query();
        $qry->select(['*'])
                ->from('appointment')
                ->where(['sales_man' => $id]);
        if (isset($from) && $from != '') {
            $contract_from = $from;
            $new_from_date = $this->changeDateFormate($contract_from);
            if ($new_from_date != '') {
                $qry->andWhere(['>=', 'contract_start_date', $new_from_date]);
            }
        }
        if (isset($to) && $to != '') {
            $contract_to = $to;
            $new_to_date = $this->changeDateFormate($contract_to);
            if ($new_to_date != '') {
                $qry->andWhere(['<=', 'contract_start_date', $new_to_date]);
            }
        }
        $command = $qry->createCommand();
        $sales_appointments = $command->queryAll();
        $sales_total = $qry->sum('sales_person_commission');
        $sales_payment = \common\models\SalesPayment::find()->where(['salesman' => $id])->all();
        $data = $this->renderPartial('sales_report', [
            'salesman' => $salesman,
            'sales_payment' => $sales_payment,
            'sales_total' => $sales_total,
            'sales_appointments' => $sales_appointments,
            'contract_to' => $contract_to,
            'contract_from' => $contract_from,
            'id' => $id,
        ]);
        echo $data;
        exit;
    }

}
