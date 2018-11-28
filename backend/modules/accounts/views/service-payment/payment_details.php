<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Services;
use common\models\Tax;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentService */

$this->title = 'Update Service Payment';
$this->params['breadcrumbs'][] = ['label' => 'Appointment Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Accounts</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="appointment-history">
            <table class="table table-responsive">
                <tr>
                    <th>Customer Name</th>
                    <td>: <?= $appointment->customer != '' ? \common\models\Debtor::findOne($appointment->customer)->company_name : '' ?></td>
                    <th>Service Type</th>
                    <td>: <?= $appointment->service_type != '' ? \common\models\AppointmentServices::findOne($appointment->service_type)->service : '' ?></td>
                </tr>
                <tr>
                    <th>Service ID</th>
                    <td>: <?= $appointment->service_id ?></td>
                    <th>Sponsor</th>
                    <td>: <?= $appointment->sponsor != '' ? \common\models\Sponsor::findOne($appointment->sponsor)->name : '' ?></td>
                </tr>
            </table>
        </div>
        <?= \common\components\AlertMessageWidget::widget() ?>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'account-form',
        ]);
        ?>
        <?php if (!empty($security_cheque)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="security-cheque-details">
                        <div class="row">
                            <div class='col-md-12 col-xs-12 expense-head'>
                                <span class="sub-heading">Security Cheque Details</span>
                                <div class="horizontal_line"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                                <div class = "form-group">
                                    <label class="control-label" for="">Cheque Number</label>
                                    <input class="form-control" type = "text" name = "Security[cheque_num]" required value="<?= $security_cheque->cheque_no ?>">

                                </div>
                            </div>
                            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <label class="control-label" for="">Cheque Date</label>
                                    <input type="date" class="form-control" name="Security[cheque_date]" required value="<?= $security_cheque->cheque_date ?>">
                                </div>
                            </div>
                            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <label class="control-label" for="">Amount</label>
                                    <input class="form-control" type = "number" name = "Security[amount]" required min="1" value="<?= $security_cheque->amount ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div id="expiry-details">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label" for="">License Expiry Date</label>
                                <input type="date" class="form-control" name="Appointment[license_expiry_date]" value="<?= $appointment->license_expiry_date ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label" for="">Contract Start Date</label>
                                <input type="date" class="form-control" name="Appointment[contract_start_date]" value="<?= $appointment->contract_start_date ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label" for="">Contract End Date</label>
                                <input type="date" class="form-control" name="Appointment[contract_end_date]" value="<?= $appointment->contract_end_date ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="appointment-service-create">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Tax Amount</th>
                        <th>Total</th>
                        <th>Payment Type</th>
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
                                <td>
                                    <?php
                                    if ($service->payment_type == 1) {
                                        echo 'Multiple';
                                    } elseif ($service->payment_type == 2) {
                                        echo 'One Time';
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>
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
                            <td></td>
                        </tr>

                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #c5c5c5;">
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Multiple Total</label>
                        <input type="text" value="<?= $cheque_tot ?>" id="multiple-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">No of Cheques</label>
                        <input style=" margin: 0px 5px;"type="number" value="<?= count($multiple_cheque_details) ?>" id="multiple-cheque-count" class="form-control" step="1" readonly/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-multiple">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 expense-head">
                                <span class="sub-heading">Cheque Details</span>
                                <div class="horizontal_line"></div>
                            </div>
                        </div>
                        <?php
                        if (!empty($multiple_cheque_details)) {
                            $j = 0;
                            foreach ($multiple_cheque_details as $multiple_cheque_detail) {
                                $j++;
                                ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Cheque Number</label>
                                            <input class="form-control" type="text" name="update[<?= $multiple_cheque_detail->id ?>][cheque_num][]" value="<?= $multiple_cheque_detail->cheque_number ?>" required>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Cheque Date</label>
                                            <input type="date" class="form-control" name="update[<?= $multiple_cheque_detail->id ?>][cheque_date][]" value="<?= $multiple_cheque_detail->cheque_date ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Amount</label>
                                            <input class="form-control mul_cheque_amt" id="mul_cheque_amt-<?= $j ?>" type="number" name="update[<?= $multiple_cheque_detail->id ?>][amount][]" value="<?= $multiple_cheque_detail->amount ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">One Time Payment</label>
                        <input type="text" value="<?= $services_ontime_amount ?>" id="one-time-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Payment Type</label>
                        <select style="margin: 0px 5px;" id="one-time-payment_type" class="form-control" disabled>
                            <option value=""><?= count($onetime_cheque_details) > 0 ? 'Cheque' : 'Cash' ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-one-time">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 expense-head">
                                <span class="sub-heading">Cheque Details</span>
                                <div class="horizontal_line"></div>
                            </div>
                        </div>
                        <?php
                        if (!empty($onetime_cheque_details)) {
                            foreach ($onetime_cheque_details as $onetime_cheque_detail) {
                                ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Cheque Number</label>
                                            <input class="form-control" type="text" name="update[<?= $onetime_cheque_detail->id ?>][cheque_num][]" value="<?= $onetime_cheque_detail->cheque_number ?>" required>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Cheque Date</label>
                                            <input type="date" class="form-control" name="update[<?= $onetime_cheque_detail->id ?>][cheque_date][]" value="<?= $onetime_cheque_detail->cheque_date ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                                        <div class="form-group">
                                            <label class="control-label" for="">Amount</label>
                                            <input class="form-control" id="one_time_amt" type="number" name="update[<?= $onetime_cheque_detail->id ?>][amount][]" value="<?= $onetime_cheque_detail->amount ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group action-btn-right">
            <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
            <?= Html::submitButton('Update', ['class' => 'btn btn-success create-btn']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?= Html::a('<span>Complete and proceed to next</span>', ['service-details-complete', 'id' => $appointment->id], ['class' => 'btn btn-block btn-success btn-sm', 'style' => 'float:right;']) ?>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $("document").ready(function () {
//        $(document).on('change', '.payment-type', function (e) {
//            var count = $(this).val();
//            var id = $(this).attr('id');
//            var arr = id.split("-");
//            var service_id = arr[1];
//            $.ajax({
//                type: 'POST',
//                cache: false,
//                async: false,
//                data: {service_id: service_id, count: count},
//                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/add-cheque-details',
//                success: function (data) {
//                    $("#cheque-details-content-" + service_id).html(data);
//                }
//            });
//        });
        $(document).on('change', '.payment-type', function (e) {
            var type = $(this).val();
            calculateTotal();
            chequeAmountTotal();
        });
        $(document).on('change keyup', '.mul_cheque_amt', function (e) {
            chequeAmountTotal();
        });
        $(document).on('change keyup', '#one_time_amt', function (e) {
            var amt = $(this).val();
            var one_time_tot = $('#one-time-tot').val();
            if (parseFloat(amt) > parseFloat(one_time_tot)) {
                alert('Amount exxeeds one time total');
                $('#one_time_amt').val(one_time_tot);
            }
        });
        $(document).on('change keyup', '#multiple-cheque-count', function (e) {
            var count = $(this).val();
            var tot_amt = $('#multiple-tot').val();
            if (count > 15) {
                count = 15;
                $('#multiple-cheque-count').val(count);
            }
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {count: count, total_amt: tot_amt},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/multiple-cheque-details',
                success: function (data) {
                    $("#cheque-details-content-multiple").html(data);
                }
            });
        });
        $(document).on('change', '#one-time-payment_type', function (e) {
            var type = $(this).val();
            var tot_amt = $('#one-time-tot').val();
            if (type == 2) {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {total_amt: tot_amt},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/one-time-cheque-details',
                    success: function (data) {
                        $("#cheque-details-content-one-time").html(data);
                    }
                });
            } else {
                $("#cheque-details-content-one-time").html('');
            }
        });

        $(document).on('submit', '#account-form', function (e) {
            var mul_tot_amt = $('#multiple-tot').val();
            var tot = chequeAmountTotal();
            if (mul_tot_amt != tot) {
                alert('Cheque amount total does not match with multiple total amount.Please Enter a valid amount.');
                e.preventDefault();
            }

        });
    });
    function chequeAmountTotal() {
        var row_count = $('#multiple-cheque-count').val();
        var tot_amt = $('#multiple-tot').val();
        var mul_tot = 0;
        for (i = 1; i <= row_count; i++) {
            var row_tot = $('#mul_cheque_amt-' + i).val();
            var mul_tot_pre = parseFloat(mul_tot);
            mul_tot += parseFloat(row_tot);
            if (mul_tot > tot_amt) {
                alert('Cheque amount total does not match with multiple total amount');
                var bal = tot_amt - mul_tot_pre;
                if (bal >= 0) {
                    $('#mul_cheque_amt-' + i).val(bal);
                } else {
                    $('#mul_cheque_amt-' + i).val(0);
                }
            }
        }
        return mul_tot;
    }
    function calculateTotal() {
        var row_count = $('#total-row_count').val();
        var mul_tot = 0;
        var one_tot = 0;
        for (i = 1; i <= row_count; i++) {
            var payment_type = $('.payment_type-' + i).val();
            var amt = $('#amount_total-' + i).val();
            if (payment_type != '' && amt != '' && amt > 0) {
                if (payment_type == 1) {
                    mul_tot += parseFloat(amt);
                } else if (payment_type == 2) {
                    one_tot += parseFloat(amt);
                }
            }

        }
        $('#multiple-tot').val(mul_tot);
        $('#one-time-tot').val(one_tot);
    }
</script>

