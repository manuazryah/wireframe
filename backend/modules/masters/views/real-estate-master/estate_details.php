<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Real Estate Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .summary{
        display: none;
    }
</style>
<!-- Default box -->
<div class="box table-responsive">
    <div class="real-estate-details-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <section id="tabs">
                <div class="card1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">General Details</span>', ['update', 'id' => $real_estate_master->id]);
                            ?>
                        </li>
                        <li role="presentation" class="active">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Real Estate Details</span>', ['real-estate-details', 'id' => $real_estate_master->id]);
                            ?>
                        </li>
                    </ul>
                </div>
            </section>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'category',
                        'format' => 'raw',
                        'filter' => [1 => 'License', 2 => 'Plots'],
                        'value' => function ($model) {
                            if ($model->category == 1) {
                                return 'License';
                            } else if ($model->category == 2) {
                                return 'Plots';
                            } else {
                                return '';
                            }
                        },
                    ],
                    'code',
                    [
                        'attribute' => 'availability',
                        'format' => 'raw',
                        'filter' => [0 => 'Occupied', 1 => 'Not Occupied'],
                        'value' => function ($model) {
                            return $model->availability == 1 ? 'Not Occupied' : 'Occupied';
                        },
                    ],
                    [
                        'attribute' => 'appointment_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (isset($data->appointment_id)) {
                                return \yii\helpers\Html::a(\common\models\Appointment::findOne($data->appointment_id)->service_id, ['/appointment/appointment/view', 'id' => $data->appointment_id], ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        },
                        'filter' => Select2::widget([
                            'name' => 'RealEstateDetailsSearch[appointment_id]',
                            'model' => $searchModel,
                            'value' => $searchModel->appointment_id,
                            'data' => ArrayHelper::map(
                                    common\models\Appointment::find()->all(), 'id', 'service_id'
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
                        'attribute' => 'customer_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (isset($data->customer_id)) {
                                return \yii\helpers\Html::a(\common\models\Debtor::findOne($data->customer_id)->company_name, ['/masters/debtor/update', 'id' => $data->customer_id], ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        },
                        'filter' => Select2::widget([
                            'name' => 'ServiceChequeDetailsSearch[customer_id]',
                            'model' => $searchModel,
                            'value' => $searchModel->customer_id,
                            'data' => ArrayHelper::map(
                                    common\models\Debtor::find()->all(), 'id', 'company_name'
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
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'contentOptions' => ['style' => 'width:50px;text-align:center;'],
//                        'header' => 'Actions',
//                        'template' => '{update}',
//                        'buttons' => [
//                            'update' => function ($url, $model) {
//                                return Html::a('<span><i class="fa fa-pencil" aria-hidden="true"></i></span>', $url, [
//                                            'title' => Yii::t('app', 'update'),
//                                            'class' => '',
//                                ]);
//                            },
//                        ],
//                        'urlCreator' => function ($action, $model) {
//                            if ($action === 'update') {
//                                $url = Url::to(['update-estate-details', 'id' => $model->id]);
//                                return $url;
//                            }
//                        }
//                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

