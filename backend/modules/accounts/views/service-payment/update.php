<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Services;
use common\models\Tax;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentService */

$this->title = 'Service Payment';
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
        <section id="tabs1">
            <div class="card1">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 1</span>', ['service-payment/service-payment', 'id' => $id]);
                        ?>
                    </li>
                    <li role="presentation" class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 2</span>', ['service-payment/service-payment-update', 'id' => $id]);
                        ?>
                    </li>
                    <li role="presentation">
                        <?php
                        if ($appointment->sub_status != '' && $appointment->sub_status > 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 3</span>', ['service-payment/payment', 'id' => $id]);
                        } else {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 2</span>', ['service-payment/service-payment-update', 'id' => $id]);
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </section>
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
        <div class="form-group field-appointment-id">

            <input type="hidden" name="security_cheque" value="0"><label><input type="checkbox" id="security_cheque" name="security_cheque" value="1"> Security Cheque</label>

            <div class="help-block"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="security-cheque-details">

                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-md-12 col-xs-12 expense-head'>
                <span class="sub-heading">Contract Details</span>
                <div class="horizontal_line"></div>
            </div>
            <div class="col-md-12">
                <div id="expiry-details">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">License Expiry Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-license_expiry_date" name="Appointment[license_expiry_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="" autofocus>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">Contract Start Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-contract_start_date" name="Appointment[contract_start_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask >
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">Contract End Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-contract_end_date" name="Appointment[contract_end_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask >
                                </div>
                                <!-- /.input group -->
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
                        $cheque_tax_tot = 0;
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
                                $cheque_tax_tot += $service->tax_amount;
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
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name">
                        <label class="control-label" for="debtor-company_name">Cheque Amount</label>
                        <input type="text" value="<?= $cheque_tot ?>" id="multiple-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name">
                        <label class="control-label" for="debtor-company_name">Tax Amount</label>
                        <input type="text" value="<?= $cheque_tax_tot ?>" id="multiple-tax-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name">
                        <label class="control-label" for="debtor-company_name">No of Cheques</label>
                        <input style=" margin: 0px 0px;"type="number" id="multiple-cheque-count" class="form-control" step="1" max="15" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-multiple">

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">One Time Payment</label>
                        <input type="text" value="<?= $onetime_tot ?>" id="one-time-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Payment Type</label>
                        <select style="margin: 0px 0px;" id="one-time-payment_type" class="form-control">
                            <option value="1">Cash</option>
                            <option value="2">Cheque</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-one-time">

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group action-btn-right">
            <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success create-btn']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $("document").ready(function () {

        $('#appointment-license_expiry_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#appointment-contract_start_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#appointment-contract_end_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $(document).on('change', '.payment-type', function (e) {
            var type = $(this).val();
            calculateTotal();
            chequeAmountTotal();
            checkOnetimePayment();
            checkMultiplePayment();
            calculateTaxTotal();
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
            var tot_tax = $('#multiple-tax-tot').val();
            var cheque_count = $('#multiple-cheque-count').val();
            if (cheque_count > 0) {
                $("#cmprivacy").remove();
            }
            if (count > 15) {
                count = 15;
                $('#multiple-cheque-count').val(count);
            }
            showLoader();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {count: count, total_amt: tot_amt, tax_amount: tot_tax},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/multiple-cheque-details',
                success: function (data) {
                    $("#cheque-details-content-multiple").html(data);
                    SetDateFormateCreate(count);
                }
            });
            hideLoader();
        });
        $(document).on('blur', '.service-amt-tot', function (e) {
            var amt_val = $(this).val();
            var service_id = $(this).attr('data-val').match(/\d+/); // 123456
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {amt_val: amt_val, service_id: service_id},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/change-service-total',
                success: function (data) {
                    $('.payment-type').trigger("change");
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
                        $('#createone-cheque_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
                    }
                });
            } else {
                $("#cheque-details-content-one-time").html('');
            }
        });

        $(document).on('submit', '#account-form', function (e) {
            var mul_tot_amt = $('#multiple-tot').val();
            var cheque_count = $('#multiple-cheque-count').val();
            var tot = chequeAmountTotal();
            var start = mul_tot_amt - 1;
            var end = mul_tot_amt + 1;
            if (tot < start || tot > end) {
                if (mul_tot_amt > 0 && cheque_count <= 0) {
                    $('#multiple-cheque-count').after('<div id="cmprivacy" style="color:red;">Enter Valid No of Cheques.</div>');
                } else {
                    alert('Cheque amount total does not match with multiple total amount.Please Enter a valid amount.');
                }
                e.preventDefault();
            }

        });

        $('#security_cheque').change(function () {
            showLoader();
            if ($(this).is(":checked")) {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-security-cheque-details',
                    success: function (data) {
                        $("#security-cheque-details").html(data);
                        $('#security-cheque_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
                    }
                });
            } else {
                $('#security-cheque-details').html('');
            }
            hideLoader();
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
                    $('#mul_cheque_amt-' + i).val(bal.toFixed(2));
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
    function calculateTaxTotal() {
        var row_count = $('#total-row_count').val();
        var mul_tax_tot = 0;
        for (i = 1; i <= row_count; i++) {
            var payment_type = $('.payment_type-' + i).val();
            var amt = $('#tax_amount_total-' + i).val();
            if (payment_type != '' && amt != '' && amt > 0) {
                if (payment_type == 1) {
                    mul_tax_tot += parseFloat(amt);
                }
            }

        }
        $('#multiple-tax-tot').val(mul_tax_tot);
    }
    function checkOnetimePayment() {
        var one_time_tot = $('#one-time-tot').val();
        if (one_time_tot == 0 || one_time_tot == '') {
            $('#one-time-payment_type').val(1);
            $('#one-time-payment_type').trigger("change");
        }
    }
    function checkMultiplePayment() {
        var multi_tot = $('#multiple-tot').val();
        if (multi_tot == 0 || multi_tot == '') {
            $('#multiple-cheque-count').val(0);
            $('#multiple-cheque-count').trigger("change");
        }
    }
    function SetDateFormateCreate(row_count) {
        if (row_count >= 0) {
            for (i = 1; i <= row_count; i++) {
                $('#create-' + i).inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
            }
        }
    }
</script>

