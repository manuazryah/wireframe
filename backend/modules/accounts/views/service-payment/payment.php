<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;
use yii\widgets\Pjax;

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
            <?php Pjax::begin(['id' => 'products-table']); ?>
            <table class="table table-bordered">
                <tr>
                    <th></th>
                    <th>Particulars</th>
                    <th>Cheque Number</th>
                    <th>Amount</th>
                    <th>Need To Pay</th>
                    <th>Paid</th>
                    <th>For Future</th>
                    <th>Status</th>
                </tr>
                <?php
                if (!empty($one_time_payments)) {
                    foreach ($one_time_payments as $one_time_payment) {
                        if (!empty($one_time_payment)) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $one_time_payment->service != '' ? common\models\Services::findOne($one_time_payment->service)->service_name : '' ?></td>
                                <td></td>
                                <td><?= $one_time_payment->total ?></td>
                                <td></td>
                                <td>

                                                                                                                                                                                                                                                                                            <!--									<button id="<?= $one_time_payment->service ?>" type="button" data-val="1" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                                                                                                                                                                                                                                                                            Click to pay
                                                                                                                                                                                                                                                                                            </button>-->
                                </td>
                                <td><?= $one_time_payment->amount_paid ?></td>
                                <td><?= $one_time_payment->due_amount ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                if (!empty($cleared_cheques)) {
                    foreach ($cleared_cheques as $cleared_cheque) {
                        if (!empty($cleared_cheque)) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $cleared_cheque->service_id != '' ? common\models\Services::findOne($cleared_cheque->service_id)->service_name : '' ?></td>
                                <td><?= $cleared_cheque->cheque_number ?></td>
                                <td><?= $cleared_cheque->amount ?></td>
                                <td><?= $cleared_cheque->status == 2 ? $cleared_cheque->amount : ''; ?></td>
                                <td>
                                    <?= $cleared_cheque->status == 1 ? $cleared_cheque->amount : ''; ?>

                                                                                                                                                                                                                                                                                            <!--									<button id="<?= $one_time_payment->service ?>" type="button" data-val="1" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                                                                                                                                                                                                                                                                            Click to pay
                                                                                                                                                                                                                                                                                            </button>-->
                                </td>
                                <td></td>
                                <td><?php
//									if ($previous_cheque->status == 2) {
                                    echo Html::dropDownList('status', $cleared_cheque->status, ['1' => 'Cleared', '2' => 'Pending'], ['class' => 'cheque_payment', 'id' => $cleared_cheque->id, 'prompt' => '--Change Status--']);
//									}
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                if (!empty($bounced_cheque)) {
                    foreach ($bounced_cheque as $cleared_cheque) {
                        if (!empty($cleared_cheque)) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $cleared_cheque->service_id != '' ? common\models\Services::findOne($cleared_cheque->service_id)->service_name : '' ?></td>
                                <td><?= $cleared_cheque->cheque_number ?></td>
                                <td><?= $cleared_cheque->amount ?></td>
                                <td><?= $cleared_cheque->status == 2 ? $cleared_cheque->amount : ''; ?></td>
                                <td>
                                    <?= $cleared_cheque->status == 1 ? $cleared_cheque->amount : ''; ?>

                                                                                                                                                                                                                                                                                            <!--									<button id="<?= $one_time_payment->service ?>" type="button" data-val="1" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                                                                                                                                                                                                                                                                            Click to pay
                                                                                                                                                                                                                                                                                            </button>-->
                                </td>
                                <td></td>
                                <td><?php
//									if ($previous_cheque->status == 2) {
                                    echo Html::dropDownList('status', $cleared_cheque->status, ['1' => 'Cleared', '2' => 'Pending'], ['class' => 'cheque_payment', 'id' => $cleared_cheque->id, 'prompt' => '--Change Status--']);
//									}
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                if (!empty($previous_cheques)) {
                    foreach ($previous_cheques as $previous_cheque) {
                        if (!empty($previous_cheque)) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $previous_cheque->service_id != '' ? common\models\Services::findOne($previous_cheque->service_id)->service_name : '' ?></td>
                                <td><?= $previous_cheque->cheque_number ?></td>
                                <td><?= $previous_cheque->amount ?></td>
                                <td><?= $previous_cheque->status == 2 ? $previous_cheque->amount : ''; ?></td>
                                <td>
                                    <?= $previous_cheque->status == 1 ? $previous_cheque->amount : ''; ?>

                                                                                                                                                                                                                                                                                            <!--									<button id="<?= $one_time_payment->service ?>" type="button" data-val="1" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                                                                                                                                                                                                                                                                            Click to pay
                                                                                                                                                                                                                                                                                            </button>-->
                                </td>
                                <td></td>
                                <td><?php
//									if ($previous_cheque->status == 2) {
                                    echo Html::dropDownList('status', $previous_cheque->status, ['1' => 'Cleared', '2' => 'Pending'], ['class' => 'cheque_payment', 'id' => $previous_cheque->id, 'prompt' => '--Change Status--']);
//									}
                                    ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                <?php
//				var_dump($cheque_dates);
//				exit;
                if (!empty($cheque_dates)) {
                    foreach ($cheque_dates as $cheque_date) {
                        if (!empty($cheque_date)) {
                            $service_cheques = common\models\ServiceChequeDetails::find()->where(['cheque_date' => $cheque_date->cheque_date])->andWhere(['status' => NULL])->all();
                            if (!empty($service_cheques)) {
                                ?>
                                <tr>
                                    <td rowspan="<?= count($service_cheques) ?>" ><?= $cheque_date->cheque_date ?></td>
                                    <?php
                                    foreach ($service_cheques as $service_cheque) {
                                        if (!empty($service_cheque)) {
                                            ?>

                                            <td><?= $service_cheque->service_id != '' ? common\models\Services::findOne($service_cheque->service_id)->service_name : '' ?></td>
                                            <td><?= $service_cheque->cheque_number ?></td>
                                            <td><?= $service_cheque->amount ?></td>
                                            <td><?= $cheque_date->cheque_date == date('Y-m-d') ? $service_cheque->amount : ''; ?></td>
                                            <td>
                                                <?= $service_cheque->status == 1 ? $service_cheque->amount : ''; ?>

                                            </td>
                                            <td><?= $service_cheque->amount ?></td>
                                            <td>
                                                <?php
                                                echo Html::dropDownList('status', $service_cheque->status, ['1' => 'Cleared', '2' => 'Pending'], ['class' => 'cheque_payment', 'id' => $service_cheque->id, 'prompt' => '--Change Status--']);
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
                            <li>Total Expense</li>
                            <span><?= sprintf('%0.2f', $total_amount); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <ul>
                            <li>Total Received</li>
                            <span><?= $payed_amount ?></span>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Balance</li>
                            <span style="color: #939b21">-<?= sprintf('%0.2f', $balance); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <ul>
                            <li><a href="<?= Yii::$app->homeUrl ?>accounts/service-payment/payment-history?id=<?= $appointment->id ?>" class="button">View payment history</a></li>

                            <li>
                                <a id="<?= $appointment->id ?>" type="button" data-val="2" class="pay-btn button" data-toggle="modal" data-target="#modal-default" >
                                    Make a payment
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
            var type = $(this).attr('data-val');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {appointment_id: appointment_id, type: type},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
                }
            });

        });

    });
</script>

