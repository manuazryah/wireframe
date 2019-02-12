<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Dated Cheque Report';
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
                    <div class="table-responsive" style="height: 275px;">
                        <?php Pjax::begin(['id' => 'products-table']); ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
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
                                        'name' => 'ServiceChequeDetailsSearch[appointment_id]',
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
                                    'attribute' => 'customer',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        if (isset($data->appointment_id)) {
                                            return $data->getCustomer($data->appointment_id);
                                        } else {
                                            return '';
                                        }
                                    },
                                    'filter' => Select2::widget([
                                        'name' => 'ServiceChequeDetailsSearch[customer]',
                                        'model' => $searchModel,
                                        'value' => $searchModel->customer,
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
                                'cheque_number',
                                    [
                                    'attribute' => 'cheque_date',
                                    'value' => function ($data) {
                                        return date("Y-m-d", strtotime($data->cheque_date));
                                    },
                                    'headerOptions' => [
                                        'class' => 'col-md-2'
                                    ],
                                    'filter' => DateRangePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'created_at_range',
                                        'convertFormat' => true,
                                        'pluginOptions' => [
                                            'locale' => ['format' => 'Y-m-d'],
                                        ],
                                    ])
                                ],
                                'amount',
                                    [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return \yii\helpers\Html::dropDownList('status', null, ['' => 'Change Status', '1' => 'Cleared', '2' => 'Pending'], ['class' => 'form-control admin_status_field cheque_payment', 'id' => $data->id,]);
                                    },
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
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
        $('#contract_from').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#contract_to').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $(document).on('change', '.cheque_payment', function (e) {
            var cheque_id = this.id;
            var cheque_status = $('option:selected', this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: cheque_id, status: cheque_status},
                url: '<?= Yii::$app->homeUrl; ?>reports/reports/ajax-cheque-payment',
                success: function (response) {
                    $.pjax.reload({container: '#products-table', timeout: false});
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script>

