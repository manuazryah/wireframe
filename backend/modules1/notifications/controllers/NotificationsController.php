<?php

namespace backend\modules\notifications\controllers;

use Yii;
use common\models\Notifications;
use common\models\NotificationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends Controller {

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
     * Lists all Notifications models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $new_notifications = ArrayHelper::map(Notifications::find()->where(new Expression('!FIND_IN_SET(:users, users)'))->addParams([':users' => Yii::$app->user->identity->id])->orWhere(['IS', 'users', (new Expression('Null'))])->all(), 'id', 'id');
        $dataProvider->query->andWhere(['id' => $new_notifications]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notifications model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = Notifications::findOne(['id' => $id]);
        $user_id = Yii::$app->user->identity->id;
        if ($model->users == '') {
            $model->users = $user_id;
        } else {
            $arr = explode(',', $model->users);
            if (!in_array($user_id, $arr)) {
                $model->users = $model->users . ',' . $user_id;
            }
        }
        $model->update();
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Notifications();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notifications model.
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
     * Deletes an existing Notifications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
