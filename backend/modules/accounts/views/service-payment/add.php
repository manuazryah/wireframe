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
        <?php $form = ActiveForm::begin(); ?>
        <div class="appt-services">
            <div class="append-box-head">
                                        <!--<a href=""><button class="remove"><i class="fa fa-close"></i></button></a>-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="formrow">
                            <h5>Particular</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="formrow">
                            <h5>Comments</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="formrow">
                            <h5>Amount</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="formrow">
                            <h5>Payment Type</h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($services)) {
                $count = 0;
                foreach ($services as $service) {
                    if (!empty($service)) {
                        $count++;
                        ?>
                        <div class="append-box" id="service_payment-<?= $service->id ?>">
                                                    <!--<a href=""><button class="remove"><i class="fa fa-close"></i></button></a>-->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="formrow">
                                        <span><?= $service->service != '' ? Services::findOne($service->service)->service_name : '' ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="formrow">
                                        <span><?= $service->comment ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="formrow">
                                        <input id="amount_total-<?= $count ?>" type="hidden" value="<?= $service->total ?>">
                                        <span ><?= $service->total ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="formrow">
                                        <select class="form-control payment-type payment_type-<?= $count ?>" name="updatee[<?= $service->id; ?>][payment_type]" id="payment_type-<?= $service->id ?>" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="1">Multiple</option>
                                            <option value="2">One Time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <input type="hidden" value="<?= $count ?>" id="total-row_count">
        <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #c5c5c5;">
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Multiple Total</label>
                        <input type="text" value="" id="multiple-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">No of Cheques</label>
                        <input style=" margin: 0px 5px;"type="number" value="0" id="multiple-cheque-count" class="form-control" step="1" />
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
                        <label class="control-label" for="debtor-company_name">One Time Total</label>
                        <input type="text" value="" id="one-time-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Payment Type</label>
                        <select style="margin: 0px 5px;" id="one-time-payment_type" class="form-control">
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
        });
        $(document).on('change keyup', '#multiple-cheque-count', function (e) {
            var count = $(this).val();
            var tot_amt = $('#multiple-tot').val();
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
    });
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

