<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\Sponsor;
use common\models\SponsorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SponsorController implements the CRUD actions for Sponsor model.
 */
class SponsorController extends Controller {

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
//                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sponsor models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SponsorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 40,];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sponsor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sponsor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Sponsor();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $emirate_id = UploadedFile::getInstance($model, 'emirate_id');
            $passport = UploadedFile::getInstance($model, 'passport');
            $family_book = UploadedFile::getInstance($model, 'family_book');
            $photo = UploadedFile::getInstance($model, 'photo');
            $files = UploadedFile::getInstances($model, 'others');
            if (!empty($emirate_id)) {
                $model->emirate_id = $emirate_id->extension;
            }
            if (!empty($passport)) {
                $model->passport = $passport->extension;
            }
            if (!empty($family_book)) {
                $model->family_book = $family_book->extension;
            }
            if (!empty($photo)) {
                $model->photo = $photo->extension;
            }
            $model->emirate_id_expiry = $model->emirate_id != '' ? $model->emirate_id_expiry : '';
            $model->passport_expiry = $model->passport != '' ? $model->passport_expiry : '';
            $model->family_book_expiry = $model->family_book != '' ? $model->family_book_expiry : '';
            $model->others = '';
            if ($model->save()) {
                $paths = Yii::$app->basePath . '/../uploads/sponsers/' . $model->id;
                $this->Upload($files, $emirate_id, $passport, $family_book, $photo, $paths);
                Yii::$app->session->setFlash('success', "Sponsor added Successfully");
                $model = new Sponsor();
            }
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function Upload($files, $emirate_id, $passport, $family_book, $photo, $paths) {
        if (!is_dir($paths)) {
            mkdir($paths);
        }
        $path = $paths . '/';
        if (!empty($emirate_id)) {
            $emirate_id->saveAs($path . 'emirate_id.' . $emirate_id->extension);
        }
        if (!empty($passport)) {
            $passport->saveAs($path . 'passport.' . $passport->extension);
        }
        if (!empty($family_book)) {
            $family_book->saveAs($path . 'family_book.' . $family_book->extension);
        }
        if (!empty($photo)) {
            $photo->saveAs($path . 'photo.' . $photo->extension);
        }
        $path1 = $paths . '/others';
        $path1 = $this->CheckPath($path1);
        foreach ($files as $file) {
            $name = $this->fileExists($path1, $file->baseName . '.' . $file->extension, $file, 1);
            $file->saveAs($path1 . '/' . $name);
        }
    }

    public function CheckPath($paths) {
        if (!is_dir($paths)) {
            mkdir($paths);
        }
        return $paths;
    }

    public function fileExists($path, $name, $file, $sufix) {
        if (file_exists($path . '/' . $name)) {

            $name = basename($path . '/' . $file->baseName, '.' . $file->extension) . '_' . $sufix . '.' . $file->extension;
            return $this->fileExists($path, $name, $file, $sufix + 1);
        } else {
            return $name;
        }
    }

    public function actionRemove($id, $type) {
        $model = $this->findModel($id);
        $dir = Yii::$app->basePath . '/../uploads/sponsers/' . $id . '/';
        if ($type == 1) {
            $path = $dir . 'emirate_id.' . $model->emirate_id;
        } elseif ($type == 2) {
            $path = $dir . 'passport.' . $model->passport;
        } elseif ($type == 3) {
            $path = $dir . 'family_book.' . $model->family_book;
        } elseif ($type == 4) {
            $path = $dir . 'photo.' . $model->photo;
        }
        if (file_exists($path)) {
            unlink($path);
            if (!empty($model)) {
                if ($type == 1) {
                    $model->emirate_id = '';
                    $model->emirate_id_expiry = '';
                } elseif ($type == 2) {
                    $model->passport = '';
                    $model->passport_expiry = '';
                } elseif ($type == 3) {
                    $model->family_book = '';
                    $model->family_book_expiry = '';
                } elseif ($type == 4) {
                    $model->photo = '';
                }
                $model->update();
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveOther($file, $id) {
        $model = $this->findModel($id);
        $path = Yii::$app->basePath . '/../uploads/sponsers/' . $id . '/others/' . $file;
        if (file_exists($path)) {
            unlink($path);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Sponsor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $emirate_id_ = $model->emirate_id;
        $passport_ = $model->passport;
        $family_book_ = $model->family_book;
        $photo_ = $model->photo;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $emirate_id = UploadedFile::getInstance($model, 'emirate_id');
            $passport = UploadedFile::getInstance($model, 'passport');
            $family_book = UploadedFile::getInstance($model, 'family_book');
            $photo = UploadedFile::getInstance($model, 'photo');
            $files = UploadedFile::getInstances($model, 'others');
            if (!empty($emirate_id)) {
                $model->emirate_id = $emirate_id->extension;
            } else {
                $model->emirate_id = $emirate_id_;
            }
            if (!empty($passport)) {
                $model->passport = $passport->extension;
            } else {
                $model->passport = $passport_;
            }
            if (!empty($family_book)) {
                $model->family_book = $family_book->extension;
            } else {
                $model->family_book = $family_book_;
            }
            if (!empty($photo)) {
                $model->photo = $photo->extension;
            } else {
                $model->photo = $photo_;
            }
            $model->emirate_id_expiry = $model->emirate_id != '' ? $model->emirate_id_expiry : '';
            $model->passport_expiry = $model->passport != '' ? $model->passport_expiry : '';
            $model->family_book_expiry = $model->family_book != '' ? $model->family_book_expiry : '';
            $model->others = '';
            if ($model->save()) {
                $paths = Yii::$app->basePath . '/../uploads/sponsers/' . $model->id;
                $this->Upload($files, $emirate_id, $passport, $family_book, $photo, $paths);
                Yii::$app->session->setFlash('success', "Sponsor Updated Successfully");
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sponsor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', "Sponsor Removed Successfully");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Sponsor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sponsor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Sponsor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSponsorPayment($id) {
        $sponsor = $this->findModel($id);
        $sponsor_payments = \common\models\SponsorPayment::find()->where(['sponsor_id' => $id])->all();
        $sponsor_balance = \common\models\SponsorPayment::find()->where(['sponsor_id' => $id])->orderBy(['id' => SORT_DESC])->one();
        $sponsor_total = \common\models\SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 1])->sum('amount');
        $paid_total = \common\models\SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 2])->sum('amount');
        return $this->render('sponsor-payment', [
                    'sponsor' => $sponsor,
                    'sponsor_payments' => $sponsor_payments,
                    'sponsor_balance' => $sponsor_balance,
                    'sponsor_total' => $sponsor_total,
                    'paid_total' => $paid_total,
        ]);
    }

    public function actionGetPayment() {

        $data = '';
        if (Yii::$app->request->post()) {

            $sponsor_id = $_POST['sponsor_id'];
            $payment = \common\models\SponsorPayment::find()->where(['sponsor_id' => $sponsor_id])->orderBy(['id' => SORT_DESC])->one();
            $data = $this->renderPartial('_form_pay', [
                'sponsor_id' => $sponsor_id,
                'payment' => $payment,
            ]);
        }
        return $data;
    }

    public function actionAjaxPayment() {
        if (Yii::$app->request->isAjax) {
            $sponsor_id = $_POST['sponsor_id'];
            $balance_amount = $_POST['balance_amount'];
            $amount = $_POST['amount'];
            if (!empty($sponsor_id) && !empty($amount)) {
                $model = new \common\models\SponsorPayment();
                $model->sponsor_id = $sponsor_id;
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

}
