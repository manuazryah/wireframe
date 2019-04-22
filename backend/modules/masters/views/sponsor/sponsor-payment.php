<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */

$this->title = 'Sponsor Payment : ' . $sponsor->name;
$this->params['breadcrumbs'][] = ['label' => 'Sponsors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Sponsor</span>', ['index'], ['class' => 'btn btn-block manage-btn', 'style' => 'display: inline-block;']) ?>
        <?php
        echo Html::a('<i class="fa fa-print"></i>Print Report', ['sponsor/sponsor-report', 'id' => $id, 'from' => $contract_from != '' ? $contract_from : '', 'to' => $contract_to != '' ? $contract_to : ''], ['target' => '_blank', 'class' => 'btn btn-block manage-btn print-btn']);
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
                                <?= Html::a('Reset', ['/masters/sponsor/sponsor-payment', 'id' => $id], ['class' => 'btn btn-danger', 'style' => 'display:block;margin-left:10px;']) ?>
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
                                    <th>Appointment ID</th>
                                    <th>Payment Type</th>
                                    <th style="width: 150px">Sponsor Fee</th>
                                    <th>Total Amount</th>
                                    <th style="width: 150px">Agreement Start Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($sponsor_payments)) {
                                    $i = 0;
                                    foreach ($sponsor_payments as $sponsor_payment) {
                                        if (!empty($sponsor_payment)) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $sponsor_payment->customer_id != '' ? common\models\Debtor::findOne($sponsor_payment->customer_id)->company_name : 'Payment On ' . $sponsor_payment->DOC ?></td>
                                                <td><?= $sponsor_payment->appointment_id != '' ? $sponsor_payment->appointment_id : 'N/A' ?></td>
                                                <td><?= $sponsor_payment->type == 1 ? 'Credit' : 'Paid' ?></td>
                                                <td style="text-align: right;"><?= sprintf('%0.2f', $sponsor_payment->amount) ?></td>
                                                <td>
                                                    <?php
                                                    $total = 0;
                                                    if ($sponsor_payment->appointment_id != '') {
                                                        $total = common\models\AppointmentService::find()->where(['appointment_id' => $sponsor_payment->appointment_id])->sum('total');
                                                    }
                                                    echo $total;
                                                    ?>
                                                </td>
                                                <td><?= $sponsor_payment->appointment_id != '' ? common\models\Appointment::findOne($sponsor_payment->appointment_id)->contract_start_date : '' ?></td>
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
                                <th style="color: #1281c8;"><?= sprintf('%0.2f', $sponsor_total) ?></th>
                                <th style="color: #1281c8;"><?= sprintf('%0.2f', $paid_total) ?></th>
                                <th style="color:red;"><?= !empty($sponsor_balance) ? sprintf('%0.2f', $sponsor_balance->balance) : sprintf('%0.2f', 0) ?></th>
                            </tr>
                        </thead>
                    </table>
                    <?php if (!empty($sponsor_balance) && $sponsor_balance->balance > 0) { ?>
                        <a id="<?= $sponsor->id ?>" type="button" class="pay-btn button" data-toggle="modal" data-target="#modal-default" >
                            Make a receipt
                        </a>
                    <?php }
                    ?>
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
            var sponsor_id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {sponsor_id: sponsor_id},
                url: '<?= Yii::$app->homeUrl; ?>masters/sponsor/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
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

