<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AdminUsers;
use common\models\AdminPosts;
use common\models\ChequeDetails;
use common\models\Notifications;

/**
 * Site controller
 */
class SiteController extends Controller {

	/**
	 * {@inheritdoc}
	 */
	public function behaviors() {
		return [
		    'access' => [
			'class' => AccessControl::className(),
			'rules' => [
				[
				'actions' => ['login', 'error', 'index', 'home', 'forgot', 'new-password', 'exception', 'view-notification', 'all-notifications', 'ajax-notification-status'],
				'allow' => true,
			    ],
				[
				'actions' => ['logout', 'index'],
				'allow' => true,
				'roles' => ['@'],
			    ],
			],
		    ],
		    'verbs' => [
			'class' => VerbFilter::className(),
			'actions' => [
			    'logout' => ['post'],
			],
		    ],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions() {
		return [
		    'error' => [
			'class' => 'yii\web\ErrorAction',
		    ],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(array('site/home'));
		}

		$this->layout = 'login';
		$model = new AdminUsers();
		$model->scenario = 'login';
		if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

			return $this->redirect(['home']);
		} else {
			return $this->render('login', [
				    'model' => $model,
			]);
		}
	}

	public function setSession() {
		$post = AdminPosts::findOne(Yii::$app->user->identity->post_id);
		if (!empty($post)) {
			Yii::$app->session['post'] = $post->attributes;
			return true;
		} else {
			return FALSE;
		}
	}

	public function actionHome() {
		if (isset(Yii::$app->user->identity->id)) {
			if (Yii::$app->user->isGuest) {
				return $this->redirect(['index']);
			}
			$this->getNotifications();
			return $this->render('index', [
			]);
		} else {
			throw new \yii\web\HttpException(2000, 'Session Expired.');
		}
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin() {
		$this->layout = 'login';
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(['home']);
		}

		$model = new AdminUsers();
		$model->scenario = 'login';
		if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

			return $this->redirect(['home']);
		} else {
			return $this->render('login', [
				    'model' => $model,
			]);
		}
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function getNotifications() {

		$date = strtotime(date('Y-m-d'));
		$date = strtotime("+2 day", $date);
		$date_ = date("Y-m-d", $date);

		$real_estate_management_cheques = ChequeDetails::find()->where(['between', 'due_date', date("Y-m-d"), $date_])->all();
//
		$accounts_cheques = \common\models\ServiceChequeDetails::find()->where(['between', 'cheque_date', date("Y-m-d"), $date_])->all();
		$new_appointments = \common\models\Appointment::find()->where(['status' => 2])->all();
		if (!empty($real_estate_management_cheques)) {
			foreach ($real_estate_management_cheques as $cheques) {
				$check_exist = Notifications::find()->where(['data_id' => $cheques->id, 'notification_type' => 1])->one();
				if (empty($check_exist)) {
					$model = new Notifications();
					$model->data_id = $cheques->id;
					$model->master_id = $cheques->master_id;
					$model->notification_type = 1;
					$model->notification_content = 'a cheque ' . $cheques->cheque_no . ' is going to be expired on ' . $cheques->due_date . ' under Real Estate Managemnt';
					$model->date = $cheques->due_date;
					$model->status = 0;
					$model->doc = date('Y-m-d');

					if ($model->validate())
						$model->save();
				}
			}
		}
		if (!empty($accounts_cheques)) {
			foreach ($accounts_cheques as $cheques) {
				$check_exist = Notifications::find()->where(['data_id' => $cheques->id, 'notification_type' => 2])->one();
				if (empty($check_exist)) {
					$model = new Notifications();
					$model->data_id = $cheques->id;
					$model->master_id = $cheques->appointment_id;
					$model->notification_type = 2;
					$model->notification_content = 'A cheque ' . $cheques->cheque_number . ' is going to be expired on ' . $cheques->cheque_date . ' under Appointment accounts';
					$model->date = $cheques->cheque_date;
					$model->status = 0;
					$model->doc = date('Y-m-d');

					if ($model->validate())
						$model->save();
				}
			}
		}
		if (!empty($new_appointments)) {
			foreach ($new_appointments as $new_appointment) {
				$check_exist = Notifications::find()->where(['master_id' => $new_appointment->id, 'notification_type' => 3])->one();

				if (empty($check_exist)) {
					$model = new Notifications();
					$model->master_id = $new_appointment->id;
					$model->notification_type = 3;
					$model->notification_content = 'A New appointment created ';
					$model->status = 0;
					$model->doc = date('Y-m-d');

					if ($model->validate())
						$model->save();
				}
			}
		}
	}

	public function actionViewNotification($id) {
		$model = Notifications::findOne(['id' => $id]);
		$model->status = 1;
		$model->save();
		if ($model->notification_type == 1) {
			return $this->redirect(['masters/real-estate-master/cheque-details', 'id' => $model->master_id]);
		} elseif ($model->notification_type == 2) {
			return $this->redirect(['accounts/service-payment/payment', 'id' => $model->master_id]);
		} elseif ($model->notification_type == 3) {
			return $this->redirect(['accounts/service-payment/service-payment', 'id' => $model->master_id]);
		}
	}

	public function actionAllNotifications() {
//		$models = Notifications::find()->where(['<>', 'status', 1])->all();
		$models = Notifications::find()->all();
		return $this->render('notifications', [
			    'models' => $models,
		]);
	}

	public function actionAjaxNotificationStatus() {
		if (Yii::$app->request->isAjax) {
			$model_id = $_POST['id'];
			$notification_model = Notifications::findOne(['id' => $model_id]);
			$notification_model->status = 1;
			if (!empty($notification_model) && $notification_model->save())
				return 1;
			else
				return 0;
		}
	}

}
