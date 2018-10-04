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
	 * Lists all RealEstateMaster models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new RealEstateMasterSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
				$model = new RealEstateMaster();
			}
		} return $this->render('create', [
			    'model' => $model,
		]);
	}

	public function EstateDetails($model) {
		if ($model->number_of_license >= 1) {
			for ($i = 1; $i <= $model->number_of_license; $i++) {
				$this->SaveEstateDetails($model, 1, $i);
			}
		}
		if ($model->number_of_plots >= 1) {
			for ($i = 1; $i <= $model->number_of_plots; $i++) {
				$this->SaveEstateDetails($model, 2, $i);
			}
		}
		return;
	}

	public function SaveEstateDetails($model_master, $category, $code) {
		$model = new \common\models\RealEstateDetails();
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
		$model = $this->findModel($id);
		$aggrement_ = $model->aggrement;
		$ejari_ = $model->ejari;
		$cheque_copy_ = $model->cheque_copy;
		$cheque_details = \common\models\ChequeDetails::find()->where(['master_id' => $id])->all();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$aggrement = UploadedFile::getInstance($model, 'aggrement');
			$ejari = UploadedFile::getInstance($model, 'ejari');
			$cheque_copy = UploadedFile::getInstance($model, 'cheque_copy');
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
				$this->upload($model, $aggrement, $ejari, $cheque_copy);
			}
			return $this->redirect(['update', 'id' => $model->id]);
		} return $this->render('update', [
			    'model' => $model,
			    'cheque_details' => $cheque_details,
		]);
	}

	/**
	 * Deletes an existing RealEstateMaster model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
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

}
