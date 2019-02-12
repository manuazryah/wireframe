<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\RealEstateMaster;
use common\models\RealEstateMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RealEstateMasterController implements the CRUD actions for RealEstateMaster model.
 */
class RealEstateMasterController extends Controller {

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
     * Lists all RealEstateMaster models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RealEstateMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 40,];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RealEstateMaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RealEstateMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new RealEstateMaster();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $model->validate()) {
            $data = Yii::$app->request->post();
            $aggrement = UploadedFile::getInstance($model, 'aggrement');
            $ejari = UploadedFile::getInstance($model, 'ejari');
            $cheque_copy = UploadedFile::getInstance($model, 'cheque_copy');
            $model->ejari_expiry = $model->ejari_expiry != '' ? date('Y-m-d', strtotime($model->ejari_expiry)) : '';
            if (!empty($aggrement)) {
                $model->aggrement = $aggrement->extension;
            }
            if (!empty($ejari)) {
                $model->ejari = $ejari->extension;
            }
            if (!empty($cheque_copy)) {
                $model->cheque_copy = $cheque_copy->extension;
            }
            if ($model->save()) {
                $this->EstateDetails($model);
                if ($model->no_of_cheques != '' && $model->no_of_cheques >= 1) {
                    $this->ChequeDetails($model, $data);
                }
                $this->upload($model, $aggrement, $ejari, $cheque_copy);
                Yii::$app->session->setFlash('success', "Real Estate Details Created Successfully");
                return $this->redirect(['real-estate-details', 'id' => $model->id]);
//                $model = new RealEstateMaster();
            }
        } return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function EstateDetails($model) {
        if (isset($model->number_of_license) && $model->number_of_license >= 1) {
            for ($i = 1; $i <= $model->number_of_license; $i++) {
                $this->SaveEstateDetails($model, 1, $i);
            }
        }
        if (isset($model->number_of_plots) && $model->number_of_plots >= 1) {
            for ($i = 1; $i <= $model->number_of_plots; $i++) {
                $this->SaveEstateDetails($model, 2, $i);
            }
        }
        return;
    }

    public function SaveEstateDetails($model_master, $category, $code) {
        $model = new \common\models\RealEstateDetails();
        $model->type = $model_master->type;
        $model->master_id = $model_master->id;
        $model->category = $category;
        if ($category == 2) {
            $model->code = Yii::$app->SetValues->NumberAlphabet($code);
        }
        if ($category == 1) {
            $model->code = $code;
        }
        $model->save();
        return;
    }

    public function RemoveEstateDetails($model_master, $category) {
        $model = \common\models\RealEstateDetails::find()->where(['category' => $category, 'master_id' => $model_master->id])->orderBy(['id' => SORT_DESC])->one();
        if (!empty($model)) {
            $model->delete();
        }
        return;
    }

    public function ChequeDetails($model, $data) {
        if (isset($data['creates']) && $data['creates'] != '') {
            $arrs = [];
            $i = 0;
            foreach ($data['creates']['cheque_num'] as $val) {
                $arrs[$i]['cheque_num'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($data['creates']['expiry_date'] as $val) {
                $arrs[$i]['expiry_date'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($data['creates']['amount'] as $val) {
                $arrs[$i]['amount'] = $val;
                $i++;
            }
            if (!empty($arrs)) {
                $this->SaveChequeDetails($model, $arrs);
            }
        }
        return;
    }

    /*
     * to save cheque details
     */

    public function SaveChequeDetails($model, $arrs) {
        foreach ($arrs as $val) {
            $model_cheque = new \common\models\ChequeDetails();
            $model_cheque->master_id = $model->id;
            if (isset($val['cheque_num']) && $val['cheque_num'] != '') {
                $model_cheque->cheque_no = $val['cheque_num'];
            }
            if (isset($val['expiry_date']) && $val['expiry_date'] != '') {
                $model_cheque->due_date = $val['expiry_date'];
            }
            if (isset($val['amount']) && $val['amount'] != '') {
                $model_cheque->amount = $val['amount'];
            }
            Yii::$app->SetValues->Attributes($model_cheque);
            $model_cheque->save();
        }
        return;
    }

    public function upload($model, $aggrement, $ejari, $cheque_copy) {
        $path = Yii::$app->basePath . '/../uploads/real_estate/' . $model->id;
        $path = $this->CheckPath($path);
        if (!empty($aggrement)) {
            $aggrement->saveAs($path . '/aggrement.' . $aggrement->extension);
        }
        if (!empty($ejari)) {
            $ejari->saveAs($path . '/ejari.' . $ejari->extension);
        }
        if (!empty($cheque_copy)) {
            $cheque_copy->saveAs($path . '/cheque_copy.' . $cheque_copy->extension);
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

    public function actionRemove($path) {
        if (file_exists($path)) {
            unlink($path);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing RealEstateMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model_ = $this->findModel($id);
        $model = $this->findModel($id);
        $aggrement_ = $model->aggrement;
        $ejari_ = $model->ejari;
        $cheque_copy_ = $model->cheque_copy;
        $cheque_details = \common\models\ChequeDetails::find()->where(['master_id' => $id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $data = Yii::$app->request->post();
            $aggrement = UploadedFile::getInstance($model, 'aggrement');
            $ejari = UploadedFile::getInstance($model, 'ejari');
            $cheque_copy = UploadedFile::getInstance($model, 'cheque_copy');
            $model->ejari_expiry = $model->ejari_expiry != '' ? date('Y-m-d', strtotime($model->ejari_expiry)) : '';
            if (!empty($aggrement)) {
                $model->aggrement = $aggrement->extension;
            } else {
                $model->aggrement = $aggrement_;
            }
            if (!empty($ejari)) {
                $model->ejari = $ejari->extension;
            } else {
                $model->ejari = $ejari_;
            }
            if (!empty($cheque_copy)) {
                $model->cheque_copy = $cheque_copy->extension;
            } else {
                $model->cheque_copy = $cheque_copy_;
            }
            if ($model->save()) {
                $this->UpdateRealEstateDetails($model, $model_);
                $this->upload($model, $aggrement, $ejari, $cheque_copy);
                $this->ChequeDetails($model, $data);
                if (isset($_POST['updatee']) && $_POST['updatee'] != '') {
                    $this->UpdateChequeDetails($_POST['updatee']);
                }
                Yii::$app->session->setFlash('success', "Real Estate Updated successfully");
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } return $this->render('update', [
                    'model' => $model,
                    'cheque_details' => $cheque_details,
        ]);
    }

    /*
     * for updating additional data
     */

    public function UpdateChequeDetails($update) {
        $arr = [];
        $i = 0;
        foreach ($update as $key => $val) {
            $arr[$key]['cheque_num'] = $val['cheque_num'][0];
            $arr[$key]['expiry_date'] = $val['expiry_date'][0];
            $arr[$key]['amount'] = $val['amount'][0];
            $i++;
        }
        foreach ($arr as $key => $value) {
            $aditional = \common\models\ChequeDetails::findOne($key);
            $aditional->cheque_no = $value['cheque_num'];
            $aditional->due_date = date("Y-m-d", strtotime($value['expiry_date']));
            $aditional->amount = $value['amount'];
            $aditional->save();
        }
    }

    public function UpdateRealEstateDetails($model, $model_) {
        $license_count = $model->number_of_license - $model_->number_of_license;
        $plot_count = $model->number_of_plots - $model_->number_of_plots;
        if ($license_count >= 1) {
            for ($i = $model_->number_of_license + 1; $i <= $model->number_of_license; $i++) {
                $this->SaveEstateDetails($model, 1, $i);
            }
        }
        if ($plot_count >= 1) {
            for ($i = $model_->number_of_plots + 1; $i <= $model->number_of_plots; $i++) {
                $this->SaveEstateDetails($model, 2, $i);
            }
        }
        $license_reduce_count = $model_->number_of_license - $model->number_of_license;
        $plot_reduce_count = $model_->number_of_plots - $model->number_of_plots;
        if ($license_reduce_count >= 1) {
            for ($i = 1; $i <= $license_reduce_count; $i++) {
                $this->RemoveEstateDetails($model, 1);
            }
        }
        if ($plot_reduce_count >= 1) {
            for ($i = 1; $i <= $plot_reduce_count; $i++) {
                $this->RemoveEstateDetails($model, 2);
            }
        }
        return;
    }

    public function actionRealEstateDetails($id) {
        $real_estate_master = RealEstateMaster::findOne($id);
        $searchModel = new \common\models\RealEstateDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['master_id' => $id]);
        $dataProvider->pagination = false;

        return $this->render('estate_details', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'real_estate_master' => $real_estate_master,
        ]);
    }

    public function actionUpdateEstateDetails($id) {
        $model = \common\models\RealEstateDetails::findOne($id);
        $real_estate_master = RealEstateMaster::findOne($model->master_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Estate Details Updated Successfully");
            return $this->redirect(['update-estate-details', 'id' => $model->id]);
        } return $this->render('update_estate_details', [
                    'model' => $model,
                    'real_estate_master' => $real_estate_master,
        ]);
    }

    /**
     * Deletes an existing RealEstateMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->RemoveDetails($model) && $this->RemoveChequeDetails($model) && $model->delete()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', "Real Estate Removed successfully");
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "There was a problem for deletion. Please try again.");
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', "There was a problem for deletion. Please try again.");
        }

        return $this->redirect(['index']);
    }

    public function RemoveDetails($model) {
        $flag = 0;
        $model_details = \common\models\RealEstateDetails::find()->where(['master_id' => $model->id])->all();
        if (!empty($model_details)) {
            foreach ($model_details as $value) {
                if ($value->delete()) {
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

    public function RemoveChequeDetails($model) {
        $flag = 0;
        $model_cheque = \common\models\ChequeDetails::find()->where(['master_id' => $model->id])->all();
        if (!empty($model_cheque)) {
            foreach ($model_cheque as $value) {
                if ($value->delete()) {
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

    /**
     * Finds the RealEstateMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RealEstateMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RealEstateMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddChequeDetails() {
        $data = '';
        if (Yii::$app->request->isAjax) {
            $no_of_cheque = $_POST['no_of_cheque'];
            $data = $this->renderPartial('_form_cheque', [
                'no_of_cheque' => $no_of_cheque,
            ]);
        }
        return $data;
    }

    public function actionChequeDetails($id) {
        $models = \common\models\ChequeDetails::find()->where(['master_id' => $id])->all();
        return $this->render('cheque-details', [
                    'models' => $models
        ]);
    }

    public function actionUpdateChequeDetails() {
        $data = '';
        if (Yii::$app->request->isAjax) {
            $no_of_cheque = $_POST['no_of_cheque'];
            $cheque_count = $_POST['cheque_count'];
            if ($cheque_count != '' && $cheque_count > 0 && $no_of_cheque > $cheque_count) {
                $required_cheque = $no_of_cheque - $cheque_count;
            }
            $data = $this->renderPartial('_form_update_cheque', [
                'no_of_cheque' => $required_cheque,
            ]);
        }
        return $data;
    }

}
