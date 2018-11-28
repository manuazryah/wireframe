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
<style>
    #outer
    {
        width:100%;
    }
    .inner
    {
        display: inline-block;
    }
</style>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div id="outer">
            <div class="inner"><?= Html::a('<span> Manage Accounts</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?></div>
            <div class="inner"><button type="button" class="btn btn-block manage-btn sitting-agreement">Sitting</button></div>
            <div class="inner"><button type="button" class="btn btn-block manage-btn side-agreement">Side agreement</button></div>
            <div class="inner"><button type="button" class="btn btn-block manage-btn adding-agreement">Adding</button></div>
        </div>
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
        <div class="appointment-service-create">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th>Payment Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($services)) {
                        $amount_tot = 0;
                        $tax_tot = 0;
                        $grand_tot = 0;
                        foreach ($services as $service) {
                            ?>
                            <tr>
                                <td><?= Services::findOne($service->service)->service_name ?></td>
                                <td class="edit_text" id="<?= $service->id ?>-comment" val="<?= $service->comment ?>">
                                    <?php
                                    if ($service->comment == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        echo $service->comment;
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right;" class="edit_text" id="<?= $service->id ?>-amount" val="<?= $service->amount ?>">
                                    <?php
                                    if ($service->amount == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        echo $service->amount;
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right;" class="edit_dropdown" drop_id="appointmentservice-tax" id="<?= $service->id ?>-tax" val="<?= $service->tax ?>">
                                    <?php
                                    if ($service->tax == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        ?>
                                        <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '%' : '' ?>
                                    <?php }
                                    ?>

                                </td>
                                <td style="text-align: right;" class="total-<?= $service->id ?>"><?= $service->total ?></td>
                                <td class="edit_dropdown_pay" drop_id="appointmentservice-payment_type" id="<?= $service->id ?>-payment_type" val="<?= $service->payment_type ?>">
                                    <?php
                                    if ($service->payment_type == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        if ($service->payment_type == 1) {
                                            echo 'Multiple';
                                        } elseif ($service->payment_type == 2) {
                                            echo 'One Time';
                                        }
                                        ?>
                                    <?php }
                                    ?>

                                </td>
                                <td>
                                    <?= Html::a('<i class="fa fa-pencil"></i>', ['/accounts/service-payment/service-payment/', 'id' => $id, 'prfrma_id' => $service->id], ['class' => '', 'tittle' => 'Edit']) ?>
                                    <?= Html::a('<i class="fa fa-remove"></i>', ['/accounts/service-payment/delete-performa', 'id' => $service->id], ['class' => '', 'tittle' => 'Edit', 'data-confirm' => 'Are you sure you want to delete this item?']) ?>
                                </td>
                            </tr>
                            <?php
                            $amount_tot += $service->amount;
                            $tax_tot += $service->tax_amount;
                            $grand_tot += $service->total;
                        }
                        ?>
                        <tr>
                            <td colspan="2" style="text-align: right;">Total</td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                            <td></td>
                            <td></td>
                        </tr>

                    <?php }
                    ?>
                    <?php $form = ActiveForm::begin(); ?>
                    <?php
                    $services = [];
                    if ($appointment->service_type == 1) {
                        $services = ArrayHelper::map(Services::findAll(['service_category' => 1]), 'id', 'service_name');
                    } elseif ($appointment->service_type == 2) {
                        $services = ArrayHelper::map(Services::find()->where(['service_category' => 2])->orWhere(['service_category' => 3])->all(), 'id', 'service_name');
                    } elseif ($appointment->service_type == 3) {
                        $services = ArrayHelper::map(Services::find()->where(['service_category' => 1])->orWhere(['service_category' => 2])->orWhere(['service_category' => 3])->all(), 'id', 'service_name');
                    } elseif ($appointment->service_type == 4) {
                        $services = ArrayHelper::map(Services::findAll(['service_category' => 2]), 'id', 'service_name');
                    } elseif ($appointment->service_type == 5) {
                        $services = ArrayHelper::map(Services::findAll(['service_category' => 6]), 'id', 'service_name');
                    }
                    ?>
                    <tr>
                        <td>
                            <?= $form->field($model, 'service')->dropDownList($services, ['prompt' => 'Choose Service', 'required' => TRUE])->label(FALSE) ?>
                        </td>
                        <td><?= $form->field($model, 'comment')->textInput()->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'required' => TRUE])->label(FALSE) ?></td>
                        <td>
                            <?php $taxes = ArrayHelper::map(Tax::findAll(['status' => 1]), 'id', 'name'); ?>
                            <?= $form->field($model, 'tax')->dropDownList($taxes, ['prompt' => 'Choose Tax'])->label(FALSE) ?>
                            <input type="hidden" value="<?= $model->tax != '' ? Tax::findOne($model->tax)->value : '' ?>" id="tax-val" />
                        </td>
                        <td><?= $form->field($model, 'total')->textInput(['maxlength' => true, 'readonly' => TRUE])->label(FALSE) ?></td>
                        <td>
                            <?= $form->field($model, 'payment_type')->dropDownList(['2' => 'One Time', '1' => 'Multiple'])->label(FALSE) ?>
                        </td>
                        <td>
                            <div style="display: inline-flex;">
                                <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?>
                                <?= Html::a(!$model->isNewRecord ? 'Reset' : '', ['/accounts/service-payment/service-payment/', 'id' => $id], ['class' => !$model->isNewRecord ? 'btn btn-danger' : '', 'style' => !$model->isNewRecord ? 'display:block;margin-left:10px;' : 'display:none']) ?>
                            </div>
                        </td>
                    </tr>
                    <?php ActiveForm::end(); ?>
                </tbody>
            </table>
        </div>
        <?= Html::a('<span>Service Complete and proceed to next</span>', ['service-complete', 'id' => $appointment->id], ['class' => 'btn btn-block btn-success btn-sm', 'style' => 'float:right;']) ?>
    </div>
    <!-- /.box-body -->
</div>
<div class="modal fade inventory-report-modal" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.box -->
<script>
    $("document").ready(function () {

    $(document).on('keyup mouseup', '#appointmentservice-amount', function (e) {
    calculateTotal();
    });
            $(document).on('change', '#appointmentservice-tax', function (e) {
    var tax = $(this).val();
            $.ajax({
            type: 'POST',
                    cache: false,
                    async: false,
                    data: {tax: tax},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-tax',
                    success: function (data) {
                    $("#tax-val").val(data);
                            calculateTotal();
                    }
            });
    });
            /*
             * Double click enter function
             * */

            $('.edit_text').on('dblclick', function () {
    var val = $(this).attr('val');
            var idd = this.id;
            var res_data = idd.split("-");
            if (res_data[1] == 'comment') {
    $(this).html('<textarea class="' + idd + ' form-control" value="' + val + '">' + val + '</textarea>');
    } else {
    $(this).html('<input class="' + idd + ' form-control" type="text" value="' + val + '"/>');
    }

    $('.' + idd).focus();
    });
            $('.edit_text').on('focusout', 'input,textarea', function () {
    var thiss = $(this).parent('.edit_text');
            var data_id = thiss.attr('id');
            var res_id = data_id.split("-");
            var res_val = $(this).val();
            $.ajax({
            type: 'POST',
                    cache: false,
                    data: {id: res_id[0], name: res_id[1], valuee: res_val},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/edit-service',
                    success: function (data) {
                    if (data == '') {
                    data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    thiss.html(res_val);
                            if (res_id[1] == 'amount') {
                    $('.total-' + data_id).text(data);
                    }
                    location.reload();
                    }
            });
    });
            /*
             * Double click Dropdown
             * */

            $('.edit_dropdown').on('dblclick', function () {
    var val = $(this).attr('val');
            var drop_id = $(this).attr('drop_id');
            var idd = this.id;
            var option = $('#' + drop_id).html();
            $(this).html('<select class="' + drop_id + ' form-control" value="' + val + '">' + option + '</select>');
            $('.' + drop_id + ' option[value="' + val + '"]').attr("selected", "selected");
            $('.' + drop_id).focus();
    });
            $('.edit_dropdown').on('focusout', 'select', function () {
    var thiss = $(this).parent('.edit_dropdown');
            var data_id = thiss.attr('id');
            var res_id = data_id.split("-");
            var res_val = $(this).val();
            $.ajax({
            type: 'POST',
                    cache: false,
                    data: {id: res_id[0], name: res_id[1], valuee: res_val},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/edit-service-tax',
                    success: function (data) {
                    if (data == '') {
                    data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
//                    thiss.html(data);
                    location.reload();
                    }
            });
    });
            $('.edit_dropdown_pay').on('dblclick', function () {
    var val = $(this).attr('val');
            var drop_id = $(this).attr('drop_id');
            var idd = this.id;
            var option = $('#' + drop_id).html();
            $(this).html('<select class="' + drop_id + ' form-control" value="' + val + '">' + option + '</select>');
            $('.' + drop_id + ' option[value="' + val + '"]').attr("selected", "selected");
            $('.' + drop_id).focus();
    });
            $('.edit_dropdown_pay').on('focusout', 'select', function () {
    var thiss = $(this).parent('.edit_dropdown_pay');
            var data_id = thiss.attr('id');
            var res_id = data_id.split("-");
            var res_val = $(this).val();
            $.ajax({
            type: 'POST',
                    cache: false,
                    data: {id: res_id[0], name: res_id[1], valuee: res_val},
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/edit-payment-type',
                    success: function (data) {
                    if (data == '') {
                    data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
//                    thiss.html(data);
                    location.reload();
                    }
            });
    });
            /******************** Agreements**********************************************/

            $(document).on('click', '.sitting-agreement', function () {
    var appointment_id = '<?php echo $appointment->id; ?>';
            if (appointment_id != ''){
    $.ajax({
    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/sitting-agreement',
            type: "POST",
            data: {},
            success: function (data) {
            var res = $.parseJSON(data);
                    $('.modal-content').html(res.result['report']);
                    $('#modal-default').modal('show');
            }
    });
    });
            $(document).on('click', '.side-agreement', function () {
    var appointment_id = '<?php echo $appointment->id; ?>';
            $.ajax({
            url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/side-agreement',
                    type: "POST",
                    data: {},
                    success: function (data) {
                    var res = $.parseJSON(data);
                            $('.modal-content').html(res.result['report']);
                            $('#modal-default').modal('show');
                    }
            });
    });
            $(document).on('click', '.sitting-agreement', function () {
    var appointment_id = '<?php echo $appointment->id; ?>';
            $.ajax({
            url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/adding-agreement',
                    type: "POST",
                    data: {},
                    success: function (data) {
                    var res = $.parseJSON(data);
                            $('.modal-content').html(res.result['report']);
                            $('#modal-default').modal('show');
                    }
            });
    });
            /******************** Agreements**********************************************/

    });
            function calculateTotal() {
            var tot = 0;
                    var tax_amount = 0;
                    var amount = $("#appointmentservice-amount").val();
                    var tax_val = $("#tax-val").val();
                    if (amount != '' && amount > 0) {
            if (tax_val != '' && tax_val > 0) {
            tax_amount = (parseFloat(amount) * parseFloat(tax_val)) / 100;
            }
            tot = (parseFloat(amount) + parseFloat(tax_amount));
            }
            $("#appointmentservice-total").val(tot.toFixed(2));
            }
</script>


