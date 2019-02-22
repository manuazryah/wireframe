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

$this->title = 'Full Report';
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
            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Contract [From - To] </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input id="contract_from" name="contract_from" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $contract_from != '' ? $contract_from : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input id="contract_to" name="contract_to" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $contract_to != '' ? $contract_to : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Amount [From - To] </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="total_from" class="form-control" id="exampleInputEmail1" placeholder="From" value="<?= $total_from != '' ? $total_from : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="total_to" class="form-control" id="exampleInputEmail1" placeholder="To" value="<?= $total_to != '' ? $total_to : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Paid Amount [From - To] </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="paid_from"class="form-control" id="exampleInputEmail1" placeholder="From" value="<?= $paid_from != '' ? $paid_from : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="paid_to" class="form-control" id="exampleInputEmail1" placeholder="To" value="<?= $paid_to != '' ? $paid_to : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Balance Amount [From - To] </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="balance_from" class="form-control" id="exampleInputEmail1" placeholder="From" value="<?= $balance_from != '' ? $balance_from : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="balance_to" class="form-control" id="exampleInputEmail1" placeholder="To" value="<?= $balance_to != '' ? $balance_to : '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div style="display: inline-flex;float: right;">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Reset', ['/reports/reports/index/'], ['class' => 'btn btn-danger', 'style' => 'display:block;margin-left:10px;']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $summary = RealEstateDetails::instance()->getSummary($dataProvider->models);
                    ?>
                    <table class="table table-bordered table-responsive">
                        <tbody>
                            <tr>
                                <th rowspan="2" style="text-align: center;text-transform: uppercase;">Report Summary</th>
                                <th>Total Amount</th>
                                <th>Amount Paid</th>
                                <th>Balance Amount</th>
                            </tr>
                            <tr>
                                <th><?= sprintf('%0.2f', $summary['total_amount']) ?></th>
                                <th><?= sprintf('%0.2f', $summary['paid_amount']) ?></th>
                                <th><?= sprintf('%0.2f', $summary['balance_amount']) ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" style="height: 475px;">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'customer_id',
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
                                [
                                    'attribute' => 'code',
                                    'label' => 'Office ID',
                                ],
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
                                    'attribute' => 'sales_person',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->sales_person)) {
                                            return \yii\helpers\Html::a(\common\models\AdminUsers::findOne($data->sales_person)->name, ['/admin/admin-users/update', 'id' => $data->sales_person], ['target' => '_blank']);
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => Select2::widget([
                                        'name' => 'RealEstateDetailsSearch[sales_person]',
                                        'model' => $searchModel,
                                        'value' => $searchModel->sales_person,
                                        'data' => ArrayHelper::map(
                                                common\models\AdminUsers::find()->all(), 'id', 'name'
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
                                    'attribute' => 'availability',
                                    'format' => 'raw',
                                    'filter' => [1 => 'Available', 0 => 'Not Available'],
                                    'value' => function ($model) {
                                        return $model->availability == 0 ? 'Not Available' : 'Available';
                                    },
                                ],
                                [
                                    'attribute' => 'total_amount',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getTotal($model->appointment_id);
                                    },
                                ],
                                [
                                    'attribute' => 'paid_amount',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getPaidAmount($model->appointment_id);
                                    },
                                ],
                                [
                                    'attribute' => 'balance_amount',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getBalanceAmount($model->appointment_id);
                                    },
                                ],
                                [
                                    'attribute' => 'contract_start',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getContractStartDate($model->appointment_id);
                                    },
                                ],
                                [
                                    'attribute' => 'contract_expiry',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getExpiryDate($model->appointment_id);
                                    },
                                ],
                                [
                                    'attribute' => 'next_payment',
                                    'filter' => false,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return $model->getNextPaymentDate($model->appointment_id);
                                    },
                                ],
//                    ['class' => 'yii\grid\ActionColumn'],
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

