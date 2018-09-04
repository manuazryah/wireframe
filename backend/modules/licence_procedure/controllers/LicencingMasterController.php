<?php

namespace backend\modules\licence_procedure\controllers;

use Yii;
use common\models\LicencingMaster;
use common\models\LicencingMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LicencingMasterController implements the CRUD actions for LicencingMaster model.
 */
class LicencingMasterController extends Controller {

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
     * Lists all LicencingMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LicencingMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LicencingMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LicencingMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LicencingMaster();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LicencingMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $license_master = $this->findModel($id);
        $model = \common\models\LiceTrdnameIntlapro::find()->where(['licensing_master_id' => $id])->one();
        if (empty($model)) {
            $model = new \common\models\LiceTrdnameIntlapro();
            $model->setScenario('create');
        }
        if ($model->load(Yii::$app->request->post())) {
            $receipt = UploadedFile::getInstance($model, 'payment_receipt');
            $certificate = UploadedFile::getInstance($model, 'certificate');
            $sponsor_family_book = UploadedFile::getInstance($model, 'sponsor_family_book');
            $model->licensing_master_id = $id;
            $model->date = date('Y-m-d');
            $model->CB = Yii::$app->user->identity->id;
            if (!empty($sponsor_family_book)) {
                $model->sponsor_family_book = $sponsor_family_book->extension;
            }
            if (!empty($certificate)) {
                $model->certificate = $certificate->extension;
            }
            if (!empty($receipt)) {
                $model->payment_receipt = $receipt->extension;
            }
            if ($model->validate() && $model->save()) {
                $this->upload($model, $receipt, $certificate, $sponsor_family_book);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'license_master' => $license_master,
            ]);
        }
    }

    /**
     * Upload Initial approval Documents.
     * @return mixed
     */
    public function Upload($model, $receipt, $certificate, $sponsor_family_book) {
        if (isset($receipt) && !empty($receipt)) {
            $receipt->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/trade_initial_approval/receipt/' . $model->id . '.' . $receipt->extension);
        }
        if (isset($certificate) && !empty($certificate)) {
            $certificate->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/trade_initial_approval/certificate/' . $model->id . '.' . $certificate->extension);
        }
        if (isset($sponsor_family_book) && !empty($sponsor_family_book)) {
            $sponsor_family_book->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/trade_initial_approval/family_book/' . $model->id . '.' . $sponsor_family_book->extension);
        }
        return TRUE;
    }

    public function actionMoa($id) {
        $license_master = $this->findModel($id);
        $model = \common\models\Moa::find()->where(['licensing_master_id' => $id])->one();
        if (empty($model)) {
            $model = new \common\models\Moa();
            $model->setScenario('create');
        }
        if ($model->load(Yii::$app->request->post())) {
            $aggrement = UploadedFile::getInstance($model, 'aggrement');
            $moa_document = UploadedFile::getInstance($model, 'moa_document');
            $model->licensing_master_id = $id;
            $model->date = date('Y-m-d');
            $model->CB = Yii::$app->user->identity->id;
            if (!empty($aggrement)) {
                $model->aggrement = $aggrement->extension;
            }
            if (!empty($moa_document)) {
                $model->moa_document = $moa_document->extension;
            }
            if ($model->validate() && $model->save()) {
                $this->uploadMoaDocument($model, $moa_document, $aggrement);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('_moa', [
                        'model' => $model,
                        'license_master' => $license_master,
            ]);
        }
    }

    /**
     * Upload MOA Documents.
     * @return mixed
     */
    public function uploadMoaDocument($model, $moa_document, $aggrement) {
        if (isset($moa_document) && !empty($moa_document)) {
            $moa_document->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/moa/moa_document/' . $model->id . '.' . $moa_document->extension);
        }
        if (isset($aggrement) && !empty($aggrement)) {
            $aggrement->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/moa/aggrement/' . $model->id . '.' . $aggrement->extension);
        }
        return TRUE;
    }

    public function actionPaymentVoucher($id) {
        $license_master = $this->findModel($id);
        $model = \common\models\PaymentVoucher::find()->where(['licensing_master_id' => $id])->one();
        if (empty($model)) {
            $model = new \common\models\PaymentVoucher();
            $model->setScenario('create');
        }
        if ($model->load(Yii::$app->request->post())) {
            $ejari = UploadedFile::getInstance($model, 'ejari');
            $main_license = UploadedFile::getInstance($model, 'main_license');
            $noc = UploadedFile::getInstance($model, 'noc');
            $service_receipt = UploadedFile::getInstance($model, 'service_receipt');
            $voucher_attachment = UploadedFile::getInstance($model, 'voucher_attachment');
            $model->licensing_master_id = $id;
            $model->date = date('Y-m-d');
            $model->CB = Yii::$app->user->identity->id;
            if (!empty($ejari)) {
                $model->ejari = $ejari->extension;
            }
            if (!empty($main_license)) {
                $model->main_license = $main_license->extension;
            }
            if (!empty($noc)) {
                $model->noc = $noc->extension;
            }
            if (!empty($service_receipt)) {
                $model->service_receipt = $service_receipt->extension;
            }
            if (!empty($voucher_attachment)) {
                $model->voucher_attachment = $voucher_attachment->extension;
            }
            if ($model->validate() && $model->save()) {
                $this->uploadVoucherDocument($model, $ejari, $main_license, $noc, $service_receipt, $voucher_attachment);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('_payment_voucher', [
                        'model' => $model,
                        'license_master' => $license_master,
            ]);
        }
    }

    /**
     * Upload Payment Voucher Documents.
     * @return mixed
     */
    public function uploadVoucherDocument($model, $ejari, $main_license, $noc, $service_receipt, $voucher_attachment) {
        if (isset($ejari) && !empty($ejari)) {
            $ejari->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/voucher_documents/ejari/' . $model->id . '.' . $ejari->extension);
        }
        if (isset($main_license) && !empty($main_license)) {
            $main_license->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/voucher_documents/main_license/' . $model->id . '.' . $main_license->extension);
        }
        if (isset($noc) && !empty($noc)) {
            $noc->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/voucher_documents/noc/' . $model->id . '.' . $noc->extension);
        }
        if (isset($service_receipt) && !empty($service_receipt)) {
            $service_receipt->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/voucher_documents/service_receipt/' . $model->id . '.' . $service_receipt->extension);
        }
        if (isset($voucher_attachment) && !empty($voucher_attachment)) {
            $voucher_attachment->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/voucher_documents/voucher_attachment/' . $model->id . '.' . $voucher_attachment->extension);
        }
        return TRUE;
    }

    public function actionLicence($id) {
        $license_master = $this->findModel($id);
        $model = \common\models\Licence::find()->where(['licensing_master_id' => $id])->one();
        if (empty($model)) {
            $model = new \common\models\Licence();
            $model->setScenario('create');
        }
        if ($model->load(Yii::$app->request->post())) {
            $licence_attachment = UploadedFile::getInstance($model, 'licence_attachment');
            $model->expiry_date = date("Y-m-d", strtotime($model->expiry_date));
            $model->licensing_master_id = $id;
            $model->date = date('Y-m-d');
            $model->CB = Yii::$app->user->identity->id;
            if (!empty($licence_attachment)) {
                $model->licence_attachment = $licence_attachment->extension;
            }
            if ($model->validate() && $model->save()) {
                $this->uploadLicenseDocument($model, $licence_attachment);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->render('_licence', [
                        'model' => $model,
                        'license_master' => $license_master,
            ]);
        }
    }

    /**
     * Upload License Documents.
     * @return mixed
     */
    public function uploadLicenseDocument($model, $licence_attachment) {
        if (isset($licence_attachment) && !empty($licence_attachment)) {
            $licence_attachment->saveAs(Yii::$app->basePath . '/../uploads/license_procedure/licence/licence_attachment/' . $model->id . '.' . $moa_document->extension);
        }
        return TRUE;
    }

    /**
     * Deletes an existing LicencingMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LicencingMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LicencingMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LicencingMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
