<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appointments';
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

            <?= Html::a('<span> Create Appointment</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
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
                            if ($data->status == 0) {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/appointment/appointment/update', 'id' => $data->id]);
                            } else {
                                return \yii\helpers\Html::a(AppointmentServices::findOne($data->service_type)->service, ['/accounts/appointment/appointment/view', 'id' => $data->id]);
                            }
                        } else {
                            return '';
                        }
                    },
                    'filter' => ArrayHelper::map(AppointmentServices::find()->asArray()->all(), 'id', 'service'),
                ],
                [
                    'attribute' => 'service_id',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if (isset($data->service_id)) {
                            if ($data->status == 1) {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/appointment/appointment/update', 'id' => $data->id]);
                            } else {
                                return \yii\helpers\Html::a($data->service_id, ['/accounts/appointment/appointment/view', 'id' => $data->id]);
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
                    'attribute' => 'status',
                    'format' => 'raw',
                    'filter' => [1 => 'Pending', 2 => 'Procced to Accounts'],
                    'value' => function ($model) {
                        if ($model->status == 1) {
                            return \yii\helpers\Html::a('Pending', ['/accounts/appointment/appointment/update', 'id' => $model->id]);
                        } elseif ($model->status == 2) {
                            return \yii\helpers\Html::a('Procced to Accounts', ['/accounts/appointment/appointment/view', 'id' => $model->id]);
                        }
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:50px;'],
//                    'header' => 'Actions',
                    'template' => '{appointment}',
                    'buttons' => [
                        'appointment' => function ($url, $model) {
                            if ($model->status == 1) {
                                $icon = 'fa fa-pencil';
                            } else {
                                $icon = 'fa fa-eye';
                            }
                            return Html::a('<i class="' . $icon . '"></i>', $url, [
                                        'title' => Yii::t('app', 'service'),
                                        'class' => '',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model) {
                        if ($action === 'appointment') {
                            if ($model->status == 1) {
                                $url = Url::to(['update', 'id' => $model->id]);
                            } else {
                                $url = Url::to(['view', 'id' => $model->id]);
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

