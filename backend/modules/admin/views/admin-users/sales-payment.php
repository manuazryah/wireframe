<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */

$this->title = 'Salesman Payment : ' . $salesman->name;
$this->params['breadcrumbs'][] = ['label' => 'Sponsors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Salesman</span>', ['index'], ['class' => 'btn btn-block manage-btn', 'style' => 'display: inline-block;']) ?>
        <?php
        echo Html::a('<i class="fa fa-print"></i>Print Report', ['admin-users/sales-report', 'id' => $salesman->id, 'from' => $contract_from != '' ? $contract_from : '', 'to' => $contract_to != '' ? $contract_to : ''], ['target' => '_blank', 'class' => 'btn btn-block manage-btn print-btn']);
        ?>
        <div class="sponsor-create">
            <?php Pjax::begin(['id' => 'products-table']); ?>
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div style="display: inline-flex;float: left; margin-top: 25px;">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Reset', ['/admin/admin-users/sales-payment', 'id' => $id], ['class' => 'btn btn-danger', 'style' => 'display:block;margin-left:10px;']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-8">
                    <div class="custmr-details">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Customer</th>
                                    <th>Appointment</th>
                                    <th>Total Amount</th>
                                    <th>UBL Amount</th>
                                    <th style="width: 150px">Commission</th>
                                    <th style="width: 150px">Agreement Start Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($sales_appointments)) {
                                    $i = 0;
                                    foreach ($sales_appointments as $sales_appointment) {
                                        if (!empty($sales_appointment)) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $sales_appointment['customer'] != '' ? common\models\Debtor::findOne($sales_appointment['customer'])->company_name : '' ?></td>
                                                <td><?= $sales_appointment['service_id'] ?></td>
                                                <td>
                                                    <?php
                                                    $total = 0;
                                                    if ($sales_appointment['id'] != '') {
                                                        $total = common\models\AppointmentService::find()->where(['appointment_id' => $sales_appointment['id']])->sum('total');
                                                    }
                                                    echo $total;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $ubl_total = 0;
                                                    $services = \common\models\Services::find()->where(['type' => 1])->all();
                                                    if (!empty($services)) {
                                                        $arr = [];
                                                        foreach ($services as $service) {
                                                            $arr[] = $service->id;
                                                        }
                                                        if (!empty($arr)) {
                                                            $ubl_total = common\models\AppointmentService::find()->where(['appointment_id' => $sales_appointment['id']])->andWhere(['service' => $arr])->sum('total');
                                                        }
                                                    }
                                                    echo $ubl_total;
                                                    ?>
                                                </td>
                                                <td style="text-align: right;"><input type="text"  class="form-control sales-pay" id="<?= $sales_appointment['id'] ?>" value="<?= $sales_appointment['sales_person_commission'] != '' && $sales_appointment['sales_person_commission'] > 0 ? sprintf('%0.2f', $sales_appointment['sales_person_commission']) : '' ?>" /></td>
                                                <td><?= $sales_appointment['id'] != '' ? common\models\Appointment::findOne($sales_appointment['id'])->contract_start_date : '' ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>TOTAL</th>
                                <th>PAID</th>
                                <th>BALANCE</th>
                            </tr>
                            <tr>
                                <th style="color: #1281c8;"><?= sprintf('%0.2f', $sales_total) ?></th>
                                <th style="color: #1281c8;"><?= sprintf('%0.2f', $paid_total) ?></th>
                                <th style="color:red;"><?= sprintf('%0.2f', $sales_total - $paid_total) ?></th>
                            </tr>
                        </thead>
                    </table>
                    <?php
                    $balance = $sales_total - $paid_total;
                    if (!empty($balance) && $balance > 0) {
                        ?>
                        <a id="<?= $salesman->id ?>" type="button" class="pay-btn button" data-toggle="modal" data-target="#modal-default" >
                            Make a receipt
                        </a>
                        <?php
                    }
                    ?>
                    <div class="custmr-details">
                        <h3>Payment History</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th style="width: 150px">Date of Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($sales_payment)) {
                                    $i = 0;
                                    foreach ($sales_payment as $sales_payment_val) {
                                        if (!empty($sales_payment_val)) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $sales_payment_val->type == '' ? 'Credit' : 'Debit' ?></td>
                                                <td style="text-align: right;"><?= sprintf('%0.2f', $sales_payment_val->amount) ?></td>
                                                <td><?= $sales_payment_val->DOC ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content payment-modal">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>

    $("document").ready(function () {
        $(document).on('click', '.pay-btn', function (e) {
            var salesman = $(this).attr('id');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {salesman: salesman},
                url: '<?= Yii::$app->homeUrl; ?>admin/admin-users/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
                }
            });

        });

        $(document).on('blur', '.sales-pay', function (e) {
            var appid = $(this).attr('id');
            var amount = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {appid: appid, amount: amount},
                url: '<?= Yii::$app->homeUrl; ?>admin/admin-users/save-commission',
                success: function (data) {
                    $.pjax.reload({container: '#products-table', timeout: false});
                }
            });

        });

    });
</script>
<script>
    $("document").ready(function () {
        $('#contract_from').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        $('#contract_to').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
    });
</script>

