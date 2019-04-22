<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\RealEstateDetails;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sponsor Office Wise Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .grid-view .form-control{
        border-radius: 5px;
    }
    /*    .grid-view{
            max-height: 700px;
            overflow-y: scroll;
        }
        .grid-view .summary{
            border: 1px solid #bbb9b9;
            border-bottom: 0px;
            border-right: 0px;
        }*/
</style>
<!-- Default box -->
<div class="box table-responsive">
    <div class="real-estate-details-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?php
//                    $summary = RealEstateDetails::instance()->getSummary($dataProvider->models);
                    ?>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'sponsor',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->sponsor)) {
                                            return \yii\helpers\Html::a(\common\models\Sponsor::findOne($data->sponsor)->name, ['/masters/sponsor/update', 'id' => $data->sponsor], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => Select2::widget([
                                        'name' => 'RealEstateDetailsSearch[sponsor]',
                                        'model' => $searchModel,
                                        'value' => $searchModel->sponsor,
                                        'data' => ArrayHelper::map(
                                                common\models\Sponsor::find()->all(), 'id', 'name'
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
                                    'label' => 'Customer',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->customer_id)) {
                                            return \yii\helpers\Html::a(Debtor::findOne($data->customer_id)->company_name, ['/masters/debtor/update', 'id' => $data->customer_id], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => Select2::widget([
                                        'name' => 'RealEstateDetailsSearch[customer_id]',
                                        'model' => $searchModel,
                                        'value' => $searchModel->customer_id,
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
                                    'attribute' => 'appointment_id',
                                    'label' => 'Appointment',
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
                                    'attribute' => 'master_id',
                                    'label' => 'Real Estate ID',
                                    'value' => function($data) {
                                        if ($data->master->reference_code != '') {
                                            return $data->master->reference_code;
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => ArrayHelper::map(\common\models\RealEstateMaster::find()->asArray()->all(), 'id', 'reference_code'),
                                ],
//                                [
//                                    'attribute' => 'code',
//                                    'label' => 'Office ID',
//                                ],
                                [
                                    'attribute' => 'office_type',
                                    'label' => 'Office Type',
                                    'value' => function($data) {
                                        if ($data->office_type != '') {
                                            return \common\models\AppointmentServices::findOne($data->office_type)->service;
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => ArrayHelper::map(\common\models\AppointmentServices::find()->asArray()->all(), 'id', 'service'),
                                ],
                                [
                                    'attribute' => 'total_amount',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getTotal($model->appointment_id);
                                    },
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $("document").ready(function () {
        $('#contract_from').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        $('#contract_to').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
    });
</script>

