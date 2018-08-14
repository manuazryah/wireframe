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
                foreach ($services as $service) {
                    if (!empty($service)) {
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
                                        <span><?= $service->total ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="formrow">
                                        <select class="form-control payment-type" name="updatee[<?= $service->id; ?>][payment_type]" id="payment_type-<?= $service->id ?>" required>
                                            <option value="">Select PaymentType</option>
                                            <option value="1">Monthly</option>
                                            <option value="2">Quarterly</option>
                                            <option value="3">Twice a Year</option>
                                            <option value="4">Annually</option>
                                            <option value="5">One Time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="cheque-details-content-<?= $service->id ?>">

                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
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
        $(document).on('change', '.payment-type', function (e) {
            var count = $(this).val();
            var id = $(this).attr('id');
            var arr = id.split("-");
            var service_id = arr[1];
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {service_id: service_id, count: count},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/add-cheque-details',
                success: function (data) {
                    $("#cheque-details-content-" + service_id).html(data);
                }
            });
        });
    });
</script>

