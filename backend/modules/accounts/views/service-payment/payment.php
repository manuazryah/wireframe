<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Services;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts Payment(Appointments)';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>

        <div class="box-body table-responsive">
            <?= Html::a('<span> Manage Accounts</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>Comment</th>
                                <th>Amount</th>
                                <th>Tax Amount</th>
                                <th>Projection Amount</th>
                                <th>Actual Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($services)) {
                                $amount_tot = 0;
                                $tax_tot = 0;
                                $grand_tot = 0;
                                $onetime_tot = 0;
                                $cheque_tot = 0;
                                foreach ($services as $service) {
                                    ?>
                                    <tr>
                                        <td><?= Services::findOne($service->service)->service_name ?></td>
                                        <td><?= $service->comment ?></td>
                                        <td style="text-align:right"><?= $service->amount ?></td>
                                        <td style="text-align: right;"><?= $service->tax_amount ?> <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? '( ' . $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '% )' : '' ?></td>
                                        <td style="text-align: right;"><?= $service->total ?></td>
                                        <td style="text-align: right;"><?= $service->total ?></td>
                                    </tr>
                                    <?php
                                    $amount_tot += $service->amount;
                                    $tax_tot += $service->tax_amount;
                                    $grand_tot += $service->total;
                                    if ($service->payment_type == 1) {
                                        $cheque_tot += $service->total;
                                    } elseif ($service->payment_type == 2) {
                                        $onetime_tot += $service->total;
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="2" style="text-align: right;">Total</td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                                </tr>

                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="acc-print">
                        <?php
                        echo Html::a('<i class="fa fa-print"></i>Print', ['service-payment/accounts-report', 'id' => $appointment->id], ['target' => '_blank']);
                        ?>
                    </div>
                </div>
            </div>
            <br/>
            <?php Pjax::begin(['id' => 'products-table']); ?>
            <table class="table table-bordered">
                <tr>
                    <th></th>
                    <th>Cheque Number</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
                <?php if ($total_cash_amount > 0) { ?>
                    <tr>
                        <td></td>
                        <td>Cash Payment</td>
                        <td><?= $total_cash_amount ?></td>
                        <td><?= $cash_paid ?></td>
                        <td><?= $total_cash_amount - $cash_paid ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                if (!empty($cheque_dates)) {
                    foreach ($cheque_dates as $cheque_date) {
                        if (!empty($cheque_date)) {
                            $service_cheques = common\models\ServiceChequeDetails::find()->where(['cheque_date' => $cheque_date->cheque_date])->andWhere(['appointment_id' => $appointment->id])->all();
                            if (!empty($service_cheques)) {
                                ?>
                                <tr>
                                    <td rowspan="<?= count($service_cheques) ?>" ><?= $cheque_date->cheque_date ?></td>
                                    <?php
                                    foreach ($service_cheques as $service_cheque) {
                                        if (!empty($service_cheque)) {
                                            ?>

                                            <td><?= $service_cheque->cheque_number ?></td>
                                            <td><?= $service_cheque->amount ?></td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo $service_cheque->amount;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo 0;
                                                } elseif ($service_cheque->status == 2) {
                                                    echo $service_cheque->amount;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo 'Cleared';
                                                } else {
                                                    echo Html::dropDownList('status', $service_cheque->status, ['1' => 'Cleared', '2' => 'Pending'], ['class' => 'cheque_payment form-control', 'id' => $service_cheque->id, 'prompt' => '--Change Status--']);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
                ?>
            </table>
            <div id="tabs">
                <div class="customer-info-footer">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <ul>
                            <li>Total Cost</li>
                            <span><?= sprintf('%0.2f', $grand_tot); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <ul>
                            <li>Total Received</li>
                            <span><?= sprintf('%0.2f', $total_received); ?></span>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Balance</li>
                            <span style="color: #939b21"><?= sprintf('%0.2f', $total_balance); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <ul>
                            <li>
                                <?= Html::a('View payment history', ['/accounts/service-payment/payment-history', 'id' => $appointment->id], ['class' => 'button']) ?>
                            <li>
                                <a id="<?= $appointment->id ?>" type="button" class="pay-btn button" data-toggle="modal" data-target="#modal-default" >
                                    Make a receipt
                                </a>
                            </li>
                        </ul>
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
<!-- /.modal -->
<script>

    $("document").ready(function () {
        $(document).on('change', '.cheque_payment', function (e) {
            var cheque_id = this.id;
            var cheque_status = $('option:selected', this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: cheque_id, status: cheque_status},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/ajax-cheque-payment',
                success: function (response) {
                    $.pjax.reload({container: '#products-table', timeout: false});
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $(document).on('click', '.pay-btn', function (e) {
            var appointment_id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {appointment_id: appointment_id},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
                }
            });

        });

    });
</script>

