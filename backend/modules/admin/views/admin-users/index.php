<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\AdminPosts;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="admin-users-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= \common\components\AlertMessageWidget::widget() ?>

            <?= Html::a('<span> Create Admin Users</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    [
                        'attribute' => 'post_id',
                        'label' => 'Post Name',
                        'value' => 'post.post_name',
                        'filter' => ArrayHelper::map(AdminPosts::find()->asArray()->all(), 'id', 'post_name'),
                    ],
                    'name',
                    'email:email',
                    'phone_number',
                    [
                        'attribute' => 'commission',
                        'format' => 'raw',
                        'value' => function($data, $key, $index, $column) {
                            return $data->getTotal($data->id);
                        },
                    ],
                    [
                        'attribute' => 'paid',
                        'format' => 'raw',
                        'value' => function($data, $key, $index, $column) {
                            return $data->getPaid($data->id);
                        },
                    ],
                    [
                        'attribute' => 'balance',
                        'format' => 'raw',
                        'value' => function($data, $key, $index, $column) {
                            return $data->getBalance($data->id);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:30px;'],
//                        'header' => 'Actions',
                        'template' => '{update}{delete}{payment}',
                        'buttons' => [
                            'payment' => function ($url, $model) {
                                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                            'title' => Yii::t('app', 'update'),
                                            'class' => '',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                $appointment = \common\models\Appointment::find()->where(['sales_man' => $model->id])->all();
                                if (empty($appointment)) {
                                    return Html::a('<i class="fa fa-trash-o"></i>', $url, [
                                                'title' => Yii::t('app', 'delete'),
                                                'class' => '',
                                    ]);
                                }
                            },
                            'payment' => function ($url, $model) {
                                $appointment = \common\models\Appointment::find()->where(['sales_man' => $model->id])->all();
                                if (!empty($appointment)) {
                                    return Html::a('<i class="fa fa-credit-card"></i>', $url, [
                                                'title' => Yii::t('app', 'payment'),
                                                'class' => '',
                                    ]);
                                }
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'update') {
                                $url = Url::to(['update', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['delete', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'payment') {
                                $url = Url::to(['sales-payment', 'id' => $model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

