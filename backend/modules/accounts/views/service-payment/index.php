<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts (Appointments)';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'customer',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->customer)) {
                            return \yii\helpers\Html::a(Debtor::findOne($data->customer)->company_name, ['/masters/debtor/update', 'id' => $data->customer], ['target' => '_blank']);
                        } else {
                            return '';
                        }
                    },
                    'filter' => Select2::widget([
                        'name' => 'AppointmentSearch[customer]',
                        'model' => $searchModel,
                        'value' => $searchModel->customer,
                        'data' => ArrayHelper::map(
                                common\models\Debtor::findAll(['status' => 1]), 'id', 'company_name'
                        ),
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'placeholder' => '-- Select --',
                            'style' => 'width: 300px;'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'attribute' => 'service_type',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->service_type)) {
                            if ($data->sub_status == 0) {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/service-payment/service-payment', 'id' => $data->id]);
                            } elseif ($data->sub_status == 1) {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/service-payment/service-payment-update', 'id' => $data->id]);
                            } elseif ($data->sub_status == 2) {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/service-payment/service-payment-details', 'id' => $data->id]);
                            } elseif ($data->sub_status == 3) {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/service-payment/payment', 'id' => $data->id]);
                            }
                        } else {
                            return $data->id;
                        }
                    },
                    'filter' => ArrayHelper::map(AppointmentServices::find()->asArray()->all(), 'id', 'service'),
                ],
                [
                    'attribute' => 'service_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->service_id)) {
                            if ($data->sub_status == 0) {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/service-payment/service-payment', 'id' => $data->id]);
                            } elseif ($data->sub_status == 1) {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/service-payment/service-payment-update', 'id' => $data->id]);
                            } elseif ($data->sub_status == 2) {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/service-payment/service-payment-details', 'id' => $data->id]);
                            } elseif ($data->sub_status == 3) {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/service-payment/payment', 'id' => $data->id]);
                            }
                        } else {
                            return '';
                        }
                    },
                ],
                [
                    'attribute' => 'sponsor',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->sponsor)) {
                            return \yii\helpers\Html::a(Sponsor::findOne($data->sponsor)->name, ['/masters/sponsor/update', 'id' => $data->sponsor], ['target' => '_blank']);
                        } else {
                            return '';
                        }
                    },
                    'filter' => Select2::widget([
                        'name' => 'AppointmentSearch[sponsor]',
                        'model' => $searchModel,
                        'value' => $searchModel->sponsor,
                        'data' => ArrayHelper::map(
                                common\models\Sponsor::findAll(['status' => 1]), 'id', 'name'
                        ),
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'placeholder' => '-- Select --',
                            'style' => 'width: 300px;'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:50px;'],
//                    'header' => 'Actions',
                    'template' => '{service}',
                    'buttons' => [
                        'service' => function ($url, $model) {
                            return Html::a('<i class="fa fa-database"></i>', $url, [
                                        'title' => Yii::t('app', 'service'),
                                        'class' => '',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model) {
                        if ($action === 'service') {
                            $url = '';
                            if ($model->sub_status == 0) {
                                $url = Url::to(['service-payment', 'id' => $model->id]);
                            } elseif ($model->sub_status == 1) {
                                $url = Url::to(['service-payment-update', 'id' => $model->id]);
                            } elseif ($model->sub_status == 2) {
                                $url = Url::to(['service-payment-details', 'id' => $model->id]);
                            } elseif ($model->sub_status == 3) {
                                $url = Url::to(['payment', 'id' => $model->id]);
                            }
                            return $url;
                        }
                    }
                ],
            ];

// Renders a export dropdown menu
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns
            ]);

// You can choose to render your own GridView separately
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
