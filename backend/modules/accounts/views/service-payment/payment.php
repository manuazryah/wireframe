<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;

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
            <table class="table table-bordered">
                <tr>
                    <th></th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
                <?php
                if (!empty($one_time_payments)) {
                    foreach ($one_time_payments as $one_time_payment) {
                        if (!empty($one_time_payment)) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $one_time_payment->service != '' ? common\models\Services::findOne($one_time_payment->service)->service_name : '' ?></td>
                                <td>
                                    <?= $one_time_payment->total ?>
                                    <button id="<?= $one_time_payment->service ?>" type="button" data-val="1" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                        Click to pay
                                    </button>
                                </td>
                                <td><?= $one_time_payment->amount_paid ?></td>
                                <td><?= $one_time_payment->due_amount ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                <?php
                if (!empty($cheque_dates)) {
                    foreach ($cheque_dates as $cheque_date) {
                        if (!empty($cheque_date)) {
                            $service_cheques = common\models\ServiceChequeDetails::find()->where(['cheque_date' => $cheque_date->cheque_date])->all();
                            if (!empty($service_cheques)) {
                                ?>
                                <tr>
                                    <td rowspan="<?= count($service_cheques) ?>" ><?= $cheque_date->cheque_date ?></td>
                                    <?php
                                    foreach ($service_cheques as $service_cheque) {
                                        if (!empty($service_cheque)) {
                                            ?>

                                            <td><?= $service_cheque->service_id != '' ? common\models\Services::findOne($service_cheque->service_id)->service_name : '' ?></td>
                                            <td>
                                                <?= $service_cheque->amount ?>
                                                <button id="<?= $service_cheque->service_id ?>" type="button" data-val="2" class="pay-btn" data-toggle="modal" data-target="#modal-default">
                                                    Click to pay
                                                </button>
                                            </td>
                                            <td></td>
                                            <td></td>
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
        $(document).on('click', '.pay-btn', function (e) {
            var service_id = $(this).attr('id');
            var type = $(this).attr('data-val');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {service_id: service_id, type: type},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
                }
            });
        });
    });
</script>

